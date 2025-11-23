<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import type { PageProps as BasePageProps } from '@inertiajs/core';
import { Inertia } from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';
import { defineProps, onMounted, ref } from 'vue';

const props = defineProps<{
    orders: Array<{
        id: number;
        quantity: number;
        status: string;
        created_at: string;
        product?: {
            id: number;
            name: string;
            price: number;
            image: string;
        };
    }>;
}>();

interface CustomPageProps extends BasePageProps {
    flash?: {
        success?: string;
        error?: string;
    };
}

const page = usePage<CustomPageProps>();
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');

onMounted(() => {
    if (page.props.flash?.success) {
        toastMessage.value = page.props.flash.success;
        toastType.value = 'success';
        showToast.value = true;
        setTimeout(() => (showToast.value = false), 5000);
    } else if (page.props.flash?.error) {
        toastMessage.value = page.props.flash.error;
        toastType.value = 'error';
        showToast.value = true;
        setTimeout(() => (showToast.value = false), 5000);
    }
});

function updateStatus(orderId: number, event: Event) {
    const newStatus = (event.target as HTMLSelectElement).value;
    if (confirm(`Change order status to "${newStatus}"?`)) {
        Inertia.put(
            `/orders/${orderId}`,
            { status: newStatus },
            { preserveScroll: true },
        );
    } else {
        window.location.reload();
    }
}

function getTotal(price: any, qty: number) {
    return (Number(price) * qty).toFixed(2);
}

function formatDate(dateString: string) {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
}

function getStatusConfig(status: string) {
    const configs: Record<
        string,
        { label: string; badge: string; icon: string }
    > = {
        pending: {
            label: 'Pending',
            badge: 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400 dark:border-yellow-800',
            icon: '⏱️',
        },
        processing: {
            label: 'Processing',
            badge: 'bg-blue-100 text-blue-800 border-blue-200 dark:bg-blue-900/30 dark:text-blue-400 dark:border-blue-800',
            icon: '⚙️',
        },
        shipped: {
            label: 'Shipped',
            badge: 'bg-purple-100 text-purple-800 border-purple-200 dark:bg-purple-900/30 dark:text-purple-400 dark:border-purple-800',
            icon: '🚚',
        },
        delivered: {
            label: 'Delivered',
            badge: 'bg-green-100 text-green-800 border-green-200 dark:bg-green-900/30 dark:text-green-400 dark:border-green-800',
            icon: '✅',
        },
        cancelled: {
            label: 'Cancelled',
            badge: 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800',
            icon: '❌',
        },
    };
    return configs[status] || configs.pending;
}
</script>

