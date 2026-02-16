<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Database\Seeder;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'title' => 'Overthinking Just Got Stylish',
            'description' => 'Premium hoodies and tees for your daily existential crisis. Because fashion > therapy.',
            'image' => 'banners/hero-1.jpg',
            'link' => '/shop',
            'button_text' => 'Shop Now',
            'sort_order' => 1,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(3),
        ]);

        Banner::create([
            'title' => 'New Arrivals: Fresh Designs, Same Anxiety',
            'description' => 'Check out our latest collection of witty tees and cozy hoodies. Limited stock, unlimited existential dread.',
            'image' => 'banners/hero-2.jpg',
            'link' => '/shop?filter=new-arrivals',
            'button_text' => 'Explore Collection',
            'sort_order' => 2,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(2),
        ]);

        Banner::create([
            'title' => 'Winter Sale: For All 3 Days of Dhaka Winter',
            'description' => 'Up to 30% off on hoodies and jackets. Perfect for AC rooms and imaginary winter.',
            'image' => 'banners/hero-3.jpg',
            'link' => '/shop?category=hoodies',
            'button_text' => 'Shop Hoodies',
            'sort_order' => 3,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonth(),
        ]);

        Banner::create([
            'title' => 'Free Shipping on Orders Over ৳2000',
            'description' => 'Nationwide delivery. From Dhaka traffic to your doorstep. Eventually.',
            'image' => 'banners/hero-4.jpg',
            'link' => '/shop',
            'button_text' => 'Start Shopping',
            'sort_order' => 4,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(6),
        ]);
    }
}

