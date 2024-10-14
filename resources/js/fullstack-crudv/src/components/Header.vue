<template>
  <nav class="navbar navbar-expand-md bg-primary" data-bs-theme="dark"> <!-- Changed from lg to md -->
    <div class="container-fluid">
      <a class="navbar-brand" href="#">{{ title }}</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <router-link class="nav-link" to="/weather">Weather API</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link active" to="/users">User List
              <!-- <span class="visually-hidden">(current)</span> -->
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/users/add">Add User</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: 'AppHeader',
  props: {
    title: String
  }
}
</script>

<style>
/* Add any styles specific to the header here */
</style>