<template>
  <div class="box">
    <div class="level">
      <div class="level-item">
        <figure class="image is-64x64">
          <img class="is-rounded" :src="characterImage">
        </figure>
      </div>
    </div>
    <div class="level">
      <p class="level-item title is-3">{{character.name}}</p>
    </div>
    <div class="level is-mobile">
      <div class="level-item has-text-centered">
        <div>
          <p class="header">HP</p>
          <p class="title">{{character.currentHP}}</p>
        </div>
      </div>
      <div class="level-item has-text-centered">
        <div>
          <p class="header">AC</p>
          <p class="title">{{character.armorClass}}</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    character: {
      type: Object,
      required: true,
      default: null
    }
  },
  computed: {
    characterImage: function() {
      return this.character.image || "https://www.belr.com/wp-content/uploads/2017/06/avatar-placeholder-generic-1.jpg";
    }
  }
};
</script>

<style lang="scss" scoped>

</style>