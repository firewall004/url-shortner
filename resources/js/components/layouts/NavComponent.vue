<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <router-link class="navbar-brand" to="/">{{ appName }}</router-link>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li v-if="isAuthenticated" class="nav-item">
                        <router-link class="nav-link" to="/">Home</router-link>
                    </li>
                    <li v-if="!isAuthenticated" class="nav-item">
                        <router-link class="nav-link" to="/login">Login</router-link>
                    </li>
                    <li v-if="!isAuthenticated" class="nav-item">
                        <router-link class="nav-link" to="/register">Register</router-link>
                    </li>
                    <li v-if="isAuthenticated" class="nav-item">
                        <router-link class="nav-link" to="/user">User</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import { isAuthenticated } from '../../auth';

export default {
    name: 'NavComponent',
    data() {
        return {
            appName: "URL Shortener",
            isAuthenticated: isAuthenticated()
        };
    },
};
</script>
