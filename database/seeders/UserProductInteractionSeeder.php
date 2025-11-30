<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Product, UserProductInteraction};
use Illuminate\Support\Facades\DB;
use App\Models\Category;

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
    // User::factory(5)->has(Address::factory()->count(2))->create()->each(function ($user) use ($products) {
        //     $cart = Cart::factory()->for($user)->create();
        //     CartItem::factory()
        //         ->count(3)
        //         ->for($cart)
        //         ->state(fn() => ['product_id' => $products->random()->id])
        //         ->create();

        //     $orders = Order::factory()->count(5)->for($user)->create();
        //     $orders->each(function ($order) use ($products) {
        //         OrderItem::factory()
        //             ->count(4)
        //             ->for($order)
        //             ->state(fn() => ['product_id' => $products->random()->id])
        //             ->create();
        //         Payment::factory()->for($order)->create();
        //     });
        // });
        $this->command->info('Seeding user-product interactions...');

        DB::beginTransaction();

        try {

  // Seed categories from CSV
        $this->seedCategoriesFromCsv();

        // Seed products from CSV
        $this->seedProductsFromCsv();


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






    private function seedCategoriesFromCsv(): void
    {
        $csvFile = database_path('seeders/data/categories.csv');

        if (!file_exists($csvFile)) {
            $this->command->warn('Categories CSV file not found!');
            return;
        }

        $file = fopen($csvFile, 'r');
        $header = fgetcsv($file); // Skip header row

        while (($row = fgetcsv($file)) !== false) {
            Category::updateOrCreate(
                ['id' => $row[0]], // Match by ID
                [
                    'name' => $row[1],
                    'slug' => $row[2],
                ]
            );
        }

        fclose($file);
        $this->command->info('Categories seeded from CSV successfully!');
    }

    /**
     * Seed products from CSV file
     */
    private function seedProductsFromCsv(): void
    {
        $csvFile = database_path('seeders/data/products.csv');

        if (!file_exists($csvFile)) {
            $this->command->warn('Products CSV file not found!');
            return;
        }

        $file = fopen($csvFile, 'r');
        $header = fgetcsv($file); // Skip header row

        while (($row = fgetcsv($file)) !== false) {
            Product::create([
                'name' => $row[0],
                'slug' => $row[1],
                'price' => (float) $row[2],
                'quantity' => (int) $row[3],
                'description' => $row[4],
                'category_id' => (int) $row[5],
                'image' => $row[6] ?? null,
            ]);
        }

        fclose($file);
        $this->command->info('Products seeded from CSV successfully!');
    }





}




