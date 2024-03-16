<template>
    <div>
        <h1>URL Shortener</h1>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            user: {}
        };
    },
    created() {
        this.fetchUserDetails();
    },
    methods: {
        fetchUserDetails() {
            const token = sessionStorage.getItem('url_shortener_token');

            axios.get('/api/user', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            })
                .then(response => {
                    console.log('User details:', response.data.data);
                    this.user = response.data.data;
                })
                .catch(error => {
                    console.error('Error fetching user details:', error.message);
                });
        },
    }
};
</script>
