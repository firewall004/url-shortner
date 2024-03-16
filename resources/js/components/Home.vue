<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="display-4 mb-4">Welcome, {{ user.name }}</h1>
                <p class="lead">{{ user.email }}</p>
                <hr class="my-4">
                <div v-if="urls.length == 0">
                    <h4>No URLs found</h4>
                </div>
                <div v-else>
                    <h2 class="mb-4">Your Shortened URLs</h2>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Original URL</th>
                                    <th scope="col">Shortened URL</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="url in urls" :key="url.id">
                                    <td>{{ url.original_url }}</td>
                                    <td><a :href="url.shortened_url" target="_blank">{{ url.shortened_url }}</a></td>
                                    <td>
                                        <button @click="editUrl(url)" class="btn btn-primary">Edit</button>
                                        <button class="btn btn-danger" @click="deleteUrl(url.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <router-link class="btn btn-primary" to="/url-shortener">Shorten a URL</router-link>
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
        },
        deleteUrl(id) {
            axios.delete(`/api/urls/${id}`, {
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            })
                .then(response => {
                    this.urls = this.urls.filter(url => url.id !== id);
                    console.log('URL deleted successfully:', response.data.message);
                })
                .catch(error => {
                    console.error('Error deleting URL:', error);
                });
        },
        editUrl(url) {
            this.$router.push({ name: 'urlShortener', params: { url } });
        }
    }
};
</script>
