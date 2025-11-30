<?php

namespace App\Services\Products\Contracts;

use App\Models\Product;
use Illuminate\Support\Collection;

interface RecommendationServiceInterface
{
    /**
     * Get personalized recommendations for a user
     */
    public function getRecommendationsForUser(?int $userId, int $limit = 8): Collection;

    /**
     * Get recommendations for a product page (similar products)
     */
    public function getRecommendationsForProduct(Product $product, int $limit = 4): Collection;

    /**
     * Get homepage recommendations
     */
    public function getHomePageRecommendations(?int $userId = null): array;

    /**
     * Track user interaction with a product
     */
    public function trackInteraction(int $productId, ?int $userId, string $type, ?string $sessionId = null): void;

    /**
     * Trigger model retraining
     */
    public function retrainModel(): bool;
}
