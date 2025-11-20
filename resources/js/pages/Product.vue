<script setup lang="ts">
import { Inertia } from '@inertiajs/inertia';
import { defineProps, ref } from 'vue';

const props = defineProps<{
    product: {
        id: number;
        name: string;
        description: string;
        short_description: string;
        full_description: string;
        specs?: string[]; // from DB JSON
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

function increase() {
    quantity.value++;
}
function decrease() {
    if (quantity.value > 1) quantity.value--;
}

function addToCart() {
    Inertia.post('/cart', {
        product_id: props.product.id,
        quantity: quantity.value,
    });
}

function buyNow() {
    Inertia.post(
        '/cart',
        {
            product_id: props.product.id,
            quantity: quantity.value,
            buy_now: true, // signal controller to redirect
        },
        {
            onSuccess: () => Inertia.visit('/cart'),
        },
    );
}
</script>

<template>
    <div class="mx-auto max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
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
                        v-for="(img, idx) in props.product.thumbnails || [
                            props.product.image,
                        ]"
                        :key="idx"
                        :src="img"
                        class="h-20 w-20 cursor-pointer rounded-lg border object-cover hover:border-blue-500"
                    />
                </div>
            </div>

            <!-- Product Info -->
            <div class="flex flex-col justify-between">
                <div>
                    <h1
                        class="text-3xl font-semibold text-gray-800 dark:text-white"
                    >
                        {{ props.product.name }}
                    </h1>

                    <p class="mt-2 text-2xl font-bold text-blue-600">
                        RM {{ props.product.price }}
                    </p>

                    <p class="mt-1 text-gray-500">
                        {{ props.product.short_description }}
                    </p>

                    <!-- Category / Brand / Model -->
                    <div class="mt-4 space-y-1 text-gray-600">
                        <p v-if="props.product.category">
                            <strong>Category:</strong>
                            {{ props.product.category }}
                        </p>
                        <p v-if="props.product.brand">
                            <strong>Brand:</strong> {{ props.product.brand }}
                        </p>
                        <p v-if="props.product.model_no">
                            <strong>Model No:</strong>
                            {{ props.product.model_no }}
                        </p>
                        <p v-if="props.product.warranty">
                            <strong>Warranty:</strong>
                            {{ props.product.warranty }}
                        </p>
                    </div>

                    <!-- Specifications -->
                    <div
                        class="mt-6"
                        v-if="props.product.specs && props.product.specs.length"
                    >
                        <h2 class="mb-2 text-lg font-semibold">
                            Specifications
                        </h2>
                        <ul class="list-inside list-disc text-gray-600">
                            <li
                                v-for="(line, idx) in props.product.specs"
                                :key="idx"
                            >
                                {{ line }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Quantity & Buttons -->
                <div class="mt-6 flex flex-col gap-4">
                    <div class="flex items-center gap-4">
                        <span class="font-semibold">Quantity:</span>
                        <div class="flex w-32 items-center rounded-lg border">
                            <button
                                @click="decrease"
                                class="px-3 py-2 text-gray-700 hover:bg-gray-100"
                            >
                                -
                            </button>
                            <span class="flex-1 text-center">{{
                                quantity
                            }}</span>
                            <button
                                @click="increase"
                                class="px-3 py-2 text-gray-700 hover:bg-gray-100"
                            >
                                +
                            </button>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <button
                            @click="addToCart"
                            class="flex-1 rounded-lg bg-blue-600 py-3 font-semibold text-white hover:bg-blue-700"
                        >
                            Add to Cart
                        </button>

                        <button
                            @click="buyNow"
                            class="flex-1 rounded-lg bg-orange-500 py-3 font-semibold text-white hover:bg-orange-600"
                        >
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Full Description -->
        <div class="mt-10">
            <h2 class="mb-4 text-2xl font-semibold">Product Description</h2>
            <p class="whitespace-pre-line text-gray-600">
                {{ props.product.full_description }}
            </p>
        </div>
    </div>
</template>
