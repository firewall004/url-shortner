<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">URL Shortener</h2>
                        <form @submit.prevent="shortenURL">
                            <div class="mb-3">
                                <label for="originalURL" class="form-label">Enter URL to Shorten:</label>
                                <input type="text" class="form-control" id="originalURL" v-model="originalURL"
                                    placeholder="Enter URL" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Shorten URL</button>
                            </div>
                        </form>
                        <div v-if="shortenedURL" class="mt-3">
                            <p class="card-text">Shortened URL: <a :href="shortenedURL" target="_blank">{{ shortenedURL
                                    }}</a></p>
                        </div>
                    </div>
                </div>
                <router-link class="btn btn-link mt-3 d-block text-center" to="/">View All URLs</router-link>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
    data() {
        return {
            originalURL: '',
            shortenedURL: ''
        };
    },
    methods: {
        shortenURL() {
            axios.post('/api/shorten-url', { original_url: this.originalURL }, {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${this.getToken()}`
                }
            })
                .then(response => {
                    this.shortenedURL = response.data.data.shortened_url;
                })
                .catch(error => {
                    if (error.response.status === 403) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Forbidden',
                            text: error.response.data.message,
                        });
                    } else {
                        console.error('Error shortening URL:', error);
                    }
                });
        },
        getToken() {
            return sessionStorage.getItem('url_shortener_token');
        }
    }
};
</script>
