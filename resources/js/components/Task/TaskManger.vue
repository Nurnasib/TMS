<template>
    <div>
      <TaskList @task-updated="fetchTasks" @add-task="openForm" @edit-task="openForm" />
      <TaskForm :show="showTaskForm" :taskId="selectedTaskId" @close="closeForm" />
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  import TaskList from './TaskList.vue';
  import TaskForm from './TaskForm.vue';
  
  const showTaskForm = ref(false);  // Controls form visibility
  const selectedTaskId = ref(null); // Tracks selected task for editing
  
  // Function to close the form
  function closeForm() {
    showTaskForm.value = false;
    selectedTaskId.value = null; // Reset task ID when closing
  }
  
  // Function to open the form (for adding a new task or editing an existing one)
  function openForm(taskId = null) {
    selectedTaskId.value = taskId;  // Set the task ID (null for new tasks)
    showTaskForm.value = true;      // Show the form
  }
  </script>
  