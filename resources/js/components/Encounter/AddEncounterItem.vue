<template>
  <div class="modal-card">
    <header class="modal-card-head">
      <p class="modal-card-title">Add Item</p>
      <button class="delete" aria-label="close" @click="closeModal"/>
    </header>
    <section class="modal-card-body">
        <div class="field">
            <label class="label">Name</label>
            <div class="control">
                <input class="input" type="text" v-model="encounterItem.name">
            </div>
        </div>
        <div class="field">
            <label class="label">Description</label>
            <div class="control">
                <textarea class="textarea" v-model="encounterItem.description"></textarea>
            </div>
        </div>
    </section>
    <footer class="modal-card-foot">
      <button class="button is-success" @click="saveItem">Add Item</button>
      <button class="button" @click="closeModal">Cancel</button>
    </footer>
  </div>
</template>

<script>
import _ from 'lodash'

export default {
    methods: {
        closeModal: function() {
            this.$emit('close-modal');
        },
        saveItem: function() {
            const item = _.cloneDeep(this.encounterItem);
            this.$emit('save-item', item);

            this.encounterItem.name = "";
            this.encounterItem.description = "";        
        }
    },
    data() {
        return {
            encounterItem: {
                name: "",
                description: ""
            }
        };
    }
};
</script>

<style lang="scss" scoped>
</style>