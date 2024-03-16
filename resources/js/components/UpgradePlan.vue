<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Upgrade Plan</h2>
                        <form @submit.prevent="upgradePlan">
                            <div class="mb-3">
                                <label for="quotaLimit" class="form-label">New Quota Limit:</label>
                                <input type="number" id="quotaLimit" v-model="shortenLimit" class="form-control" min="0"
                                    max="1000" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upgrade</button>
                        </form>
                    </div>
                </div>
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Plan Details</h5>
                        <p class="card-text">Total Limit: {{ user.shorten_limit }}</p>
                        <p class="card-text">Remaining Limit: {{ user.shorten_limit - user.total_urls_count }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';
import { getAuthToken } from '../auth';

export default {
    data() {
        return {
            user: {},
            shortenLimit: 0,
            token: '',
        };
    },
    mounted() {
        this.token = getAuthToken();
        this.fetchUserDetails();
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
                    this.shortenLimit = this.user.shorten_limit
                })
                .catch(error => {
                    console.error('Error fetching user details:', error.message);
                });
        },
        upgradePlan() {
            axios.put('/api/user/upgrade-plan', { 'shortenLimit': this.shortenLimit }, {
                headers: {
                    'Authorization': `Bearer ${this.token}`
                }
            })
                .then(response => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Upgraded!',
                        text: 'Plan upgraded successfully.',
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 3000
                    });
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'An error occurred while upgrading the plan.',
                        toast: true,
                        position: 'top',
                        showConfirmButton: false,
                        timer: 3000
                    });
                });
        }
    }
};
</script>
