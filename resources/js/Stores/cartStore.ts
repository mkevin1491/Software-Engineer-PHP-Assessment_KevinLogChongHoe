// cartStore.ts
import { reactive, computed } from 'vue';
import { router } from '@inertiajs/vue3';

// Reactive cart state
export const cartStore = reactive({
    items: [] as Array<{ id: number; quantity: number; product: { id: number; name: string; price: number; image: string } }>,
});

// Computed: total number of items
export const cartCount = computed(() => cartStore.items.reduce((sum, item) => sum + item.quantity, 0));

// Update quantity
export function updateQuantity(itemId: number, quantity: number) {
    if (quantity < 1) return;
    router.patch(`/cart/${itemId}`, { quantity }, { preserveScroll: true });
}

// Remove item
export function removeItem(itemId: number) {
    router.delete(`/cart/${itemId}`, { preserveScroll: true });
}
