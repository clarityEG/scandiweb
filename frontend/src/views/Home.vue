<template>
    <div class="container-fluid mt-5">
        <div class="row justify-content-between">
            <div class="col">
                <span class="page-title ms-3 fs-4 fw-bold">Product List</span>
            </div>
            <div class="col text-end">
                <RouterLink :to="{name : 'AddProduct'}" class="d-inline-block text-end">
                    <button type="button" class="btn btn-sm btn-primary me-3">ADD</button>
                </RouterLink>
                <button type="button" id="delete-product-btn" @click="deleteProductsFunc" class="btn btn-sm btn-primary d-inline-block text-end ms-auto">MASS DELETE</button>
            </div>
        </div>
    </div>
    <hr>

    <div class="container-fluid">
        <div class="row row-cols-md-3 row-cols-sm-2">
            <div class="col" v-for="product in products" :key="product.SKU">
                <div>
                    <input type="checkbox" class='delete-checkbox' :value="product.sku" v-model="deleteProducts">
                    
                    <div class="text-center">
                        <span>SKU: </span>
                        <span class="text-center">{{product.sku}}</span>
                    </div>

                    <div class="text-center">
                        <span>Name: </span>
                        <span class='text-center'>{{product.name}}</span>
                    </div>
                    
                    <div class="text-center">
                        <span>Price: </span>
                        <span class='text-center'>{{product.price}}</span>
                        <span> $</span>
                    </div>

                    <div>
                        <p class='text-center' v-if="product.type == 'DVD'">
                            Size: {{product.attribute}}
                        </p>    
                        <p class='text-center' v-if="product.type == 'Book'">
                            Weight: {{product.attribute}}
                        </p>
                        <p class='text-center' v-if="product.type == 'Furniture'">
                            Dimensions: {{product.attribute}}
                        </p>    
                    </div>                                                        
                                                    
                </div>
            </div>
        </div>
    </div>

    <hr>
    <p class="text-center">Scandiweb Test assigment</p>
</template>

<script>
import { RouterLink, RouterView } from 'vue-router'
import axios from 'axios'
import {APIURI} from '../main.js'

export default{
    mounted(){
        this.getProducts()
    },
    data(){
        return {
            deleteProducts: [],
            products: [],
            deleteFlag: false
        }
    },
    methods: {
        getProducts(){
            const that = this
            axios.get(APIURI + 'products').then(function(res){
                that.products = res.data
            })
        },     
        deleteProductsFunc(){
            console.log('delete products', this.deleteProducts)
            // prevent deletion request if no products are found
            if (this.deleteProducts.length == 0)
                return

            const that = this
            axios.post(APIURI + 'delete-products', {
                "prods":that.deleteProducts  
            }, {
                    // so that post request is a simple request
                    // no preflight is sent. so we can use 000webhost free hosting plan
                headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
            }).then(function(){
                // if we deleted a product we need to reget the new list from server
                that.getProducts()
            })

        }
    }
}

</script>

<style>
</style>