<template>
  <div class="container">
    <div class="modal" :class="{ 'is-active': showModal }">
      <div class="modal-background"></div>
      <AddEncounterItem @close-modal="toggleModal" @save-item="addEncounterItem"/>
    </div>

    <div class="box">
      <div class="field">
        <label class="label">Name</label>
        <div class="control">
          <input class="input" type="text" v-bind="encounter.name">
        </div>
      </div>

      <div>
        <table class="table">
          <thead>
            <tr>
              <th></th>
              <th>Item</th>
              <th>Description</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in encounter.items" :key="item.name">
              <th></th>
              <td>{{item.name}}</td>
              <td>{{item.description}}</td>
            </tr>
            <tr>
              <th></th>
              <td>
                <a class="button is-secondary" @click="toggleModal">Add an Item</a>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div>
        <label class="label">Notes</label>
        <div class="control">
          <textarea class="textarea" v-bind="encounter.notes"/>
        </div>

        <a class="button is-primary" @click="saveEncounter">Save</a>
      </div>
    </div>
  </div>
</template>

<script>
import AddEncounterItem from "./AddEncounterItem.vue";
export default {
  components: {
    AddEncounterItem
  },
  methods: {
    saveEncounter: function() {
      alert("Fire off to API logic");
    },
    toggleModal: function() {
      this.showModal = !this.showModal;
    },
    addEncounterItem: function(item) {
      this.encounter.items.push(item);
      this.toggleModal();
    }
  },
  data() {
    return {
      encounter: {
        name: "",
        notes: "",
        items: new Array()
      },
      showModal: false
    };
  }
};
</script>

<style lang="scss" scoped>
</style>