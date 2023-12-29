/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap';
import { createRouter,createWebHashHistory } from 'vue-router';
import { createApp } from 'vue';
import App from './App.vue'
import {vueRoutes} from "./VueRoutes.js";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
const router = createRouter({
    history: createWebHashHistory(),
    routes:vueRoutes,
    linkActiveClass: "",
    linkExactActiveClass: "active"
})
const app = createApp(App);

app.use(router);
app.use(VueSweetalert2);

app.mount('#app');
