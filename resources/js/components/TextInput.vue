<template>
    <div>
        <label :for="input" class="sr-only">{{ label }}</label>
        <input :v-model="inputComputed" :id="input" :name="input" :type="inputType" :autocomplete="label" required
            class="relative block w-full appearance-none  border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:z-10 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 sm:text-sm"
            :class="[firstInput ? 'rounded-t-md' : '', lastInput ? 'rounded-b-md' : '']" :placeholder="placeholder" />
    </div>
    <span v-if="error" class="px-2 py-4 sm:text-xs text-red-400 border-none">
        {{ error }}
    </span>
</template>

<script setup>
import { defineProps, defineEmits, toRefs, computed } from 'vue';
const emit = defineEmits(['update:input']);
const props = defineProps({
    label: String,
    firstInput: { type: Boolean, default: false },
    lastInput: { type: Boolean, default: false },
    input: String,
    inputType: String,
    placeholder: { type: String, default: '' },
    error: String,
});

const { label, firstInput, lastInput, input, placeholder, error } = toRefs(props);
const inputComputed = computed({
    get: () => input.value,
    set: (val) => emit('update:input', val)
});

</script>