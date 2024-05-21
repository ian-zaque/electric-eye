import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../Home/Home.vue'
import TypeSensorsPage from '../components/TypeSensors/TypeSensorsPage.vue'
import SensorsPage from '../components/Sensors/SensorsPage.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/sensors-types',
    name: 'Tipos de Sensores',
    component: TypeSensorsPage
  },
  {
    path: '/sensors',
    name: 'Sensores',
    component: SensorsPage
  },
]


export default new VueRouter({
  // mode: 'history',
  // base: process.env.BASE_URL,
  routes
})
