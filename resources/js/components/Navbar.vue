<script setup lang="ts">
import { Link, router, usePage } from '@inertiajs/vue3';
import { computed, onMounted, ref, watch } from 'vue';

// 1. Props & Page Data
const props = defineProps<{
    cartItems?: Array<{ id: number; quantity: number }>;
    user?: { name: string; email: string } | null;
    search?: string;
}>();

const page = usePage();

// 2. Smart Cart Count
const cartCount = computed(() => {
    if (props.cartItems) {
        return props.cartItems.reduce((sum, item) => sum + item.quantity, 0);
    }
    return (page.props.cartCount as number) || 0;
});

// Helper to check if actually logged in (ignoring the 'Guest' fallback)
const isAuthenticated = computed(() => {
    return !!(props.user || page.props.auth?.user);
});

const currentUser = computed(() => {
    return props.user || page.props.auth?.user || { name: 'Guest', email: '' };
});

// 3. Force Update on Mount
onMounted(() => {
    // Only reload cart count if user is logged in to avoid unnecessary calls
    if (isAuthenticated.value) {
        router.reload({ only: ['cartCount'] });
    }
});

// 4. Animation Logic
const isAnimating = ref(false);

watch(cartCount, (newVal, oldVal) => {
    if (newVal > oldVal) {
        isAnimating.value = true;
        setTimeout(() => {
            isAnimating.value = false;
        }, 300);
    }
});


// 5. Search & Menu Logic
const showMenu = ref(false);
const searchQuery = ref(props.search || '');

function handleSearch() {
    if (searchQuery.value.trim()) {
        router.get('/', { search: searchQuery.value }, {
        });
    } else {
        router.get('/');
    }
}
</script>

<template>
    <header
        class="z-50 flex w-full flex-wrap bg-white py-7 transition-colors lg:flex-nowrap lg:justify-start dark:bg-neutral-900"
    >
        <nav
            class="relative mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-4 md:px-6 lg:px-8"
        >
            <!-- Logo -->
            <div class="flex shrink-0 items-center">
                <Link
                    href="/"
                    class="inline-block flex-none rounded-xl text-2xl font-bold text-indigo-600 transition-colors dark:text-indigo-400"
                >
                    MyShop
                </Link>
            </div>

            <!-- Search Bar -->
            <div class="flex max-w-2xl flex-1 items-center">
                <form @submit.prevent="handleSearch" class="relative w-full">
                    <div
                        class="pointer-events-none absolute inset-y-0 start-0 z-20 flex items-center ps-4"
                    >
                        <svg
                            class="size-4 shrink-0 text-gray-400 dark:text-neutral-500"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="11" cy="11" r="8" />
                            <path d="m21 21-4.3-4.3" />
                        </svg>
                    </div>
                    <input
                        v-model="searchQuery"
                        type="text"
                        class="block w-full rounded-lg border border-gray-200 py-2.5 ps-11 pe-4 text-sm focus:border-indigo-500 focus:ring-indigo-500 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white dark:placeholder:text-neutral-500"
                        placeholder="Search for products..."
                    />
                    <button
                        v-if="searchQuery"
                        @click="searchQuery = ''"
                        type="button"
                        class="absolute inset-y-0 end-0 z-20 flex items-center pe-4 text-gray-400 hover:text-gray-600 dark:text-neutral-500 dark:hover:text-neutral-400"
                    >
                        <svg
                            class="size-4 shrink-0"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <path d="M18 6 6 18" />
                            <path d="m6 6 12 12" />
                        </svg>
                    </button>
                </form>
            </div>

            <!-- Right Side Icons -->
            <div class="flex shrink-0 items-center gap-x-3">
                <!-- OPTION 1: User is Logged In -->
                <template v-if="isAuthenticated">
                    <!-- Cart Button -->
                    <Link
                        href="/cart"
                        class="relative flex size-9.5 items-center justify-center rounded-xl border border-gray-200 bg-white text-gray-800 transition hover:bg-gray-100 dark:border-neutral-700 dark:bg-neutral-900 dark:text-white"
                    >
                        <span class="sr-only">Cart</span>
                        <svg
                            class="size-4 shrink-0"
                            xmlns="http://www.w3.org/2000/svg"
                            width="24"
                            height="24"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >
                            <circle cx="8" cy="21" r="1" />
                            <circle cx="19" cy="21" r="1" />
                            <path
                                d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"
                            />
                        </svg>

                        <!-- Cart Count Badge -->
                        <span
                            v-if="cartCount > 0"
                            :class="{ 'bump-animation': isAnimating }"
                            class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-red-500 text-xs font-bold text-white shadow-sm transition-transform"
                        >
                            {{ cartCount }}
                        </span>
                    </Link>

                    <!-- Profile Menu -->
                    <div class="relative">
                        <button
                            @click="showMenu = !showMenu"
                            class="flex size-9.5 items-center justify-center rounded-xl border border-gray-200 bg-white transition hover:bg-gray-100 dark:border-neutral-700 dark:bg-neutral-900"
                        >
                            <img
                                :src="`https://ui-avatars.com/api/?name=${encodeURIComponent(currentUser.name)}`"
                                class="h-6 w-6 rounded-full"
                            />
                        </button>
                        <div
                            v-if="showMenu"
                            class="absolute right-0 z-50 mt-2 w-48 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg dark:border-neutral-700 dark:bg-neutral-900"
                        >
                            <div
                                class="border-b border-gray-200 px-4 py-3 dark:border-neutral-700"
                            >
                                <p
                                    class="text-sm font-semibold text-gray-800 dark:text-white"
                                >
                                    {{ currentUser.name }}
                                </p>
                                <p class="truncate text-xs text-gray-500">
                                    {{ currentUser.email }}
                                </p>
                            </div>
                            <Link
                                href="/logout"
                                method="post"
                                as="button"
                                class="block w-full px-4 py-2.5 text-left text-sm text-red-600 hover:bg-red-50"
                            >
                                Logout
                            </Link>
                        </div>
                    </div>
                </template>

                <!-- OPTION 2: User is Guest (Not Logged In) -->
                <template v-else>
                    <div class="flex items-center gap-2">
                        <Link
                            href="/login"
                            class="inline-flex items-center justify-center rounded-lg border border-transparent px-4 py-2 text-sm font-semibold text-gray-800 transition-colors hover:bg-gray-100 dark:text-white dark:hover:bg-neutral-800"
                        >
                            Log in
                        </Link>
                        <Link
                            href="/register"
                            class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition-all hover:bg-indigo-700 focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:outline-none"
                        >
                            Register
                        </Link>
                    </div>
                </template>
            </div>
        </nav>
    </header>
</template>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap');
* {
    font-family: 'Poppins', sans-serif;
}

.size-9\.5 {
    width: 2.375rem;
    height: 2.375rem;
}

.bump-animation {
    animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}
@keyframes pop {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.4);
    }
    100% {
        transform: scale(1);
    }
}
</style>
