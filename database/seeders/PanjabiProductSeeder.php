<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class PanjabiProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $panjabiCategory = Category::updateOrCreate(
            ['slug' => 'panjabi'],
            [
                'name' => 'Panjabi',
                'description' => 'Premium Panjabi collection for festive and everyday style.',
                'is_active' => true,
                'sort_order' => 6,
            ]
        );

        $sizes = ['38', '40', '42', '44', '46'];
        $colors = [
            ['name' => 'Ivory', 'hex' => '#F8F3E9'],
            ['name' => 'Olive', 'hex' => '#556B2F'],
            ['name' => 'Navy', 'hex' => '#1F2A44'],
            ['name' => 'Maroon', 'hex' => '#800020'],
            ['name' => 'Black', 'hex' => '#111111'],
        ];

        $products = [
            [
                'name' => 'Noor Classic Panjabi',
                'slug' => 'noor-classic-panjabi',
                'short_description' => 'Clean silhouette with subtle threadwork for timeless elegance.',
                'price' => 1890,
                'discount_price' => 1690,
                'stock_quantity' => 50,
                'sku' => 'PANJ-NOOR-001',
                'is_featured' => true,
                'is_new_arrival' => true,
                'is_best_seller' => true,
            ],
            [
                'name' => 'Rongin Festive Panjabi',
                'slug' => 'rongin-festive-panjabi',
                'short_description' => 'Vibrant festive detail with breathable comfort.',
                'price' => 2150,
                'discount_price' => 1990,
                'stock_quantity' => 40,
                'sku' => 'PANJ-RONGIN-002',
                'is_featured' => true,
                'is_new_arrival' => true,
                'is_best_seller' => false,
            ],
            [
                'name' => 'Shada Noor Eid Panjabi',
                'slug' => 'shada-noor-eid-panjabi',
                'short_description' => 'Soft ivory finish crafted for Eid mornings.',
                'price' => 2400,
                'discount_price' => 2190,
                'stock_quantity' => 35,
                'sku' => 'PANJ-SHADA-003',
                'is_featured' => true,
                'is_new_arrival' => false,
                'is_best_seller' => true,
            ],
            [
                'name' => 'Meghla Linen Panjabi',
                'slug' => 'meghla-linen-panjabi',
                'short_description' => 'Light linen blend with smart modern fit.',
                'price' => 1750,
                'discount_price' => null,
                'stock_quantity' => 60,
                'sku' => 'PANJ-MEGHLA-004',
                'is_featured' => false,
                'is_new_arrival' => true,
                'is_best_seller' => false,
            ],
            [
                'name' => 'Rajkio Embroidered Panjabi',
                'slug' => 'rajkio-embroidered-panjabi',
                'short_description' => 'Fine embroidery accents for premium occasions.',
                'price' => 2750,
                'discount_price' => 2490,
                'stock_quantity' => 28,
                'sku' => 'PANJ-RAJKIO-005',
                'is_featured' => true,
                'is_new_arrival' => false,
                'is_best_seller' => true,
            ],
            [
                'name' => 'Shorot Evening Panjabi',
                'slug' => 'shorot-evening-panjabi',
                'short_description' => 'Refined evening tone with structured neckline.',
                'price' => 1990,
                'discount_price' => 1790,
                'stock_quantity' => 42,
                'sku' => 'PANJ-SHOROT-006',
                'is_featured' => false,
                'is_new_arrival' => true,
                'is_best_seller' => false,
            ],
            [
                'name' => 'Sultan Heritage Panjabi',
                'slug' => 'sultan-heritage-panjabi',
                'short_description' => 'Inspired by heritage cuts with contemporary comfort.',
                'price' => 2900,
                'discount_price' => 2650,
                'stock_quantity' => 22,
                'sku' => 'PANJ-SULTAN-007',
                'is_featured' => true,
                'is_new_arrival' => false,
                'is_best_seller' => true,
            ],
            [
                'name' => 'Kashful Casual Panjabi',
                'slug' => 'kashful-casual-panjabi',
                'short_description' => 'Relaxed fit Panjabi for daily wear.',
                'price' => 1490,
                'discount_price' => null,
                'stock_quantity' => 70,
                'sku' => 'PANJ-KASHFUL-008',
                'is_featured' => false,
                'is_new_arrival' => true,
                'is_best_seller' => false,
            ],
            [
                'name' => 'Nocturne Black Panjabi',
                'slug' => 'nocturne-black-panjabi',
                'short_description' => 'Bold black statement piece for night events.',
                'price' => 2300,
                'discount_price' => 2090,
                'stock_quantity' => 30,
                'sku' => 'PANJ-NOCTURNE-009',
                'is_featured' => true,
                'is_new_arrival' => false,
                'is_best_seller' => true,
            ],
            [
                'name' => 'Utsob Signature Panjabi',
                'slug' => 'utsob-signature-panjabi',
                'short_description' => 'Celebration-ready silhouette with premium finishing.',
                'price' => 2600,
                'discount_price' => 2350,
                'stock_quantity' => 25,
                'sku' => 'PANJ-UTSOB-010',
                'is_featured' => true,
                'is_new_arrival' => true,
                'is_best_seller' => true,
            ],
        ];

        foreach ($products as $item) {
            Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $panjabiCategory->id,
                    'name' => $item['name'],
                    'short_description' => $item['short_description'],
                    'description' => sprintf(
                        '<p>%s</p><p>Tailored for comfort with breathable fabric and refined detailing suitable for festive days and smart casual wear.</p>',
                        $item['short_description']
                    ),
                    'price' => $item['price'],
                    'discount_price' => $item['discount_price'],
                    'stock_quantity' => $item['stock_quantity'],
                    'sku' => $item['sku'],
                    'sizes' => $sizes,
                    'colors' => $colors,
                    'is_active' => true,
                    'is_featured' => $item['is_featured'],
                    'is_new_arrival' => $item['is_new_arrival'],
                    'is_best_seller' => $item['is_best_seller'],
                    'meta_title' => $item['name'] . ' - Premium Panjabi Bangladesh',
                    'meta_description' => $item['short_description'] . ' Shop premium Panjabi with fast delivery across Bangladesh.',
                    'meta_keywords' => 'panjabi bangladesh, panjabi for men, festive panjabi, premium panjabi',
                ]
            );
        }

        $this->command?->info('Seeded/updated 10 Panjabi products successfully.');
    }
}
