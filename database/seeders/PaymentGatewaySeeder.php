<?php

namespace Database\Seeders;

use App\Models\PaymentGateway;
use Illuminate\Database\Seeder;

class PaymentGatewaySeeder extends Seeder
{
    public function run(): void
    {
        PaymentGateway::updateOrCreate(
            ['slug' => 'bkash'],
            [
                'name' => 'bKash',
                'description' => 'bKash Tokenized Checkout — official payment gateway',
                'credentials' => [
                    'app_key'    => '',
                    'app_secret' => '',
                    'username'   => '',
                    'password'   => '',
                ],
                'settings' => [
                    'sandbox'      => true,
                    'callback_url' => '',
                ],
                'is_active' => false,
                'sort_order' => 1,
            ]
        );
    }
}
