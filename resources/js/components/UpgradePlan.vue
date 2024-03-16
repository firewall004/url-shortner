<template>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
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
            shortenLimit: '1000',
            token: getAuthToken(),
        };
    },
    methods: {
        // TODO: Get from auth the token
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
                    console.error('Error upgrading plan:', error);
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
