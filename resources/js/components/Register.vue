
<template>
  <div class="container mt-3">
    <div class="card col-md-8 mx-auto">
      <div class="card-header">
        <h2>Register</h2>
      </div>
      <div class="card-body">
        <form @submit.prevent="submitRegister">
          <div class="mb-2">
            <label for="name" class="form-label">Name:</label>
            <input type="text" id="name" class="form-control" v-model="name" required />
          </div>
          <div class="mb-2">
            <label for="email" class="form-label">Email:</label>
            <input type="email" id="email" class="form-control" v-model="email" required />
          </div>
          <div class="mb-2">
            <label for="password" class="form-label">Password:</label>
            <input type="password" id="password" class="form-control" v-model="password" required />
          </div>
          <div class="mb-2">
            <label for="password_confirmation" class="form-label">Confirm Password:</label>
            <input type="password" id="password_confirmation" class="form-control" v-model="password_confirmation" required />
          </div>
          <button type="submit" class="btn btn-primary">Register</button>
        </form>
      </div>
    </div>
  </div>
</template>
  
  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  import { store } from '../store';
  
  const name = ref('');
  const email = ref('');
  const password = ref('');
  const password_confirmation = ref('');
  const router = useRouter();
  
  const submitRegister = async () => {
    try {
      const response = await axios.post('api/register', {
        name: name.value,
        email: email.value,
        password: password.value,
        password_confirmation: password_confirmation.value,
      });
      localStorage.setItem('token', response.data.token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
      const userRes = await axios.get('/api/user');
      store.user = userRes.data;
      localStorage.setItem('user', JSON.stringify(userRes.data));
      router.push('/');
    } catch (error) {
      alert(error.message);
    }
  };
  </script>
  