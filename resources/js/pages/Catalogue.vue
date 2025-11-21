<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import { Inertia } from '@inertiajs/inertia';

import { defineProps } from 'vue';

const props = defineProps<{ products: Array<any> }>();

// Navigate to product page using Inertia
function viewProduct(productId: number) {
    Inertia.get(`/products/${productId}`);
    console.log('ProductID is:' + productId);
}
</script>

<template>
    <Navbar />
    <div class="mx-auto max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <div
                v-for="product in props.products"
                :key="product.id"
                class="group hover:shadow-glow-light dark:hover:shadow-glow-dark flex h-full flex-col rounded-xl border border-gray-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 dark:border-neutral-700 dark:bg-neutral-900 dark:shadow-neutral-700/70"
                @click="viewProduct(product.id)"
                style="cursor: pointer"
            >
                <div
                    class="flex h-52 flex-col items-center justify-center overflow-hidden rounded-t-xl bg-gradient-to-br from-blue-500 to-blue-600"
                >
                    <img
                        :src="product.image"
                        :alt="product.name"
                        class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    />
                </div>
                <div class="p-4 md:p-6">
                    <span
                        class="mb-1 block text-xs font-semibold text-blue-600 uppercase dark:text-blue-500"
                    >
                        RM {{ product.price }}
                    </span>
                    <h3
                        class="text-xl font-semibold text-gray-800 dark:text-neutral-300 dark:hover:text-white"
                    >
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

/* Light mode glow effect */
.hover\:shadow-glow-light:hover {
    box-shadow:
        0 10px 40px -10px rgba(59, 130, 246, 0.3),
        0 0 0 1px rgba(59, 130, 246, 0.1),
        0 0 20px rgba(59, 130, 246, 0.2);
}

/* Dark mode glow effect */
.dark .dark\:hover\:shadow-glow-dark:hover {
    box-shadow:
        0 10px 40px -10px rgba(96, 165, 250, 0.5),
        0 0 0 1px rgba(96, 165, 250, 0.2),
        0 0 30px rgba(96, 165, 250, 0.3);
}
</style>
