/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import App from './AppUser.vue'
import VueRouter from 'vue-router'
import store from './store'
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import VueSidebarMenu from 'vue-sidebar-menu'
import Home from './components/Home/Home.vue'
import TypeSensorsPage from './components/TypeSensors/TypeSensorsPage.vue'
import SensorsPage from './components/Sensors/SensorsPage.vue'
import RegionsPage from './components/Regions/RegionsPage.vue'
import InterestZonesPage from './components/InterestZones/InterestZonePage.vue'

window.Vue = require('vue');

Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(IconsPlugin);
Vue.use(VueSidebarMenu)

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    hashbang: false,
    routes: [
        // { path: '/user/atividades', name: 'userAtividades', component: AtribuicoesTable, props: { hasFiltro: true } },
        // { path: '/:pathMatch(.*)', name: 'NotFound', component: Home },              // Redireciona NotFoundUrl para Home
        { path: '/',  name: 'home', alias: '/home', component: Home },
        { path: '/regions', name: 'Regiões', component: RegionsPage },
        { path: '/zones', name: 'Zonas de Interesse', component: InterestZonesPage },
        { path: '/sensors', name: 'Sensores', component: SensorsPage },
        { path: '/sensors-types', name: 'Tipos de Sensores', component: TypeSensorsPage },
    ]
})

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//App
Vue.component('app-user', require('./AppUser.vue').default);

// Sidebar
Vue.component("side-bar", require("./components/Sidebar/Sidebar.vue").default);
Vue.component("side-bar-link", require("./components/Sidebar/SidebarLink.vue").default);

// Notification
Vue.component("flash-notification", require("./components/Notification/FlashNotification.vue").default);
Vue.component("notification", require("./components/Notification/Notification.vue").default);

// EmptySpace
Vue.component("empty-space", require("./components/EmptySpace/EmptySpace.vue").default);

// TypeSensors
Vue.component("type-sensors-page", require("./components/TypeSensors/TypeSensorsPage.vue").default);
Vue.component("type-sensors-modal", require("./components/TypeSensors/TypeSensorsModal.vue").default);

// Sensors
Vue.component("sensors-page", require("./components/Sensors/SensorsPage.vue").default);
Vue.component("sensors-modal", require("./components/Sensors/SensorsModal.vue").default);

// Regions
Vue.component("regions-page", require("./components/Regions/RegionsPage.vue").default);
Vue.component("regions-modal", require("./components/Regions/RegionsModal.vue").default);

// InterestZone
Vue.component("interest-zones-page", require("./components/InterestZones/InterestZonePage.vue").default);
Vue.component("interest-zones-modal", require("./components/InterestZones/InterestZoneModal.vue").default);

const app = new Vue({
    router,
    store,
    el: '#app',
});
