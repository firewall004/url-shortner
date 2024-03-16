require('./bootstrap');

window.Vue = require('vue').default;

import Vue from 'vue';
import VueRouter from 'vue-router';

Vue.use(VueRouter);

import Home from './components/Home.vue';
import Login from './components/Login.vue';
import Register from './components/Register.vue';

const routes = [
    { path: '/', component: Home, meta: { requiresAuth: true } },
    { path: '/login', component: Login },
    { path: '/register', component: Register },
];

const router = new VueRouter({
    mode: 'history',
    routes
});

// router.beforeEach((to, from, next) => {
//     if (to.path !== '/login' && !isAuthenticated()) {
//       next('/login');
//     } else {
//       next();
//     }
//   })

router.beforeEach((to, from, next) => {
    // Check if the route requires authentication
    if (to.matched.some(record => record.meta.requiresAuth)) {
      // If the route requires authentication and the user is not authenticated,
      // redirect to the login page
      if (!isAuthenticated()) {
        next('/login');
      } else {
        // If the user is authenticated, allow access to the route
        next();
      }
    } else {
      // If the route does not require authentication, allow access to the route
      next();
    }
  });;

  function isAuthenticated() {
    const token = sessionStorage.getItem('url_shortener_token');
    return !!token;
  }

const app = new Vue({
    el: '#app',
    router
});
