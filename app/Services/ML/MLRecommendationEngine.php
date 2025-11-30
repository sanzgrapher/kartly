<?php

namespace App\Services\ML;

use App\Models\UserProductInteraction;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Rubix\ML\Datasets\Labeled;
use Rubix\ML\Datasets\Unlabeled;
use Rubix\ML\Classifiers\KNearestNeighbors;
use Rubix\ML\Kernels\Distance\Cosine;

class MLRecommendationEngine
{
    private ?KNearestNeighbors $model = null;
    private const MODEL_PATH = 'ml-models/recommendation-model.dat';
    private const MIN_TRAINING_DATA = 10; // Minimum interactions needed to train

    /**
     * Train the collaborative filtering model
     */
    public function trainModel(): bool
    {
        try {
            // Get all user-product interactions
            $interactions = UserProductInteraction::with(['user', 'product'])
                ->whereNotNull('user_id')
                ->get();

            if ($interactions->count() < self::MIN_TRAINING_DATA) {
                Log::warning('Not enough data to train ML model', [
                    'count' => $interactions->count(),
                    'required' => self::MIN_TRAINING_DATA
                ]);
                return false;
            }

            // Build user-item matrix
            [$samples, $labels] = $this->buildUserItemMatrix($interactions);

            if (empty($samples)) {
                Log::warning('No valid samples for ML training');
                return false;
            }

            // Create labeled dataset
            $dataset = new Labeled($samples, $labels);

            // Train KNN model with cosine similarity
            $this->model = new KNearestNeighbors(
                k: 5,
                weighted: true,
                kernel: new Cosine()
            );

            $this->model->train($dataset);

            // Save model to storage
            $this->saveModel();

            Log::info('ML model trained successfully', [
                'samples' => count($samples),
                'users' => count(array_unique($labels))
            ]);

            return true;
        } catch (\Exception $e) {
            Log::error('ML model training failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    /**
     * Get ML-based recommendations for a user
     */
    public function getRecommendationsForUser(int $userId, int $limit = 10): Collection
    {
        try {
            // Load model if not already loaded
            if (!$this->model) {
                $this->model = $this->loadModel();
            }

            if (!$this->model) {
                return collect();
            }

            // Get user's interaction history
            $userInteractions = UserProductInteraction::where('user_id', $userId)
                ->get();

            if ($userInteractions->isEmpty()) {
                return collect();
            }

            // Build user vector
            $userVector = $this->buildUserVector($userInteractions);

            // Get products user has already interacted with
            $interactedProductIds = $userInteractions->pluck('product_id')->toArray();

            // Find similar users and their liked products
            $recommendedProductIds = $this->findSimilarUsersProducts($userId, $interactedProductIds, $limit);

            // Return products
            return Product::whereIn('id', $recommendedProductIds)
                ->where('quantity', '>', 0)
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            Log::error('ML recommendation failed', [
                'user_id' => $userId,
                'error' => $e->getMessage()
            ]);
            return collect();
        }
    }

    /**
     * Get similar products using item-based collaborative filtering
     */
    public function getSimilarProducts(int $productId, int $limit = 5): Collection
    {
        try {
            // Get users who interacted with this product
            $productUsers = UserProductInteraction::where('product_id', $productId)
                ->where('rating', '>=', 3) // Only cart or purchase
                ->pluck('user_id')
                ->unique();

            if ($productUsers->isEmpty()) {
                return collect();
            }

            // Find other products these users liked
            $similarProducts = UserProductInteraction::whereIn('user_id', $productUsers)
                ->where('product_id', '!=', $productId)
                ->where('rating', '>=', 3)
                ->select('product_id')
                ->selectRaw('SUM(rating * interaction_count) as similarity_score')
                ->groupBy('product_id')
                ->orderBy('similarity_score', 'DESC')
                ->limit($limit)
                ->get();

            $productIds = $similarProducts->pluck('product_id');

            return Product::whereIn('id', $productIds)
                ->where('quantity', '>', 0)
                ->get();
        } catch (\Exception $e) {
            Log::error('Similar products recommendation failed', [
                'product_id' => $productId,
                'error' => $e->getMessage()
            ]);
            return collect();
        }
    }

    /**
     * Build user-item matrix from interactions
     */
    private function buildUserItemMatrix(Collection $interactions): array
    {
        $samples = [];
        $labels = [];

        $allProductIds = Product::pluck('id')->toArray();

        foreach ($interactions->groupBy('user_id') as $userId => $userInteractions) {
            $userVector = array_fill(0, count($allProductIds), 0);

            foreach ($userInteractions as $interaction) {
                $productIndex = array_search($interaction->product_id, $allProductIds);
                if ($productIndex !== false) {
                    // Weight by rating * interaction_count
                    $userVector[$productIndex] = $interaction->rating * $interaction->interaction_count;
                }
            }

            // Only include users with at least one interaction
            if (array_sum($userVector) > 0) {
                $samples[] = $userVector;
                $labels[] = (string) $userId; // Cast to string for categorical label
            }
        }

        return [$samples, $labels];
    }

    /**
     * Build vector for a single user
     */
    private function buildUserVector(Collection $userInteractions): array
    {
        $allProductIds = Product::pluck('id')->toArray();
        $userVector = array_fill(0, count($allProductIds), 0);

        foreach ($userInteractions as $interaction) {
            $productIndex = array_search($interaction->product_id, $allProductIds);
            if ($productIndex !== false) {
                $userVector[$productIndex] = $interaction->rating * $interaction->interaction_count;
            }
        }

        return $userVector;
    }

    /**
     * Find products liked by similar users
     */
    private function findSimilarUsersProducts(int $userId, array $excludeProductIds, int $limit): array
    {
        // Get users similar to target user based on purchase/cart history
        $similarUsers = UserProductInteraction::where('user_id', '!=', $userId)
            ->whereIn('product_id', function ($query) use ($userId) {
                $query->select('product_id')
                    ->from('user_product_interactions')
                    ->where('user_id', $userId)
                    ->where('rating', '>=', 3); // Products user added to cart or purchased
            })
            ->select('user_id')
            ->distinct()
            ->limit(10)
            ->pluck('user_id');

        if ($similarUsers->isEmpty()) {
            return [];
        }

        // Get products these similar users liked
        return UserProductInteraction::whereIn('user_id', $similarUsers)
            ->whereNotIn('product_id', $excludeProductIds)
            ->where('rating', '>=', 3)
            ->select('product_id')
            ->selectRaw('SUM(rating * interaction_count) as score')
            ->groupBy('product_id')
            ->orderBy('score', 'DESC')
            ->limit($limit)
            ->pluck('product_id')
            ->toArray();
    }

    /**
     * Save trained model to storage
     */
    private function saveModel(): void
    {
        if (!$this->model) {
            return;
        }

        $serialized = serialize($this->model);
        Storage::put(self::MODEL_PATH, $serialized);
    }

    /**
     * Load trained model from storage
     */
    private function loadModel(): ?KNearestNeighbors
    {
        if (!Storage::exists(self::MODEL_PATH)) {
            return null;
        }

        try {
            $serialized = Storage::get(self::MODEL_PATH);
            return unserialize($serialized);
        } catch (\Exception $e) {
            Log::error('Failed to load ML model', ['error' => $e->getMessage()]);
            return null;
        }
    }
}
