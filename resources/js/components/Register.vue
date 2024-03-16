<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Register</h2>
                        <form @submit.prevent="register">
                            <div class="mb-3">
                                <label for="name" class="form-label">Name:</label>
                                <input type="text" id="name" v-model="name" class="form-control"
                                    placeholder="Enter your name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" v-model="email" class="form-control"
                                    placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" v-model="password" class="form-control"
                                    placeholder="Enter your password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Register</button>
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

export default {
    name: 'Register',
    data() {
        return {
            name: '',
            email: '',
            password: ''
        };
    },
    methods: {
        register() {
            axios.post('/api/register', {
                name: this.name,
                email: this.email,
                password: this.password
            })
                .then(response => {
                    this.$router.push('/login');
                })
                .catch(error => {
                    console.error('Registration error:', error.message);
                    Swal.fire({
                        icon: 'error',
                        text: error.response.data.error,
                    });
                });
        }
    }
};
</script>
