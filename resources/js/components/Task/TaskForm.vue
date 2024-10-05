<template>
    <div class="card mt-4" v-if="show">
      <div class="card-body">
        <h5 class="card-title">{{ isEditing ? 'Edit Task' : 'Create Task' }}</h5>
        <form @submit.prevent="submitTask">
          <!-- Title Field -->
          <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" v-model="task.title" required />
          </div>
  
          <!-- Description Field -->
          <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" v-model="task.description"></textarea>
          </div>
  
          <!-- Status Field -->
          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" v-model="task.status" required>
              <option value="To Do">To Do</option>
              <option value="In Progress">In Progress</option>
              <option value="Done">Done</option>
            </select>
          </div>
  
          <!-- Due Date Field -->
          <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" v-model="task.due_date" />
          </div>
  
          <div class="mb-3">
            <label for="assigned_users" class="form-label">Assigned Users</label>
            <multiselect
                v-model="task.assigned_users"
                :options="allUsers"
                :multiple="true"
                :close-on-select="false"
                :clear-on-select="false"
                :preserve-search="true"
                placeholder="Select users"
                label="name"
                track-by="id"
            >
            </multiselect>
        </div>
  
          <!-- Buttons -->
          <button type="submit" class="btn btn-success me-2">{{ isEditing ? 'Update' : 'Create' }}</button>
          <button type="button" class="btn btn-secondary" @click="resetForm">Cancel</button>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, watch, onMounted } from 'vue';
  import Multiselect from 'vue-multiselect';
  import 'vue-multiselect/dist/vue-multiselect.min.css';
  import axios from 'axios';
  import api from '../../api'; // Replace with your API path
  import { store } from '../../store'; // Assuming you're using a store
  
  const props = defineProps({
    show: Boolean,
    taskId: Number,
  });
  
  // Task Data Initialization
  const task = ref({
    title: '',
    description: '',
    status: 'To Do',
    due_date: '',
    assigned_users: []  // Initialize as an empty array
  });
  
  const isEditing = ref(false);
  const allUsers = ref([]);
  watch(() => props.show, (newVal1) => {
    if (newVal1) {
        getUsers();
    }
  })
  
  watch(
  () => props.taskId,
  async (newVal) => {
    if (newVal) {
      isEditing.value = true;
      const response = await api.get(`/tasks/${newVal}`);
      task.value = response.data;

      if (typeof task.value.assigned_users === 'string') {
        task.value.assigned_users = JSON.parse(task.value.assigned_users);
      }
      if (task.value.due_date) {
        task.value.due_date = new Date(task.value.due_date).toISOString().split('T')[0]; // Format to YYYY-MM-DD
      }
    } else {
      resetForm();
    }
  }
);

  function resetForm() {
    isEditing.value = false;
    task.value = {
      title: '',
      description: '',
      status: 'To Do',
      due_date: '',
      assigned_users: []  
    };
  }
 
  async function submitTask() {
    try {
      if (isEditing.value) {
        await api.put(`/tasks/${props.taskId}`, task.value);
      } else {
        await api.post('/tasks', task.value);
      }
      resetForm();
      emit('task-updated');
    } catch (error) {
      console.error('Error submitting task:', error);
    }
  }
  async function getUsers() {
    try {
            const response = await api.get('/users'); 
            allUsers.value = response.data;
        } catch (error) {
            console.error('Error fetching users:', error);
        }
  }
  </script>
  
  <style scoped>
  .card {
    margin-top: 20px;
  }
  </style>
  