import { createApp } from 'vue'
import { createPinia } from 'pinia'

import App from './App.vue'
import router from './router'
import axios from 'axios'
import VueAxios from 'vue-axios'
// axios.create({
//   baseURL: import.meta.env.VITE_APP_BASE_URL
// })
// import axios from 'axios'
// const url = import.meta.env.VITE_APP_BASE_URL;
axios.defaults.baseURL = import.meta.env.VITE_APP_BASE_URL;

import '../public/assets/js/pages/form-element-select.js'
import '../public/assets/vendors/choices.js/choices.min.js'
const app = createApp(App)
app.use(createPinia())
app.use(router)
app.use(VueAxios, axios)


app.mount('#app')
