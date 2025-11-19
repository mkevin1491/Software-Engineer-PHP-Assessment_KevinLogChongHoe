<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'Wireless Mouse',
                'description' => 'Ergonomic wireless mouse with adjustable DPI.',
                'price' => 49.90,
                'image' => '/images/products/mouse.jpeg'
            ],
            [
                'name' => 'Mechanical Keyboard',
                'description' => 'RGB backlit mechanical keyboard with tactile switches.',
                'price' => 199.00,
                'image' => '/images/products/keyboard.jpeg'
            ],
            [
                'name' => 'Gaming Headset',
                'description' => 'Surround sound headset with noise-cancelling mic.',
                'price' => 129.50,
                'image' => '/images/products/headset.jpeg'
            ],
            [
                'name' => 'USB-C Hub',
                'description' => '5-in-1 USB-C hub for laptops and tablets.',
                'price' => 79.00,
                'image' => '/images/products/usbchub.jpeg'
            ],
            [
                'name' => 'Webcam HD',
                'description' => '1080p webcam for video calls and streaming.',
                'price' => 89.90,
                'image' => '/images/products/webcam.jpeg'
            ],
            [
                'name' => 'Portable SSD 1TB',
                'description' => 'High-speed portable SSD for quick file transfers.',
                'price' => 399.00,
                'image' => '/images/products/ssd.jpeg'
            ],
            [
                'name' => 'Smartwatch',
                'description' => 'Fitness smartwatch with heart rate and sleep tracking.',
                'price' => 249.90,
                'image' => '/images/products/smartwatch.jpeg'
            ],
            [
                'name' => 'Bluetooth Speaker',
                'description' => 'Portable waterproof Bluetooth speaker with long battery life.',
                'price' => 149.50,
                'image' => '/images/products/speaker.jpeg'
            ],
            [
                'name' => 'Laptop Stand',
                'description' => 'Adjustable aluminum laptop stand for better ergonomics.',
                'price' => 99.90,
                'image' => '/images/products/laptopstand.jpeg'
            ],
            [
                'name' => 'Wireless Charger',
                'description' => 'Fast wireless charger for smartphones and earbuds.',
                'price' => 59.90,
                'image' => '/images/products/charger.jpeg'
            ],
            [
                'name' => 'Noise Cancelling Earbuds',
                'description' => 'True wireless earbuds with active noise cancellation.',
                'price' => 179.90,
                'image' => '/images/products/earbuds.jpeg'
            ],
            [
                'name' => 'Gaming Mouse Pad',
                'description' => 'Large mouse pad with smooth surface for precision gaming.',
                'price' => 39.90,
                'image' => '/images/products/mousepad.jpeg'
            ],
            [
                'name' => '4K Monitor',
                'description' => '27-inch 4K UHD monitor with HDR support.',
                'price' => 1299.00,
                'image' => '/images/products/monitor.jpeg'
            ],
            [
                'name' => 'External Hard Drive 2TB',
                'description' => 'Portable external HDD for backup and storage.',
                'price' => 199.00,
                'image' => '/images/products/hdd.jpeg'
            ],
            [
                'name' => 'Laptop Backpack',
                'description' => 'Water-resistant backpack with laptop compartment.',
                'price' => 149.00,
                'image' => '/images/products/backpack.jpeg'
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}