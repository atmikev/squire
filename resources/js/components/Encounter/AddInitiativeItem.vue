<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Add Character</p>
      <button class="delete" aria-label="close" @click="$emit('add-item-to-initiative-list')"></button>
    </header>
    <section class="modal-card-body">
      <div class="level">
        <div class="level-item">
          <label>Name</label>
          <input v-model="initiativeItem.name" placeholder="Name">
        </div>
      </div>
      <div class="level">
        <div class="level-item">
          <label>Current HP</label>
          <input v-model="initiativeItem.currentHP" placeholder="Current HP">
        </div>
      </div>
      <div class="level">
        <div class="level-item">
          <label>Armour Class</label>
          <input v-model="initiativeItem.armorClass" placeholder="AC">
        </div>
      </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success" @click="createNewItem">Save</button>
      <button class="button" @click="$emit('add-item-to-initiative-list')">Cancel</button>
    </footer>
  </div>
</template>

<script>
import _ from "lodash";

export default {
  data() {
    return {
      initiativeItem: {
        name: "",
        currentHP: 0,
        armorClass: 0
      }
    };
  },
  methods: {
    createNewItem: function() {
      const newItem = _.cloneDeep(this.initiativeItem);
      this.$emit("add-item-to-initiative-list", newItem);
    }
  }
};
</script>

<style lang="scss" scoped>
</style>