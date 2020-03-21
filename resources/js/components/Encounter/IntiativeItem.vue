<template>
  
  <div class="box">
    <div>
      <div class="level">
        <div class="level-item">
          <figure class="image is-32x32">
            <img class="is-rounded" :src="characterImage">
          </figure>
        </div>

        <div class="level-item">
          <span class="is-size-7 name-label has-text-left">{{characterName}}</span>
        </div>
      </div>
    </div>

    <div>
      <div class="level">
        <div class="level-left">
          <div class="level-item">
            <div class="column is-size-7">{{armorClass}} AC</div>
          </div>
        </div>
        <div class="level-right">
          <div class="level-item">
            <div :show="currentHP" class="column is-size-7">{{currentHP}} HP</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    characterImage: function() {
      return this.image || "https://www.belr.com/wp-content/uploads/2017/06/avatar-placeholder-generic-1.jpg";
    }
  },
  props: {
    characterName: {
      type: String,
      required: true
    },
    currentHP: {
      type: Number,
      required: false
    },
    armorClass: {
      type: Number,
      required: false
    },
    image: {
      type: String,
      required: true,
      default: ""
    }
  }
};
</script>

<style lang="scss" scoped>

.name-label {
  word-wrap: default;
  margin: 4px;
}

</style>