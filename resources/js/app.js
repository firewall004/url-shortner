require('./bootstrap');
// require('dotenv').config();

window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router';
import { isAuthenticated } from './auth';

Vue.use(VueRouter);

Vue.component(
    "base-layout",
    require("./components/layouts/BaseLayout.vue").default
);

import Home from './components/Home.vue';
import User from './components/User.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

const routes = [
    { path: '/', component: Home, meta: { requiresAuth: true } },
    { path: '/user', component: User, meta: { requiresAuth: true } },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      if (!isAuthenticated()) {
        next('/login');
      } else {
        next();
      }
    } else {
      next();
    }
  });;

const app = new Vue({
    el: '#app',
    router
});
