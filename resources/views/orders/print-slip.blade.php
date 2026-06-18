<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parcel Slip {{ $order->order_number }} - Neonman</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', 'Segoe UI', sans-serif; font-size: 12px; color: #1a1a1a; }
        .slip { width: 100%; max-width: 400px; margin: 0 auto; padding: 20px; border: 2px solid #881337; }

        /* Header */
        .header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 2px solid #881337; }
        .brand { display: flex; align-items: center; gap: 8px; }
        .brand img { height: 32px; }
        .order-badge { background: #881337; color: white; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; }

        /* Sections */
        .section { margin-bottom: 12px; }
        .section-title { font-size: 9px; font-weight: 700; color: #881337; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 6px; padding-bottom: 4px; border-bottom: 1px dashed #e5e7eb; }
        .row { display: flex; justify-content: space-between; padding: 2px 0; }
        .label { font-size: 10px; color: #6b7280; }
        .value { font-size: 12px; font-weight: 600; color: #111827; }
        .value-lg { font-size: 14px; font-weight: 800; color: #881337; }
        .address { font-size: 12px; font-weight: 600; color: #111827; line-height: 1.4; }

        /* Items */
        .items { margin-bottom: 12px; }
        .item { display: flex; justify-content: space-between; padding: 4px 0; border-bottom: 1px solid #f3f4f6; }
        .item:last-child { border-bottom: none; }
        .item-name { font-size: 11px; font-weight: 600; color: #111827; flex: 1; }
        .item-qty { font-size: 11px; color: #6b7280; width: 40px; text-align: center; }
        .item-price { font-size: 11px; font-weight: 700; color: #111827; width: 70px; text-align: right; }

        /* Total */
        .total-row { display: flex; justify-content: space-between; padding: 8px 0; border-top: 2px solid #881337; margin-top: 4px; }
        .total-label { font-size: 12px; font-weight: 700; color: #111827; }
        .total-value { font-size: 16px; font-weight: 800; color: #881337; }

        /* Payment */
        .payment-row { display: flex; gap: 12px; margin-top: 8px; padding: 8px; background: #f9fafb; border-radius: 6px; }
        .payment-box { flex: 1; text-align: center; }
        .payment-box .label { font-size: 9px; }
        .payment-box .value { font-size: 11px; }

        /* Footer */
        .footer { margin-top: 12px; padding-top: 8px; border-top: 1px dashed #e5e7eb; text-align: center; font-size: 9px; color: #9ca3af; }

        /* Status */
        .status-badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 9px; font-weight: 700; text-transform: uppercase; }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-paid { background: #d1fae5; color: #065f46; }
        .status-processing { background: #fce7f3; color: #9d174d; }
        .status-shipped { background: #ede9fe; color: #5b21b6; }
        .status-delivered { background: #d1fae5; color: #065f46; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }

        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .slip { border: 2px solid #000; }
            @page { margin: 10mm; size: A5 portrait; }
        }
    </style>
</head>
<body>
    <div class="slip">
        <!-- Header -->
        <div class="header">
            <div class="brand">
                <img src="{{ asset('logo.svg') }}" alt="Neonman">
            </div>
            <div class="order-badge">{{ $order->order_number }}</div>
        </div>

        <!-- Customer -->
        <div class="section">
            <div class="section-title">Recipient</div>
            <div style="margin-bottom: 4px;">
                <span class="value" style="font-size: 14px;">{{ $order->customer_name }}</span>
            </div>
            <div class="address">{{ $order->shipping_address }}</div>
            <div class="row" style="margin-top: 4px;">
                <span class="value">{{ $order->shipping_district }}, {{ $order->shipping_division }}</span>
            </div>
            <div class="row">
                <span class="label">Phone</span>
                <span class="value">{{ $order->shipping_phone }}</span>
            </div>
        </div>

        <!-- Items -->
        <div class="items">
            <div class="section-title">Items ({{ $order->items->count() }})</div>
            @foreach($order->items as $item)
            <div class="item">
                <span class="item-name">{{ $item->product_name }}</span>
                <span class="item-qty">x{{ $item->quantity }}</span>
                <span class="item-price">৳{{ number_format($item->total, 0) }}</span>
            </div>
            @endforeach
        </div>

        <!-- Total -->
        <div class="total-row">
            <span class="total-label">Total Amount</span>
            <span class="total-value">৳{{ number_format($order->total, 0) }}</span>
        </div>

        <!-- Payment -->
        <div class="payment-row">
            <div class="payment-box">
                <div class="label">Payment</div>
                <div class="value" style="text-transform: uppercase;">{{ $order->payment_method }}</div>
            </div>
            <div class="payment-box">
                <div class="label">Status</div>
                <span class="status-badge status-{{ $order->payment_status }}">{{ ucfirst($order->payment_status) }}</span>
            </div>
            <div class="payment-box">
                <div class="label">Order Status</div>
                <span class="status-badge status-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with <strong style="color: #881337;">Neonman</strong> | neonman.com</p>
        </div>
    </div>
    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
