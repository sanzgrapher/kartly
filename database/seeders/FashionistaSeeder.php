<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Product, UserProductInteraction, Category};
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class FashionistaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create the Fashionista User
        $user = User::firstOrCreate(
            ['email' => 'fashionista@example.com'],
            [
                'name' => 'Fashion Lover',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info("Created user: fashionista@example.com (password: password)");

        // 2. Get Fashion & Beauty Categories
        $categories = Category::whereIn('name', ['Fashion', 'Beauty & Personal Care'])->get();

        if ($categories->isEmpty()) {
            $this->command->error("Fashion/Beauty categories not found!");
            return;
        }

        // 3. Get Products from these categories
        $targetProducts = Product::whereIn('category_id', $categories->pluck('id'))
            ->limit(10)
            ->get();

        if ($targetProducts->isEmpty()) {
            $this->command->error("No products found in Fashion/Beauty!");
            return;
        }

        $this->command->info("Simulating interactions for Fashion & Beauty products...");

        DB::beginTransaction();

        try {
            // 4. Create Heavy Interactions for Main User
            foreach ($targetProducts as $product) {
                // View 3 times
                UserProductInteraction::recordInteraction($user->id, $product->id, 'view');
                UserProductInteraction::recordInteraction($user->id, $product->id, 'view');
                UserProductInteraction::recordInteraction($user->id, $product->id, 'view');

                // Add to cart
                UserProductInteraction::recordInteraction($user->id, $product->id, 'cart');

                // Purchase some (50% chance)
                if (rand(0, 1)) {
                    UserProductInteraction::recordInteraction($user->id, $product->id, 'purchase');
                }
            }

            // 5. Create "Similar Users" (Neighbors)
            // We need other users who ALSO like these products for CF to work
            $similarUsers = User::factory(5)->create();

            foreach ($similarUsers as $similarUser) {
                // They like mostly the same products
                foreach ($targetProducts->random(5) as $product) {
                    UserProductInteraction::recordInteraction($similarUser->id, $product->id, 'view');
                    UserProductInteraction::recordInteraction($similarUser->id, $product->id, 'cart');
                }

                // But they ALSO like some OTHER fashion products (to recommend to our main user)
                $otherFashionProducts = Product::whereIn('category_id', $categories->pluck('id'))
                    ->whereNotIn('id', $targetProducts->pluck('id'))
                    ->limit(5)
                    ->get();

                foreach ($otherFashionProducts as $product) {
                    UserProductInteraction::recordInteraction($similarUser->id, $product->id, 'view');
                    UserProductInteraction::recordInteraction($similarUser->id, $product->id, 'purchase');
                }
            }

            DB::commit();
            $this->command->info("✓ Created interactions for Fashionista + 5 Similar Users.");
            $this->command->info("Run 'php artisan recommendations:train' to update the model.");
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error("Failed: " . $e->getMessage());
        }
    }
}
