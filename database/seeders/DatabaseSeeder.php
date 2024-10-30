<?php

namespace Database\Seeders;

use App\Models\{User,Order,Product};
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)
        ->hasOrders(3)
        ->create()
        ->each(function ($user) {
            $products = Product::factory(5)->create();
            foreach ($products as $product) {
                $user->orders()->each(function ($order) use ($product) {
                    $order->products()->attach($product->id, ['quantity' => rand(1, 5)]);
                });
            }
        });
    }
}
