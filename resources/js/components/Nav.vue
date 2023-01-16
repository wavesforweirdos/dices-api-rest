<template>
    <nav>
        <RouterLink to="/login">Log in</RouterLink>
        <RouterLink to="/register">Sign in</RouterLink>
        <RouterLink to="/game">Game</RouterLink>
        <RouterLink to="/ranking">Ranking</RouterLink>
        <RouterLink to="{ name: '/stats', params: { id: user.id} }">My stats</RouterLink>
        <button @click="Logout">Log out</button>
    </nav>
</template>

<script>
import { useRouter } from 'vue-router';
export default {
    setup() {
        const router = useRouter();
        const Logout = () => {
            localStorage.clear();
            router.push({ path: '/login' });
        };
        return { Logout };
    },
};
</script>

<style scoped>
nav {
    width: 100%;
    font-size: 12px;
    text-align: center;
    margin-top: 2rem;
}

nav a.router-link-exact-active {
    color: var(--color-text);
}

nav a.router-link-exact-active:hover{
    background-color: transparent;
}

nav a{
    display: inline-block;
    padding: 0 1rem;
    border-left: 1px solid var(--color-border);
}

nav a:first-of-type {
    border: 0;
}

@media (min-width: 1024px) {
    nav {
        text-align: left;
        margin-left: -1rem;
        font-size: 1rem;

        padding: 1rem 0;
        margin-top: 1rem;
    }
}
</style>