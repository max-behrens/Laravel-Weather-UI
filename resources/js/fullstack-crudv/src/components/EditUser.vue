<template>
  <div class="container">
    <div class="title-main">Edit User</div>
    <div v-if="errorMessage" class="alert alert-danger">
      {{ errorMessage }}
    </div>

    <div class="user-edit-container">
      <form @submit.prevent="submitForm" style="width: 100%;">
        <div class="form-group">
          <label for="name">Name:</label>
          <input 
            type="text" 
            id="name"
            class="form-control" 
            v-model="form.name" 
            required
          >
        </div>

        <div class="form-group">
          <label for="email">Email:</label>
          <input 
            type="email" 
            id="email"
            class="form-control" 
            v-model="form.email" 
            required
          >
        </div>

        <div class="form-group">
          <label for="password">Current Password:</label>
          <input 
            type="password" 
            id="password"
            class="form-control" 
            v-model="form.password" 
            required
          >
        </div>

        <button type="submit" class="btn btn-primary" :disabled="loading">
          {{ loading ? 'Updating...' : 'Update' }}
        </button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      user: null,
      form: {
        name: '',
        email: '',
        password: ''
      },
      errorMessage: null,
      loading: false
    };
  },
  
  created() {
    this.getUser();
  },
  
  methods: {
    async getUser() {
      const userId = this.$route.params.id;
      try {
        const response = await axios.get('/users/formatted');
        const users = response.data;
        
        this.user = users.find(user => user.id === parseInt(userId));
        
        if (!this.user) {
          this.errorMessage = 'User not found.';
          return;
        }
        
        // Only set name and email, not password
        this.form.name = this.user.name;
        this.form.email = this.user.email;
        
      } catch (error) {
        console.error('Error fetching user:', error);
        this.errorMessage = 'Error fetching user data. Please try again.';
      }
    },
    
    async submitForm() {
      try {
        this.loading = true;
        this.errorMessage = null;
        
        const userId = this.$route.params.id;
        
        const response = await axios.put(`/api/users/${userId}`, this.form);
        
        if (response.data.message) {
          // Show success message before redirecting
          alert(response.data.message);
        }
        
        // Redirect to users list
        this.$router.push('/users');
        
      } catch (error) {
        console.error('Error updating user:', error);
        
        // Handle validation errors from Laravel
        if (error.response?.status === 422) {
          const validationErrors = error.response.data.errors;
          // Display the first validation error message
          this.errorMessage = Object.values(validationErrors)[0][0];
        } else {
          this.errorMessage = error.response?.data?.message || 'Error updating user data. Please try again.';
        }
      } finally {
        this.loading = false;
      }
    }
  }
};
</script>