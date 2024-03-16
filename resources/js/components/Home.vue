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
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="url in urls" :key="url.id">
                                    <td>
                                        <template v-if="url.status">
                                            <a :href="url.original_url" target="_blank">{{ url.original_url }}</a>
                                        </template>
                                        <template v-else>
                                            {{ url.original_url }}
                                        </template>
                                    </td>

                                    <td>
                                        <template v-if="url.status">
                                            <a :href="url.shortened_url" target="_blank">{{ url.shortened_url }}</a>
                                        </template>
                                        <template v-else>
                                            {{ url.shortened_url }}
                                        </template>
                                    </td>
                                    <td>
                                        <button
                                            :class="{ 'badge bg-success': url.status === 1, 'badge bg-danger': url.status === 0 }"
                                            @click="toggleStatus(url.id)">
                                            {{ url.status == 1 ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td>
                                        <button @click="editUrl(url)" class="btn btn-primary">Edit</button>
                                        <button class="btn btn-danger" @click="deleteUrl(url.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <router-link class="btn btn-primary" to="/url-shortener">
                    Shorten a URL
                </router-link>
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
            Swal.fire({
                title: 'Are you sure?',
                text: 'You are about to delete this URL.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/urls/${id}`, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                        .then(response => {
                            console.log('URL deleted successfully:', response.data.message);
                            this.urls = this.urls.filter(url => url.id !== id);
                            Swal.fire('Deleted!', 'The URL has been deleted.', 'success');
                        })
                        .catch(error => {
                            console.error('Error deleting URL:', error);
                            Swal.fire('Error!', 'An error occurred while deleting the URL.', 'error');
                        });
                }
            });
        },
        editUrl(url) {
            this.$router.push({ name: 'urlShortener', params: { url } });
        },
        toggleStatus(id) {
            axios.put(`/api/urls/${id}/toggleStatus`, null, {
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            })
                .then(response => {
                    // TODO: Add loader
                    this.urls = this.urls.map(url => {
                        if (url.id === id) {
                            url.status = (!url.status) + 0;
                        }

                        return url;
                    });
                    console.log('URL status updated successfully:', response.data.message);
                })
                .catch(error => {
                    console.error('Error updating URL status:', error);
                });
        }

    }
};
</script>
