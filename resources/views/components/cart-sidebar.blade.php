<!-- Cart Sidebar Backdrop -->
<div
    x-data="{ open: false }"
    x-on:open-cart.window="open = true"
    x-on:cart-close.window="open = false"
    x-cloak
    x-show="open"
    x-transition:enter="transition-opacity duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition-opacity duration-300"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    @click="$dispatch('cart-close')"
    class="fixed inset-0 z-[100] bg-black/40 backdrop-blur-[2px] pointer-events-auto"
></div>

<!-- Cart Sidebar Panel -->
<div
    x-data="cartSidebar()"
    x-on:open-cart.window="open = true; fetchCart()"
    x-on:cart-close.window="open = false"
    x-on:cart-updated.window="fetchCart()"
    x-cloak
    x-show="open"
    x-transition:enter="transition-transform duration-300 ease-out"
    x-transition:enter-start="translate-y-full lg:translate-x-full lg:translate-y-0"
    x-transition:enter-end="translate-y-0 lg:translate-x-0"
    x-transition:leave="transition-transform duration-250 ease-in"
    x-transition:leave-start="translate-y-0 lg:translate-x-0"
    x-transition:leave-end="translate-y-full lg:translate-x-full lg:translate-y-0"
    @click.outside="$dispatch('cart-close')"
    @keydown.escape.window="$dispatch('cart-close')"
    class="fixed right-0 bottom-0 lg:top-0 lg:bottom-0 z-[101]
           w-full sm:w-[420px] lg:w-[420px]
           max-h-[85vh] lg:max-h-none
           bg-white dark:bg-gray-950
           lg:shadow-[-8px_0_30px_rgba(0,0,0,0.12)]
           shadow-[0_-8px_30px_rgba(0,0,0,0.15)]
           lg:rounded-none rounded-t-2xl
           flex flex-col"
