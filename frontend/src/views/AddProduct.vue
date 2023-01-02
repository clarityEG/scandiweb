<template>
  <div class="container-fluid">
    <div class="row justify-content-between">
      <div class="col mt-4">
        <h1 class="fs-4">Product add</h1>
      </div>
      <div class="col text-end mt-4">
        <button type="button" class="btn btn-sm btn-primary me-2" @click="validate">Save</button>
        <RouterLink :to="{name: 'Home'}">
          <button type="button" class="btn btn-sm btn-primary">Cancel</button>
        </RouterLink>      
      </div>
    </div>
  </div>

  <form id="product_form">

    <div class="container-fluid">
      <div class="row mt-3">
        <div class="col-2">
          <label for="sku">SKU</label>
        </div>
        <div class="col">
          <input type="text" id="sku" v-model.lazy="sku">
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-2">
          <label for="name">Name</label>
        </div>
        <div class="col">
          <input type="text" id="name" v-model.lazy="name">
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-2">
          <label for="price">Price</label>
        </div>
        <div class="col">
          <input type="text" id="price" v-model.lazy="price">
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-2">
          <label for="productType">Type switcher</label>
        </div>
        <div class="col">
          <select name="type" id="productType" v-model.lazy="type">
            <option disabled>Type switcher</option>
            <option value="DVD">DVD</option>
            <option value="Book">Book</option>
            <option value="Furniture">Furniture</option>
          </select>
        </div>
      </div>


      <div class="row mt-3" v-if="type == 'DVD'">
        <div class="col-2">
          <label for="size">size (MB)</label>
        </div>
        <div class="col">
          <input type="text" id="size" v-model.lazy="size">
        </div>
      </div>

      <div class="row mt-3" v-if="type == 'Book'">
        <div class="col-2">
          <label for="weight">Weight (KG)</label>
        </div>
        <div class="col">
          <input type="text" id="weight" v-model.lazy="weight">
        </div>
      </div>


      <div v-if="type == 'Furniture'">
        <div class="row mt-3">
          <div class="col-2">
            <label for="height">Height (CM)</label>
          </div>
          <div class="col">
            <input type="text" id="height" v-model.lazy="height">
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-2">
            <label for="width">Width (CM)</label>
          </div>
          <div class="col">
            <input type="text" id="width" v-model.lazy="width">
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-2">
            <label for="length">Length (CM)</label>
          </div>
          <div class="col">
            <input type="text" id="length" v-model.lazy="length">
          </div>
        </div>

      </div>
    </div>
  </form>


  <div class="modal" :style="showErr ? 'display: block' : '' " tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Error</h5>
          <button type="button" class="btn-close" aria-label="Close" @click="showErr = false"></button>
        </div>
        <div class="modal-body">
          <p>{{errMsg[errMsgIndex]}}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" @click="showErr = false">Close</button>
        </div>
      </div>
    </div>
  </div>


</template>
<script>
import axios from 'axios';
import { APIURI } from '../main';

export default {
  data() {
    return {
    
      showErr: false,
      errMsg: [
        'Please, provide the data of indicated type', 
        'Please, submit required data',
        'Please provide a unique product SKU.',
        'UnKnown error occurred please try again later.'
        ],
      errMsgIndex: 0,

      sku: '',
      name: '',
      price: null,
      type: '',
      size: null,
      weight: null,
      height: null,
      width: null,
      length: null,
    }
  },
  methods: {
    submit(){
      console.log('submitting')
      const that = this
      axios.post(APIURI + 'products', {
        sku: this.sku.toLowerCase(),
        name: this.name,
        price: this.price,
        type: this.type,
        attribute: (
          this.type == 'DVD' ? this.size : 
            (this.type == 'Book' ? this.weight : {height: this.height, width: this.width, length: this.length})) 
      }, {
                    // so that post request is a simple request
                    // no preflight is sent. so we can use 000webhost free hosting plan
                headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            }
      }).then(function(){
        that.$router.push({name: 'Home'})
      }).catch(function(err){
        if(err.response.status == 409){
          that.errMsgIndex = 2
          that.showErr = 1
        }else{
          that.errMsgIndex = 3
          that.showErr = 1
        }
      })

    },
    validate(){
      
      // if user didn't submit valid input for common fields
      if (
        this.sku.length === 0 || this.name.length === 0 || !this.price        
        ){
        this.errMsgIndex = 1
        this.showErr = true
        return
      } 
      
      if(
        isNaN( this.price ) || this.price <= 0
      ){
        this.errMsgIndex = 0
        this.showErr = true
        return
      }

      // Then check Type check its it's fields
      if ( this.type === 'DVD' ) {
        if( !this.size ){  // if null
          this.errMsgIndex = 1
          this.showErr = true
          return
        }
        if ( isNaN(this.size) || this.size <= 0 ){
          this.errMsgIndex = 0
          this.showErr = true
          return
        }
      } else if ( this.type === 'Book' ) {
        if( !this.weight){  // if empty
          this.errMsgIndex = 1
          this.showErr = true
          return
        }
        if ( isNaN(this.weight) || this.weight <= 0 ){
          this.errMsgIndex = 0
          this.showErr = true
          return
        }
      } else if ( this.type === 'Furniture') {
        if ( !this.length || !this.width || !this.height ){
          this.errMsgIndex = 1
          this.showErr = true
          return
        }
        if ( 
          isNaN(this.length) || this.length <= 0 ||
          isNaN(this.width)  || this.width <= 0 ||
          isNaN(this.height) || this.height <= 0
          ) {          
          this.errMsgIndex = 0
          this.showErr = true
          return
        }
      }else { // If no type is selected
        this.errMsgIndex = 1
        this.showErr = true
        return
      }

      // If all tests succeed now we can submit our form
      console.log('success')
      this.submit()
    }
  }
}

</script>

<style>

</style>
