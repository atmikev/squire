import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './App.vue'
import CampaignList from './components/Campaign/CampaignList.vue'
import CampaignDetails from './components/Campaign/CampaignDetails.vue'
import CreateCampaign from './components/Campaign/CreateCampaign.vue'
import CreateEncounter from './components/Encounter/CreateEncounter.vue'
import EncounterDetails from './components/Encounter/EncounterDetails.vue'

Vue.config.productionTip = false
Vue.use(VueRouter)

const routes = [
  {
    path: '/encounters',
    component: EncounterDetails
  },
  {
    path: '/campaigns',
    component: CampaignList
  },
  {
    path: '/campaigns/create',
    component: CreateCampaign
  },
  {
    path: '/campaigns/:id(\\d+)',
    component: CampaignDetails
  },
  {
    path: '/campaigns/:id(\\d+)/encounters/create',
    component: CreateEncounter
  },
  {
    path: '/campaigns/:campaignID(\\d+)/encounters/:encounterID(\\d+)',
    component: EncounterDetails
  }
]

const router = new VueRouter({
  routes
})

new Vue({
  render: h => h(App),
  router
}).$mount('#app')
