import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import '../node_modules/bootstrap5/src/css/bootstrap.min.css'

export let APIURI = 'https://scandiwebtestwebsite2022testing.000webhostapp.com/'
//export let APIURI = 'http://localhost:8002/'

const app = createApp(App)

app.use(router)

app.mount('#app')
