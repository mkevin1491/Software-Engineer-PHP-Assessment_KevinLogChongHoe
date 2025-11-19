<script setup lang="ts">
import { defineEmits, defineProps, ref, watch } from 'vue';

const props = defineProps<{
    show: boolean;
    product: any;
    quantity: number;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
    (e: 'add', quantity: number): void;
}>();

// Local quantity to control plus/minus
const localQuantity = ref(props.quantity);

// Keep localQuantity in sync with prop
watch(
    () => props.quantity,
    (val) => {
        localQuantity.value = val;
    },
);

function closeModal() {
    emit('close');
}

function add() {
    emit('add', localQuantity.value);
}

function increment() {
    localQuantity.value++;
}

function decrement() {
    if (localQuantity.value > 1) localQuantity.value--;
}
</script>

<template>
    <div
        v-if="show"
        class="bg-opacity-50 fixed inset-0 z-50 flex items-center justify-center bg-black"
    >
        <div class="w-80 rounded-lg bg-white p-4 shadow-lg">
            <!-- Product Image -->
            <img
                :src="product.image"
                alt="product image"
                class="mb-4 h-40 w-full rounded-lg object-cover"
            />

            <!-- Product Name -->
            <h2 class="mb-2 text-lg font-semibold">{{ product.name }}</h2>

            <!-- Product Price -->
            <p class="mb-4 text-lg font-bold text-red-600">
                RM {{ product.price }}
            </p>

            <!-- Quantity Input -->
            <div class="mb-4">
                <label class="mb-1 block font-medium">Quantity</label>
                <div
                    class="flex w-32 items-center overflow-hidden rounded border"
                >
                    <button
                        @click="decrement"
                        class="bg-gray-200 px-3 py-1 hover:bg-gray-300"
                    >
                        −
                    </button>
                    <input
                        type="number"
                        v-model="localQuantity"
                        min="1"
                        class="w-full p-1 text-center outline-none"
                    />
                    <button
                        @click="increment"
                        class="bg-gray-200 px-3 py-1 hover:bg-gray-300"
                    >
                        +
                    </button>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-between gap-2">
                <button
                    @click="closeModal"
                    class="flex-1 rounded border px-4 py-2 hover:bg-gray-100"
                >
                    Cancel
                </button>
                <button
                    @click="add"
                    class="flex-1 rounded bg-orange-500 px-4 py-2 text-white hover:bg-orange-600"
                >
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
</template>
