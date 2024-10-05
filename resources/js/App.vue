<template>
    <NavBar />
    <div class="container">
      <TaskManger />
    </div>
    <router-view />
  </template>
  
  <script setup>
  import NavBar from './components/NavBar.vue';
  import TaskManger from './components/Task/TaskManger.vue';
    // import router from './router';
  
  </script>
  