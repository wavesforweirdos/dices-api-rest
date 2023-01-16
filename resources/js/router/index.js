import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../../views/HomeView.vue'

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
      component: () => import('../../views/auth/LoginView.vue')
    },
    {
      path: '/register',
      name: 'register',
      component: () => import('../../views/auth/RegisterView.vue')
    },
    {
      path: '/game',
      name: 'game',
      component: () => import('../../views/game/GameView.vue')
    },
    {
      path: '/ranking',
      name: 'ranking',
      component: () => import('../../views/game/RankingView.vue')
    },
    {
      path: '/stats/:id',
      name: 'stats',
      component: () => import('../../views/game/StatsView.vue')
    }
  ]
})

export default router
