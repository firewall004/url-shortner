<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <router-link class="navbar-brand" to="/">{{ appName }}</router-link>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li v-if="isAuthenticated" class="nav-item mx-1" :class="{ 'active': $route.path === '/' }">
                        <router-link class="nav-link" to="/">Home</router-link>
                    </li>
                    <li v-if="!isAuthenticated" class="nav-item mx-1" :class="{ 'active': $route.path === '/login' }">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li v-if="!isAuthenticated" class="nav-item mx-1"
                        :class="{ 'active': $route.path === '/register' }">
                        <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                    <li v-if="isAuthenticated" class="nav-item mx-1"
                        :class="{ 'active': $route.path === '/url-shortener' }">
                        <router-link class="nav-link" to="/url-shortener">URL Shortener</router-link>
                    </li>
                    <li v-if="isAuthenticated" class="nav-item mx-1"
                        :class="{ 'active': $route.path === '/upgrade-plan' }">
                        <router-link class="nav-link" to="/upgrade-plan">Upgrade</router-link>
                    </li>
                    <li v-if="isAuthenticated" class="nav-item mx-1">
                        <button @click="logout" class="btn btn-secondary">Logout</button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import axios from 'axios';
import { isAuthenticated, getAuthToken, removeAuthToken } from '../../auth';

export default {
    name: 'NavBar',
    data() {
        return {
            appName: process.env.MIX_APP_NAME,
            isAuthenticated: isAuthenticated(),
            token: getAuthToken()
        };
    },
    methods: {
        logout() {
            axios.get('/api/logout', {
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            })
                .then(response => {
                    removeAuthToken()
                    this.$router.push('/login');
                })
                .catch(error => {
                    console.error('Logout error:', error.message);
                });
        }
    },
    watch: {
        '$route'() {
            this.isAuthenticated = isAuthenticated();
        }
    }
};
</script>

<style>
.nav-item.active {
    background-color: #e9ecef;
}
</style>
