<template>
    <div class="container">
      <div class="title-main">
        Add New User</div>
      <!-- Display error messages -->
      <div v-if="errors.length" class="alert alert-danger">
        <ul>
          <li v-for="(error, index) in errors" :key="index">{{ error }}</li>
        </ul>
      </div>
  
      <!-- User creation form -->
      <div class="user-add-container">
      <form @submit.prevent="addUser" style="width: 100%;">
        <div class="form-group">
          <label for="name">Name:</label>
          <input type="text" class="form-control" v-model="user.name" required />
        </div>
  
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" class="form-control" v-model="user.email" required />
        </div>
  
        <div class="form-group">
          <label for="password">Password:</label>
          <input type="password" class="form-control" v-model="user.password" required />
        </div>
  
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'AddUser',
    data() {
      return {
        user: {
          name: '',
          email: '',
          password: '',
        },
        errors: [],  // Array to hold validation errors
      };
    },
    methods: {
      async addUser() {
        try {
          // Attempt to send a POST request to create a new user
          await axios.post('/api/users', this.user);
          this.$router.push('/users');  // Redirect to user list after successful addition
          alert('User added successfully');
        } catch (error) {
          // Capture validation errors and populate the errors array
          if (error.response && error.response.status === 422) {
            this.errors = error.response.data.errors
              ? Object.values(error.response.data.errors).flat() // Flatten error array if nested
              : [];
          } else {
            console.error('An unexpected error occurred:', error);
          }
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Optional: Add any custom styles here */
  </style>