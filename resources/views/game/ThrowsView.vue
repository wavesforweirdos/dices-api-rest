<template>
  <!-- This example requires Tailwind CSS v2.0+ -->
  <div id="stats">
    <div class="px-4 sm:px-6 lg:px-8 sm:pt-8">
      <div class="sm:flex sm:items-center">
        <div class="sm:flex-auto text-center lg:text-left">
          <h1 class="text-xl font-semibold text-emerald-900">My throws</h1>
          <p class="mt-2 text-sm text-gray-700">Last throws order by date</p>
        </div>
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
          <button @click="deleteData"
            class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">Delete
            data</button>
        </div>
      </div>
      <!-- The table component -->
      <Table :fields='fields' :tableData="games"></Table>
    </div>
  </div>
</template>

<script>

import axios from "axios";
import { isProxy, toRaw } from 'vue';
import { defineComponent, ref } from 'vue'
import Table from '../../js/components/TableThrows.vue'

export default defineComponent({
  components: {
    Table
  },
  data() {
    return {
      idUser: localStorage.getItem('idUser'),
      games: [],
      loading: true,
      fields: ['created_at', 'dice1', 'dice2', 'result']
    };
  },
  methods: {
    getData() {
      axios.get('/players/' + this.idUser + '/games')
        .then((res) => {
          this.games = res.data.games
          if (isProxy(this.games)) {
            this.games = toRaw(this.games)
          }
          this.loading = false
        }).catch(err => {
          this.games = []
        })
    },
    deleteData() {
      axios.delete('/players/' + this.idUser + '/games')
        .then(
          this.$router.push('/game')
        )
        .catch(err => { console.error(err) })
    }
  },
  mounted() {
    this.getData();
  }
});
</script>

<style>
i {
  font-size: 1rem !important;
}

#Player {
  font-weight: 500;
  color: rgb(17 24 39);
}

#result {
  display: inline-flex;
  border-radius: 9999px;
  background-color: rgb(209 250 229);
  padding-left: 0.5rem;
  /* 8px */
  padding-right: 0.5rem;
  /* 8px */
  font-size: 0.75rem;
  /* 12px */
  line-height: 1rem;
  /* 16px */
  font-weight: 600;
  line-height: 1.5rem;
  /* 24px */
  color: rgb(6 95 70);
}

#result>#winGame {
  display: block
}
</style>
