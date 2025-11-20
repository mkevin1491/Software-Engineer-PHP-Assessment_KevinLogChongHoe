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
                'short_description' => 'Ergonomic wireless mouse with adjustable DPI and silent clicks.',
                'full_description' => 'This ergonomic wireless mouse is designed for comfort and precision. Featuring adjustable DPI levels, silent-click buttons, and a responsive optical sensor, it delivers smooth performance for office work, browsing, and light gaming. The compact design fits naturally in the hand, reducing fatigue during long sessions.',
                'specs' => [
                    'Sensor' => 'Optical Tracking',
                    'DPI Levels' => '800 / 1200 / 1600',
                    'Connectivity' => '2.4GHz Wireless',
                    'Battery Life' => 'Up to 12 months',
                    'Weight' => '85g',
                    'Compatibility' => 'Windows, macOS, Linux',
                ],
                'category' => 'Accessories',
                'brand' => 'LogiTech',
                'model_no' => 'WM-X200',
                'warranty' => '1 Year Warranty',
                'price' => 49.90,
                'image' => '/images/products/mouse.jpeg',
            ],

            [
                'name' => 'Mechanical Keyboard',
                'short_description' => 'RGB mechanical keyboard with tactile switches and full N-key rollover.',
                'full_description' => 'A premium RGB mechanical keyboard built for both productivity and gaming. Equipped with durable tactile switches, full anti-ghosting, and customizable RGB lighting, it delivers a precise and enjoyable typing experience. Its solid aluminum top plate adds durability and a premium feel.',
                'specs' => [
                    'Switch Type' => 'Tactile (Brown)',
                    'Layout' => '104 Keys',
                    'Lighting' => '16.8M RGB Customizable',
                    'Connectivity' => 'USB-C Wired',
                    'Key Rollover' => 'Full N-Key',
                    'Frame Material' => 'Aluminum Top Plate',
                ],
                'category' => 'Peripherals',
                'brand' => 'KeyChron',
                'model_no' => 'MK-K200',
                'warranty' => '2 Years Warranty',
                'price' => 199.00,
                'image' => '/images/products/keyboard.jpeg',
            ],

            [
                'name' => 'Gaming Headset',
                'short_description' => 'Surround sound headset with noise-cancelling microphone.',
                'full_description' => 'Experience immersive gaming audio with this high-performance surround sound headset. It features soft memory foam cushions, a detachable noise-cancelling microphone, and enhanced bass response for competitive gaming. Ideal for long gaming sessions with maximum comfort.',
                'specs' => [
                    'Driver Size' => '50mm',
                    'Sound' => 'Virtual 7.1 Surround',
                    'Microphone' => 'Noise Cancelling, Detachable',
                    'Connectivity' => 'USB / 3.5mm',
                    'Weight' => '280g',
                ],
                'category' => 'Audio',
                'brand' => 'HyperX',
                'model_no' => 'HG-500',
                'warranty' => '2 Years Warranty',
                'price' => 129.50,
                'image' => '/images/products/headset.jpeg',
            ],

            [
                'name' => 'USB-C Hub',
                'short_description' => '5-in-1 USB-C hub for laptops and tablets.',
                'full_description' => 'This compact 5-in-1 USB-C hub expands your device connectivity with HDMI output, USB-A ports, and SD card support. Designed for productivity and travel, the hub features fast data transfer and durable aluminum housing.',
                'specs' => [
                    'Ports' => '1× HDMI, 2× USB-A 3.0, 1× SD, 1× MicroSD',
                    'HDMI Output' => '4K 30Hz',
                    'Material' => 'Aluminum Alloy',
                    'Cable' => 'Built-in USB-C',
                ],
                'category' => 'Accessories',
                'brand' => 'Ugreen',
                'model_no' => 'UC-HB51',
                'warranty' => '1 Year Warranty',
                'price' => 79.00,
                'image' => '/images/products/usbchub.jpeg',
            ],

            [
                'name' => 'Webcam HD',
                'short_description' => '1080p webcam ideal for meetings and streaming.',
                'full_description' => 'A high-definition webcam designed for video calls, virtual meetings, and online streaming. With automatic light correction and a wide-angle lens, it delivers clear visuals even in low-light environments.',
                'specs' => [
                    'Resolution' => '1080p Full HD',
                    'Field of View' => '90°',
                    'Microphone' => 'Dual Noise Reduction Mics',
                    'Mounting' => 'Clip-on / Tripod Compatible',
                ],
                'category' => 'Video',
                'brand' => 'LogiTech',
                'model_no' => 'WC-1080',
                'warranty' => '1 Year Warranty',
                'price' => 89.90,
                'image' => '/images/products/webcam.jpeg',
            ],

            [
                'name' => 'Portable SSD 1TB',
                'short_description' => 'High-speed 1TB portable SSD for fast file transfers.',
                'full_description' => 'This 1TB portable SSD delivers ultra-fast data transfer speeds suitable for video editing, backups, and everyday storage. Shock-resistant and lightweight, making it perfect for travel.',
                'specs' => [
                    'Capacity' => '1TB',
                    'Speed' => 'Up to 1050 MB/s',
                    'Interface' => 'USB-C 3.2 Gen 2',
                    'Durability' => 'Shock Resistant (2m Drop)',
                ],
                'category' => 'Storage',
                'brand' => 'Samsung',
                'model_no' => 'T7-1TB',
                'warranty' => '3 Years Warranty',
                'price' => 399.00,
                'image' => '/images/products/ssd.jpeg',
            ],

            [
                'name' => 'Smartwatch',
                'short_description' => 'Fitness smartwatch with heart rate, GPS, and sleep tracking.',
                'full_description' => 'A versatile smartwatch built for health tracking and productivity. Features continuous heart-rate monitoring, built-in GPS, detailed sleep analysis, and long battery life. Works seamlessly with both iOS and Android.',
                'specs' => [
                    'Display' => '1.4” AMOLED',
                    'Sensors' => 'Heart Rate, SpO2, Accelerometer',
                    'GPS' => 'Built-in',
                    'Battery Life' => 'Up to 10 Days',
                ],
                'category' => 'Wearables',
                'brand' => 'Amazfit',
                'model_no' => 'SW-GT4',
                'warranty' => '1 Year Warranty',
                'price' => 249.90,
                'image' => '/images/products/smartwatch.jpeg',
            ],

            [
                'name' => 'Bluetooth Speaker',
                'short_description' => 'Portable waterproof Bluetooth speaker with deep bass.',
                'full_description' => 'A compact Bluetooth speaker with powerful sound and waterproof durability. Ideal for travel, outdoor activities, or home use, with a battery life lasting up to 12 hours.',
                'specs' => [
                    'Output' => '20W',
                    'Battery Life' => '12 Hours',
                    'Waterproof Rating' => 'IPX7',
                    'Connectivity' => 'Bluetooth 5.1',
                ],
                'category' => 'Audio',
                'brand' => 'JBL',
                'model_no' => 'BS-Go3',
                'warranty' => '1 Year Warranty',
                'price' => 149.50,
                'image' => '/images/products/speaker.jpeg',
            ],

            [
                'name' => 'Laptop Stand',
                'short_description' => 'Adjustable aluminum laptop stand with improved airflow.',
                'full_description' => 'A lightweight but sturdy laptop stand designed to improve ergonomics and airflow. Adjustable height and angle allow comfortable long-hour use while reducing neck strain.',
                'specs' => [
                    'Material' => 'Aluminum Alloy',
                    'Adjustable Height' => '6 Levels',
                    'Weight Capacity' => '20kg',
                    'Compatibility' => '11"–17" Laptops',
                ],
                'category' => 'Accessories',
                'brand' => 'NexStand',
                'model_no' => 'LS-600',
                'warranty' => '1 Year Warranty',
                'price' => 99.90,
                'image' => '/images/products/laptopstand.jpeg',
            ],

            [
                'name' => 'Wireless Charger',
                'short_description' => 'Fast wireless charger for smartphones and earbuds.',
                'full_description' => 'A compact wireless charger supporting fast charging for compatible smartphones and TWS earbuds. Designed with over-charge and temperature protection.',
                'specs' => [
                    'Output' => '15W Fast Charging',
                    'Standard' => 'Qi Certified',
                    'Cable' => 'USB-C Included',
                    'Protection' => 'Overheat & Overcharge Protection',
                ],
                'category' => 'Charging',
                'brand' => 'Anker',
                'model_no' => 'WC-15F',
                'warranty' => '18 Months Warranty',
                'price' => 59.90,
                'image' => '/images/products/charger.jpeg',
            ],

            [
                'name' => 'Noise Cancelling Earbuds',
                'short_description' => 'Wireless earbuds with ANC and long battery life.',
                'full_description' => 'Premium ANC earbuds with deep bass, crystal-clear calling microphones, and a comfortable in-ear seal. Offers up to 7 hours of playtime on a single charge.',
                'specs' => [
                    'Noise Cancellation' => 'Active ANC',
                    'Battery Life' => '7h (Earbuds) + 21h (Case)',
                    'Connectivity' => 'Bluetooth 5.2',
                    'Water Rating' => 'IPX4',
                ],
                'category' => 'Audio',
                'brand' => 'Sony',
                'model_no' => 'WF-NC300',
                'warranty' => '1 Year Warranty',
                'price' => 179.90,
                'image' => '/images/products/earbuds.jpeg',
            ],

            [
                'name' => 'Gaming Mouse Pad',
                'short_description' => 'Large smooth mouse pad for precision gaming.',
                'full_description' => 'A durable gaming mouse pad with a smooth micro-woven surface for optimal speed and control. The anti-slip rubber base ensures stability even in intense gaming sessions.',
                'specs' => [
                    'Size' => '900×400 mm',
                    'Surface' => 'Micro-Woven Cloth',
                    'Base' => 'Anti-Slip Rubber',
                    'Thickness' => '4mm',
                ],
                'category' => 'Accessories',
                'brand' => 'SteelSeries',
                'model_no' => 'MP-QCKXL',
                'warranty' => '6 Months Warranty',
                'price' => 39.90,
                'image' => '/images/products/mousepad.jpeg',
            ],

            [
                'name' => '4K Monitor',
                'short_description' => '27-inch 4K UHD monitor with HDR and IPS panel.',
                'full_description' => 'A professional 27-inch 4K UHD monitor featuring an IPS display for exceptional color accuracy and HDR support for vivid visuals. Suitable for content creators, designers, and productivity users.',
                'specs' => [
                    'Resolution' => '3840 × 2160 (4K UHD)',
                    'Panel Type' => 'IPS',
                    'Refresh Rate' => '60Hz',
                    'Ports' => 'HDMI, DisplayPort, USB-C',
                ],
                'category' => 'Displays',
                'brand' => 'Dell',
                'model_no' => 'U2723QX',
                'warranty' => '3 Years Warranty',
                'price' => 1299.00,
                'image' => '/images/products/monitor.jpeg',
            ],

            [
                'name' => 'External Hard Drive 2TB',
                'short_description' => 'Portable external HDD suitable for backup and storage.',
                'full_description' => 'A reliable 2TB external HDD with USB 3.0 connectivity. Ideal for backups, file storage, and transferring large files. Lightweight and durable.',
                'specs' => [
                    'Capacity' => '2TB',
                    'Interface' => 'USB 3.0',
                    'Transfer Speed' => 'Up to 120 MB/s',
                    'Shock Resistance' => 'Yes',
                ],
                'category' => 'Storage',
                'brand' => 'Seagate',
                'model_no' => 'STEA-2000',
                'warranty' => '3 Years Warranty',
                'price' => 199.00,
                'image' => '/images/products/hdd.jpeg',
            ],

            [
                'name' => 'Laptop Backpack',
                'short_description' => 'Durable water-resistant backpack with padded laptop compartment.',
                'full_description' => 'A lightweight and durable backpack featuring a padded compartment that fits laptops up to 17 inches. Water-resistant exterior keeps your belongings safe in any weather.',
                'specs' => [
                    'Material' => 'Water-Resistant Polyester',
                    'Capacity' => '22L',
                    'Laptop Size Support' => 'Up to 17 inches',
                    'Extra Features' => 'USB Charging Port, Anti-Theft Pocket'
                ],
                'category' => 'Bags',
                'brand' => 'Tigernu',
                'model_no' => 'BP-T22',
                'warranty' => '1 Year Warranty',
                'price' => 149.00,
                'image' => '/images/products/backpack.jpeg',
            ],

        ];

        foreach ($products as $product) {
            Product::updateOrCreate($product);
        }
    }
}
