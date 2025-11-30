<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Product, UserProductInteraction};
use Illuminate\Support\Facades\DB;

class UserProductInteractionSeeder extends Seeder
{
    /**
     * Seed test interaction data for ML training
     */
    public function run(): void
    {
        // Get existing users and products
        $users = User::limit(10)->get();
        $products = Product::limit(20)->get();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->warn('Please seed users and products first!');
            return;
        }

        $this->command->info('Seeding user-product interactions...');

        DB::beginTransaction();

        try {
            $interactionCount = 0;

            foreach ($users as $user) {
                // Each user views 5-10 random products
                $viewedProducts = $products->random(rand(5, 10));
                foreach ($viewedProducts as $product) {
                    UserProductInteraction::recordInteraction(
                        $user->id,
                        $product->id,
                        'view'
                    );
                    $interactionCount++;
                }

                // Each user adds 2-5 products to cart
                $cartProducts = $products->random(rand(2, 5));
                foreach ($cartProducts as $product) {
                    UserProductInteraction::recordInteraction(
                        $user->id,
                        $product->id,
                        'cart'
                    );
                    $interactionCount++;
                }

                // Each user purchases 1-3 products
                $purchasedProducts = $products->random(rand(1, 3));
                foreach ($purchasedProducts as $product) {
                    UserProductInteraction::recordInteraction(
                        $user->id,
                        $product->id,
                        'purchase'
                    );
                    $interactionCount++;
                }
            }

            DB::commit();

            $this->command->info("✓ Created {$interactionCount} interactions for ML training");
            $this->command->info('Run: php artisan recommendations:train');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('Seeding failed: ' . $e->getMessage());
        }
    }
}
