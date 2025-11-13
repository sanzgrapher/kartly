<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Order;

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
        return [
            'order_id'         => Order::factory(),
            'payment_method'   => fake()->randomElement(['credit_card', 'paypal', 'bank_transfer']),
            'transaction_code' => fake()->unique()->uuid(),
            'payment_status'   => fake()->randomElement(['pending', 'completed', 'failed']),
            'amount'           => fake()->numberBetween(100, 100000),
        ];
    }
}
