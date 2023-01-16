<script setup>
import { ref } from 'vue';
import TextInput from '../../js/components/TextInput.vue';

let name = ref('')
let email = ref('')
let password = ref('')
let password_confirmation = ref('')
</script>

<template>
  <div class="register">
    <div class="flex min-h-full w-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="w-full max-w-md space-y-8">
        <form class="mt-8 space-y-6" @submit.prevent="submit">
          <div class="-space-y-px shadow-sm">
            <TextInput label="name" :firstInput=1 :lastInput=0 placeholder="Name" v-model:input="name" inputType="text">
            </TextInput>
            <TextInput label="email" :firstInput=0 :lastInput=0 placeholder="Email address" v-model:input="email"
              inputType="text"></TextInput>
            <TextInput label="password" :firstInput=0 :lastInput=0 placeholder="Password" v-model:input="password"
              inputType="password"></TextInput>
            <TextInput label="password_confirmation" :firstInput=0 :lastInput=1 placeholder="Password confirmation"
              v-model:input="password_confirmation" inputType="password"></TextInput>
          </div>
          <div class="flex justify-center lg:justify-end mt-4">
            <button type="submit"
              class="group relative flex w-1/3 justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
              Sign up
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  name: 'Register',
  setup() {
    const router = useRouter();
    const validation = ref([]);

    const submit = async () => {
      await axios
        .post('/register', {
          name: name.value,
          email: email.value,
          password: password.value,
          password_confirmation: password_confirmation.value,
        })
        .then(() => {
          router.push({ path: '/login' });
        })
        .catch((error) => {
          validation.value = error.response.data;
        });
    };

    return {
      name,
      email,
      password,
      password_confirmation,
      submit,
      validation,
    };
  },
};
</script>
<style>
@media (min-width: 1024px) {
  .register {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
