<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
       
        if (! User::where('email', 'admin@example.com')->exists()) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'admin@example.com',
            ]);

            $user->changeRole(UserRole::ADMIN);
            $user2 = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

            $user2->changeRole(UserRole::CUSTOMER);
        }
        // Category::factory(10)->has(Product::factory()->count(15))->create();

        // Seed categories from CSV
        $this->seedCategoriesFromCsv();

        // Seed products from CSV
        $this->seedProductsFromCsv();

        $products = Product::all();
        $this->call([
            // RoleSeeder::class,
            FashionistaSeeder::class,
        ]);
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
    }

    /**
     * Seed categories from CSV file
     */
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