<template>
    <Navbar />
    <!-- Toast Notification (Top Right) -->
    <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="transform translate-x-full opacity-0"
        enter-to-class="transform translate-x-0 opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="transform translate-x-0 opacity-100"
        leave-to-class="transform translate-x-full opacity-0"
    >
        <div
            v-if="showToast"
            :class="[
                'fixed top-6 right-6 z-50 max-w-md min-w-[320px] rounded-lg border shadow-xl',
                toastType === 'success'
                    ? 'border-green-200 bg-green-50 dark:border-green-700 dark:bg-green-900/90'
                    : 'border-red-200 bg-red-50 dark:border-red-700 dark:bg-red-900/90',
            ]"
        >
            <div class="flex items-start gap-3 p-4">
                <div
                    :class="[
                        'flex-shrink-0 rounded-full p-1',
                        toastType === 'success'
                            ? 'bg-green-100 dark:bg-green-800'
                            : 'bg-red-100 dark:bg-red-800',
                    ]"
                >
                    <svg
                        v-if="toastType === 'success'"
                        class="h-5 w-5 text-green-600 dark:text-green-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        />
                    </svg>
                    <svg
                        v-else
                        class="h-5 w-5 text-red-600 dark:text-red-300"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </div>
                <div class="flex-1">
                    <p
                        :class="[
                            'text-sm font-semibold',
                            toastType === 'success'
                                ? 'text-green-900 dark:text-green-100'
                                : 'text-red-900 dark:text-red-100',
                        ]"
                    >
                        {{ toastType === 'success' ? 'Success!' : 'Error!' }}
                    </p>
                    <p
                        :class="[
                            'mt-1 text-sm',
                            toastType === 'success'
                                ? 'text-green-700 dark:text-green-200'
                                : 'text-red-700 dark:text-red-200',
                        ]"
                    >
                        {{ toastMessage }}
                    </p>
                </div>
                <button
                    @click="showToast = false"
                    :class="[
                        'flex-shrink-0 rounded-lg p-1 transition hover:bg-black/5 dark:hover:bg-white/10',
                        toastType === 'success'
                            ? 'text-green-600 dark:text-green-300'
                            : 'text-red-600 dark:text-red-300',
                    ]"
                >
                    <svg
                        class="h-5 w-5"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </Transition>

    <!-- Main Content -->
    <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                Order Management
            </h1>
            <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                Track and manage all your orders in one place
            </p>
        </div>

        <!-- Empty State -->
        <div
            v-if="props.orders.length === 0"
            class="rounded-xl border-2 border-dashed border-gray-300 bg-gray-50 p-12 text-center dark:border-neutral-700 dark:bg-neutral-800/50"
        >
            <svg
                class="mx-auto h-16 w-16 text-gray-400 dark:text-neutral-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="1.5"
                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                />
            </svg>
            <h3
                class="mt-4 text-lg font-semibold text-gray-900 dark:text-white"
            >
                No orders yet
            </h3>
            <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
                Your order history will appear here once you make a purchase
            </p>
        </div>

        <!-- Order List -->
        <div v-else class="space-y-4">
            <div
                v-for="order in props.orders"
                :key="order.id"
                class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition hover:shadow-md dark:border-neutral-700 dark:bg-neutral-800"
            >
                <!-- Order Header -->
                <div
                    class="flex flex-wrap items-center justify-between gap-4 border-b border-gray-200 bg-gray-50 px-6 py-4 dark:border-neutral-700 dark:bg-neutral-800/50"
                >
                    <div class="flex items-center gap-4">
                        <div>
                            <p
                                class="text-xs font-medium text-gray-500 uppercase dark:text-neutral-400"
                            >
                                Order ID
                            </p>
                            <p
                                class="mt-1 font-mono text-sm font-semibold text-gray-900 dark:text-white"
                            >
                                #{{ String(order.id).padStart(6, '0') }}
                            </p>
                        </div>
                        <div
                            class="h-8 w-px bg-gray-300 dark:bg-neutral-600"
                        ></div>
                        <div>
                            <p
                                class="text-xs font-medium text-gray-500 uppercase dark:text-neutral-400"
                            >
                                Order Date
                            </p>
                            <p
                                class="mt-1 text-sm text-gray-900 dark:text-white"
                            >
                                {{ formatDate(order.created_at) }}
                            </p>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div
                        :class="[
                            'inline-flex items-center gap-2 rounded-full border px-4 py-2 text-sm font-semibold',
                            getStatusConfig(order.status).badge,
                        ]"
                    >
                        <span>{{ getStatusConfig(order.status).icon }}</span>
                        <span>{{ getStatusConfig(order.status).label }}</span>
                    </div>
                </div>

                <!-- Order Content -->
                <div class="p-6">
                    <div class="flex flex-col gap-6 sm:flex-row">
                        <!-- Product Info -->
                        <template v-if="order.product">
                            <div class="flex flex-1 gap-4">
                                <div
                                    class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-lg border border-gray-200 bg-gray-100 dark:border-neutral-600 dark:bg-neutral-700"
                                >
                                    <img
                                        :src="order.product.image"
                                        :alt="order.product.name"
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                                <div class="flex-1">
                                    <h3
                                        class="text-lg font-semibold text-gray-900 dark:text-white"
                                    >
                                        {{ order.product.name }}
                                    </h3>
                                    <div
                                        class="mt-2 flex items-center gap-4 text-sm text-gray-600 dark:text-neutral-400"
                                    >
                                        <span>Qty: {{ order.quantity }}</span>
                                        <span
                                            class="text-gray-400 dark:text-neutral-500"
                                            >•</span
                                        >
                                        <span
                                            >RM
                                            {{
                                                Number(
                                                    order.product.price,
                                                ).toFixed(2)
                                            }}
                                            each</span
                                        >
                                    </div>
                                    <div class="mt-3 flex items-baseline gap-2">
                                        <span
                                            class="text-sm text-gray-600 dark:text-neutral-400"
                                            >Total:</span
                                        >
                                        <span
                                            class="text-xl font-bold text-indigo-600 dark:text-indigo-400"
                                        >
                                            RM
                                            {{
                                                getTotal(
                                                    order.product.price,
                                                    order.quantity,
                                                )
                                            }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        <!-- Fallback if product deleted -->
                        <div
                            v-else
                            class="flex flex-1 items-center gap-3 rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-800 dark:bg-red-900/20"
                        >
                            <svg
                                class="h-6 w-6 flex-shrink-0 text-red-600 dark:text-red-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                />
                            </svg>
                            <div>
                                <p
                                    class="font-semibold text-red-900 dark:text-red-200"
                                >
                                    Product No Longer Available
                                </p>
                                <p
                                    class="mt-1 text-sm text-red-700 dark:text-red-300"
                                >
                                    This product has been removed from the
                                    catalog
                                </p>
                            </div>
                        </div>

                        <!-- Status Update Section -->
                        <div
                            class="flex flex-col gap-3 sm:w-64 sm:border-l sm:border-gray-200 sm:pl-6 dark:sm:border-neutral-700"
                        >
                            <label
                                class="text-xs font-semibold tracking-wide text-gray-700 uppercase dark:text-neutral-300"
                            >
                                Update Status
                            </label>
                            <select
                                :value="order.status"
                                @change="updateStatus(order.id, $event)"
                                class="block w-full rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-900 shadow-sm transition focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 focus:outline-none dark:border-neutral-600 dark:bg-neutral-700 dark:text-white dark:focus:border-indigo-400 dark:focus:ring-indigo-400"
                            >
                                <option value="pending">⏱️ Pending</option>
                                <option value="shipped">🚚 Shipped</option>
                                <option value="delivered">✅ Delivered</option>
                                <option value="cancelled">❌ Cancelled</option>
                            </select>

                            <p
                                class="text-xs text-gray-500 dark:text-neutral-400"
                            >
                                Select a new status to update this order
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, box-shadow;
    transition-duration: 200ms;
    transition-timing-function: ease-in-out;
}
</style>
