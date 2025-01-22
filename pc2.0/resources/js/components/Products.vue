<template>
    <div v-if="loading">Loading products...</div>
    <div v-else>
        <ul>
            <li v-for="product in products" :key="product.id">
                <h3>{{ product.name }}</h3>
                <p>{{ product.description }}</p>
                <p>Price: ${{ product.price }}</p>
            </li>
        </ul>
    </div>

</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            products: [],
            error: null,
            loading: true,
        };
    },
    methods: {
        async fetchProducts() {
            this.loading = true;
            this.error = null;
            try {
                const response = await axios.get('http://127.0.0.1:8000/api/zakeke/products');
                this.products = response.data;
            } catch (error) {
                console.error('Error fetching products:', error);
                this.error = 'Failed to load products. Please try again later.';
            } finally {
                this.loading = false;
            }
        },
    },
    mounted() {
        this.fetchProducts();
    },
};
</script>

<style scoped>
</style>
