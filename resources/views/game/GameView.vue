      
<script setup>
import RouterLinkButton from "../../js/components/RouterLinkButton.vue";
</script>

<template>
  <div id="game">
    <div class="flex min-h-full w-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <div class="w-full max-w-md space-y-8">
        <div class="m-auto p-5 text-center flex flex-col items-center justify-center gap-6">
          <div class="flex flex-row justify-center mb-4 gap-8">
            <img class="h-28" src="../../assets/faceDice/d2.svg" id="dice1">
            <img class="h-28" src="../../assets/faceDice/d5.svg" id="dice2">
          </div>
          <RouterLinkButton btnText="Roll dices" color="emerald" url="/players/:id/games/"></RouterLinkButton>
        </div>
      </div>
    </div>
  </div>
</template>