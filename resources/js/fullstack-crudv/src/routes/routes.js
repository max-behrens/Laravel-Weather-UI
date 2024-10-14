import Weather from '../components/Weather';
import UserList from '../components/UserList.vue';  
import AddUser from '../components/AddUser.vue';  
import EditUser from '../components/EditUser.vue';
import ShowUser from '../components/ShowUser.vue';
import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    { path: '/', redirect: '/weather' },  // Default weather API page
    { path: '/users', component: UserList, name: 'users-index' },  // Users list page
    { path: '/users/add', component: AddUser },  // Add new user
    { path: '/users/edit/:id', component: EditUser, name: 'users.edit' },  // Edit user by ID
    { path: '/users/:id', component: ShowUser },  // Show user details by ID
    { path: '/weather', component: Weather }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;