>
    <!-- Header -->
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-200 dark:border-gray-800 flex-shrink-0">
        <div class="flex items-center gap-3">
            <h2 class="text-lg font-bold font-display text-gray-900 dark:text-white">Your Cart</h2>
            <span
                x-show="itemCount > 0"
                x-text="itemCount"
                class="inline-flex items-center justify-center min-w-[24px] h-6 px-1.5 rounded-full bg-primary-900 text-white text-xs font-bold"
            ></span>
        </div>
        <button @click="$dispatch('cart-close')" class="w-9 h-9 flex items-center justify-center rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    <!-- Free Shipping Progress -->
    <div x-show="subTotal > 0" class="px-5 py-3 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
        <template x-if="subTotal >= 2000">
            <div class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400 font-medium">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                You've unlocked free shipping!
            </div>
        </template>
        <template x-if="subTotal < 2000">
            <div>
                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1.5">
                    <span>Add <span x-text="'৳' + fmt(2000 - subTotal)" class="font-semibold text-gray-900 dark:text-white"></span> more for free shipping</span>
                    <span x-text="Math.min(Math.round((subTotal / 2000) * 100), 100) + '%'" class="font-semibold"></span>
                </div>
                <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                    <div class="h-full bg-primary-900 rounded-full transition-all duration-500" :style="`width: ${Math.min((subTotal / 2000) * 100, 100)}%`"></div>
                </div>
            </div>
        </template>
    </div>

    <!-- Items -->
    <div class="flex-1 overflow-y-auto overscroll-contain">
        <!-- Empty -->
        <div x-show="items.length === 0 && !loading" class="flex flex-col items-center justify-center py-16 px-6">
            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-5">
                <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <p class="text-gray-900 dark:text-white font-semibold mb-1">Your cart is empty</p>
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mb-5">Add items to get started</p>
            <button @click="$dispatch('cart-close'); window.location.href='{{ url('/shop') }}'" class="px-6 py-2.5 bg-gray-900 dark:bg-white dark:text-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-primary-900 transition-colors">
                Start Shopping
            </button>
        </div>

        <!-- Loading -->
        <div x-show="loading" class="p-5 space-y-4">
            <template x-for="i in 3" :key="i">
                <div class="flex gap-3 animate-pulse">
                    <div class="w-16 h-16 bg-gray-200 dark:bg-gray-800 rounded-lg flex-shrink-0"></div>
                    <div class="flex-1 space-y-2 py-1">
                        <div class="h-4 bg-gray-200 dark:bg-gray-800 rounded w-3/4"></div>
                        <div class="h-3 bg-gray-200 dark:bg-gray-800 rounded w-1/2"></div>
                        <div class="h-5 bg-gray-200 dark:bg-gray-800 rounded w-1/3 mt-3"></div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Items List -->
        <div x-show="items.length > 0 && !loading" class="divide-y divide-gray-100 dark:divide-gray-800">
            <template x-for="item in items" :key="item.id">
                <div class="flex gap-3 p-5 hover:bg-gray-50 dark:hover:bg-gray-900/50 transition-colors group/item">
                    <a :href="'/product/' + item.attributes.slug" class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 bg-gray-100 dark:bg-gray-800 rounded-lg overflow-hidden">
                        <img :src="item.attributes.image" :alt="item.name" class="w-full h-full object-cover" loading="lazy">
                    </a>
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-start gap-2 mb-1">
                            <a :href="'/product/' + item.attributes.slug" class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-2 leading-tight hover:text-primary-600 transition-colors" x-text="item.name"></a>
                            <button @click="removeItem(item.id)" class="flex-shrink-0 w-7 h-7 flex items-center justify-center rounded-full text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-all opacity-0 group-hover/item:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-gray-500 dark:text-gray-400 mb-2">
                            <span x-show="item.attributes.size" x-text="item.attributes.size"></span>
                            <span x-show="item.attributes.size && item.attributes.color" class="text-gray-300 dark:text-gray-600">/</span>
                            <span x-show="item.attributes.color" x-text="item.attributes.color"></span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                                <button @click="updateQty(item.id, item.quantity - 1)" :disabled="item.quantity <= 1" class="w-8 h-8 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 disabled:opacity-30 disabled:cursor-not-allowed transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                </button>
                                <span x-text="item.quantity" class="w-8 h-8 flex items-center justify-center text-sm font-semibold text-gray-900 dark:text-white border-x border-gray-200 dark:border-gray-700"></span>
                                <button @click="updateQty(item.id, item.quantity + 1)" class="w-8 h-8 flex items-center justify-center text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                </button>
                            </div>
                            <span class="text-sm font-bold text-gray-900 dark:text-white" x-text="'৳' + fmt(item.price * item.quantity)"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Footer -->
    <div x-show="items.length > 0 && !loading" class="border-t border-gray-200 dark:border-gray-800 flex-shrink-0">
        <!-- Coupon -->
        <div class="px-5 py-3">
            <div class="flex gap-2">
                <input type="text" x-model="couponCode" @keydown.enter="applyCoupon()" placeholder="Coupon code"
                    class="flex-1 px-3 py-2 text-sm border border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-900 focus:border-transparent">
                <button @click="applyCoupon()" :disabled="!couponCode.trim() || couponLoading"
                    class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white text-sm font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 disabled:opacity-50 transition-colors flex-shrink-0">
                    <span x-show="!couponLoading">Apply</span>
                    <svg x-show="couponLoading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </button>
            </div>
            <p x-show="couponMessage" :class="couponSuccess ? 'text-green-600' : 'text-red-500'" x-text="couponMessage" class="text-xs mt-1.5"></p>
        </div>

        <!-- Summary -->
        <div class="px-5 py-3 space-y-2 bg-gray-50 dark:bg-gray-900/50">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Subtotal</span>
                <span class="font-medium text-gray-900 dark:text-white" x-text="'৳' + fmt(subTotal)"></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Shipping</span>
                <span class="font-medium" :class="shippingFee === 0 ? 'text-green-600' : 'text-gray-900 dark:text-white'" x-text="shippingFee === 0 ? 'FREE' : '৳' + fmt(shippingFee)"></span>
            </div>
            <div x-show="discount > 0" class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Discount</span>
                <span class="font-medium text-green-600" x-text="'-৳' + fmt(discount)"></span>
            </div>
            <div class="flex justify-between pt-2 border-t border-gray-200 dark:border-gray-800">
                <span class="font-bold text-gray-900 dark:text-white">Total</span>
                <span class="text-xl font-bold text-primary-900 dark:text-primary-400" x-text="'৳' + fmt(total)"></span>
            </div>
        </div>

        <!-- Checkout -->
        <div class="px-5 py-4 space-y-2">
            <a href="{{ url('/checkout') }}" @click="$dispatch('cart-close')" class="block w-full py-3.5 bg-gray-900 hover:bg-primary-900 dark:bg-white dark:hover:bg-gray-100 dark:text-gray-900 text-white text-center text-sm font-bold rounded-xl transition-all duration-200 active:scale-[0.98]">
                Proceed to Checkout
            </a>
            <button @click="$dispatch('cart-close')" class="block w-full py-2.5 text-center text-sm text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                Continue Shopping
            </button>
        </div>
    </div>
