<template>
    <nav>
        <div v-if="!isLoggedIn">
            <router-link :to="{ name: 'home' }">Login</router-link>
            <router-link :to="{ name: 'register' }">Sign in</router-link>
        </div>
        <div v-else>
            <router-link :to="{ name: 'game' }">¡Play!</router-link>
            <router-link :to="{ name: 'throws', params: { id: idUser } }">Throws</router-link>
            <router-link :to="{ name: 'ranking' }">Ranking</router-link>
            <router-link class="text-emerald-700 opacity-30" :to="{ name: 'logout' }">Log out</router-link>
        </div>
    </nav>
</template> 

<script>
export default {
    data() {
        return {
            idUser: localStorage.getItem('idUser'),
        }
    },
    computed : {
      isLoggedIn : function(){ return localStorage.getItem('idUser')}
    }
}
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

nav a.router-link-exact-active:hover {
    background-color: transparent;
}

nav a {
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