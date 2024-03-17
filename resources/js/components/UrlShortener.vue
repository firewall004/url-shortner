<template>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">URL Shortener</h2>
                        <form @submit.prevent="shortenURL">
                            <div class="mb-3">
                                <label for="originalURL" class="form-label">Enter URL to Shorten</label>
                                <input type="text" class="form-control" id="originalURL" v-model="originalURL"
                                    placeholder="Enter an URL" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Shorten URL</button>
                            </div>
                        </form>
                        <div v-if="shortenedURL" class="mt-3">
                            <p class="card-text">Shortened URL: <a :href="shortenedURL" target="_blank">{{ shortenedURL
                                    }}
                                    <share-icon />
                                </a></p>
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
import { getAuthToken } from '../auth';
import ShareIcon from './icons/Share.vue'

export default {
    name: 'UrlShortener',
    data() {
        return {
            originalURL: this.url ? this.url.original_url : '',
            shortenedURL: this.url ? this.url.shortened_url : '',
            token: getAuthToken(),
        };
    },
    components: {
        ShareIcon,
    },
    props: {
        url: {
            type: Object,
            required: false
        }
    },
    methods: {
        shortenURL() {
            let apiShortenUrl = '/api/urls/shorten';
            let apiMethod = 'post'

            if (this.url) {
                apiMethod = 'put'
                apiShortenUrl = 'api/urls/shorten/' + this.url.id;
            }

            axios.request(
                {
                    method: apiMethod,
                    url: apiShortenUrl,
                    data: {
                        original_url: this.originalURL
                    },
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${this.token}`
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
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.response.data.message,
                        });
                    }
                });
        },
    }
};
</script>
