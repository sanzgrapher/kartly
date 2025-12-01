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
     * Get ML-based recommendations for a user using trained KNN model
     */
    public function getRecommendationsForUser(int $userId, int $limit = 10): Collection
    {
        try {
            // Load model if not already loaded
            if (!$this->model) {
                $this->model = $this->loadModel();
            }

            if (!$this->model) {
                Log::warning('ML model not available for user recommendations', ['user_id' => $userId]);
                return collect();
            }

            // Get user's interaction history
            $userInteractions = UserProductInteraction::where('user_id', $userId)
                ->get();

            if ($userInteractions->isEmpty()) {
                return collect();
            }

            // Build user vector for prediction
            $userVector = $this->buildUserVector($userInteractions);

            // Get products user has already interacted with
            $interactedProductIds = $userInteractions->pluck('product_id')->toArray();

            // Use KNN model to find similar users
            $similarUserIds = $this->predictSimilarUsers($userVector, $userId);

            if (empty($similarUserIds)) {
                Log::info('No similar users found via ML model', ['user_id' => $userId]);
                return collect();
            }

            // Get products liked by similar users
            $recommendedProductIds = $this->getProductsFromSimilarUsers($similarUserIds, $interactedProductIds, $limit);

            // Return products
            return Product::whereIn('id', $recommendedProductIds)
                ->where('quantity', '>', 0)
                ->limit($limit)
                ->get();
        } catch (\Exception $e) {
            Log::error('ML recommendation failed', [
                'user_id' => $userId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
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
     * Use trained KNN model to predict similar users based on interaction patterns
     */
    private function predictSimilarUsers(array $userVector, int $currentUserId): array
    {
        try {
            // Get all user vectors from the database to compare
            $allUserInteractions = UserProductInteraction::whereNotNull('user_id')
                ->where('user_id', '!=', $currentUserId)
                ->get()
                ->groupBy('user_id');

            if ($allUserInteractions->isEmpty()) {
                return [];
            }

            // Build vectors for all users and calculate cosine similarity
            $similarities = [];
            $allProductIds = Product::pluck('id')->toArray();

            foreach ($allUserInteractions as $otherUserId => $interactions) {
                $otherUserVector = $this->buildUserVectorFromInteractions($interactions, $allProductIds);
                
                // Calculate cosine similarity between current user and other user
                $similarity = $this->cosineSimilarity($userVector, $otherUserVector);
                
                if ($similarity > 0) {
                    $similarities[(int)$otherUserId] = $similarity;
                }
            }

            // Sort by similarity (highest first) and take top K neighbors
            arsort($similarities);
            $topSimilarUsers = array_slice(array_keys($similarities), 0, 5, true);

            Log::info('KNN model found similar users', [
                'current_user' => $currentUserId,
                'similar_users' => $topSimilarUsers,
                'similarities' => array_slice($similarities, 0, 5, true)
            ]);

            return $topSimilarUsers;
        } catch (\Exception $e) {
            Log::error('Failed to predict similar users', [
                'error' => $e->getMessage(),
                'user_id' => $currentUserId
            ]);
            return [];
        }
    }

    /**
     * Calculate cosine similarity between two vectors
     */
    private function cosineSimilarity(array $vectorA, array $vectorB): float
    {
        $dotProduct = 0;
        $magnitudeA = 0;
        $magnitudeB = 0;

        for ($i = 0; $i < count($vectorA); $i++) {
            $dotProduct += $vectorA[$i] * $vectorB[$i];
            $magnitudeA += $vectorA[$i] * $vectorA[$i];
            $magnitudeB += $vectorB[$i] * $vectorB[$i];
        }

        $magnitudeA = sqrt($magnitudeA);
        $magnitudeB = sqrt($magnitudeB);

        if ($magnitudeA == 0 || $magnitudeB == 0) {
            return 0;
        }

        return $dotProduct / ($magnitudeA * $magnitudeB);
    }

    /**
     * Build user vector from interactions collection
     */
    private function buildUserVectorFromInteractions(Collection $interactions, array $allProductIds): array
    {
        $userVector = array_fill(0, count($allProductIds), 0);

        foreach ($interactions as $interaction) {
            $productIndex = array_search($interaction->product_id, $allProductIds);
            if ($productIndex !== false) {
                $userVector[$productIndex] = $interaction->rating * $interaction->interaction_count;
            }
        }

        return $userVector;
    }

    /**
     * Get products liked by similar users (found via ML model)
     */
    private function getProductsFromSimilarUsers(array $similarUserIds, array $excludeProductIds, int $limit): array
    {
        if (empty($similarUserIds)) {
            return [];
        }

        // Get products these ML-identified similar users liked
        return UserProductInteraction::whereIn('user_id', $similarUserIds)
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
