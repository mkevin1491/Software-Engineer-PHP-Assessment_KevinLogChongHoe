<script setup lang="ts">
import Navbar from '@/components/Navbar.vue';
import { Link, router } from '@inertiajs/vue3'; // Use Link for pagination
import { defineProps } from 'vue';

// 1. Define the structure of the Laravel Pagination Object
const props = defineProps<{
    products: {
        data: Array<any>;
        from: number;
        to: number;
        total: number;
        prev_page_url: string | null;
        next_page_url: string | null;
    };
    searchTerm?: string;
}>();

function viewProduct(productId: number) {
    router.get(`/products/${productId}`);
}
</script>

<template>
    <Navbar :search="props.searchTerm" />

    <div class="mx-auto max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-14">
        <!-- Product Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            <!-- 2. Loop through 'products.data' instead of 'products' -->
            <div
                v-for="product in props.products.data"
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

        <!-- 3. Pagination Section -->
        <!-- Only show if we have products -->
        <div
            v-if="props.products.total > 0"
            class="mt-12 flex flex-col items-center gap-4"
        >
            <!-- Help text -->
            <span class="text-sm text-gray-700 dark:text-gray-400">
                Showing
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ props.products.from }}
                </span>
                to
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ props.products.to }}
                </span>
                of
                <span class="font-semibold text-gray-900 dark:text-white">
                    {{ props.products.total }}
                </span>
                Entries
            </span>

            <!-- Buttons -->
            <div class="inline-flex -space-x-px rounded-md shadow-sm">
                <!-- Previous Button -->
                <!-- We use 'component' tag to dynamically render a Link or a Span depending on if URL exists -->
                <component
                    :is="props.products.prev_page_url ? Link : 'span'"
                    :href="props.products.prev_page_url"
                    :class="[
                        'inline-flex items-center rounded-s-lg border px-4 py-2 text-sm font-medium',
                        props.products.prev_page_url
                            ? 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-400 dark:hover:bg-neutral-700 dark:hover:text-white'
                            : 'cursor-not-allowed border-gray-300 bg-gray-100 text-gray-400 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-600',
                    ]"
                >
                    Previous
                </component>

                <!-- Next Button -->
                <component
                    :is="props.products.next_page_url ? Link : 'span'"
                    :href="props.products.next_page_url"
                    :class="[
                        'inline-flex items-center rounded-e-lg border px-4 py-2 text-sm font-medium',
                        props.products.next_page_url
                            ? 'border-gray-300 bg-white text-gray-700 hover:bg-gray-50 dark:border-neutral-700 dark:bg-neutral-800 dark:text-gray-400 dark:hover:bg-neutral-700 dark:hover:text-white'
                            : 'cursor-not-allowed border-gray-300 bg-gray-100 text-gray-400 dark:border-neutral-700 dark:bg-neutral-900 dark:text-neutral-600',
                    ]"
                >
                    Next
                </component>
            </div>
        </div>

        <!-- Empty State (if search returns 0 results) -->
        <div v-else class="mt-20 text-center">
            <p class="text-gray-500">No products found.</p>
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
