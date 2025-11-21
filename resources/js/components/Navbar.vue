<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed, defineProps, ref } from 'vue';

const props = defineProps<{
    cartItems?: Array<{
        id: number;
        quantity: number;
    }>;
    user?: {
        name: string;
        email: string;
    } | null;
}>();

// Cart count
const cartCount = computed(
    () => props.cartItems?.reduce((sum, item) => sum + item.quantity, 0) ?? 0,
);

// Profile Dropdown
const showMenu = ref(false);

// Search query
const searchQuery = ref('');

// Handle search
function handleSearch() {
    if (searchQuery.value.trim()) {
        console.log('Searching for:', searchQuery.value);
        // Add your search logic here
    }
}
</script>

<template>
    <header class="flex flex-wrap lg:justify-start lg:flex-nowrap z-50 w-full py-7 bg-white dark:bg-neutral-900 transition-colors">
        <nav class="relative max-w-7xl w-full flex items-center justify-between gap-4 px-4 md:px-6 lg:px-8 mx-auto">
            <!-- Logo Section -->
            <div class="flex items-center shrink-0">
                <Link 
                    href="/" 
                    class="flex-none rounded-xl text-2xl inline-block font-bold focus:outline-hidden focus:opacity-80 text-indigo-600 dark:text-indigo-400 transition-colors"
                    aria-label="MyShop"
                >
                    MyShop
                </Link>
            </div>

            <!-- Search Bar (Center) -->
            <div class="flex-1 max-w-2xl flex items-center">
                <form @submit.prevent="handleSearch" class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center pointer-events-none z-20 ps-4">
                        <svg class="shrink-0 size-4 text-gray-400 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"/>
                            <path d="m21 21-4.3-4.3"/>
                        </svg>
                    </div>
                    <input 
                        v-model="searchQuery"
                        type="text" 
                        class="py-2.5 ps-11 pe-4 block w-full border border-gray-200 rounded-lg text-sm placeholder:text-gray-400 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 disabled:opacity-50 disabled:pointer-events-none transition dark:bg-neutral-900 dark:border-neutral-700 dark:text-white dark:placeholder:text-neutral-500 dark:focus:border-indigo-500 dark:focus:ring-indigo-500/20" 
                        placeholder="Search for products..."
                    />
                    <button 
                        v-if="searchQuery"
                        @click="searchQuery = ''"
                        type="button"
                        class="absolute inset-y-0 end-0 flex items-center z-20 pe-4 text-gray-400 hover:text-gray-600 dark:text-neutral-500 dark:hover:text-neutral-400"
                    >
                        <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"/>
                            <path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Button Group (Right Side) -->
            <div class="flex items-center gap-x-2 shrink-0">
                <!-- Cart Button -->
                <Link 
                    href="/cart" 
                    class="size-9.5 relative flex justify-center items-center rounded-xl bg-white border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 transition dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-white/10 dark:text-white"
                >
                    <span class="sr-only">Cart</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="8" cy="21" r="1"/>
                        <circle cx="19" cy="21" r="1"/>
                        <path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/>
                    </svg>
                    
                    <!-- Cart Count Badge -->
                    <span
                        v-if="cartCount > 0"
                        class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white"
                    >
                        {{ cartCount }}
                    </span>
                </Link>

                <!-- Profile Menu Button -->
                <div class="relative">
                    <button
                        @click="showMenu = !showMenu"
                        class="size-9.5 flex justify-center items-center rounded-xl bg-white border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-hidden focus:bg-gray-100 transition dark:bg-neutral-900 dark:border-neutral-700 dark:hover:bg-white/10 dark:text-white"
                    >
                        <img
                            :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(props.user?.name ?? 'Guest')}`"
                            :alt="props.user?.name ?? 'Guest'"
                            class="h-6 w-6 rounded-full"
                        />
                    </button>

                    <!-- Profile Dropdown -->
                    <div
                        v-if="showMenu"
                        class="absolute right-0 mt-2 w-48 rounded-xl border border-gray-200 bg-white shadow-lg dark:bg-neutral-900 dark:border-neutral-700 overflow-hidden"
                    >
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-neutral-700">
                            <p class="text-sm font-semibold text-gray-800 dark:text-white">
                                {{ props.user?.name ?? 'Guest' }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-neutral-400">
                                {{ props.user?.email ?? '' }}
                            </p>
                        </div>

                        <Link
                            href="/profile"
                            class="block px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-100 transition dark:text-neutral-300 dark:hover:bg-neutral-800"
                            @click="showMenu = false"
                        >
                            Profile
                        </Link>

                        <Link
                            href="/logout"
                            method="post"
                            as="button"
                            class="block w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition dark:text-red-400 dark:hover:bg-red-950/20"
                            @click="showMenu = false"
                        >
                            Logout
                        </Link>
                    </div>
                </div>
            </div>
            <!-- End Button Group -->
        </nav>
    </header>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

* {
    font-family: 'Poppins', sans-serif;
}

/* Custom size for buttons */
.size-9\.5 {
    width: 2.375rem;
    height: 2.375rem;
}
</style>