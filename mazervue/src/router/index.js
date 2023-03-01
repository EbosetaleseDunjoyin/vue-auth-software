import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/auth/LoginView.vue'
import RegisterView from '../views/auth/RegisterView.vue'
import ForgotPasswordView from '../views/auth/ForgotPasswordView.vue'
import Otp from '../views/auth/Otp.vue'
import MasterView from '../views/MasterView.vue'
import SettingsView from '../views/SettingsView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/otp',
      name: 'otp',
      component: Otp
    },
    {
      path: '/forgot-password',
      name: 'forgot password',
      component: ForgotPasswordView
    },
    {
      path: '/admin',
      name: 'admin',
      component: MasterView
    },
    {
      path: '/settings',
      name: 'settings',
      component: SettingsView
    },
  ]
})

export default router
