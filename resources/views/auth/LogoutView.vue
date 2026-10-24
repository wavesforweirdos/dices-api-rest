<template>
</template>

<script>
import { useRouter } from 'vue-router';

export default {
  setup() {
    const router = useRouter();

    localStorage.clear();
    router.push({ path: '/' });
  }
};
</script>
