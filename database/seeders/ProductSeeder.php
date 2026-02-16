<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tshirts = Category::where('slug', 't-shirts')->first();
        $oversized = Category::where('slug', 'oversized-tees')->first();
        $hoodies = Category::where('slug', 'hoodies')->first();
        $jackets = Category::where('slug', 'jackets')->first();
        $socks = Category::where('slug', 'socks')->first();

        $sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        $colors = [
            ['name' => 'Black', 'hex' => '#000000'],
            ['name' => 'White', 'hex' => '#FFFFFF'],
            ['name' => 'Navy', 'hex' => '#000080'],
            ['name' => 'Ash', 'hex' => '#B2BEB5'],
        ];

        // T-Shirts
        Product::create([
            'category_id' => $tshirts->id,
            'name' => 'Existential Crisis Tee',
            'slug' => 'existential-crisis-tee',
            'short_description' => 'For when you question everything except your fashion choices',
            'description' => '<p>Ever stare at the ceiling at 3 AM wondering about your life decisions? This tee gets you. Made from 100% cotton, it\'s soft enough to cry into and stylish enough to wear to your daily existential breakdowns.</p><p><strong>Features:</strong></p><ul><li>Premium 180 GSM cotton</li><li>Screen printed with crisis-proof ink</li><li>Pairs well with overthinking</li><li>Machine washable (unlike your anxiety)</li></ul>',
            'price' => 550.00,
            'discount_price' => 450.00,
            'stock_quantity' => 50,
            'sku' => 'NEON-EC-001',
            'sizes' => $sizes,
            'colors' => $colors,
            'is_active' => true,
            'is_featured' => true,
            'is_new_arrival' => true,
            'is_best_seller' => false,
            'meta_title' => 'Existential Crisis Tee - Funny T-Shirt Bangladesh',
            'meta_description' => 'Buy the Existential Crisis Tee - for when you question everything except your fashion. Premium cotton, funny design, Bangladesh delivery.',
            'meta_keywords' => 'funny tshirt, existential crisis, streetwear bangladesh, neonman',
        ]);

        Product::create([
            'category_id' => $tshirts->id,
            'name' => 'Overthinking Hoodie',
            'slug' => 'overthinking-hoodie',
            'short_description' => 'Comes with free anxiety and endless "what if" scenarios',
            'description' => '<p>Perfect for those who analyze text messages for 3 hours. This hoodie has a spacious hood - ideal for hiding from responsibilities and social situations.</p><p><strong>Why You Need This:</strong></p><ul><li>Heavyweight 280 GSM fleece</li><li>Kangaroo pocket for stress balls</li><li>Drawstrings to hide from the world</li><li>Designed in Dhaka, overthought everywhere</li></ul>',
            'price' => 1500.00,
            'discount_price' => 1200.00,
            'stock_quantity' => 30,
            'sku' => 'NEON-OT-002',
            'sizes' => $sizes,
            'colors' => array_slice($colors, 0, 3),
            'is_active' => true,
            'is_featured' => true,
            'is_new_arrival' => true,
            'is_best_seller' => true,
            'meta_title' => 'Overthinking Hoodie - Premium Hoodie Bangladesh',
            'meta_description' => 'Overthinking Hoodie with free anxiety included. Heavyweight fleece, perfect for Dhaka AC rooms. Order now!',
            'meta_keywords' => 'hoodie bangladesh, overthinking, funny hoodie, dhaka streetwear',
        ]);

        Product::create([
            'category_id' => $tshirts->id,
            'name' => 'Procrastination Champion Tee',
            'slug' => 'procrastination-champion-tee',
            'short_description' => 'Will ship... eventually. Just like your life goals.',
            'description' => '<p>You\'ll buy this tomorrow. Or maybe next week. Or when you feel like it. But when you do, you\'ll own a testament to your ability to delay everything except looking good.</p><p><strong>Procrastinator Approved:</strong></p><ul><li>Soft cotton (you deserve comfort)</li><li>Classic fit (no effort required)</li><li>Tag says "Do it later"</li><li>Delivery: When we get to it (JK, 3-5 days)</li></ul>',
            'price' => 650.00,
            'discount_price' => null,
            'stock_quantity' => 45,
            'sku' => 'NEON-PC-003',
            'sizes' => $sizes,
            'colors' => $colors,
            'is_active' => true,
            'is_featured' => false,
            'is_new_arrival' => true,
            'is_best_seller' => true,
            'meta_title' => 'Procrastination Champion T-Shirt - Funny Tee BD',
            'meta_description' => 'Procrastination Champion Tee - for those who do it later. Soft cotton, funny design, Bangladesh delivery.',
            'meta_keywords' => 'procrastination tshirt, funny tee, bangladesh streetwear',
        ]);

        Product::create([
            'category_id' => $oversized->id,
            'name' => 'Dhaka Traffic Survivor Hoodie',
            'slug' => 'dhaka-traffic-survivor-hoodie',
            'short_description' => 'For those who\'ve seen things. Terrible, gridlocked things.',
            'description' => '<p>If you\'ve survived Malibagh intersection at 5 PM, you\'ve earned this hoodie. If you\'ve seen a rickshaw go the wrong way on a one-way street, this is yours. If you know what "just 5 more minutes" actually means in Dhaka traffic, welcome home.</p><p><strong>Battle-Tested Features:</strong></p><ul><li>Extra thick fabric (like Dhaka traffic)</li><li>Hood big enough to scream into</li><li>Pocket for your broken dreams</li><li>Reflective print (unlike traffic signals)</li></ul>',
            'price' => 1800.00,
            'discount_price' => 1499.00,
            'stock_quantity' => 25,
            'sku' => 'NEON-DTS-004',
            'sizes' => $sizes,
            'colors' => [
                ['name' => 'Black', 'hex' => '#000000'],
                ['name' => 'Navy', 'hex' => '#000080'],
            ],
            'is_active' => true,
            'is_featured' => true,
            'is_new_arrival' => false,
            'is_best_seller' => true,
            'meta_title' => 'Dhaka Traffic Survivor Hoodie - Bangladesh Streetwear',
            'meta_description' => 'Dhaka Traffic Survivor Hoodie for those who\'ve seen it all. Premium quality, funny design, fast delivery.',
            'meta_keywords' => 'dhaka traffic, funny hoodie bangladesh, streetwear dhaka',
        ]);

        Product::create([
            'category_id' => $tshirts->id,
            'name' => 'Chai Addict Tee',
            'slug' => 'chai-addict-tee',
            'short_description' => 'Powered by 7-cup breakfast. Zero apologies.',
            'description' => '<p>Your blood type is Cha+. You measure time in cups. Your autopilot goes to the nearest tea stall. This tee is basically a documentary of your life.</p><p><strong>Chai-ffeine Infused:</strong></p><ul><li>Breathable cotton (for post-chai sweats)</li><li>Tagless (like your tea preference)</li><li>Pre-shrunk (unlike your tea budget)</li><li>Pairs well with biscuits</li></ul>',
            'price' => 500.00,
            'discount_price' => null,
            'stock_quantity' => 60,
            'sku' => 'NEON-CHAI-005',
            'sizes' => $sizes,
            'colors' => $colors,
            'is_active' => true,
            'is_featured' => true,
            'is_new_arrival' => true,
            'is_best_seller' => false,
            'meta_title' => 'Chai Addict T-Shirt - Tea Lover Tee Bangladesh',
            'meta_description' => 'Chai Addict Tee for true tea lovers. Soft cotton, funny design, Bangladesh delivery.',
            'meta_keywords' => 'chai tshirt, tea lover, funny tee bangladesh',
        ]);

        Product::create([
            'category_id' => $oversized->id,
            'name' => 'Social Battery Low Oversized Tee',
            'slug' => 'social-battery-low-tee',
            'short_description' => 'Currently running on 1% and avoiding eye contact',
            'description' => '<p>Oversized for maximum comfort while hiding from humanity. The perfect conversation starter about how you don\'t want conversations.</p><p><strong>Antisocial Specs:</strong></p><ul><li>Extra oversized fit (more fabric to hide behind)</li><li>Drop shoulders (for that "don\'t talk to me" vibe)</li><li>Long length (covers your introverted soul)</li><li>Side slits (for dramatic exits)</li></ul>',
            'price' => 750.00,
            'discount_price' => 650.00,
            'stock_quantity' => 40,
            'sku' => 'NEON-SBL-006',
            'sizes' => ['M', 'L', 'XL', 'XXL'],
            'colors' => array_slice($colors, 0, 3),
            'is_active' => true,
            'is_featured' => false,
            'is_new_arrival' => true,
            'is_best_seller' => false,
            'meta_title' => 'Social Battery Low Oversized Tee - Introvert T-Shirt',
            'meta_description' => 'Social Battery Low Oversized Tee for introverts. Extra roomy, soft cotton, Bangladesh delivery.',
            'meta_keywords' => 'introvert tshirt, oversized tee bangladesh, funny shirt',
        ]);

        Product::create([
            'category_id' => $hoodies->id,
            'name' => 'Assignment Due Tomorrow Hoodie',
            'slug' => 'assignment-due-tomorrow-hoodie',
            'short_description' => 'Started today. Due tomorrow. Perfect.',
            'description' => '<p>Why start early when you can start panicking at 11 PM? This hoodie understands your workflow (or lack thereof). Designed for last-minute warriors and deadline adrenaline junkies.</p><p><strong>Panic Mode Features:</strong></p><ul><li>Hood for hiding from your professor</li><li>Oversized for 3-day wear sessions</li><li>Machine washable (you won\'t have time anyway)</li><li>Coffee stain resistant (tested extensively)</li></ul>',
            'price' => 1600.00,
            'discount_price' => 1299.00,
            'stock_quantity' => 35,
            'sku' => 'NEON-ADT-007',
            'sizes' => $sizes,
            'colors' => [
                ['name' => 'Black', 'hex' => '#000000'],
                ['name' => 'Ash', 'hex' => '#B2BEB5'],
            ],
            'is_active' => true,
            'is_featured' => true,
            'is_new_arrival' => true,
            'is_best_seller' => true,
            'meta_title' => 'Assignment Due Tomorrow Hoodie - Student Hoodie BD',
            'meta_description' => 'Assignment Due Tomorrow Hoodie for procrastinating students. Premium quality, funny design, fast delivery.',
            'meta_keywords' => 'student hoodie bangladesh, assignment procrastination, funny hoodie',
        ]);

        Product::create([
            'category_id' => $tshirts->id,
            'name' => 'Rickshaw Puller Strong Tee',
            'slug' => 'rickshaw-puller-strong-tee',
            'short_description' => 'Respecting the real MVPs of Dhaka streets',
            'description' => '<p>A tribute to the unsung heroes who navigate chaos daily. This tee celebrates strength, resilience, and the art of not caring about traffic rules.</p><p><strong>Street Respect:</strong></p><ul><li>Heavy duty cotton (built tough)</li><li>Comfortable fit (for all-day wear)</li><li>Screenprinted graphics (won\'t fade like your gym motivation)</li><li>Represent the real Dhaka</li></ul>',
            'price' => 550.00,
            'discount_price' => null,
            'stock_quantity' => 50,
            'sku' => 'NEON-RPS-008',
            'sizes' => $sizes,
            'colors' => $colors,
            'is_active' => true,
            'is_featured' => false,
            'is_new_arrival' => false,
            'is_best_seller' => true,
            'meta_title' => 'Rickshaw Puller Strong Tee - Dhaka Street Culture',
            'meta_description' => 'Rickshaw Puller Strong Tee celebrating Dhaka street culture. Quality cotton, unique design, Bangladesh.',
            'meta_keywords' => 'dhaka culture tshirt, rickshaw bangladesh, streetwear',
        ]);

        Product::create([
            'category_id' => $jackets->id,
            'name' => 'Dhaka Winter Survival Jacket',
            'slug' => 'dhaka-winter-survival-jacket',
            'short_description' => 'For all 3 days of winter and year-round AC rooms',
            'description' => '<p>Dhaka winter lasts from January 15th to January 17th, but office ACs run 365 days. This lightweight jacket is perfect for both imaginary winters and very real air conditioning.</p><p><strong>All-Season Protection:</strong></p><ul><li>Lightweight polyester shell (not too hot, not too cold)</li><li>Water resistant (for sudden Dhaka showers)</li><li>Zip pockets (for your precious phone)</li><li>Fits over hoodies (layering game strong)</li></ul>',
            'price' => 2800.00,
            'discount_price' => 2299.00,
            'stock_quantity' => 20,
            'sku' => 'NEON-DWJ-009',
            'sizes' => $sizes,
            'colors' => [
                ['name' => 'Black', 'hex' => '#000000'],
                ['name' => 'Navy', 'hex' => '#000080'],
                ['name' => 'Olive', 'hex' => '#808000'],
            ],
            'is_active' => true,
            'is_featured' => true,
            'is_new_arrival' => true,
            'is_best_seller' => false,
            'meta_title' => 'Dhaka Winter Survival Jacket - Lightweight Jacket BD',
            'meta_description' => 'Dhaka Winter Survival Jacket for 3-day winters and year-round AC. Water resistant, stylish, Bangladesh delivery.',
            'meta_keywords' => 'jacket bangladesh, winter jacket dhaka, lightweight jacket',
        ]);

        Product::create([
            'category_id' => $socks->id,
            'name' => 'Disappearing Socks Mystery Pack',
            'slug' => 'disappearing-socks-mystery-pack',
            'short_description' => 'Where do they go? Nobody knows. Buy extras.',
            'description' => '<p>Pack of 3 pairs. You\'ll lose 2 within a month. It\'s science. But while they\'re here, your feet will be comfy and confused about their inevitable disappearance.</p><p><strong>Mysterious Features:</strong></p><ul><li>Soft cotton blend (until they vanish)</li><li>Breathable (so they can escape easier)</li><li>Elastic that actually works (for now)</li><li>Pack of 3 (because washing machine gods demand tribute)</li></ul>',
            'price' => 250.00,
            'discount_price' => 199.00,
            'stock_quantity' => 100,
            'sku' => 'NEON-SOCK-010',
            'sizes' => ['Free Size'],
            'colors' => [
                ['name' => 'Black', 'hex' => '#000000'],
                ['name' => 'White', 'hex' => '#FFFFFF'],
                ['name' => 'Mixed', 'hex' => '#808080'],
            ],
            'is_active' => true,
            'is_featured' => false,
            'is_new_arrival' => true,
            'is_best_seller' => true,
            'meta_title' => 'Disappearing Socks Mystery Pack - Funny Socks BD',
            'meta_description' => 'Disappearing Socks Mystery Pack - soft cotton, pack of 3. Perfect gift, Bangladesh delivery.',
            'meta_keywords' => 'funny socks bangladesh, cotton socks, mystery pack',
        ]);

        Product::create([
            'category_id' => $tshirts->id,
            'name' => 'Biryani > Everything Tee',
            'slug' => 'biryani-everything-tee',
            'short_description' => 'Mathematical proof that biryani solves all problems',
            'description' => '<p>Relationship issues? Biryani. Work stress? Biryani. Existential dread? Biryani. This tee is a public service announcement about life\'s universal truth.</p><p><strong>Scientifically Proven:</strong></p><ul><li>Soft cotton (like the rice in good biryani)</li><li>Pre-shrunk (like your budget after Kacchi orders)</li><li>Breathable fabric (for post-biryani food coma)</li><li>Wear to Biriyani joints for instant credibility</li></ul>',
            'price' => 500.00,
            'discount_price' => 450.00,
            'stock_quantity' => 70,
            'sku' => 'NEON-BIR-011',
            'sizes' => $sizes,
            'colors' => $colors,
            'is_active' => true,
            'is_featured' => true,
            'is_new_arrival' => false,
            'is_best_seller' => true,
            'meta_title' => 'Biryani Everything Tee - Funny Food T-Shirt Bangladesh',
            'meta_description' => 'Biryani > Everything Tee for true biryani lovers. Soft cotton, funny design, Bangladesh delivery.',
            'meta_keywords' => 'biryani tshirt, funny food tee bangladesh, kacchi',
        ]);

        Product::create([
            'category_id' => $oversized->id,
            'name' => 'Freelancer Life Oversized Hoodie',
            'slug' => 'freelancer-life-hoodie',
            'short_description' => 'Work from bed. Live in this hoodie. Invoice unpaid.',
            'description' => '<p>For digital nomads who haven\'t left their room in 3 weeks. For Upwork warriors. For those who say "I work from home" but really mean "I work from under my blanket."</p><p><strong>Remote Work Ready:</strong></p><ul><li>Ultra oversized (basically a wearable blanket)</li><li>Side slits (for cross-legged sitting)</li><li>Thumbholes (for cold morning client calls)</li><li>Perfect for Zoom meetings (looks professional from chest up)</li></ul>',
            'price' => 1900.00,
            'discount_price' => 1599.00,
            'stock_quantity' => 30,
            'sku' => 'NEON-FLO-012',
            'sizes' => ['L', 'XL', 'XXL'],
            'colors' => [
                ['name' => 'Charcoal', 'hex' => '#36454F'],
                ['name' => 'Ash', 'hex' => '#B2BEB5'],
            ],
            'is_active' => true,
            'is_featured' => true,
            'is_new_arrival' => true,
            'is_best_seller' => false,
            'meta_title' => 'Freelancer Life Oversized Hoodie - Work From Home BD',
            'meta_description' => 'Freelancer Life Oversized Hoodie for remote workers. Ultra comfortable, perfect for Zoom calls, Bangladesh.',
            'meta_keywords' => 'freelancer hoodie bangladesh, work from home, oversized hoodie',
        ]);
    }
}

