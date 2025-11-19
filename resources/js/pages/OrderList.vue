<script setup lang="ts">
import { defineProps, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps<{
    orders: Array<{
        id: number;
        quantity: number;
        status: string;
        product: {
            id: number;
            name: string;
            price: number;
            image: string;
        };
    }>;
}>();

// Function to update order status
function updateStatus(orderId: number, newStatus: string) {
    Inertia.put(`/orders/${orderId}`, { status: newStatus });
}

// Compute total price per order
function orderTotal(order: any) {
    return order.product.price * order.quantity;
}
</script>

<template>
    <div class="mx-auto max-w-4xl p-4">
        <h1 class="mb-4 text-2xl font-bold">Order List</h1>

        <div v-if="props.orders.length === 0" class="text-gray-500">
            No orders yet.
        </div>

        <div v-else class="space-y-4">
            <div
                v-for="order in props.orders"
                :key="order.id"
                class="flex items-center gap-4 rounded-lg border p-4"
            >
                <img
                    :src="order.product.image"
                    alt=""
                    class="h-24 w-24 rounded object-cover"
                />
                <div class="flex-1">
                    <h2 class="font-semibold">{{ order.product.name }}</h2>
                    <p class="mt-1 font-bold">
                        RM {{ order.product.price }} x {{ order.quantity }} = RM {{ orderTotal(order) }}
                    </p>
                    <p class="mt-1">Status: 
                        <span :class="order.status === 'completed' ? 'text-green-600 font-bold' : 'text-yellow-600 font-bold'">
                            {{ order.status }}
                        </span>
                    </p>
                    <div class="mt-2 flex gap-2">
                        <button
                            v-if="order.status === 'pending'"
                            @click="updateStatus(order.id, 'completed')"
                            class="rounded bg-green-600 px-3 py-1 text-white hover:bg-green-700"
                        >
                            Mark Completed
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
