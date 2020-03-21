<template>
  <div class="box" @click="clickedEncounter">
    <h3 class="subtitle">{{encounter.name}}</h3>
    <p>Location: {{encounter.location}}</p>
    <p>{{encounter.description}}</p>
  </div>
</template>

<script>
export default {
  props: {
    encounter: {
      type: Object,
      required: true,
      default: new Object()
    }
  },
  methods: {
      clickedEncounter() {
          this.$emit("clicked-encounter", this.encounter.id)
      }
  }
};
</script>

<style lang="scss" scoped>
</style>