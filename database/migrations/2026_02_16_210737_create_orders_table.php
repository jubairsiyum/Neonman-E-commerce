<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            
            // Guest checkout info
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
            
            // Shipping address
            $table->text('shipping_address');
            $table->string('shipping_district');
            $table->string('shipping_division');
            $table->string('shipping_postal_code')->nullable();
            $table->string('shipping_phone');
            
            // Order totals
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('shipping_charge', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            
            // Payment info
            $table->string('payment_method'); // cod, bkash
            $table->string('payment_status')->default('pending'); // pending, paid, failed
            $table->string('bkash_transaction_id')->nullable();
            $table->string('bkash_proof_image')->nullable();
            $table->timestamp('paid_at')->nullable();
            
            // Order status
            $table->string('status')->default('pending'); // pending, paid, processing, shipped, delivered, cancelled
            $table->text('notes')->nullable();
            $table->text('admin_notes')->nullable();
            
            // Coupon
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->string('coupon_code')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
