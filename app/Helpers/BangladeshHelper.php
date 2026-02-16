<?php

namespace App\Helpers;

class BangladeshHelper
{
    /**
     * All divisions of Bangladesh
     */
    public static function divisions(): array
    {
        return [
            'Dhaka',
            'Chattogram',
            'Rajshahi',
            'Khulna',
            'Barishal',
            'Sylhet',
            'Rangpur',
            'Mymensingh',
        ];
    }

    /**
     * All districts by division
     */
    public static function districts(): array
    {
        return [
            'Dhaka' => [
                'Dhaka', 'Faridpur', 'Gazipur', 'Gopalganj', 'Kishoreganj',
                'Madaripur', 'Manikganj', 'Munshiganj', 'Narayanganj', 'Narsingdi',
                'Rajbari', 'Shariatpur', 'Tangail',
            ],
            'Chattogram' => [
                'Bandarban', 'Brahmanbaria', 'Chandpur', 'Chattogram', 'Cumilla',
                'Cox\'s Bazar', 'Feni', 'Khagrachari', 'Lakshmipur', 'Noakhali',
                'Rangamati',
            ],
            'Rajshahi' => [
                'Bogura', 'Joypurhat', 'Naogaon', 'Natore', 'Chapainawabganj',
                'Pabna', 'Rajshahi', 'Sirajganj',
            ],
            'Khulna' => [
                'Bagerhat', 'Chuadanga', 'Jessore', 'Jhenaidah', 'Khulna',
                'Kushtia', 'Magura', 'Meherpur', 'Narail', 'Satkhira',
            ],
            'Barishal' => [
                'Barguna', 'Barishal', 'Bhola', 'Jhalokathi', 'Patuakhali', 'Pirojpur',
            ],
            'Sylhet' => [
                'Habiganj', 'Moulvibazar', 'Sunamganj', 'Sylhet',
            ],
            'Rangpur' => [
                'Dinajpur', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Nilphamari',
                'Panchagarh', 'Rangpur', 'Thakurgaon',
            ],
            'Mymensingh' => [
                'Jamalpur', 'Mymensingh', 'Netrokona', 'Sherpur',
            ],
        ];
    }

    /**
     * Get flat list of all districts
     */
    public static function allDistricts(): array
    {
        $districts = [];
        foreach (self::districts() as $division => $divisionDistricts) {
            $districts = array_merge($districts, $divisionDistricts);
        }
        sort($districts);
        return $districts;
    }

    /**
     * Get districts for a specific division
     */
    public static function getDistrictsByDivision(string $division): array
    {
        return self::districts()[$division] ?? [];
    }

    /**
     * Format Bangladesh phone number
     */
    public static function formatPhoneNumber(string $phone): string
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Add +880 if not present
        if (strlen($phone) === 11 && str_starts_with($phone, '0')) {
            $phone = '880' . substr($phone, 1);
        }

        // Format: +880 1XXX-XXXXXX
        if (strlen($phone) === 13 && str_starts_with($phone, '880')) {
            return '+880 ' . substr($phone, 3, 4) . '-' . substr($phone, 7);
        }

        return $phone;
    }

    /**
     * Validate Bangladesh phone number
     */
    public static function isValidPhoneNumber(string $phone): bool
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);

        // Check if it's 11 digits starting with 01
        if (strlen($phone) === 11 && str_starts_with($phone, '01')) {
            return true;
        }

        // Check if it's 13 digits starting with 880
        if (strlen($phone) === 13 && str_starts_with($phone, '880')) {
            return true;
        }

        return false;
    }

    /**
     * Format currency in BDT
     */
    public static function formatCurrency(float $amount): string
    {
        return '৳ ' . number_format($amount, 2);
    }

    /**
     * Calculate shipping charge based on division
     */
    public static function calculateShipping(string $division, float $subtotal): float
    {
        $freeShippingThreshold = config('app.free_shipping_threshold', 2000);

        if ($subtotal >= $freeShippingThreshold) {
            return 0;
        }

        // Different shipping charges for different divisions
        $shippingRates = [
            'Dhaka' => 60,
            'Chattogram' => 120,
            'Rajshahi' => 120,
            'Khulna' => 120,
            'Barishal' => 150,
            'Sylhet' => 150,
            'Rangpur' => 150,
            'Mymensingh' => 100,
        ];

        return $shippingRates[$division] ?? 120; // Default 120 BDT
    }

    /**
     * Get COD charge
     */
    public static function getCODCharge(): float
    {
        return config('app.cod_charge', 60);
    }

    /**
     * Get bKash details
     */
    public static function getBkashDetails(): array
    {
        return [
            'number' => config('app.bkash_personal_number', '01XXXXXXXXX'),
            'account_name' => config('app.bkash_account_name', 'Neonman Store'),
            'type' => 'Personal',
        ];
    }
}
