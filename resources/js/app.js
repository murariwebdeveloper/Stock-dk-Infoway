import './bootstrap';

import { createApp } from 'vue';
import { createPinia } from 'pinia';
import axios from 'axios';

import router from './router';
import { useAuthStore } from '@/stores/auth';

import App from "./layouts/App.vue";
import BootstrapVue3 from 'bootstrap-vue-3';

import 'vue3-toastify/dist/index.css';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

// import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import 'bootstrap-vue-3/dist/bootstrap-vue-3.css';


import { AgGridVue } from "@ag-grid-community/vue3";


axios.defaults.baseURL = window.apiUrl;
const pinia = createPinia();
const app = createApp(App);
app.use(pinia);
app.use(router);

app.use(BootstrapVue3);
app.use(VueSweetalert2);

const authStore = useAuthStore();

app.component("AgGridVue", AgGridVue);

authStore.fetchUser().finally(() => {
    app.mount('#app');
});
