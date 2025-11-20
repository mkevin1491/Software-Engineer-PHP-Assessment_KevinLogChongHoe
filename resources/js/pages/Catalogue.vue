<script setup lang="ts">
import { defineProps } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps<{ products: Array<any> }>();

// Navigate to product page using Inertia
function viewProduct(productId: number) {
    Inertia.get(`/products/${productId}`);
    console.log("ProductID is:" + productId);
}
</script>

<template>
    <div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="product in props.products"
                :key="product.id"
                class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-700 dark:shadow-neutral-700/70"
                @click="viewProduct(product.id)"
                style="cursor: pointer;"
            >
                <div class="h-52 flex flex-col justify-center items-center bg-gradient-to-br from-blue-500 to-blue-600 rounded-t-xl overflow-hidden">
                    <img
                        :src="product.image"
                        :alt="product.name"
                        class="w-full h-full object-cover"
                    />
                </div>
                <div class="p-4 md:p-6">
                    <span class="block mb-1 text-xs font-semibold uppercase text-blue-600 dark:text-blue-500">
                        RM {{ product.price }}
                    </span>
                    <h3 class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white">
                        {{ product.name }}
                    </h3>
                    <p class="mt-3 text-gray-500 dark:text-neutral-500">
                        {{ product.short_description }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');
* {
    font-family: 'Poppins', sans-serif;
}
</style>
