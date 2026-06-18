<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $order->order_number }} - Neonman</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', 'Segoe UI', sans-serif; font-size: 13px; color: #1a1a1a; line-height: 1.5; }
        .page { max-width: 800px; margin: 0 auto; padding: 30px; }

        /* Header */
        .header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px; padding-bottom: 20px; border-bottom: 3px solid #881337; }
        .brand { display: flex; align-items: center; gap: 12px; }
        .brand img { height: 48px; width: auto; }
        .invoice-info { text-align: right; }
        .invoice-title { font-size: 22px; font-weight: 800; color: #881337; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 4px; }
        .invoice-number { font-size: 14px; font-weight: 600; color: #374151; }
        .invoice-date { font-size: 12px; color: #6b7280; margin-top: 2px; }

        /* Sections */
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
        .section { padding: 16px; border: 1px solid #e5e7eb; border-radius: 8px; }
        .section-title { font-size: 10px; font-weight: 700; color: #881337; text-transform: uppercase; letter-spacing: 1.5px; margin-bottom: 10px; padding-bottom: 6px; border-bottom: 1px solid #f3f4f6; }
        .field { margin-bottom: 6px; }
        .field-label { font-size: 10px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; }
        .field-value { font-size: 13px; font-weight: 600; color: #111827; }

        /* Table */
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 24px; }
        .items-table th { background: #f9fafb; padding: 10px 12px; text-align: left; font-size: 10px; font-weight: 700; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid #e5e7eb; }
        .items-table th:last-child, .items-table td:last-child { text-align: right; }
        .items-table th:nth-child(3), .items-table td:nth-child(3) { text-align: center; }
        .items-table td { padding: 10px 12px; border-bottom: 1px solid #f3f4f6; font-size: 13px; }
        .items-table tr:last-child td { border-bottom: 2px solid #e5e7eb; }

        /* Summary */
        .summary { width: 280px; margin-left: auto; }
        .summary-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
        .summary-row.total { border-top: 2px solid #881337; margin-top: 6px; padding-top: 10px; font-weight: 800; font-size: 16px; color: #881337; }

        /* Status Badge */
        .badge { display: inline-block; padding: 3px 10px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-pending { background: #fef3c7; color: #92400e; }
        .badge-paid { background: #d1fae5; color: #065f46; }
        .badge-processing { background: #fce7f3; color: #9d174d; }
        .badge-shipped { background: #ede9fe; color: #5b21b6; }
        .badge-delivered { background: #d1fae5; color: #065f46; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }

        /* Footer */
        .footer { margin-top: 40px; padding-top: 16px; border-top: 1px solid #e5e7eb; text-align: center; font-size: 11px; color: #9ca3af; }

        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .page { padding: 15px; }
            @page { margin: 15mm; }
        }
    </style>
</head>
<body>
    <div class="page">
        <!-- Header -->
        <div class="header">
            <div class="brand">
                <img src="{{ asset('logo.svg') }}" alt="Neonman">
            </div>
            <div class="invoice-info">
                <div class="invoice-title">Invoice</div>
                <div class="invoice-number">{{ $order->order_number }}</div>
                <div class="invoice-date">{{ $order->created_at->format('M d, Y \a\t h:i A') }}</div>
            </div>
        </div>

        <!-- Customer & Shipping -->
        <div class="grid-2">
            <div class="section">
                <div class="section-title">Bill To</div>
                <div class="field">
                    <div class="field-label">Name</div>
                    <div class="field-value">{{ $order->customer_name }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Phone</div>
                    <div class="field-value">{{ $order->customer_phone }}</div>
                </div>
                @if($order->customer_email)
                <div class="field">
                    <div class="field-label">Email</div>
                    <div class="field-value">{{ $order->customer_email }}</div>
                </div>
                @endif
            </div>
            <div class="section">
                <div class="section-title">Ship To</div>
                <div class="field">
                    <div class="field-label">Address</div>
                    <div class="field-value">{{ $order->shipping_address }}</div>
                </div>
                <div class="field">
                    <div class="field-label">District / Division</div>
                    <div class="field-value">{{ $order->shipping_district }}, {{ $order->shipping_division }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Phone</div>
                    <div class="field-value">{{ $order->shipping_phone }}</div>
                </div>
            </div>
        </div>

        <!-- Status -->
        <div style="margin-bottom: 20px;">
            <span class="badge badge-{{ $order->status }}">{{ ucfirst($order->status) }}</span>
            <span class="badge badge-{{ $order->payment_status }}" style="margin-left: 6px;">Payment: {{ ucfirst($order->payment_status) }}</span>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Variant</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td><strong>{{ $item->product_name }}</strong></td>
                    <td>{{ $item->variant_details ? implode(' / ', array_values(json_decode($item->variant_details, true) ?: [])) : '-' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>৳{{ number_format($item->price, 0) }}</td>
                    <td><strong>৳{{ number_format($item->total, 0) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary -->
        <div class="summary">
            <div class="summary-row">
                <span>Subtotal</span>
                <span>৳{{ number_format($order->subtotal, 0) }}</span>
            </div>
            @if($order->discount > 0)
            <div class="summary-row">
                <span>Discount</span>
                <span style="color: #059669;">-৳{{ number_format($order->discount, 0) }}</span>
            </div>
            @endif
            <div class="summary-row">
                <span>Shipping</span>
                <span>{{ $order->shipping_charge > 0 ? '৳' . number_format($order->shipping_charge, 0) : 'FREE' }}</span>
            </div>
            @if($order->tax > 0)
            <div class="summary-row">
                <span>Tax</span>
                <span>৳{{ number_format($order->tax, 0) }}</span>
            </div>
            @endif
            <div class="summary-row total">
                <span>Total</span>
                <span>৳{{ number_format($order->total, 0) }}</span>
            </div>
        </div>

        <!-- Payment -->
        <div style="margin-top: 24px; padding: 12px 16px; background: #f9fafb; border-radius: 8px; display: flex; gap: 24px;">
            <div>
                <div class="field-label">Payment Method</div>
                <div class="field-value" style="text-transform: uppercase;">{{ $order->payment_method }}</div>
            </div>
            @if($order->coupon_code)
            <div>
                <div class="field-label">Coupon</div>
                <div class="field-value" style="color: #881337;">{{ $order->coupon_code }}</div>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thank you for shopping with <strong style="color: #881337;">Neonman</strong>!</p>
            <p style="margin-top: 2px;">Questions? Contact us at {{ config('app.shop_phone', '+880 1XXX-XXXXXX') }} | {{ config('app.shop_email', 'hello@neonman.com') }}</p>
        </div>
    </div>
    <script>
        window.onload = function() { window.print(); }
    </script>
</body>
</html>
