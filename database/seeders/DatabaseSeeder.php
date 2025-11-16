<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
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
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'admin@example.com',
                'role' => 'admin',
            ]);
        }

        Category::factory(5)->has(Product::factory()->count(10))->create();

        User::factory(5)
            ->has(Address::factory()->count(2))
            ->has(Cart::factory()->has(CartItem::factory()->count(3)))
            ->has(Order::factory()->count(5)->has(OrderItem::factory()->count(4))->has(Payment::factory()))
            ->create();
    }
}
