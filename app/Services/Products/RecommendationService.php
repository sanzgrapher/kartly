<?php

namespace App\Services\Products;

use App\Services\Products\Contracts\RecommendationServiceInterface;
use App\Services\ML\MLRecommendationEngine;
use App\Models\{Product, UserProductInteraction};
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RecommendationService implements RecommendationServiceInterface
{
    public function __construct(
        private MLRecommendationEngine $mlEngine
    ) {}

    /**
     * Get personalized recommendations for a user
     */
    public function getRecommendationsForUser(?int $userId, int $limit = 8): Collection
    {
        if (!$userId) {
            return $this->getPopularProducts($limit);
        }

        $interactionCount = UserProductInteraction::where('user_id', $userId)->count();

        if ($interactionCount < 5) {
            return $this->getPopularProducts($limit);
        }

        // Active user (5-10 interactions) - hybrid approach
        if ($interactionCount < 10) {
            $mlRecs = $this->mlEngine->getRecommendationsForUser($userId, (int)($limit / 2));
            $popular = $this->getPopularProducts((int)($limit / 2));
            return $mlRecs->merge($popular)->shuffle()->take($limit);
        }

        // Old user (10+ interactions) - full ML
        $mlRecs = $this->mlEngine->getRecommendationsForUser($userId, $limit);

        // Fallback to category-based if ML returns nothing
        if ($mlRecs->isEmpty()) {
            return $this->getRecommendationsFromPurchaseHistory($userId, $limit);
        }

        return $mlRecs;
    }

    /**
     * Get recommendations for a product page
     */
    public function getRecommendationsForProduct(Product $product, int $limit = 4): Collection
    {
        // Try ML-based similar products first
        $mlSimilar = $this->mlEngine->getSimilarProducts($product->id, $limit);

        if ($mlSimilar->isNotEmpty()) {
            return $mlSimilar;
        }

        // Fallback to category-based
        return Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('quantity', '>', 0)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Get homepage recommendations
     */
    public function getHomePageRecommendations(?int $userId = null): array
    {
        // Guest user
        if (!$userId) {
            return [
                'section_title' => 'Popular Products',
                'products' => $this->getPopularProducts(8),
                'is_personalized' => false
            ];
        }

        $interactionCount = UserProductInteraction::where('user_id', $userId)->count();

        // New user
        if ($interactionCount < 5) {
            return [
                'section_title' => 'Trending Products',
                'products' => $this->getTrendingProducts(8),
                'is_personalized' => false
            ];
        }

        // Active/Old user
        return [
            'section_title' => 'Recommended For You',
            'products' => $this->getRecommendationsForUser($userId, 8),
            'is_personalized' => true
        ];
    }

    /**
     * Track user interaction
     */
    public function trackInteraction(int $productId, ?int $userId, string $type, ?string $sessionId = null): void
    {
        UserProductInteraction::recordInteraction($userId, $productId, $type, $sessionId);
    }

    /**
     * Trigger model retraining
     */
    public function retrainModel(): bool
    {
        return $this->mlEngine->trainModel();
    }

    /**
     * Get popular products
     */
    private function getPopularProducts(int $limit): Collection
    {
        return Product::select('products.*')
            ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
            ->where('products.quantity', '>', 0)
            ->groupBy('products.id')
            ->orderByRaw('COUNT(order_items.id) DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * Get trending products (recently added)
     */
    private function getTrendingProducts(int $limit): Collection
    {
        return Product::where('created_at', '>=', now()->subDays(30))
            ->where('quantity', '>', 0)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }

    /**
     * Get recommendations based on purchase history
     */
    private function getRecommendationsFromPurchaseHistory(int $userId, int $limit): Collection
    {
        // Get categories user has purchased from
        $userCategories = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.user_id', $userId)
            ->distinct()
            ->pluck('products.category_id');

        if ($userCategories->isEmpty()) {
            return $this->getPopularProducts($limit);
        }

        // Get products from those categories (exclude already purchased)
        return Product::whereIn('category_id', $userCategories)
            ->whereNotIn('id', function ($query) use ($userId) {
                $query->select('product_id')
                    ->from('order_items')
                    ->join('orders', 'order_items.order_id', '=', 'orders.id')
                    ->where('orders.user_id', $userId);
            })
            ->where('quantity', '>', 0)
            ->inRandomOrder()
            ->limit($limit)
            ->get();
    }
}
