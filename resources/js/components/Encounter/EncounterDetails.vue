<template>
  <div class="container is-full-height">
    <div class="modal" :class="{ 'is-active': initiativeModalIsVisible }">
      <div class="modal-background"></div>
      <AddInitiativeItem @add-item-to-initiative-list="addInitiativeItem"/>
    </div>

    <div class="container">
      <div class="columns">
        <div class="column is-one-fifth">
          <InitiativeList
            :items="items"
            @updated-character="updateDisplayedCharacter"
            @add-initiative-item="showAddInitiativeModal"
          />
        </div>
        <div class="column">
          <EncounterTurnDetails :character="detailsCharacter"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import EncounterTurnDetails from "./EncounterTurnDetails.vue";
import InitiativeList from "./InitiativeList.vue";
import AddInitiativeItem from "./AddInitiativeItem.vue";

export default {
  components: {
    EncounterTurnDetails,
    InitiativeList,
    AddInitiativeItem
  },

  methods: {
    showAddInitiativeModal: function() {
      this.initiativeModalIsVisible = true;
    },
    hideAddInitiativeModal: function() {
      this.initiativeModalIsVisible = false;
    },
    addInitiativeItem: function(character) {
      if (character) {
        this.items.push(character);
      }
      this.hideAddInitiativeModal();
    },
    updateDisplayedCharacter: function(character) {
      this.activeCharacter = character;
    }
  },
  computed: {
      detailsCharacter: function() {
          return this.activeCharacter ? this.activeCharacter : this.items[0];
      }
  },
  data() {
    return {
      initiativeModalIsVisible: false,
      activeCharacter: null,
      items: [
        {
          name: "Barric Liadon",
          currentHP: 44,
          armorClass: 12,
          image: ""
        },
        {
          name: "Vondal Bouldershoulder",
          currentHP: 14,
          armorClass: 12,
          image: ""
        },
        {
          name: "Gustav Van Klimpt",
          currentHP: 20,
          armorClass: 18,
          image: ""
        },
        {
          name: "James",
          currentHP: 20,
          armorClass: 13,
          image: ""
        },
        {
          name: "Brooz",
          currentHP: 20,
          armorClass: 13,
          image: ""
        },
        {
          name: "Geoff",
          currentHP: 20,
          armorClass: 17,
          image: ""
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
.is-full-height {
  height: 100vh;
}
</style>