<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="display-5 mb-4">Welcome, {{ user.name }}</h1>
                <hr class="my-4">
                <div v-if="urls.length === 0">
                    <h4>No URLs Found</h4>
                </div>
                <div v-else>
                    <div class="row align-items-center mb-4">
                        <div class="col-md-8">
                            <h2 class="mb-0">Your Shortened URLs</h2>
                        </div>
                        <div class="col-md-4 text-md-end">
                            <b class="mb-0 blockquote-footer">Total Limit: {{ user.shorten_limit }} ({{
                    user.shorten_limit - urls.length }} remaining)</b>
                        </div>
                    </div>
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
                                            {{ url.status === 1 ? 'Active' : 'Inactive' }}
                                        </button>
                                    </td>
                                    <td>
                                        <button @click="editUrl(url)" class="btn btn-primary btn-sm">Edit</button>
                                        <button class="btn btn-danger btn-sm" @click="deleteUrl(url.id)">Delete</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <router-link class="btn btn-primary" to="/url-shortener">
                    Shorten URL
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { getAuthToken } from '../auth';

export default {
    name: 'Home',
    data() {
        return {
            user: {},
            urls: [],
            token: getAuthToken()
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
                title: 'Confirm Deletion',
                text: 'Are you sure you want to delete this URL?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.delete(`/api/urls/${id}`, {
                        headers: {
                            'Authorization': `Bearer ${this.token}`
                        }
                    })
                        .then(response => {
                            this.urls = this.urls.filter(url => url.id !== id);
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: 'The URL has been deleted successfully',
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000
                            });
                        })
                        .catch(error => {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'An error occurred while deleting the URL',
                                toast: true,
                                position: 'top',
                                showConfirmButton: false,
                                timer: 3000
                            });
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
