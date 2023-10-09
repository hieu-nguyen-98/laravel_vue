import './bootstrap';

import 'admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js';
import 'admin-lte/dist/js/adminlte.min.js';

import VueSweetalert2 from 'vue-sweetalert2';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import {createRouter, createWebHistory} from 'vue-router'; 
import { createPinia } from 'pinia';
import App from './App.vue';

import Login from './pages/auth/Login.vue';

import Routes from './routes.js';

const app = createApp(App);
const pinia = createPinia();
const router = createRouter({
    routes: Routes,
    history : createWebHistory(),
});
app.use(pinia);
app.use(VueSweetalert2);
app.use(router);

if (window.location.pathname === '/admin/login') {
    const loginApp = createApp({});
    
    loginApp.component('Login', Login);
    loginApp.mount('#loginAdmin');
} else {
    app.mount('#app');
}
