<template>
  <div>
    <AppHeader title="WEATHER UI" />
    <router-view></router-view> <!-- This is where routed components will be displayed -->
  </div>
</template>

<script>
import AppHeader from './components/Header.vue';

export default {
  name: 'App',
  components: {
    AppHeader,
  },
};
</script>

<style>
/* Add any global styles here */
</style>