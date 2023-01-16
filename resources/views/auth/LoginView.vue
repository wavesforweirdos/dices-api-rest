
<script setup>
import { ref } from 'vue';
import TextInput from '../../js/components/TextInput.vue';

let email = ref('')
let password = ref('')
</script>
<template>
  <div class="login">
    <div class="flex min-h-full w-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="w-full max-w-md space-y-8">
        <form class="mt-8 space-y-6" @submit.prevent="submit">
          <div class="-space-y-px shadow-sm">
            <TextInput label="email" :firstInput=1 :lastInput=0 placeholder="Email address" v-model:input="email"
              inputType="text"></TextInput>
            <TextInput label="password" :firstInput=0 :lastInput=1 placeholder="Password" v-model:input="password"
              inputType="password"></TextInput>
          </div>
          <div class="flex justify-center lg:justify-end mt-4">
            <button type="submit"
              class="group relative flex w-1/3 justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
              Log in
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
  name: 'Login',
  setup() {
    const router = useRouter();

    const submit = async () => {
      const response = await axios.post('/login', {
        email: email.value,
        password: password.value,
      });
      localStorage.setItem('token', response.data.token);
      await router.push({ path: '/' });
    };

    return {
      email,
      password,
      submit,
    };
  },
};
</script>

<style>
@media (min-width: 1024px) {
  .login {
    min-height: 100vh;
    display: flex;
    align-items: center;
  }
}
</style>
