<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Login</h2>
                        <form @submit.prevent="login">
                            <div class="mb-3 input-group">
                                <span class="input-group-text">
                                    <username-icon />
                                </span>
                                <input type="email" id="email" v-model="email" class="form-control"
                                    placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3 input-group">
                                <span class="input-group-text">
                                    <password-icon />
                                </span>
                                <input type="password" id="password" v-model="password" class="form-control"
                                    placeholder="Enter your password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { setAuthToken } from '../auth';
import UsernameIcon from './icons/Email.vue';
import PasswordIcon from './icons/Password.vue';

export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    components: {
        UsernameIcon,
        PasswordIcon,
    },
    methods: {
        login() {
            axios.post('/api/login', {
                email: this.email,
                password: this.password
            })
                .then(response => {
                    setAuthToken(response.data.token);

                    this.$router.push('/');
                })
                .catch(error => {
                    console.error('Login error:', error.message);
                    Swal.fire({
                        icon: 'error',
                        text: error.response.data.error,
                    });
                });
        }
    },
};
</script>
