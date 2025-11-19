<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia';
import { defineProps, ref } from 'vue';

const props = defineProps<{
    cartItems: Array<{
        id: number;
        quantity: number;
        product: {
            id: number;
            name: string;
            price: number;
            image: string;
        };
    }>;
}>();

// Update quantity
function updateQuantity(itemId: number, quantity: number) {
    Inertia.put(`/cart/${itemId}`, { quantity });
}

// Remove item
function removeItem(itemId: number) {
    Inertia.delete(`/cart/${itemId}`);
}

function checkout() {
    Inertia.post('/cart/checkout'); // calls the checkout route
}

// Compute total
const total = ref(0);
total.value = props.cartItems.reduce(
    (sum, item) => sum + item.product.price * item.quantity,
    0,
);
</script>

<template>
    <div class="mx-auto max-w-3xl p-4">
        <h1 class="mb-4 text-2xl font-bold">Your Cart</h1>

        <div v-if="props.cartItems.length === 0" class="text-gray-500">
            Your cart is empty.
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="item in props.cartItems"
                :key="item.id"
                class="flex items-center gap-4 rounded-lg border p-4"
            >
                <img
                    :src="item.product.image"
                    alt=""
                    class="h-24 w-24 rounded object-cover"
                />
                <div class="flex-1">
                    <h2 class="font-semibold">{{ item.product.name }}</h2>
                    <p class="mt-1 font-bold">RM {{ item.product.price }}</p>
                    <div class="mt-2 flex items-center gap-2">
                        <input
                            type="number"
                            v-model.number="item.quantity"
                            min="1"
                            class="w-16 rounded border px-2 py-1"
                        />
                        <button
                            @click="updateQuantity(item.id, item.quantity)"
                            class="rounded bg-blue-600 px-3 py-1 text-white hover:bg-blue-700"
                        >
                            Update
                        </button>
                        <button
                            @click="removeItem(item.id)"
                            class="rounded bg-red-600 px-3 py-1 text-white hover:bg-red-700"
                        >
                            Remove
                        </button>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-right text-lg font-bold">
                Total: RM
                {{
                    props.cartItems.reduce(
                        (sum, item) => sum + item.product.price * item.quantity,
                        0,
                    )
                }}
            </div>

            <div class="mt-4 text-right">
                <button
                    @click="checkout"
                    class="rounded bg-green-600 px-6 py-2 text-white hover:bg-green-700"
                >
                    Checkout
                </button>
            </div>
        </div>
    </div>
</template>
