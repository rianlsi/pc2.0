<template>
    <div>
        <h1>Our Products</h1>

        <!-- Loading State -->
        <div v-if="loading">Loading products...</div>

        <!-- Error State -->
        <div v-else-if="errorMessage" class="alert alert-danger">{{ errorMessage }}</div>

        <!-- Display Products -->
        <div v-else>
            <div v-if="products.length === 0">No products found.</div>
            <div class="row">
                <div v-for="product in products" :key="product.id" class="col-md-4">
                    <div class="card">
                        <img :src="product.image_url || 'default_image_url.jpg'" :alt="product.name" class="card-img-top" />
                        <div class="card-body">
                            <h5 class="card-title">{{ product.name }}</h5>
                            <p class="card-text">{{ product.description }}</p>
                            <a href="#" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            products: [],
            loading: true,
            errorMessage: ''
        };
    },
    mounted() {
        // Fetch the products from the Laravel API when the component is mounted
        axios.get('/api/products')
            .then((response) => {
                this.products = response.data; // Store the fetched products in the data property
                this.loading = false;
            })
            .catch((error) => {
                console.error('Error fetching products:', error);
                this.errorMessage = 'There was an error loading the products.';
                this.loading = false;
            });
    }
};
</script>

<style scoped>
/* Add any specific styles for your product component */
</style>
