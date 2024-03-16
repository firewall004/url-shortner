<template>
    <div>
      <h2>Register</h2>
      <form @submit.prevent="register">
        <div>
          <label for="name">Name:</label>
          <input type="text" id="name" v-model="name" required>
        </div>
        <div>
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" required>
        </div>
        <div>
          <label for="password">Password:</label>
          <input type="password" id="password" v-model="password" required>
        </div>
        <button type="submit">Register</button>
      </form>
    </div>
  </template>

  <script>
  import axios from 'axios';

  export default {
    data() {
      return {
        name: '',
        email: '',
        password: ''
      };
    },
    methods: {
      register() {
        axios.post('/api/register', {
          name: this.name,
          email: this.email,
          password: this.password
        })
        .then(response => {
          console.log('Registration successful');
          this.$router.push('/login');
        })
        .catch(error => {
          console.error('Registration error:', error.message);
        });
      }
    }
  };
  </script>
