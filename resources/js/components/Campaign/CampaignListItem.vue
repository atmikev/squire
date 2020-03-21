<template>
  <div>
      <router-link :to="`/campaigns/${campaign.id}`">{{campaign.name}}</router-link>
  </div>
</template>

<script>
export default {
  props: {
    campaign: {
      type: Object,
      require: true,
      default: new Object()
    }
  }
};
</script>

<style lang="scss" scoped>
</style>