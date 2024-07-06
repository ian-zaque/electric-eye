import Vue from 'vue'
import Vuex from 'vuex'
import typeSensors from '../components/TypeSensors/store/index.js'
import sensors from '../components/Sensors/store/index.js'
import regions from '../components/Regions/store/index.js'
import notifications from '../components/Notification/store/index.js'

Vue.use(Vuex)

export default new Vuex.Store({
  modules: {
    typeSensors,
    sensors,
    regions,
    notifications,
  },

  actions: {
    dispatchNotification({dispatch}, payload) {
      dispatch('notifications/notificationStoreCommit', payload)
    },
  }
})
