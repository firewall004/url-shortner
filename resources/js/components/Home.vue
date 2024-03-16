<template>
    <div>
      <h2>Welcome, {{ user.name }}</h2>
      <p>Email: {{ user.email }}</p>
      <button @click="logout">Logout</button>
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
      logout() {
        const token = sessionStorage.getItem('url_shortener_token');

        axios.get('/api/logout', null, {
          headers: {
            'Authorization': `Bearer ${token}`
          }
        })
        .then(response => {
          console.log('Logout successful');

          sessionStorage.removeItem('url_shortener_token');

          this.$router.push('/login');
        })
        .catch(error => {
          sessionStorage.removeItem('url_shortener_token');

          console.error('Logout error:', error.message);
        });
      }
    }
  };
  </script>
