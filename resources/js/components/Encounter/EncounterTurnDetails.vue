<template>
  <div class="columns">
    <div class="column">
      <p class="heading is-capital">On the Clock</p>
      <CharacterCard :character="character"/>
    </div>
  </div>
</template>

<script>
import CharacterCard from "./CharacterCard.vue";

export default {
  components: {
    CharacterCard
  },
  props: {
    character: {
      type: Object,
      required: true,
      default: new Object()
    }
  }
};
</script>

<style lang="scss" scoped>
</style>