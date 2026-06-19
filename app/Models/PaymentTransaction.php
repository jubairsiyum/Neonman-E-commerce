<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentTransaction extends Model
{
    use HasFactory;

    const STATUS_PENDING    = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED  = 'completed';
    const STATUS_FAILED     = 'failed';
    const STATUS_CANCELLED  = 'cancelled';
    const STATUS_REFUNDED   = 'refunded';

    protected $fillable = [
        'order_id',
        'payment_gateway_id',
        'transaction_id',
        'payment_id',
        'trx_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'request_payload',
        'response_payload',
        'error_message',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'request_payload' => 'array',
        'response_payload' => 'array',
        'paid_at' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function gateway(): BelongsTo
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    /**
     * Mark transaction as completed
     */
    public function markCompleted(string $trxId = null, array $response = []): void
    {
        $this->update([
            'status' => self::STATUS_COMPLETED,
            'trx_id' => $trxId,
            'response_payload' => $response,
            'paid_at' => now(),
        ]);
    }

    /**
     * Mark transaction as failed
     */
    public function markFailed(string $message = null, array $response = []): void
    {
        $this->update([
            'status' => self::STATUS_FAILED,
            'error_message' => $message,
            'response_payload' => $response,
        ]);
    }

    /**
     * Check if transaction is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Scope: completed transactions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }
}
