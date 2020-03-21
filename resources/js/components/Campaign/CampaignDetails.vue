<template>
  <div class="container">
    <div class="level">
      <div class="level-left">
        <h1 class="title level-item">Campaign {{campaignID}}</h1>
      </div>
      <div class="level-right">
        <a class="button is-primary level-item" @click="createEncounter">Add Encounter</a>
      </div>
    </div>
    
    <EncounterList @view-encounter="viewEncounter"/>

  </div>
</template>

<script>
import EncounterList from "../Encounter/EncounterList.vue";

export default {
  methods: {
    createEncounter() {
      this.$router.push(`/campaigns/${this.campaignID}/encounters/create`);
    },
    viewEncounter(encounterID) {
      this.$router.push(`/campaigns/${this.campaignID}/encounters/${encounterID}`);
    }
  },
  computed: {
    campaignID: function() {
      return this.$route.params.id;
    }
  },
  components: {
    EncounterList
  }
};
</script>

<style lang="scss" scoped>
</style>