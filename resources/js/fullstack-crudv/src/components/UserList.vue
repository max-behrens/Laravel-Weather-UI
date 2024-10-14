<template>
    <div class="container">
        <div class="title-main">
            User List
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Date Created</th>
                    <th>Date Modified</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" :key="user.id">
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ new Date(user.created_at).toLocaleString() }}</td>
                    <td>{{ new Date(user.updated_at).toLocaleString() }}</td>
                    <td>
                        <div class="user-buttons">
                            <router-link :to="'/users/' + user.id" class="btn user-button-primary">View</router-link>
                            <router-link :to="'/users/edit/' + user.id" class="btn user-button-primary">Edit</router-link>
                            <button @click="deleteUser(user.id)" class="btn user-button-secondary">Delete</button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <router-link class="btn btn-primary" to="/users/add">Add New User</router-link>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    name: 'UserList',
    data() {
        return {
            users: [] // Store the list of users
        };
    },
    created() {
        this.fetchFormattedUserList();
    },
    methods: {
        async fetchFormattedUserList() {
            try {
                const response = await axios.get('/users/formatted', {
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                // Log the response to see what it contains
                console.log(response.data);

                // Assign the users array to the component's data
                this.users = response.data; // Directly set the users array
            } catch (error) {
                console.error('Error fetching users:', error);
            }
        },
        async deleteUser(id) {
            const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content; // Get CSRF token

            console.log(`Attempting to delete user with ID: ${id}`); // Debug log

            try {
                const response = await axios.delete(`/users/${id}`, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Set the CSRF token in the headers
                    }
                });
                
                console.log('Delete response:', response.data); // Debug log

                // Check for success message
                if (response.data.message === 'User deleted successfully') {
                    // Re-fetch the users after deletion
                    this.fetchFormattedUserList(); 
                }
            } catch (error) {
                console.error('Error deleting user:', error); // Debug log
            }
        }
    }
};
</script>