<template>
  <div class="register">
    <div class="flex min-h-full w-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="w-full max-w-md space-y-8">
        <form class="mt-8 space-y-6" @submit.prevent="submit">
          <div class="-space-y-px shadow-sm">
            <div>
              <label for="name" class="sr-only">Nickname</label>
              <input v-model="user.name" id="name" name="name" type="text"
                class="relative block w-full appearance-none  border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:z-10 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 sm:text-sm rounded-t-md"
                placeholder="Nickname" />
            </div>
            <div>
              <label for="email" class="sr-only">Email</label>
              <input v-model="user.email" id="email" name="email" type="email" required
                class="relative block w-full appearance-none  border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:z-10 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 sm:text-sm"
                placeholder="Email address" />
            </div>
            <div>
              <label for="password" class="sr-only">Password</label>
              <input v-model="user.password" id="password" name="password" type="password" required
                class="relative block w-full appearance-none  border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:z-10 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 sm:text-sm"
                placeholder="Password" />
            </div>
            <div>
              <label for="password_confirmation" class="sr-only">Password Confirmation</label>
              <input v-model="user.password_confirmation" id="password_confirmation" name="password_confirmation"
                type="password" required
                class="relative block w-full appearance-none  border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-300 focus:z-10 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500 sm:text-sm rounded-b-md"
                placeholder="Password Confirmation" />
            </div>
          </div>
          <span v-if="error" class="px-2 py-6 sm:text-xs text-red-400 border-none">
            {{ error }}
          </span>
          <div class="mt-4 flex flex-col gap-4 items-center justify-center lg:flex-row lg:justify-between">
            <p class="text-sm text-gray-900">
              Already, have an account?
              <router-link to="/" class="text-emerald-500 no-underline hover:underline">
                Login
              </router-link>
            </p>
            <button type="submit" @click="register"
              class="group relative flex w-1/3 justify-center rounded-md border border-transparent bg-emerald-600 py-2 px-4 text-sm font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2">
              Register
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      error: '',
      user: {
        name: '',
        email: '',
        password: '',
        password_confirmation: ''
      }
    };
  },
  name: 'register',
  methods: {
    register() {
      this.$axios.post('/players', this.user)
        .then(() => {
          this.$router.push('/login');
        })
        .catch(error => {
          this.error = error.response.data.message;
        })
    }
  }
}
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
