<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1>HOME</h1>
                <h2>Welcome 123, {{ user.name }}({{ user.email }})</h2>
                <hr>
                <h3>Your Shortened URLs</h3>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Original URL</th>
                                <th>Shortened URL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="url in urls" :key="url.id">
                                <td>{{ url.original_url }}</td>
                                <td><a :href="url.shortened_url" target="_blank">{{ url.shortened_url }}</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <router-link class="btn btn-secondary" to="/url-shortener">Shorten new URL</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: {},
            urls: [],
            token: sessionStorage.getItem('url_shortener_token'),
        };
    },
    mounted() {
        this.fetchUserDetails();
        this.getUserUrls();
    },
    methods: {
        fetchUserDetails() {
            axios.get('/api/user', {
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.user = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching user details:', error.message);
                });
        },
        getUserUrls() {
            axios.get('/api/urls', {
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.urls = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching user URLs:', error);
                });
        }
    }
};
</script>
