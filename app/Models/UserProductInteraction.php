<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProductInteraction extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'session_id',
        'interaction_type',
        'rating',
        'interaction_count',
    ];

    protected $casts = [
        'interaction_count' => 'integer',
        'rating' => 'integer',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public static function recordInteraction(?int $userId, int $productId, string $type, ?string $sessionId = null): void
    {
        $rating = match ($type) {
            'view' => 1,
            'cart' => 3,
            'purchase' => 5,
            default => 1,
        };

        if ($type === 'purchase') {
            static::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'session_id' => $sessionId,
                'interaction_type' => $type,
                'rating' => $rating,
                'interaction_count' => 1,
            ]);
            return;
        }

        // For views and cart, update existing or create new
        $interaction = static::where('user_id', $userId)
            ->where('product_id', $productId)
            ->where('interaction_type', $type)
            ->first();

        if ($interaction) {
            // Increment count for repeated views/cart additions
            $interaction->increment('interaction_count');
            $interaction->touch(); // Update timestamp
        } else {
            static::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'session_id' => $sessionId,
                'interaction_type' => $type,
                'rating' => $rating,
                'interaction_count' => 1,
            ]);
        }
    }

    /**
     * Get user-item interaction matrix for ML training
     */
    public static function getUserInteractionMatrix(): array
    {
        $interactions = static::with(['user', 'product'])
            ->whereNotNull('user_id')
            ->get();

        $matrix = [];

        foreach ($interactions->groupBy('user_id') as $userId => $userInteractions) {
            $userVector = [];

            foreach ($userInteractions as $interaction) {
                // Weight by rating * interaction_count
                $score = $interaction->rating * $interaction->interaction_count;
                $userVector[$interaction->product_id] = $score;
            }

            $matrix[$userId] = $userVector;
        }

        return $matrix;
    }

    /**
     * Get all training data for ML model
     */
    public static function getTrainingData(): array
    {
        return static::whereNotNull('user_id')
            ->select('user_id', 'product_id', 'rating', 'interaction_count')
            ->get()
            ->toArray();
    }
}
