import { createRouter, createWebHistory } from 'vue-router';
import Register from './components/register.vue';
import Login from './components/login.vue';
import TaskManger from './components/Task/TaskManger.vue';

const routes = [
  { path: '/register', component: Register },
  { path: '/login', component: Login },
  { path: '/tasks', component: TaskManger },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
