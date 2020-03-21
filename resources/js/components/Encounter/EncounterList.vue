<template>
  <div>
    <EncounterListItem
      v-for="encounter in encounters"
      :encounter="encounter"
      :key="encounter.name"
      @clicked-encounter="clickedEncounter"
    />
  </div>
</template>

<script>
import EncounterListItem from "./EncounterListItem.vue";

export default {
  components: {
    EncounterListItem
  },
  methods: {
    clickedEncounter(encounterID) {
      this.$emit('view-encounter', encounterID);
    }
  },
  data() {
    return {
      encounters: [
        {
          id: 0,
          name: "Encounter 0",
          description:
            "The 0th encounter where the characters all get to learn about each other and stuff."
        },
        {
          id: 1,
          name: "Encounter 1",
          description:
            "The first encounter where all the crazy stuff starts happening"
        },
        {
          id: 2,
          name: "Encounter 2",
          description: "An impromptu battle maybe?"
        },
        {
          id: 3,
          name: "Encounter 3",
          description: "I'm running out of ideas..."
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
</style>