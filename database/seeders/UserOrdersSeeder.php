<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{User, Address, Cart, CartItem, Order, OrderItem, Payment, Product}; 


class UserOrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        User::factory(5)->has(Address::factory()->count(2))->create()->each(function ($user) use ($products) {
            $cart = Cart::factory()->for($user)->create();
            CartItem::factory()
            ->count(3)
            ->for($cart)
            ->state(fn() => ['product_id' => $products->random()->id])
            ->create();

            $orders = Order::factory()
            ->count(5)
            ->for($user)
            ->state(function () {
                // random time within last 30 days
                $date = now()->subDays(rand(0, 30))->subMinutes(rand(0, 1440));
                return ['created_at' => $date, 'updated_at' => $date];
            })
            ->create();

            $orders->each(function ($order) use ($products) {
            OrderItem::factory()
                ->count(4)
                ->for($order)
                ->state(fn() => [
                'product_id' => $products->random()->id,
                'created_at' => $order->created_at,
                'updated_at' => $order->created_at,
                ])
                ->create();

            // create a payment shortly after the order time (still within last 30 days)
            $paymentTime = $order->created_at->copy()->addMinutes(rand(1, 60));
            if ($paymentTime->greaterThan(now())) {
                $paymentTime = now();
            }

            Payment::factory()->for($order)->create([
                'created_at' => $paymentTime,
                'updated_at' => $paymentTime,
            ]);
            });
        });
        }
    }
