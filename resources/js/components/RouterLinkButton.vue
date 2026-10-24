<template>
    <router-link :to="url"
        class="group relative flex w-1/3 justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2"
        :class="[color ? 'bg-' + color + '-600 hover:bg-' + color + '-700' : 'bg-emerald-600  hover:bg-emerald-700']">
        {{ btnText }}
    </router-link>
</template>

<script setup>

import { defineProps, toRefs } from 'vue';

const props = defineProps({ btnText: String, url: String, color: String });
const { btnText, url, color } = toRefs(props);

</script>

