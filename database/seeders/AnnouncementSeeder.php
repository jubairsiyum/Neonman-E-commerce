<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Illuminate\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        $announcements = [
            [
                'message'    => 'Free Shipping Over ৳2,000',
                'icon'       => 'truck',
                'highlight'  => null,
                'is_active'  => true,
                'sort_order' => 1,
            ],
            [
                'message'    => 'Use Code {highlight} for 10% Off',
                'icon'       => 'tag',
                'highlight'  => 'WELCOME10',
                'is_active'  => true,
                'sort_order' => 2,
            ],
            [
                'message'    => '7-Day Easy Returns & Exchanges',
                'icon'       => 'clock',
                'highlight'  => null,
                'is_active'  => true,
                'sort_order' => 3,
            ],
            [
                'message'    => 'Premium Streetwear, Made in Bangladesh',
                'icon'       => 'star',
                'highlight'  => null,
                'is_active'  => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($announcements as $index => $announcement) {
            Announcement::updateOrCreate(
                ['message' => $announcement['message']],
                $announcement
            );
        }
    }
}
