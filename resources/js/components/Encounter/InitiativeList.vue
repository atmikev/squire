<template>
  <div>
    <div class="heading is-capital">Initiative</div>
    <div class="scrollable">
      <InitiativeItem
        v-for="item in dataItems"
        :key="item.name"
        :characterName="item.name"
        :armorClass="item.armorClass"
        :currentHP="item.currentHP"
        :image="item.image"
        :class="{selected: isSelected(item)}"
      />
    </div>
    <div>
      <a class="button is-fullwidth is-primary" @click="nextItem">Next Character</a>
      <a
        class="button is-fullwidth is-secondary"
        @click="$emit('add-initiative-item')"
      >Add Character</a>
    </div>
  </div>
</template>

<script>
import InitiativeItem from "./IntiativeItem.vue";

export default {
  props: {
    items: {
      type: Array,
      required: true,
      default: new Array()
    }
  },
  data() {
    return {
      dataItems: this.items,
      activeItemIndex: 0
    };
  },
  methods: {
    isSelected: function(item) {
      return item.name == this.dataItems[this.activeItemIndex].name;
    },
    nextItem: function() {
      this.activeItemIndex = (this.activeItemIndex + 1) % this.items.length;
      this.$emit('updated-character', this.items[this.activeItemIndex])
    }
  },
  components: {
    InitiativeItem
  }
};
</script>

<style lang="scss" scoped>
.scrollable {
  height: 90vh;
  overflow-y: auto;
  overflow-x: hidden;
  padding: 10px;
}

.selected {
  background-color: gray;
}

</style>