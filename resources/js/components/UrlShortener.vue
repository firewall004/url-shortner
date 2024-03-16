<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">URL Shortener</h2>
                        <form @submit.prevent="shortenURL">
                            <div class="form-group">
                                <input type="text" class="form-control" v-model="originalURL"
                                    placeholder="Enter URL to shorten" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Shorten URL</button>
                        </form>
                        <div v-if="shortenedURL" class="mt-3">
                            <p class="card-text">Shortened URL: <a :href="shortenedURL" target="_blank">{{ shortenedURL
                                    }}</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
import axios from 'axios';

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
                    console.error('Error shortening URL:', error);
                });
        },
        getToken() {
            return sessionStorage.getItem('url_shortener_token');
        }
    }
};
</script>
