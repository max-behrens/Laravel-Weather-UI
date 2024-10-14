<template>
  <div class="container">
    <div class="title-main">
      User Details
    </div>
    <div v-if="user" class="user-details-container">
      <div class="form-group">
        <label for="name">Name:</label>
        <input
          type="name"
          v-model="user.name"
          disabled
          class="form-control"
        />
      </div>
      

      <div class="form-group">
        <label for="email">Email:</label>
        <input
          type="email"
          v-model="user.email"
          disabled
          class="form-control"
        />
      </div>

      <div class="form-group">
        <router-link :to="'/users/edit/' + user.id" class="btn user-button-primary">Edit</router-link>
        <button @click="deleteUser" class="btn user-button-secondary">Delete</button>
      </div>
    </div>
    <div v-else class="alert alert-warning">Loading user details...</div>
    <div v-if="errorMessage" class="error-message">
      {{ errorMessage }}
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { Logger } from 'sass';

export default {
  data() {
    return {
      user: null, // Initialize user object
      errorMessage: null // Initialize error message
    };
  },
  created() {
    this.getUser(); // Fetch user data when the component is created
    },
    methods: {
      async getUser() {

        const userId = this.$route.params.id; // Get user ID from route parameters
        try {
          const response = await axios.get('/users/formatted', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });
          
          console.log(response.data); // Log the response to see its structure

          const users = response.data; // Assign response data to users

          // Initialize user as null
          this.user = null; 

  
            // Loop through each user to find the one with the matching ID
            for (let i = 0; i < users.length; i++) {
              if (users[i].id === parseInt(userId)) {
                this.user = users[i]; // Set the user if found
                break; // Exit the loop once the user is found
              }
            }

            // If user is not found, set an error message
            if (!this.user) {
              this.errorMessage = 'User not found.';
            }

        } catch (error) {
          console.error('Error fetching users:', error);
          this.errorMessage = 'Error fetching user data. Please try again.'; // Set error message
        }
    },
    async deleteUser() {
      const userId = this.user.id;
      if (confirm('Are you sure you want to delete this user?')) {
        try {
          await axios.delete(`/api/users/${userId}`);
          this.$router.push('/users'); // Redirect to the users list after deletion
        } catch (error) {
          console.error('Error deleting user:', error);
          this.errorMessage = 'Error deleting user. Please try again.'; // Set error message
        }
      }
    }
  }
}
</script>