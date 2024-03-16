<template>
    <div>
      <h2>Login</h2>
      <form @submit.prevent="login">
        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" required>
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        email: '',
        password: ''
      };
    },
    methods: {
        login() {
      axios.post('/api/login', {
        email: this.email,
        password: this.password
      })
      .then(response => {
        console.log('Login successful');
        console.log('Token:', response.data.token);

        sessionStorage.setItem('url_shortener_token', response.data.token);

        this.$router.push('/');
      })
      .catch(error => {
        console.error('Login error:', error.message);
      });
    }
    }
  };
  </script>
