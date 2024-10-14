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
              <input type="text" class="form-control" v-model="form.name" required>
          </div>

          <div class="form-group">
              <label for="email">Email:</label>
              <input type="email" class="form-control" v-model="form.email" required>
          </div>

          <button type="submit" class="btn btn-primary">Update</button>
      </form>
      </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
      return {
          user: null, // Initialize user object
          form: { // Initialize the form object
              name: '',
              email: ''
          },
          errorMessage: null // Initialize error message
      };
  },
    created() {
        this.getUser(); // Call method to fetch user data
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
            } else {
                  this.form.name = this.user.name;
                  this.form.email = this.user.email;
              }

        } catch (error) {
          console.error('Error fetching users:', error);
          this.errorMessage = 'Error fetching user data. Please try again.'; // Set error message
        }
      },
      async submitForm() {
        try {
            const userId = this.$route.params.id; // Get user ID from route parameters
            // Make a PUT request to update the user
            await axios.put(`/api/users/${userId}`, this.form);
            // Optionally, redirect or show a success message
            this.$router.push('/users'); // Redirect to /users
            alert('User updated successfully');
            // Redirect or perform further actions here
        } catch (error) {
            console.error('Error updating user:', error);
            this.errorMessage = 'Error updating user data. Please try again.'; // Set error message
        }
    }
    }
  };
  </script>