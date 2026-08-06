<div
    x-data="toastManager()"
    x-on:toast.window="add($event.detail.message, $event.detail.type)"
    class="fixed top-4 right-4 z-[99999] flex flex-col gap-2 pointer-events-none"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="toast.show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-x-full opacity-0"
            x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-full opacity-0"
            class="pointer-events-auto flex items-center gap-2 px-4 py-3 rounded-xl shadow-lg text-sm font-medium max-w-xs"
            :class="{
                'bg-green-600 text-white': toast.type === 'success',
                'bg-red-600 text-white': toast.type === 'error',
                'bg-gray-900 dark:bg-white text-white dark:text-gray-900': toast.type === 'info',
            }"
        >
            <svg x-show="toast.type === 'success'" class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <svg x-show="toast.type === 'error'" class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
            <span x-text="toast.message"></span>
        </div>
    </template>
</div>

<script>
function toastManager() {
    return {
        toasts: [],
        counter: 0,

        add(message, type = 'success') {
            const id = ++this.counter;
            this.toasts.push({ id, message, type, show: true });
            setTimeout(() => {
                const idx = this.toasts.findIndex(t => t.id === id);
                if (idx > -1) this.toasts[idx].show = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 200);
            }, 3000);
        }
    }
}

window.showToast = function(message, type = 'success') {
    window.dispatchEvent(new CustomEvent('toast', { detail: { message, type } }));
};
</script>
