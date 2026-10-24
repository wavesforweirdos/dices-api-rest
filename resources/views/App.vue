<script setup>
import HomeView from '../js/components/HomeMsg.vue'
import NavBar from '../js/components/Nav.vue'
import { RouterView } from 'vue-router'
</script>

<template>
  <header>
    <img alt="DiceGame logo" class="logo" src="../assets/logo.svg" width="125" height="125" />
    <div class="wrapper max-w-7xl mx-auto">
      <HomeView msg="Congrats!" />
      <NavBar />
    </div>
  </header>
  <RouterView />
</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}

.logo {
  display: block;
  margin: 0 auto 2rem;
}

@media (min-width: 1024px) {
  header {
    display: flex;
    place-items: center;
    padding-right: calc(var(--section-gap) / 2);
  }

  .logo {
    margin: 0 2rem 0 0;
  }

  header .wrapper {
    display: flex;
    place-items: flex-start;
    flex-wrap: wrap;
  }
}
</style>
