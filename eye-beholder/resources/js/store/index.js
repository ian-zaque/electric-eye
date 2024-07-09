import Vue from 'vue'
import Vuex from 'vuex'
import notifications from '../components/Notification/store/index.js'
import typeSensors from '../components/TypeSensors/store/index.js'
import sensors from '../components/Sensors/store/index.js'
import regions from '../components/Regions/store/index.js'
import interestZones from '../components/InterestZones/store/index.js'
import udes from '../components/UDE/store/index.js'
import udeClasses from '../components/UdeClasses/store/index.js'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    typeSensors,
    sensors,
    regions,
    notifications,
    interestZones,
    udes,
    udeClasses,
  },

  actions: {
    dispatchNotification({dispatch}, payload) {
      dispatch('notifications/notificationStoreCommit', payload)
    },
  }
})
