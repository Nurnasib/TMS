// api.js
import axios from 'axios';
import { store } from './store'; // Make sure to import your store where the token is stored

const api = axios.create({
  baseURL: '/api', // Set your base URL for the API
});

// Add a request interceptor to automatically add the Authorization header
api.interceptors.request.use((config) => {
  const token = store.token;
  if (token) {
    config.headers['Authorization'] = `Bearer ${token}`;
  }
  return config;
}, (error) => {
  return Promise.reject(error);
});

export default api;
