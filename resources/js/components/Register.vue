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
                                <div v-if="nameError" class="text-danger">{{ nameError }}</div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" id="email" v-model="email" class="form-control"
                                    placeholder="Enter your email" required>
                                <div v-if="emailError" class="text-danger">{{ emailError }}</div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password:</label>
                                <input type="password" id="password" v-model="password" class="form-control"
                                    placeholder="Enter your password" required>
                                <div v-if="passwordError" class="text-danger">{{ passwordError }}</div>
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
            password: '',
            nameError: '',
            emailError: '',
            passwordError: ''
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
                    if (error.response && error.response.status === 422 && error.response.data.errors) {
                        const errors = error.response.data.errors;
                        if (errors.name) {
                            this.nameError = errors.name[0];
                        } else {
                            this.nameError = '';
                        }
                        if (errors.email) {
                            this.emailError = errors.email[0];
                        } else {
                            this.emailError = '';
                        }
                        if (errors.password) {
                            this.passwordError = errors.password[0];
                        } else {
                            this.passwordError = '';
                        }
                    } else {
                        this.nameError = 'Registration failed. Please try again.';
                        this.emailError = 'Registration failed. Please try again.';
                        this.passwordError = 'Registration failed. Please try again.';
                    }
                });
        }
    }
};
</script>
