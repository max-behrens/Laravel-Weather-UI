// resources/js/main.js

import { createApp } from 'vue';
import App from './App.vue';  // Your main App component
import router from './routes/routes.js'; // Import your router instance
import Weather from './components/Weather.vue'; // Import your weather component

const app = createApp(App);

// Register the Weather Component globally
app.component('weather-component', Weather);

// Use the router
app.use(router);

// Mount the app
app.mount('#app');