<template>
  <!-- This example requires Tailwind CSS v2.0+ -->
  <div class="px-4 sm:px-6 lg:px-8 sm:pt-8">
    <div class="sm:flex sm:items-center">
      <div class="sm:flex-auto text-center lg:text-left">
        <h1 class="text-xl font-semibold text-emerald-900">Ranking</h1>
        <p class="mt-2 text-sm text-gray-700">The ranking of succed</p>
      </div>
    </div>
    <!-- The table component -->
    <Table :fields='fields' :tableData="players"></Table>
  </div>
</template>

<script>

import axios from "axios";
import { isProxy, toRaw } from 'vue';
import { defineComponent, ref } from 'vue'
import Table from '../../js/components/TableRanking.vue'

export default defineComponent({
  components: {
    Table
  },
  data() {
    return {
      players: [],
      loading: true,
      fields: ['Player', 'Victories', 'Games', 'Success']
    };
  },
  async mounted() {
    axios.get('/players/ranking')
      .then((res) => {
        this.players = res.data.ranking
        if (isProxy(this.players)) {
          this.players = toRaw(this.players)
        }
        this.loading = false
      }).catch(err => {
        this.players = []
      })
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

#Success {
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

#Success>#rate {
  display: block
}
</style>
