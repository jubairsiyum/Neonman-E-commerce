<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->foreignId('payment_gateway_id')->constrained()->cascadeOnDelete();
            $table->string('transaction_id')->nullable()->comment('Gateway transaction ID');
            $table->string('payment_id')->nullable()->comment('Gateway payment ID (bKash paymentID)');
            $table->string('trx_id')->nullable()->comment('Gateway trx ID (bKash trxID)');
            $table->decimal('amount', 12, 2);
            $table->string('currency', 3)->default('BDT');
            $table->string('status')->default('pending')->comment('pending, processing, completed, failed, cancelled, refunded');
            $table->string('payment_method')->nullable()->comment('e.g. bkash, cod');
            $table->json('request_payload')->nullable();
            $table->json('response_payload')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index('transaction_id');
            $table->index('payment_id');
            $table->index('trx_id');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
