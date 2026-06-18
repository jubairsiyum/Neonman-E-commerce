<?php

namespace Database\Seeders;

use App\Models\DeliveryZone;
use Illuminate\Database\Seeder;

class DeliveryZoneSeeder extends Seeder
{
    public function run(): void
    {
        $zones = [
            [
                'name' => 'Inside Dhaka',
                'charge' => 60,
                'free_shipping_threshold' => 2000,
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Outside Dhaka',
                'charge' => 120,
                'free_shipping_threshold' => 3000,
                'is_active' => true,
                'sort_order' => 2,
            ],
        ];

        foreach ($zones as $zone) {
            DeliveryZone::updateOrCreate(
                ['name' => $zone['name']],
                $zone
            );
        }
    }
}
