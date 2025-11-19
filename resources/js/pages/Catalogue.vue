<script setup lang="ts">
import AddToCartModal from '@/components/CatalogueComponents/AddToCartModal.vue';
import axios from 'axios';
import { defineProps, ref } from 'vue';

const props = defineProps<{ products: Array<any> }>();

// Modal state
const showModal = ref(false);
const selectedProduct = ref(null);
const quantity = ref(1);

// Function to open modal
function openModal(product: any) {
    selectedProduct.value = product;
    quantity.value = 1;
    showModal.value = true;
}

// Function to add to cart
function addToCart() {
    axios
        .post('/cart', {
            product_id: selectedProduct.value.id,
            quantity: quantity.value,
        })
        .then(() => {
            console.log('Added to cart');
            showModal.value = false;
        })
        .catch((err) => console.error(err));
}
</script>

<template>
    <div class="grid gap-6 p-4 md:grid-cols-3">
        <div
            v-for="product in props.products"
            :key="product.id"
            class="rounded-lg border p-4"
        >
            <img
                :src="product.image"
                class="h-48 w-full rounded-lg object-cover"
            />
            <h2 class="mt-2 font-semibold">{{ product.name }}</h2>
            <p class="text-gray-600">{{ product.description }}</p>
            <p class="mt-1 font-bold">RM {{ product.price }}</p>
            <button
                @click="openModal(product)"
                class="mt-2 rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
            >
                Add to Cart
            </button>
        </div>
    </div>

    <AddToCartModal
        :show="showModal"
        :product="selectedProduct"
        :quantity="quantity"
        @close="showModal = false"
        @add="addToCart"
    />
</template>
