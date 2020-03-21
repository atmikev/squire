<template>
  <div>
      <a class="button is-primary" @click="createNewCampaign">Create Campaign</a>
    <CampaignListItem v-for="campaign in campaigns" :key="campaign.id" :campaign="campaign"/>
  </div>
</template>

<script>
import CampaignListItem from "./CampaignListItem.vue";

export default {
  components: {
    CampaignListItem
  },
  methods: {
      createNewCampaign: function() {
          this.$router.push("/campaigns/create")
      }
  },
  data() {
    return {
      campaigns: [
        {
          id: 0,
          name: "Campaign 0"
        },
        {
          id: 1,
          name: "Campaign 1"
        },
        {
          id: 2,
          name: "Campaign 2"
        }
      ]
    };
  }
};
</script>

<style lang="scss" scoped>
</style>