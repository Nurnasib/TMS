<template>
  <div class="container mt-5">
    <div class="card col-md-8 mx-auto">
      <div class="card-header">
        <h2>Login</h2>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitLogin">
          <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" class="form-control" v-model="email" required />
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" class="form-control" v-model="password" required />
          </div>
          <button type="submit" class="btn btn-primary">Login</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';
import { store } from '../store';

const email = ref('');
const password = ref('');
const router = useRouter();

async function submitLogin() {
  try {
    const response = await axios.post('/api/login', { email: email.value, password: password.value });

    localStorage.setItem('token', response.data.token);
    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
    const userRes = await axios.get('/api/user');
    store.user = userRes.data;
    localStorage.setItem('user', JSON.stringify(userRes.data));
    router.push('/');
  } catch (error) {
    alert('Login failed'+':'+error.message);
  }
}
</script>
