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
        // $this->call([
        //     RoleSeeder::class,
        // ]);
        if (! User::where('email', 'admin@example.com')->exists()) {
            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'admin@example.com',
            ]);

            $user->changeRole(UserRole::ADMIN);
        }

         Category::factory(10)->has(Product::factory()->count(15))->create();

         $products = Product::all();

         User::factory(5)->has(Address::factory()->count(2))->create()->each(function ($user) use ($products) {
             $cart = Cart::factory()->for($user)->create();
            CartItem::factory()
                ->count(3)
                ->for($cart)
                ->state(fn() => ['product_id' => $products->random()->id])
                ->create();

             $orders = Order::factory()->count(5)->for($user)->create();
            $orders->each(function ($order) use ($products) {
                OrderItem::factory()
                    ->count(4)
                    ->for($order)
                    ->state(fn() => ['product_id' => $products->random()->id])
                    ->create();
                Payment::factory()->for($order)->create();
            });
        });
    }
}
