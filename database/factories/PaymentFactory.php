<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paymentMethod = fake()->randomElement(['cash_on_delivery', 'esewa']);
         $paymentStatus = $paymentMethod === 'esewa' ? 'completed' : fake()->randomElement(['pending', 'failed']);

        return [
            'order_id' => Order::factory(),
            'payment_method' => $paymentMethod,
            'transaction_code' => fake()->unique()->uuid(),
            'payment_status' => $paymentStatus,
            'amount' => fake()->numberBetween(1, 9999),
        ];
    }
}
