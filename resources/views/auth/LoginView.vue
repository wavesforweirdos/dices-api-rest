<template>
  <div class="login">
    <div class="flex min-h-full w-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="w-full max-w-md space-y-8">
        <form class="mt-8 space-y-6" @submit.prevent="submit">
          <div class="-space-y-px shadow-sm">
            <p class="text-sm text-center text-gray-900 lg:text-right pb-3">You must be logged in to play</p>
            <div>
              <label for="email" class="sr-only">Email</label>
              <input v-model="user.email" id="email" name="email" type="email" required
                class="relative block w-full appearance-none  border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:z-10 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 sm:text-sm rounded-t-md"
                placeholder="Email address" />
            </div>
            <div>
              <label for="password" class="sr-only">Password</label>
              <input v-model="user.password" id="password" name="password" type="password" required
                class="relative block w-full appearance-none  border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:z-10 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 sm:text-sm rounded-b-md"
                placeholder="Password" />
            </div>
          </div>
          <span v-if="error" class="px-2 py-6 sm:text-xs text-red-400 border-none">
            {{ error }}
          </span>
          <div class="mt-4 flex flex-col gap-4 items-center justify-center lg:flex-row lg:justify-between">
            <p class="text-sm text-gray-900">
              Don't you have an account?
              <router-link to="register" class="text-emerald-500 no-underline hover:underline">
                Register
              </router-link>
            </p>
            <button type="submit" @click="login"
              class="group relative flex w-1/3 justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
  name: 'login',
  data() {
    return {
      error: '',
      user: {
        email: '',
        password: '',
      },
    };
  },
  methods: {
    login() {
      this.$axios.post('/login', this.user)
        .then((response) => {
          if (response.data.access_token) {
            localStorage.setItem('authToken', response.data.access_token);
            localStorage.setItem('idUser', response.data.user.id);
            axios.defaults.headers['Authorization'] = `Bearer  ${localStorage.getItem('authToken')}`;
            location.reload();
            this.$router.push('/index');
          } else {
            this.error = response.data.message
          }
        })
        .catch(error => {
          this.error = error.response.data.message;
        })
    }
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
