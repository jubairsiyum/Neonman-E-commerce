import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

/* ─────────────────────────────────────────────────────────────
   Global helpers
   ───────────────────────────────────────────────────────────── */
const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ?? '';

async function apiFetch(url, method = 'POST', body = null) {
    const opts = {
        method,
        headers: {
            'X-CSRF-TOKEN': csrfToken(),
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
    };
    if (body) opts.body = JSON.stringify(body);

    try {
        const res = await fetch(url, opts);
        return res.json();
    } catch {
        return { success: false, message: 'Network error. Please try again.' };
    }
}

/* ─────────────────────────────────────────────────────────────
   Toast notification
   ───────────────────────────────────────────────────────────── */
function showToast(message, type = 'success') {
    const existing = document.getElementById('neonman-toast');
    if (existing) existing.remove();

    const bg = type === 'success'
        ? 'bg-green-600 dark:bg-green-500'
        : 'bg-red-600 dark:bg-red-500';

    const toast = document.createElement('div');
    toast.id = 'neonman-toast';
    toast.className = `fixed bottom-5 left-1/2 -translate-x-1/2 z-[9999] flex items-center gap-2 px-5 py-3 rounded-xl text-white text-sm font-medium shadow-2xl ${bg} transition-all duration-300 opacity-0 translate-y-4`;
    toast.innerHTML = `
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            ${type === 'success'
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>'}
        </svg>
        <span>${message}</span>`;

    document.body.appendChild(toast);
    requestAnimationFrame(() => {
        toast.classList.remove('opacity-0', 'translate-y-4');
    });
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-4');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

/* ─────────────────────────────────────────────────────────────
   Cart counter update helper
   ───────────────────────────────────────────────────────────── */
function updateCartCountBadge(count) {
    const badges = document.querySelectorAll('.cart-count-badge');
    badges.forEach(badge => {
        if (count > 0) {
            badge.textContent = count;
            badge.classList.remove('hidden');
        } else {
            badge.classList.add('hidden');
        }
    });
}

/* ─────────────────────────────────────────────────────────────
   Quick Add to Cart (used in product-card & product page)
   ───────────────────────────────────────────────────────────── */
window.quickAddToCart = async function (productId, quantity = 1, size = null, color = null) {
    const body = { product_id: productId, quantity };
    if (size) body.size = size;
    if (color) body.color = color;

    const data = await apiFetch('/cart/add', 'POST', body);

    if (data.success) {
        showToast(data.message ?? 'Added to cart!', 'success');
        updateCartCountBadge(data.cart_count ?? 0);
    } else {
        showToast(data.message ?? 'Could not add to cart.', 'error');
    }
};

/* ─────────────────────────────────────────────────────────────
   Toggle Wishlist (used in product-card & product page)
   ───────────────────────────────────────────────────────────── */
window.toggleWishlist = async function (productId, btn = null) {
    const data = await apiFetch('/wishlist/toggle', 'POST', { product_id: productId });

    if (data.success) {
        showToast(data.message ?? 'Wishlist updated!', 'success');

        // Update wishlist count badges
        const wishlistBadges = document.querySelectorAll('.wishlist-count-badge');
        wishlistBadges.forEach(badge => {
            const count = data.wishlist_count ?? 0;
            if (count > 0) {
                badge.textContent = count;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        });

        // Update heart icon on button
        if (btn) {
            const svg = btn.querySelector('svg');
            if (svg) {
                if (data.in_wishlist) {
                    svg.setAttribute('fill', 'currentColor');
                    btn.classList.add('text-red-500');
                } else {
                    svg.setAttribute('fill', 'none');
                    btn.classList.remove('text-red-500');
                }
            }
        }
    } else {
        if (data.message && data.message.toLowerCase().includes('login')) {
            showToast('Please log in to use your wishlist.', 'error');
            setTimeout(() => { window.location.href = '/login'; }, 1500);
        } else {
            showToast(data.message ?? 'Could not update wishlist.', 'error');
        }
    }
};
