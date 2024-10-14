// resources/js/app.js

import { createApp } from 'vue'; // Use `createApp` for Vue 3
import '../sass/app.scss'; // Adjust the path if necessary
import App from './fullstack-crudv/src/App.vue'; // Import your main App component
import WeatherComponent from './fullstack-crudv/src/components/Weather.vue'; // Import your Weather component
import router from './fullstack-crud/src/routes/routes'; // Import your router instance

const app = createApp(App); // Create your Vue app instance
app.use(router); // Use the router instance
app.component('weather-component', WeatherComponent); // Register the Weather component globally
app.mount('#app'); // Mount the app to the DOM