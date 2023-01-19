import { createRouter, createWebHistory } from 'vue-router'

const auth = (to, from, next) => {
    if (localStorage.getItem("authToken")) {
        return next();
    } else {
        return next("/login");
    }
};

const guest = (to, from, next) => {
    if (!localStorage.getItem("authToken")) {
        return next();
    } else {
        return next("/game");
    }
};

const routes = [{
        path: '/',
        name: 'home',
        component: () => import('../../views/auth/LoginView.vue'),
    },
    {
        path: '/login',
        name: 'login',
        beforeEnter: guest,
        component: () => import('../../views/auth/LoginView.vue'),
    },
    {
        path: '/register',
        name: 'register',
        beforeEnter: guest,
        component: () => import('../../views/auth/RegisterView.vue'),
    },
    {
        path: '/logout',
        name: 'logout',
        beforeEnter: auth,
        component: () => import('../../views/auth/LogoutView.vue'),
    },
    {
        path: '/game',
        name: 'game',
        beforeEnter: auth,
        component: () => import('../../views/game/GameView.vue'),
    },
    {
        path: '/ranking',
        name: 'ranking',
        beforeEnter: auth,
        component: () => import('../../views/game/RankingView.vue'),
    },
    // {
    //   path: '/stats/:id',
    //   name: 'stats',
    //   component: () => import('../../views/game/StatsView.vue')
    // }
]

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})

export default router
