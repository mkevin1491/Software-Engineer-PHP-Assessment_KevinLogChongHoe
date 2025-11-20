<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia';
import { computed, defineProps, ref } from 'vue';

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

const showAddress = ref(false);
const selectedPayment = ref('COD');

// Update quantity
function updateQuantity(itemId: number, quantity: number) {
    Inertia.put(`/cart/${itemId}`, { quantity });
}

// Remove item
function removeItem(itemId: number) {
    Inertia.delete(`/cart/${itemId}`);
}

function checkout() {
    Inertia.post('/cart/checkout');
}

function goBack() {
    window.history.back();
}

// Computed values
const subtotal = computed(() =>
    props.cartItems.reduce(
        (sum, item) => sum + item.product.price * item.quantity,
        0,
    ),
);

const tax = computed(() => subtotal.value * 0.02);
const total = computed(() => subtotal.value + tax.value);
</script>

<template>
    <div class="mx-auto flex w-full max-w-6xl flex-col px-6 py-16 md:flex-row">
        <div class="max-w-4xl flex-1">
            <button
                @click="goBack"
                class="group mb-6 flex cursor-pointer items-center gap-2 font-medium text-gray-600 transition-colors hover:text-indigo-500 dark:text-neutral-400 dark:hover:text-indigo-400"
            >
                <svg
                    width="20"
                    height="20"
                    viewBox="0 0 20 20"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M12.5 16.667 5.833 10l6.667-6.667"
                        stroke="currentColor"
                        strokeWidth="1.5"
                        strokeLinecap="round"
                        strokeLinejoin="round"
                    />
                </svg>
                Back
            </button>

            <h1 class="mb-6 text-3xl font-medium text-gray-800 dark:text-white">
                Shopping Cart
                <span class="text-sm text-indigo-500 dark:text-indigo-400">
                    {{ props.cartItems.length }} Items
                </span>
            </h1>

            <div
                v-if="props.cartItems.length === 0"
                class="text-gray-500 dark:text-neutral-400"
            >
                Your cart is empty.
            </div>

            <template v-else>
                <div
                    class="grid grid-cols-[2fr_1fr_1fr] pb-3 text-base font-medium text-gray-500 dark:text-neutral-400"
                >
                    <p class="text-left">Product Details</p>
                    <p class="text-center">Subtotal</p>
                    <p class="text-center">Action</p>
                </div>

                <div
                    v-for="item in props.cartItems"
                    :key="item.id"
                    class="grid grid-cols-[2fr_1fr_1fr] items-center border-t border-gray-200 pt-3 text-sm font-medium text-gray-500 md:text-base dark:border-neutral-700 dark:text-neutral-400"
                >
                    <div class="flex items-center gap-3 md:gap-6">
                        <div
                            class="flex h-24 w-24 cursor-pointer items-center justify-center overflow-hidden rounded border border-gray-300 dark:border-neutral-600"
                        >
                            <img
                                class="h-full max-w-full object-cover"
                                :src="item.product.image"
                                :alt="item.product.name"
                            />
                        </div>
                        <div>
                            <p
                                class="hidden font-semibold text-gray-800 md:block dark:text-white"
                            >
                                {{ item.product.name }}
                            </p>
                            <div
                                class="font-normal text-gray-500 dark:text-neutral-400"
                            >
                                <p>
                                    Price:
                                    <span>RM {{ item.product.price }}</span>
                                </p>
                                <div class="flex items-center gap-1">
                                    <p>Qty:</p>
                                    <select
                                        v-model.number="item.quantity"
                                        @change="
                                            updateQuantity(
                                                item.id,
                                                item.quantity,
                                            )
                                        "
                                        class="bg-transparent outline-none dark:bg-neutral-800 dark:text-white"
                                    >
                                        <option
                                            v-for="n in 10"
                                            :key="n"
                                            :value="n"
                                        >
                                            {{ n }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p
                        class="text-center font-semibold text-gray-800 dark:text-white"
                    >
                        RM {{ (item.product.price * item.quantity).toFixed(2) }}
                    </p>
                    <button
                        @click="removeItem(item.id)"
                        class="mx-auto cursor-pointer transition hover:opacity-70"
                    >
                        <svg
                            width="20"
                            height="20"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="m12.5 7.5-5 5m0-5 5 5m5.833-2.5a8.333 8.333 0 1 1-16.667 0 8.333 8.333 0 0 1 16.667 0"
                                stroke="#FF532E"
                                strokeWidth="1.5"
                                strokeLinecap="round"
                                strokeLinejoin="round"
                            />
                        </svg>
                    </button>
                </div>
            </template>
        </div>

        <div
            class="w-full max-w-[360px] border border-gray-300/70 bg-gray-100/40 p-5 max-md:mt-16 dark:border-neutral-700 dark:bg-neutral-800/40"
        >
            <h2
                class="text-xl font-medium text-gray-800 md:text-xl dark:text-white"
            >
                Order Summary
            </h2>
            <hr class="my-5 border-gray-300 dark:border-neutral-600" />

            <div class="mb-6">
                <p
                    class="text-sm font-medium text-gray-800 uppercase dark:text-white"
                >
                    Delivery Address
                </p>
                <div class="relative mt-2 flex items-start justify-between">
                    <p class="text-gray-500 dark:text-neutral-400">
                        No address found
                    </p>
                    <button
                        @click="showAddress = !showAddress"
                        class="cursor-pointer text-indigo-500 hover:underline dark:text-indigo-400"
                    >
                        Change
                    </button>
                    <div
                        v-if="showAddress"
                        class="absolute top-12 z-10 w-full rounded border border-gray-300 bg-white py-1 text-sm shadow-lg dark:border-neutral-600 dark:bg-neutral-800"
                    >
                        <p
                            @click="showAddress = false"
                            class="cursor-pointer p-2 text-gray-500 hover:bg-gray-100 dark:text-neutral-400 dark:hover:bg-neutral-700"
                        >
                            Klang, Selangor, MY
                        </p>
                        <p
                            @click="showAddress = false"
                            class="cursor-pointer p-2 text-center text-indigo-500 hover:bg-indigo-500/10 dark:text-indigo-400 dark:hover:bg-indigo-500/20"
                        >
                            Add address
                        </p>
                    </div>
                </div>

                <p
                    class="mt-6 text-sm font-medium text-gray-800 uppercase dark:text-white"
                >
                    Payment Method
                </p>

                <select
                    v-model="selectedPayment"
                    class="mt-2 w-full rounded border border-gray-300 bg-white px-3 py-2 text-gray-800 outline-none dark:border-neutral-600 dark:bg-neutral-800 dark:text-white"
                >
                    <option value="COD">Cash On Delivery</option>
                    <option value="Online">Online Payment</option>
                </select>
            </div>

            <hr class="border-gray-300 dark:border-neutral-600" />

            <div class="mt-4 space-y-2 text-gray-500 dark:text-neutral-400">
                <p class="flex justify-between">
                    <span>Subtotal</span>
                    <span class="text-gray-800 dark:text-white"
                        >RM {{ subtotal.toFixed(2) }}</span
                    >
                </p>
                <p class="flex justify-between">
                    <span>Shipping Fee</span>
                    <span class="text-green-600 dark:text-green-400">Free</span>
                </p>
                <p class="flex justify-between">
                    <span>Tax (2%)</span>
                    <span class="text-gray-800 dark:text-white"
                        >RM {{ tax.toFixed(2) }}</span
                    >
                </p>
                <p
                    class="mt-3 flex justify-between text-lg font-medium text-gray-800 dark:text-white"
                >
                    <span>Total Amount:</span>
                    <span>RM {{ total.toFixed(2) }}</span>
                </p>
            </div>

            <button
                @click="checkout"
                :disabled="props.cartItems.length === 0"
                class="mt-6 w-full cursor-pointer rounded bg-indigo-500 py-3 font-medium text-white transition hover:bg-indigo-600 disabled:cursor-not-allowed disabled:opacity-50 dark:bg-indigo-600 dark:hover:bg-indigo-700"
            >
                Place Order
            </button>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
* {
    font-family: 'Poppins', sans-serif;
}
</style>
