<?php

namespace App\Services\Payment;

use App\Models\PaymentGateway;
use App\Services\Payment\Gateways\BkashGateway;
use App\Services\Payment\Gateways\PaymentGatewayInterface;

class PaymentGatewayManager
{
    private static array $gateways = [
        'bkash' => BkashGateway::class,
    ];

    /**
     * Resolve a gateway instance by slug
     */
    public static function resolve(string $slug): PaymentGatewayInterface
    {
        $gateway = PaymentGateway::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $class = self::$gateways[$slug] ?? null;

        if (!$class || !class_exists($class)) {
            throw new \InvalidArgumentException("Payment gateway class not found for: {$slug}");
        }

        return new $class($gateway);
    }

    /**
     * Get all available/active gateways
     */
    public static function available(): array
    {
        return PaymentGateway::active()->get()->map(function ($gateway) {
            return [
                'id' => $gateway->id,
                'name' => $gateway->name,
                'slug' => $gateway->slug,
            ];
        })->toArray();
    }

    /**
     * Check if a gateway is available
     */
    public static function isAvailable(string $slug): bool
    {
        return PaymentGateway::where('slug', $slug)
            ->where('is_active', true)
            ->exists();
    }
}
