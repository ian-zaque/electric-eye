import Vue from 'vue'
import VueRouter from 'vue-router'
// import HomeView from '../views/HomeView.vue'
// import TypeSensorsPage from '../components/TypeSensors/TypeSensorsPage.vue'
// import SensorsPage from '../components/Sensors/SensorsPage.vue'

Vue.use(VueRouter)

const routes = [
//   {
//     path: '/',
//     name: 'home',
//     component: HomeView
//   },
//   {
//     path: '/sensors-types',
//     name: 'Tipos de Sensores',
//     component: TypeSensorsPage
//   },
//   {
//     path: '/sensors',
//     name: 'Sensores',
//     component: SensorsPage
//   },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

export default router
