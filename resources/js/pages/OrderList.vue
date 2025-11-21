<script setup lang="ts">
import { defineProps } from 'vue';
// 👇 Reverted to the import you were definitely using before
import { Inertia } from '@inertiajs/inertia'; 

const props = defineProps<{
    orders: Array<{
        id: number;
        quantity: number;
        status: string;
        created_at: string;
        // 👇 Make product optional (?) to prevent crashes if product is deleted
        product?: { 
            id: number;
            name: string;
            price: number;
            image: string;
        };
    }>;
}>();

function updateStatus(orderId: number, event: Event) {
    const newStatus = (event.target as HTMLSelectElement).value;
    
    if (confirm(`Change status to "${newStatus}"?`)) {
        // 👇 Using the older Inertia syntax compatible with your setup
        Inertia.put(`/orders/${orderId}`, { 
            status: newStatus 
        }, {
            preserveScroll: true,
        });
    } else {
        window.location.reload();
    }
}

function getTotal(price: any, qty: number) {
    // Ensure price is treated as a number (sometimes DB sends strings)
    return (Number(price) * qty).toFixed(2);
}
</script>

<template>
    <div class="mx-auto max-w-4xl p-4">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Order Management</h1>

        <!-- Empty State -->
        <div v-if="props.orders.length === 0" class="rounded-lg bg-gray-50 p-8 text-center text-gray-500">
            No orders found.
        </div>

        <!-- Order List -->
        <div v-else class="space-y-6">
            <div
                v-for="order in props.orders"
                :key="order.id"
                class="flex flex-col gap-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center"
            >
                <!-- 🛡️ SAFEGUARD: Check if product exists (in case it was deleted) -->
                <template v-if="order.product">
                    <!-- Product Image -->
                    <img
                        :src="order.product.image"
                        alt="Product Image"
                        class="h-24 w-24 flex-shrink-0 rounded-md object-cover border"
                    />

                    <!-- Order Details -->
                    <div class="flex-1">
                        <div class="flex justify-between">
                            <h2 class="text-lg font-semibold text-gray-800">{{ order.product.name }}</h2>
                            <span class="text-xs text-gray-400">Order #{{ order.id }}</span>
                        </div>
                        
                        <p class="mt-1 text-gray-600">
                            RM {{ Number(order.product.price).toFixed(2) }} x {{ order.quantity }}
                        </p>
                        
                        <p class="mt-1 font-bold text-blue-600">
                            Total: RM {{ getTotal(order.product.price, order.quantity) }}
                        </p>
                    </div>
                </template>

                <!-- Fallback if Product was Deleted -->
                <div v-else class="flex-1 text-red-500">
                    <p class="font-bold">Product Deleted</p>
                    <p class="text-sm text-gray-500">Order #{{ order.id }}</p>
                </div>

                <!-- Status Control -->
                <div class="flex flex-col gap-2 sm:w-48">
                    <label class="text-xs font-semibold text-gray-500 uppercase">Update Status</label>
                    <select 
                        :value="order.status"
                        @change="updateStatus(order.id, $event)"
                        :class="{
                            'bg-yellow-50 border-yellow-300 text-yellow-800': order.status === 'pending',
                            'bg-blue-50 border-blue-300 text-blue-800': order.status === 'shipped',
                            'bg-green-50 border-green-300 text-green-800': order.status === 'delivered',
                            'bg-gray-50 border-gray-300 text-gray-800': order.status === 'cancelled',
                        }"
                        class="block w-full rounded-md border px-3 py-2 text-sm focus:border-blue-500 focus:ring-blue-500"
                    >
                        <option value="pending">Pending</option>
                        <option value="shipped">Shipped</option>
                        <option value="delivered">Delivered</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</template>