</div>

<script>
function cartSidebar() {
    return {
        open: false,
        loading: false,
        items: [],
        itemCount: 0,
        subTotal: 0,
        shippingFee: 0,
        discount: 0,
        total: 0,
        couponCode: '',
        couponMessage: '',
        couponSuccess: false,
        couponLoading: false,

        async fetchCart() {
            this.loading = true;
            try {
                const res = await fetch('{{ url("/cart/data") }}', {
                    headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                this.items = data.items || [];
                this.itemCount = data.item_count || 0;
                this.subTotal = data.sub_total || 0;
                this.shippingFee = data.shipping_fee || 0;
                this.discount = data.discount || 0;
                this.total = data.total || 0;
                if (data.coupon_code) this.couponCode = data.coupon_code;
            } catch (e) {
                console.error('Cart fetch error:', e);
            }
            this.loading = false;
        },

        async updateQty(itemId, newQty) {
            if (newQty < 1) return;
            const item = this.items.find(i => i.id == itemId);
            if (!item) return;
            const oldQty = item.quantity;
            item.quantity = newQty;
            this.recalculate();

            try {
                const res = await fetch(`/cart/update/${itemId}`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ quantity: newQty })
                });
                const data = await res.json();
                if (!data.success) { item.quantity = oldQty; this.recalculate(); }
            } catch (e) { item.quantity = oldQty; this.recalculate(); }
        },

        async removeItem(itemId) {
            const idx = this.items.findIndex(i => i.id == itemId);
            if (idx === -1) return;
            const removed = this.items.splice(idx, 1)[0];
            this.recalculate();
            try {
                await fetch(`/cart/remove/${itemId}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 'Accept': 'application/json' }
                });
                window.dispatchEvent(new Event('cart-updated'));
            } catch (e) { this.items.splice(idx, 0, removed); this.recalculate(); }
        },

        async applyCoupon() {
            if (!this.couponCode.trim()) return;
            this.couponLoading = true;
            this.couponMessage = '';
            try {
                const res = await fetch('/cart/coupon/apply', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json', 'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ code: this.couponCode.trim() })
                });
                const data = await res.json();
                this.couponMessage = data.message;
                this.couponSuccess = data.success;
                if (data.success) { this.discount = data.discount || 0; this.recalculate(); }
            } catch (e) { this.couponMessage = 'Something went wrong.'; this.couponSuccess = false; }
            this.couponLoading = false;
        },

        recalculate() {
            this.itemCount = this.items.reduce((s, i) => s + i.quantity, 0);
            this.subTotal = this.items.reduce((s, i) => s + (i.price * i.quantity), 0);
            this.shippingFee = this.subTotal >= 2000 ? 0 : 100;
            this.total = this.subTotal + this.shippingFee - this.discount;
        },

        fmt(n) { return new Intl.NumberFormat('en-IN').format(Math.round(n)); }
    }
}
</script>
