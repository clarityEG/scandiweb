import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import AddProduct from '../views/AddProduct.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'Home',
      component: Home
    },
    {
      path: '/add-product',
      name: 'AddProduct',
      component: AddProduct
    }
  ]
})

export default router
