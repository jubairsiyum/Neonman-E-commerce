<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Welcome coupon for first-time customers
        Coupon::create([
            'code' => 'WELCOME10',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 10.00,
            'minimum_purchase' => 500.00,
            'maximum_discount' => 200.00,
            'usage_limit' => 100,
            'used_count' => 0,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(6),
        ]);

        // First order special
        Coupon::create([
            'code' => 'FIRSTORDER',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 15.00,
            'minimum_purchase' => 1000.00,
            'maximum_discount' => 300.00,
            'usage_limit' => 50,
            'used_count' => 0,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(3),
        ]);

        // Flat discount for big orders
        Coupon::create([
            'code' => 'SAVE200',
            'type' => Coupon::TYPE_FIXED,
            'value' => 200.00,
            'minimum_purchase' => 2000.00,
            'maximum_discount' => null,
            'usage_limit' => 200,
            'used_count' => 0,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(4),
        ]);

        // Weekend special
        Coupon::create([
            'code' => 'WEEKEND20',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 20.00,
            'minimum_purchase' => 1500.00,
            'maximum_discount' => 500.00,
            'usage_limit' => 75,
            'used_count' => 0,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addWeeks(8),
        ]);

        // Overthinking special (thematic!)
        Coupon::create([
            'code' => 'OVERTHINK',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 13.00,
            'minimum_purchase' => 700.00,
            'maximum_discount' => 150.00,
            'usage_limit' => 100,
            'used_count' => 0,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(2),
        ]);

        // Free shipping equivalent
        Coupon::create([
            'code' => 'FREESHIP',
            'type' => Coupon::TYPE_FIXED,
            'value' => 100.00,
            'minimum_purchase' => 1000.00,
            'maximum_discount' => null,
            'usage_limit' => 150,
            'used_count' => 0,
            'is_active' => true,
            'starts_at' => now(),
            'expires_at' => now()->addMonths(3),
        ]);

        // Expired coupon for testing
        Coupon::create([
            'code' => 'EXPIRED2024',
            'type' => Coupon::TYPE_PERCENTAGE,
            'value' => 50.00,
            'minimum_purchase' => 500.00,
            'maximum_discount' => 1000.00,
            'usage_limit' => 10,
            'used_count' => 0,
            'is_active' => false,
            'starts_at' => now()->subMonths(2),
            'expires_at' => now()->subMonth(),
        ]);
    }
}

