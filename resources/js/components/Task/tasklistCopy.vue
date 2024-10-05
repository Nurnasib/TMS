<template>
    <div>
      <h2 class="mb-4 mt-4">Task List</h2>
      <table class="table table-striped">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Due Date</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="task in tasks" :key="task.id">
            <td>{{ task.title }}</td>
            <td>{{ task.description }}</td>
            <td>{{ task.status }}</td>
            <td>{{ task.due_date ? new Date(task.due_date).toLocaleDateString() : 'N/A' }}</td>
            <td>
              <button @click="editTask(task.id)" class="btn btn-warning btn-sm">Edit</button>
              <button @click="deleteTask(task.id)" class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
      <button @click="showForm" class="btn btn-primary mt-3">Add Task</button>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, defineEmits } from 'vue';
  import axios from 'axios';
  import api from '../../api';
  
  const tasks = ref([]);
  const emit = defineEmits();
  const showTaskForm = ref(false);
  const selectedTaskId = ref(null);
  
  onMounted(fetchTasks);
  
  async function fetchTasks() {
    try {
      const response = await api.get('/tasks');
      tasks.value = response.data;
    } catch (error) {
      console.error('Error fetching tasks:', error);
    }
  }
  
  function showForm() {
    console.log('ppppp', 'jjjj');
    emit('add-task');
    
    // showTaskForm.value = true;
    // selectedTaskId.value = null;
  }
  
  function editTask(id) {
    emit('edit-task', id); // Open the form for editing
  }
  
  async function deleteTask(id) {
    if (confirm('Are you sure you want to delete this task?')) {
      try {
        await api.delete(`/tasks/${id}`);
        fetchTasks(); // Refresh the task list after deletion
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    }
  }
  </script>
  
  <style scoped>
  .table {
    margin-top: 20px;
  }
  </style>
  