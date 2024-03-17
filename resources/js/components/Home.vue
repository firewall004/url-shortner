<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1 class="display-5 mb-4">Welcome, {{ user.name | firstName }}</h1>
                <hr class="my-4">
                <div v-if="urls.length === 0">
                    <div class="alert alert-info" role="alert">
                        No URLs Found
                    </div>
                </div>
                <div v-else>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="card-title mb-0">Your Shortened URLs</h2>
                        <div>
                            <p class="card-text mb-0">
                                <strong>Total Limit:</strong> {{ user.shorten_limit }} ({{ user.shorten_limit -
                    urls.length }} remaining)
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Original URL</th>
                                    <th scope="col">Shortened URL</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(url, index) in urls" :key="url.id">
                                    <td>{{ index + 1 }}.</td>
                                    <td>
                                        <template v-if="url.status">
                                            <a :href="url.original_url" target="_blank" :title="url.original_url">{{
                    url.original_url | trimUrl }}</a>
                                        </template>
                                        <template v-else>
                                            {{ url.original_url | trimUrl }}
                                        </template>
                                    </td>
                                    <td>
                                        <template v-if="url.status">
                                            <div class="d-flex align-items-center">
                                                <a :href="url.shortened_url" target="_blank" class="me-2">
                                                    {{ url.shortened_url }}
                                                    <share-icon />
                                                </a>
                                                <button class="btn btn-light btn-sm" @click="copyUrl(url.shortened_url)"
                                                    title="Copy">
                                                    <copy-icon />
                                                </button>
                                            </div>
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
                                        <button class="btn btn-light btn-sm me-2" @click="editUrl(url)" title="Edit">
                                            <edit-icon />
                                        </button>
                                        <button class="btn btn-light btn-sm delete-btn" @click="deleteUrl(url.id)"
                                            title="Delete">
                                            <delete-icon />
                                        </button>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <router-link class="btn btn-primary" to="/url-shortener">Shorten URL</router-link>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { getAuthToken } from '../auth';
import ShareIcon from './icons/Share.vue'
import CopyIcon from './icons/Copy.vue'
import DeleteIcon from './icons/Delete.vue'
import EditIcon from './icons/Edit.vue'

export default {
    name: 'Home',
    components: {
        ShareIcon,
        CopyIcon,
        DeleteIcon,
        EditIcon,
    },
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
                    this.urls = this.urls.map(url => {
                        if (url.id === id) {
                            url.status = (!url.status) + 0;
                        }
                        return url;
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated Successfully!',
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
                        text: error.response.data.message,
                    });
                });
        },
        copyUrl(shortenedUrl) {
            const input = document.createElement('input');

            input.value = window.location.host + '/' + shortenedUrl;

            document.body.appendChild(input);

            input.select();
            input.setSelectionRange(0, 99999);

            document.execCommand('copy');

            document.body.removeChild(input);

            Swal.fire({
                icon: 'success',
                title: 'URL Copied',
                toast: true,
                position: 'top',
                showConfirmButton: false,
                timer: 3000
            });
        }
    },
    filters: {
        trimUrl: function (value, maxLength = 30) {
            if (!value) return '';

            if (value.length > maxLength) {
                return value.substring(0, maxLength) + '...';
            } else {
                return value;
            }
        },
        firstName: function (value) {
            if (!value) return '';

            return value.split(' ')[0];
        }
    },
};
</script>

<style>
.delete-btn:hover {
    background-color: #ff000026;
}

.card {
    margin-bottom: 20px;
}

.alert-info {
    background-color: #f0f9ff;
    border-color: #cfe2ff;
    color: #0c5460;
}
</style>
