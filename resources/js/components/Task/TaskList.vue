<template>
    <div class="container mt-4">
      <h2 class="mb-4">Task List</h2>
      <div class="row">
        <div class="col" v-for="status in statuses" :key="status">
          <!-- Status Heading outside the dotted border -->
          <h3 :class="statusClass(status)" class="text-center text-dark p-2 rounded">{{ status }}</h3>
  
          <div class="task-column rounded">
            <div v-for="task in filteredTasks(status)" :key="task.id" class="card mb-3 shadow">
              <div class="card-body">
                <h5 class="card-title">{{ task.title }}</h5>
                <p class="card-text">{{ task.description }}</p>
                <hr /> <!-- Line above the due date -->
                <div class="due-date-container mb-3 d-flex align-items-center">
                    <i class="bi bi-calendar me-2"></i> <!-- Calendar Icon -->
                    <button :class="randomButtonClass()" class="btn due-date-btn btn-sm">
                        {{ formatDueDate(task.due_date) }}
                    </button>
                    </div>                <div>
                  <!-- <button @click="editTask(task.id)" class="btn btn-warning btn-sm">Edit</button>
                  <button @click="deleteTask(task.id)" class="btn btn-danger btn-sm">Delete</button> -->
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button @click="showForm" class="btn btn-primary mt-3">Add Task</button>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, defineEmits } from 'vue';
  import axios from 'axios';
  import { store } from '../../store';
  
  const tasks = ref([]);
  const emit = defineEmits();

  const statuses = ['To Do', 'In Progress', 'Done'];
  
  onMounted(fetchTasks);
  
  async function fetchTasks() {
    try {
      axios.defaults.headers.common['Authorization'] = `Bearer ${store.token}`;
      const response = await axios.get('/api/tasks');
      tasks.value = response.data;
    } catch (error) {
      console.error('Error fetching tasks:', error);
    }
  }
  
  function filteredTasks(status) {
    return tasks.value.filter(task => task.status === status);
  }
  
  function formatDueDate(dueDate) {
    return dueDate ? new Date(dueDate).toLocaleDateString() : 'N/A';
  }
  
  function showForm() {
    emit('add-task');
  }
  
  function editTask(id) {
    // Emit edit event to parent with the task ID
  }
  
  async function deleteTask(id) {
    if (confirm('Are you sure you want to delete this task?')) {
      try {
        await axios.delete(`/api/tasks/${id}`);
        fetchTasks(); // Refresh the task list after deletion
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    }
  }
  
  function statusClass(status) {
  switch (status) {
    case 'To Do':
      return 'bg-light-blue';
    case 'In Progress':
      return 'bg-light-yellow';
    case 'Done':
      return 'bg-light-green';
    default:
      return '';
  }
}

function randomButtonClass() {
  const colors = ['btn-primary', 'btn-secondary', 'btn-success', 'btn-danger', 'btn-warning', 'btn-info'];
  return colors[Math.floor(Math.random() * colors.length)];
}
</script>

<style scoped>
/* Light colors for status headings */
.bg-light-blue {
  background-color: #e3f2fd !important;
}

.bg-light-yellow {
  background-color: #fff9c4 !important;
}

.bg-light-green {
  background-color: #e8f5e9 !important;
}

/* Dotted border for task columns with rounded corners */
.task-column {
  border: 2px dotted #ccc;
  border-radius: 10px;
  padding: 15px;
  margin-top: 20px;
}

.due-date-container {
  display: inline-block; /* Ensures the due date button doesn’t take full width */
}

.due-date-btn {
  display: inline-block; /* Aligns the button inline */
  min-width: auto; /* Prevents button from stretching */
  margin-left: 0;
}




/* Adjust the card styling for a better layout */
.card {
  margin-bottom: 20px;
}

hr {
  border: 1px solid #ccc;
  margin: 10px 0;
}
</style>
  