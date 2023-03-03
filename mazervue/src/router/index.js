import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import LoginView from '../views/auth/LoginView.vue'
import RegisterView from '../views/auth/RegisterView.vue'
import ForgotPasswordView from '../views/auth/ForgotPasswordView.vue'
import Otp from '../views/auth/Otp.vue'
import Logout from '../views/auth/Logout.vue'
import VerifyEmail from '../views/auth/VerifyEmail.vue'
import Onboarding from '../views/auth/Onboarding.vue'
import ProfileView from '../views/ProfileView.vue'
import SettingsView from '../views/SettingsView.vue'
import NotFound from '../views/404.vue'


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
      path: '/logout',
      name: 'logout',
      component: Logout,
      meta: {
        isAuth: true
      }
    },
    {
      path: '/register',
      name: 'register',
      component: RegisterView
    },
    {
      path: '/otp',
      name: 'otp',
      component: Otp,
      
    },
    {
      path: '/onboarding',
      name: 'onboarding',
      component: Onboarding,
      
    },
    {
      path: '/forgot-password',
      name: 'forgot password',
      component: ForgotPasswordView
    },
    {
      path: '/verify-email/:otp',
      name: 'verifyEmail',
      component: VerifyEmail,
      props:true
    },
    {
      path: '/profile',
      name: 'profile',
      component: ProfileView,
      meta: {
        isAuth: true
      }
    },
    {
      path: '/settings',
      name: 'settings',
      component: SettingsView,
      meta: {
        isAuth: true
      }
    },
    {
      path: '/:pathMatch(.*)*',
      name: '404',
      component: NotFound
    }
  ]
})

router.beforeEach((to) => {
  if(to.meta.isAuth && !localStorage.getItem('authtoken')){
    router.push('/login')
  }
})

export default router
