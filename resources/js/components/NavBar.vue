<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <!-- Navbar brand or logo -->
      <a class="navbar-brand" href="#">Task management System</a>

      <!-- Toggler for mobile view -->
      <button
        class="navbar-toggler"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Navbar items -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto">
          <li class="nav-item">
            <router-link to="/" class="nav-link" active-class="active">Home</router-link>
          </li>
        </ul>

        <!-- Right side items (user or auth links) -->
        <ul class="navbar-nav ms-auto">
          <!-- If the user is authenticated, show their name with a dropdown -->
          <li v-if="store.user" class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="userDropdown"
              role="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Welcome, {{ store.user.name }}
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><router-link to="/profile" class="dropdown-item">Profile</router-link></li>
              <li><button class="dropdown-item" @click="logout">Logout</button></li>
            </ul>
          </li>

          <!-- If the user is not authenticated, show login/register links -->
          <li v-if="!store.user" class="nav-item">
            <router-link to="/login" class="nav-link" active-class="active">Login</router-link>
          </li>
          <li v-if="!store.user" class="nav-item">
            <router-link to="/register" class="nav-link" active-class="active">Register</router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { store } from '../store';
import router from '../router';

// Logout function
const logout = () => {
  localStorage.removeItem('token');
  localStorage.removeItem('user');
  store.user = null; // Clear the store user
  router.push('/login'); // Redirect to login page
};
</script>

<style scoped>
.navbar .nav-link.active {
  font-weight: bold;
}
</style>
