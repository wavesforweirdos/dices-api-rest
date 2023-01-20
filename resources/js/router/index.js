import {
    createRouter,
    createWebHistory
} from 'vue-router'

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
        return next("/index");
    }
};

const routes = [{
        path: '/',
        name: 'home',
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
        path: '/index',
        name: 'index',
        component: () => import('../../views/game/IndexView.vue'),
    },
    {
        path: '/game',
        name: 'game',
        beforeEnter: auth,
        component: () => import('../../views/game/GameView.vue'),
    },
    {
        path: '/user/:id/throws/',
        name: 'throws',
        beforeEnter: auth,
        component: () => import('../../views/game/ThrowsView.vue'),
    },
    {
        path: '/ranking',
        name: 'ranking',
        beforeEnter: auth,
        component: () => import('../../views/game/RankingView.vue'),
    },
    {
        path: "/:pathMatch(.*)*",
        component: () => import('../components/NotFound.vue')
    }
]

const router = createRouter({
    history: createWebHistory(
        import.meta.env.BASE_URL),
    routes
})

export default router
