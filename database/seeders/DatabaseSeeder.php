<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
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

        $categories = Category::factory(10)->create();

        $categories->each(function ($category) {
            Product::factory(15)->create([
                'category_id' => $category->id,
            ]);
        });

        $users = User::factory(5)->create();

        $users->each(function ($user) {
            Address::factory(2)->create([
                'user_id' => $user->id,
            ]);
        });

    }
}
