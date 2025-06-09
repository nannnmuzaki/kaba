<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            [
                'id' => 'a1b2c3d4-e5f6-7890-1234-567890abcdef',
                'category_id' => '7ec9384d-5fe0-4d37-8a43-376ece635514', // GPU
                'name' => 'ASUS ROG STRIX GeForce RTX 5090 OC',
                'price' => 68870000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/NOUbiQJyjxX4ZkSHx6Vei6kYHONPFs9JkW5Voufu.png',
                'description' => "The ASUS ROG Strix GeForce RTX 5090 OC is a top-of-the-line graphics card designed for extreme gaming performance. It features the latest NVIDIA architecture, a massive amount of VRAM, and a robust cooling solution to handle the most demanding games and creative workloads.

### Specifications
* **GPU:** NVIDIA GeForce RTX 5090
* **VRAM:** 32GB GDDR7
* **CUDA Cores:** 20480
* **Boost Clock:** TBD
* **Ports:** 3x DisplayPort 2.1, 2x HDMI 2.1",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'b2c3d4e5-f6a7-8901-2345-67890abcdef1',
                'category_id' => '7ec9384d-5fe0-4d37-8a43-376ece635514', // GPU
                'name' => 'ASUS Dual GeForce RTX 4070 SUPER OC Edition 12GB GDDR6X',
                'price' => 12179000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/mw9re1YfPjMqy9fniqwZFr38VmTasK7Iuwp4wo2J.webp',
                'description' => "The ASUS Dual GeForce RTX 4070 SUPER OC Edition is a performance-focused graphics card that brings the power of NVIDIA's Ada Lovelace architecture to a wider audience. It's an excellent choice for high-refresh-rate 1440p gaming.

### Specifications
* **GPU:** NVIDIA GeForce RTX 4070 SUPER
* **VRAM:** 12GB GDDR6X
* **CUDA Cores:** 7168
* **Boost Clock:** 2550 MHz (OC Mode)
* **Ports:** 3x DisplayPort 1.4a, 1x HDMI 2.1",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'c3d4e5f6-a7b8-9012-3456-7890abcdef12',
                'category_id' => '6209eb9f-4d83-4478-ae4a-c57f64829292', // SSD - Storage
                'name' => 'KLEVV CRAS C930 SSD M.2 NVMe',
                'price' => 1399000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/LQCLsD40KEDbeFhyNw5ry2VSkuAd8a5t34zByn31.png',
                'description' => "The KLEVV CRAS C930 is a high-speed M.2 NVMe SSD that delivers exceptional read and write performance, making it ideal for gamers and content creators who need fast loading times and quick file transfers.

### Specifications
* **Capacity:** 1TB
* **Interface:** PCIe Gen4 x4 NVMe
* **Sequential Read:** Up to 7400 MB/s
* **Sequential Write:** Up to 6800 MB/s
* **Form Factor:** M.2 2280",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'd4e5f6a7-b8c9-0123-4567-890abcdef123',
                'category_id' => '043a90bf-c448-4f42-b7e1-f89c9d38f84e', // Power Supply
                'name' => 'Fractal Design Ion+ 2 Platinum 860W',
                'price' => 1495000,
                'tokopedia_link' => 'https://www.tokopedia.com/enterkomputer/fractal-design-ion-2-660w-80-platinum-fully-modular-psu-660w?extParam=ivf%3Dfalse%26keyword%3Dfractal+design+ion%2B+2%26search_id%3D2025052413093131BD5F0B4030441F6VLQ%26src%3Dsearch&t_id=1748092182093&t_st=1&t_pp=search_result&t_efo=search_pure_goods_card&t_ef=goods_search&t_sm=&t_spt=search_result',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/pTkKpHlYpNZZWWsi45QDg3aGGnROpPIfQQmMG8b3.webp',
                'description' => "The Fractal Design Ion+ 2 Platinum is a fully modular power supply that offers high efficiency and quiet operation. Its 860W output is sufficient for high-end gaming rigs and workstations.

### Specifications
* **Wattage:** 860W
* **Efficiency:** 80 PLUS Platinum
* **Modularity:** Fully Modular
* **Fan Size:** 140mm
* **Connectors:** 1x ATX, 2x EPS, 6x PCIe, 10x SATA, 4x Molex",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'e5f6a7b8-c9d0-1234-5678-90abcdef1234',
                'category_id' => 'cc4fcbb2-e455-4935-ba89-76665586a897', // PC Case
                'name' => 'DARKFLASH DRX70 Mesh ATX PC Case',
                'price' => 709000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/uZwcBkf71rSlaYXWfZjulqyJz3PlktLrSfKIHJKw.png',
                'description' => "The DARKFLASH DRX70 is a mid-tower ATX case with a focus on airflow, thanks to its mesh front panel. It offers a spacious interior for easy building and compatibility with a wide range of components.

### Specifications
* **Type:** ATX Mid Tower
* **Motherboard Support:** ATX, Micro-ATX, Mini-ITX
* **Expansion Slots:** 7
* **Max GPU Length:** 340mm
* **Front I/O:** 1x USB 3.0, 2x USB 2.0, HD Audio",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'f6a7b8c9-d0e1-2345-6789-0abcdef12345',
                'category_id' => '8f6950f7-0e90-4f7b-829d-800ec8e0a8b8', // CPU
                'name' => 'AMD Ryzen 7 9800X3D',
                'price' => 8890000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/fy0QknsgM1VdT6EsiMuS06F7x34xEP6gr9lL9NOk.webp',
                'description' => "The AMD Ryzen 7 9800X3D is a gaming-focused processor featuring AMD's innovative 3D V-Cache technology. This provides a massive L3 cache, leading to significant performance gains in many games.

### Specifications
* **Cores:** 8
* **Threads:** 16
* **Base Clock:** 4.5 GHz
* **Boost Clock:** 5.0 GHz
* **L3 Cache:** 96MB",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'a7b8c9d0-e1f2-3456-7890-1bcdef123456',
                'category_id' => '7ec9384d-5fe0-4d37-8a43-376ece635514', // GPU
                'name' => 'SAPPHIRE NITRO+ AMD Radeon RX 9870 XT GPU',
                'price' => 15099000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/SAERhNryo3bRnl9Uykwns9U9NEXVFZwnE0y8V8bU.png',
                'description' => "The Sapphire NITRO+ AMD Radeon RX 9870 XT is a high-performance graphics card built on AMD's latest architecture. It's designed for exceptional 4K gaming and content creation, featuring a robust cooling system and factory overclock.

### Specifications
* **GPU:** AMD Radeon RX 9870 XT
* **VRAM:** 16GB GDDR7
* **Stream Processors:** 5120
* **Boost Clock:** TBD
* **Ports:** 2x DisplayPort 2.1, 2x HDMI 2.1",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'b8c9d0e1-f2a3-4567-8901-2cdef1234567',
                'category_id' => '043a90bf-c448-4f42-b7e1-f89c9d38f84e', // Power Supply
                'name' => 'Cooler Master MWE Gold 750 V2 ATX 3.0',
                'price' => 1868000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/fpDG6hSayD8C14KbdGpG8p4LP7WGYcs3NJbLZxzT.jpg',
                'description' => "The Cooler Master MWE Gold 750 V2 is a reliable and efficient power supply that is ATX 3.0 and PCIe 5.0 ready. It's a great choice for modern builds that require stable power delivery.

### Specifications
* **Wattage:** 750W
* **Efficiency:** 80 PLUS Gold
* **Modularity:** Fully Modular
* **Fan Size:** 120mm
* **Connectors:** 1x ATX, 1x EPS, 1x 12VHPWR, 3x PCIe, 8x SATA, 4x Molex",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'c9d0e1f2-a3b4-5678-9012-3def12345678',
                'category_id' => '8f6950f7-0e90-4f7b-829d-800ec8e0a8b8', // CPU
                'name' => 'AMD Ryzen 5 5600',
                'price' => 1395000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/gOKHL59l219XpRElm19S0r4uWZ9dAqHW7fBSnSDs.webp',
                'description' => "The AMD Ryzen 5 5600 is a highly popular mid-range processor that offers excellent gaming and productivity performance for its price. It's a great value option for budget-conscious builders.

### Specifications
* **Cores:** 6
* **Threads:** 12
* **Base Clock:** 3.5 GHz
* **Boost Clock:** 4.4 GHz
* **L3 Cache:** 32MB",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'd0e1f2a3-b4c5-6789-0123-4ef123456789',
                'category_id' => '697d5475-7f0c-47d7-8b2c-ac49f822a9cd', // Motherboard
                'name' => 'ASRock B550M Pro4',
                'price' => 1695000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/ZuBh2bTpRQroWTmWdEiVq7IFjdp1NhbFKO8o3lxo.png',
                'description' => "The ASRock B550M Pro4 is a feature-rich micro-ATX motherboard that offers a stable platform for AMD Ryzen processors. It includes PCIe 4.0 support, dual M.2 slots, and a robust power delivery system.

### Specifications
* **Form Factor:** Micro-ATX
* **Chipset:** AMD B550
* **Socket:** AM4
* **Memory Support:** 4x DDR4 DIMM, up to 128GB
* **Expansion Slots:** 1x PCIe 4.0 x16, 1x PCIe 3.0 x16, 1x PCIe 3.0 x1",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'e1f2a3b4-c5d6-7890-1234-5f1234567890',
                'category_id' => '7ec9384d-5fe0-4d37-8a43-376ece635514', // GPU
                'name' => 'XFX SPEEDSTER SWFT 210 AMD Radeon RX 6600 CORE Gaming',
                'price' => 3610000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/uE5xIXWwX9V0mUQ5e6G5Yzjf5nMwHJMnzS6XfhBS.jpg',
                'description' => "The XFX Speedster SWFT 210 Radeon RX 6600 is a solid 1080p gaming graphics card based on AMD's RDNA 2 architecture. It offers a great balance of performance and price for mainstream gamers.

### Specifications
* **GPU:** AMD Radeon RX 6600
* **VRAM:** 8GB GDDR6
* **Stream Processors:** 1792
* **Boost Clock:** Up to 2491 MHz
* **Ports:** 3x DisplayPort 1.4, 1x HDMI 2.1",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 'f2a3b4c5-d6e7-8901-2345-612345678901',
                'category_id' => '334e7713-440a-47f5-b014-3af39f5574b7', // RAM
                'name' => 'KLEVV DDR4 BOLT XR Series PC28800 3600MHz Dual Channel 16GB',
                'price' => 555000,
                'tokopedia_link' => '',
                'shopee_link' => '',
                'lazada_link' => '',
                'image_path' => 'products/inFEfpsr5qiOORX3imH6xdC8uBBDQKeVxvbyuVEE.png',
                'description' => "The KLEVV BOLT XR is a high-performance DDR4 memory kit designed for gamers and enthusiasts. With a speed of 3600MHz, it provides the bandwidth needed for smooth gameplay and responsive multitasking.

### Specifications
* **Capacity:** 16GB (2x 8GB)
* **Type:** DDR4
* **Speed:** 3600MHz
* **CAS Latency:** 18
* **Voltage:** 1.35V",
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}