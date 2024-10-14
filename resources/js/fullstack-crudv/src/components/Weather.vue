<template>
  <div class="container">
    <div class="title-main">Weather Information</div>
    
    <!-- Local Time Display -->
    <div class="detail-item">
      <strong>Local time: </strong>
      <span>{{ localTime }}</span>
    </div>

    <!-- Error message display -->
    <div v-if="errorMessage" class="error-message">
      {{ errorMessage }}
    </div>

    <div class="weather-search">
      <div class="weather-search-input">
        <input
          type="text"
          v-model="city"
          placeholder="Enter country or city name..."
          class="input"
          style="width:100%;"
        />
      </div>
      <button @click="fetchWeather" class="fetch-button">Get Weather</button>
    </div>

    <div v-if="weatherData" class="weather-card">
      <h2 class="city-name"><strong>{{ weatherData.name }}</strong></h2>
      <div class="weather-details">
        <div class="detail-item">
          <strong>Temperature: </strong>
          <span>{{ (weatherData.main.temp - 273.15).toFixed(1) }} °C</span>
        </div>
        <div class="detail-item">
          <strong>Feels Like: </strong>
          <span>{{ (weatherData.main.feels_like - 273.15).toFixed(1) }} °C</span>
        </div>
        <div class="detail-item">
          <strong>Humidity: </strong>
          <span>{{ weatherData.main.humidity }}%</span>
        </div>
        <div class="detail-item">
          <strong>Pressure: </strong>
          <span>{{ weatherData.main.pressure }} hPa</span>
        </div>
        <div class="detail-item">
          <strong>Wind Speed: </strong>
          <span>{{ weatherData.wind.speed }} m/s</span>
        </div>
        <div class="detail-item">
          <strong>Weather: </strong>
          <span>{{ weatherData.weather[0].description }}</span>
        </div>
        <div class="detail-item">
          <strong>Cloudiness: </strong>
          <span>{{ weatherData.clouds.all }}%</span>
        </div>
        <div class="detail-item">
          <strong>Sunrise: </strong>
          <span>{{ formatDate(weatherData.sys.sunrise) }}</span>
        </div>
        <div class="detail-item">
          <strong>Sunset: </strong>
          <span>{{ formatDate(weatherData.sys.sunset) }}</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      city: '',
      weatherData: null,
      errorMessage: null,
      localTime: this.getCurrentTime() // Initialize with current system time
    };
  },
  methods: {
    // Method to get the current system time (formatted)
    getCurrentTime() {
      const now = new Date();
      const options = {
        weekday: 'short', // e.g. 'Mon'
        year: 'numeric',
        month: 'short', // e.g. 'Oct'
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        hour12: false // 24-hour format
      };
      return new Intl.DateTimeFormat('en-GB', options).format(now);
    },
    async fetchWeather() {
      this.errorMessage = null; // Clear previous error message
      try {
        if (!this.city) {
          this.errorMessage = 'Please enter a city name';
          return;
        }

        const apiKey = '50f86958e0582bbaafc9aaa786c7660f';
        const response = await axios.get(
          `https://api.openweathermap.org/data/2.5/weather?q=${this.city}&appid=${apiKey}`
        );

        this.weatherData = response.data; // Assign the response data to weatherData

        // Set localTime only once using the timezone offset from API data
        const timezoneOffset = this.weatherData.timezone; // Timezone offset in seconds
        const utcTime = new Date().getTime(); // Current UTC time in milliseconds
        const localTime = new Date(utcTime + timezoneOffset * 1000); // Adjust for timezone offset

        // Format the local time
        const options = {
          weekday: 'short', // e.g. 'Mon'
          year: 'numeric',
          month: 'short', // e.g. 'Oct'
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit',
          hour12: false // 24-hour format
        };

        // Update localTime
        this.localTime = new Intl.DateTimeFormat('en-GB', options).format(localTime);

        this.errorMessage = null; // Clear error message if the API call is successful
      } catch (error) {
        this.errorMessage = 'City not recognized. Please enter a valid city name'; // Set error message
        this.weatherData = null; // Clear weather data on error
        this.localTime = this.getCurrentTime(); // Reset to current system time if an error occurs
        console.error(error);
      }
    },
    formatDate(timestamp) {
      const date = new Date(timestamp * 1000); // Convert to milliseconds
      return date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }); // Format time
    }
  },
  mounted() {
    // Set initial local time on page load
    this.localTime = this.getCurrentTime();
  }
};
</script>