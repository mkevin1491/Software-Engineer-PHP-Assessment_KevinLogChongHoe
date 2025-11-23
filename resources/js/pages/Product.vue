<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import { router } from '@inertiajs/vue3';
import { defineProps, ref } from 'vue';

// Define the shape of the product prop
const props = defineProps<{
    product: {
        id: number;
        name: string;
        description: string;
        short_description: string;
        full_description: string;
        specs?: string[];
        category?: string;
        brand?: string;
        model_no?: string;
        warranty?: string;
        price: number;
        image: string;
        thumbnails?: string[];
    };
}>();

const quantity = ref(1);
const isProcessing = ref(false); // Prevents double-clicking

function increase() {
    quantity.value++;
}

function decrease() {
    if (quantity.value > 1) quantity.value--;
}

// Add to Cart → DB cart table
function addToCart() {
    if (isProcessing.value) return;
    
    isProcessing.value = true;

    router.post(
        '/cart',
        {
            product_id: props.product.id,
            quantity: quantity.value,
        },
        {
            preserveScroll: true, // Crucial: Keeps page static while Navbar updates
            onSuccess: () => {
                // Reset quantity on success
                quantity.value = 1; 
                // Note: The Navbar will automatically pick up the new 
                // 'cartCount' from global props and trigger the pop animation.
            },
            onFinish: () => {
                isProcessing.value = false;
            }
        },
    );
}

// Buy Now → Session + redirect to checkout
function buyNow() {
    router.post('/cart', {
        product_id: props.product.id,
        quantity: quantity.value,
        buy_now: true,
    });
}

// Go back to catalogue page
function goBack() {
    router.get('/');
}
</script>

<template>
    <!-- Navbar handles the Cart Icon and Animation automatically -->
    <Navbar />

    <div class="mx-auto max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <!-- Back Button -->
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

        <div class="grid gap-10 lg:grid-cols-2">
            <!-- Product Images -->
            <div class="flex flex-col gap-4">
                <img
                    :src="props.product.image"
                    :alt="props.product.name"
                    class="h-[500px] w-full rounded-xl object-cover shadow-md"
                />

                <!-- Thumbnails -->
                <div class="mt-2 flex gap-2">
                    <img
                        v-for="(img, idx) in props.product.thumbnails || [props.product.image]"
                        :key="idx"
                        :src="img"
                        class="h-20 w-20 cursor-pointer rounded-lg border object-cover hover:border-blue-500 transition-colors"
                    />
                </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-gray-800 dark:text-white">
                        {{ props.product.name }}
                    </h1>

                    <p class="mt-2 text-2xl font-bold text-blue-600">
                        RM {{ props.product.price }}
                    </p>

                    <p class="mt-1 text-gray-500">
                        {{ props.product.short_description }}
                    </p>

                    <!-- Category / Brand / Model -->
                    <div class="mt-4 space-y-1 text-gray-600 dark:text-gray-400">
                        <p v-if="props.product.category">
                            <strong>Category:</strong> {{ props.product.category }}
                        </p>
                        <p v-if="props.product.brand">
                            <strong>Brand:</strong> {{ props.product.brand }}
                        </p>
                        <p v-if="props.product.model_no">
                            <strong>Model No:</strong> {{ props.product.model_no }}
                        </p>
                        <p v-if="props.product.warranty">
                            <strong>Warranty:</strong> {{ props.product.warranty }}
                        </p>
                    </div>

                    <!-- Specifications -->
                    <div
                        class="mt-6"
                        v-if="props.product.specs && props.product.specs.length"
                    >
                        <h2 class="mb-2 text-lg font-semibold text-gray-800 dark:text-gray-200">
                            Specifications
                        </h2>
                        <ul class="list-inside list-disc text-gray-600 dark:text-gray-400">
                            <li v-for="(line, idx) in props.product.specs" :key="idx">
                                {{ line }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Quantity & Buttons -->
                <div class="mt-6 flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <span class="font-semibold text-gray-800 dark:text-white">Quantity:</span>
                        <div class="flex w-32 items-center rounded-lg border border-gray-200 dark:border-neutral-700">
                            <button
                                @click="decrease"
                                class="px-3 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-neutral-800"
                            >
                                -
                            </button>
                            <span class="flex-1 text-center text-gray-800 dark:text-white">
                                {{ quantity }}
                            </span>
                            <button
                                @click="increase"
                                class="px-3 py-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-neutral-800"
                            >
                                +
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button
                            @click="addToCart"
                            :disabled="isProcessing"
                            class="flex-1 rounded-lg bg-blue-600 py-3 font-semibold text-white hover:bg-blue-700 disabled:opacity-70 disabled:cursor-not-allowed transition-all active:scale-[0.98]"
                        >
                            {{ isProcessing ? 'Adding...' : 'Add to Cart' }}
                        </button>

                        <button
                            @click="buyNow"
                            class="flex-1 rounded-lg bg-orange-500 py-3 font-semibold text-white hover:bg-orange-600 transition-all active:scale-[0.98]"
                        >
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Description -->
        <div class="mt-10">
            <h2 class="mb-4 text-2xl font-semibold text-gray-800 dark:text-white">Product Description</h2>
            <p class="whitespace-pre-line text-gray-600 dark:text-gray-400">
                {{ props.product.full_description }}
            </p>
        </div>
    </div>
</template>