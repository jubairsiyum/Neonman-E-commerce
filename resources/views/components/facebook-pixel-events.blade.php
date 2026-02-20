{{-- Facebook Pixel Event Tracking Helper --}}

{{-- View Content Event --}}
@if(isset($event) && $event === 'ViewContent' && isset($product))
<script>
fbq('track', 'ViewContent', {
    content_name: '{{ $product->name }}',
    content_ids: ['{{ $product->id }}'],
    content_type: 'product',
    value: {{ $product->price }},
    currency: 'BDT'
});
</script>
@endif

{{-- Add to Cart Event --}}
@if(isset($event) && $event === 'AddToCart' && isset($product))
<script>
fbq('track', 'AddToCart', {
    content_name: '{{ $product->name }}',
    content_ids: ['{{ $product->id }}'],
    content_type: 'product',
    value: {{ $product->price }},
    currency: 'BDT'
});
</script>
@endif

{{-- Add to Wishlist Event --}}
@if(isset($event) && $event === 'AddToWishlist' && isset($product))
<script>
fbq('track', 'AddToWishlist', {
    content_name: '{{ $product->name }}',
    content_ids: ['{{ $product->id }}'],
    content_type: 'product',
    value: {{ $product->price }},
    currency: 'BDT'
});
</script>
@endif

{{-- Initiate Checkout Event --}}
@if(isset($event) && $event === 'InitiateCheckout' && isset($cartTotal))
<script>
fbq('track', 'InitiateCheckout', {
    value: {{ $cartTotal }},
    currency: 'BDT',
    num_items: {{ $numItems ?? 0 }}
});
</script>
@endif

{{-- Purchase Event --}}
@if(isset($event) && $event === 'Purchase' && isset($order))
<script>
fbq('track', 'Purchase', {
    value: {{ $order->total }},
    currency: 'BDT',
    content_ids: @json($order->orderItems->pluck('product_id')->toArray()),
    content_type: 'product',
    num_items: {{ $order->orderItems->count() }}
});
</script>
@endif

{{-- Search Event --}}
@if(isset($event) && $event === 'Search' && isset($searchQuery))
<script>
fbq('track', 'Search', {
    search_string: '{{ $searchQuery }}'
});
</script>
@endif

{{-- Lead Event (Registration/Newsletter) --}}
@if(isset($event) && $event === 'Lead')
<script>
fbq('track', 'Lead');
</script>
@endif

{{-- Complete Registration Event --}}
@if(isset($event) && $event === 'CompleteRegistration')
<script>
fbq('track', 'CompleteRegistration');
</script>
@endif
