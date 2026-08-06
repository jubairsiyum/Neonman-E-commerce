<div
    x-data="quickAddModal()"
    x-show="open"
    x-cloak
    x-on:quick-add.window="openModal($event.detail)"
    x-on:keydown.escape.window="close()"
    x-transition.opacity.duration.150ms
    style="z-index: 99999; isolation: isolate;"
    class="fixed inset-0 flex items-center justify-center p-4"
>
    <div @click="close()" style="z-index: 0;" class="absolute inset-0 bg-black/50 backdrop-blur-lg"></div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        @click.stop
        style="z-index: 1;"
        class="relative w-[85vw] sm:w-[320px] bg-white dark:bg-gray-900 rounded-2xl shadow-2xl max-h-[85vh] overflow-y-auto"
    >
        <template x-if="product">
            <div class="p-5">
                <button @click="close()" class="absolute top-3 right-3 w-8 h-8 flex items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-500 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <div class="flex flex-col items-center text-center mb-5">
                    <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-2xl overflow-hidden bg-gray-100 dark:bg-gray-800 mb-3">
                        <img :src="product.image" :alt="product.name" class="w-full h-full object-cover">
                    </div>
                    <h3 class="font-bold text-sm text-gray-900 dark:text-white line-clamp-2 font-display" x-text="product.name"></h3>
                    <p class="text-primary-600 dark:text-primary-400 font-bold text-lg mt-1" x-text="'৳' + fmt(product.price)"></p>
                </div>

                <template x-if="product.sizes && product.sizes.length > 0">
                    <div class="mb-4">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest text-center mb-2">Size</p>
                        <div class="flex flex-wrap justify-center gap-1.5">
                            <template x-for="size in product.sizes" :key="size">
                                <button @click="selectedSize = size"
                                    :class="selectedSize === size ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700'"
                                    class="w-11 h-11 flex items-center justify-center rounded-lg text-xs font-bold transition-colors"
                                    x-text="size.toUpperCase()"></button>
                            </template>
                        </div>
                    </div>
                </template>

                <template x-if="product.colors && product.colors.length > 0">
                    <div class="mb-4">
                        <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest text-center mb-2">Color</p>
                        <div class="flex flex-wrap justify-center gap-1.5">
                            <template x-for="color in product.colors" :key="color">
                                <button @click="selectedColor = color"
                                    :class="selectedColor === color ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700'"
                                    class="h-11 px-4 flex items-center justify-center rounded-lg text-xs font-bold transition-colors"
                                    x-text="color.charAt(0).toUpperCase() + color.slice(1)"></button>
                            </template>
                        </div>
                    </div>
                </template>

                <div class="mb-5">
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest text-center mb-2">Quantity</p>
                    <div class="flex items-center justify-center gap-2">
                        <button @click="qty = Math.max(1, qty - 1)" :disabled="qty <= 1" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                        </button>
                        <span class="w-10 text-center font-bold text-base text-gray-900 dark:text-white" x-text="qty"></span>
                        <button @click="qty = Math.min(product.maxQty, qty + 1)" :disabled="qty >= product.maxQty" class="w-9 h-9 flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 disabled:opacity-30 disabled:cursor-not-allowed transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-800 pt-4 mb-4">
                    <span class="text-xs text-gray-500 dark:text-gray-400">Total</span>
                    <span class="text-base font-bold text-gray-900 dark:text-white" x-text="'৳' + fmt(product.price * qty)"></span>
                </div>

                <button @click="addToCart()"
                    class="w-full py-3 bg-primary-900 hover:bg-primary-950 text-white text-sm font-bold rounded-xl transition-colors active:scale-[0.98]">
                    Add to Cart
                </button>
            </div>
        </template>
    </div>
</div>

<script>
function quickAddModal() {
    return {
        open: false,
        product: null,
        selectedSize: null,
        selectedColor: null,
        qty: 1,

        openModal(data) {
            this.product = data;
            this.selectedSize = null;
            this.selectedColor = null;
            this.qty = 1;
            this.open = true;
            document.body.style.overflow = 'hidden';
        },
        close() {
            this.open = false;
            document.body.style.overflow = '';
        },
        addToCart() {
            if (!this.product) return;
            window.quickAddToCart(this.product.id, this.qty, this.selectedSize, this.selectedColor);
            window.dispatchEvent(new Event('cart-updated'));
            this.close();
        },
        fmt(n) { return new Intl.NumberFormat('en-IN').format(Math.round(n)); }
    }
}
</script>
