<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'charge',
        'free_shipping_threshold',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'charge' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Calculate shipping charge for given subtotal
     */
    public function calculateShipping(float $subtotal): float
    {
        if ($this->free_shipping_threshold && $subtotal >= $this->free_shipping_threshold) {
            return 0;
        }

        return $this->charge;
    }

    /**
     * Scope: active zones
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
