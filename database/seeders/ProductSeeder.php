<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample products
        $products = [
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Laptop Pro',
                'price' => 1299.99,
                'description' => 'High-performance laptop with 16GB RAM, 512GB SSD, and the latest processor for professional use.',
                'image_path' => 'images/products/laptop-pro.jpg',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Smartphone X',
                'price' => 799.99,
                'description' => 'Latest smartphone with 6.5" OLED display, 128GB storage, and advanced camera system.',
                'image_path' => 'images/products/smartphone-x.jpg',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Wireless Headphones',
                'price' => 149.99,
                'description' => 'Premium noise-cancelling wireless headphones with 30-hour battery life and comfortable ear cushions.',
                'image_path' => 'images/products/wireless-headphones.jpg',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Smart Watch',
                'price' => 249.99,
                'description' => 'Feature-rich smartwatch with health monitoring, notifications, and 5-day battery life.',
                'image_path' => 'images/products/smart-watch.jpg',
            ],
            [
                'id' => Str::uuid()->toString(),
                'name' => 'Tablet Ultra',
                'price' => 499.99,
                'description' => 'Lightweight tablet with 10.9" Retina display, A14 chip, and all-day battery life. Perfect for work and entertainment.',
                'image_path' => 'images/products/tablet-ultra.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}