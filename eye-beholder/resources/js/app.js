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
import 'vue-multiselect/dist/vue-multiselect.min.css'
import Multiselect from 'vue-multiselect';
import * as Leaflet from 'leaflet';
import 'element-ui/lib/theme-chalk/index.css';
import lang from 'element-ui/lib/locale/lang/pt-br'
import locale from 'element-ui/lib/locale'

import VueSidebarMenu from 'vue-sidebar-menu'
import Home from './components/Home/Home.vue'
import TypeSensorsPage from './components/TypeSensors/TypeSensorsPage.vue'
import SensorsPage from './components/Sensors/SensorsPage.vue'
import RegionsPage from './components/Regions/RegionsPage.vue'
import InterestZonesPage from './components/InterestZones/InterestZonePage.vue'
import UdePage from './components/UDE/UdePage.vue'
import UdeClassPage from './components/UdeClasses/UdeClassPage.vue'
import EmergenciesPage from './components/Emergencies/EmergenciesPage.vue';
import MqttPage from './components/MQTT/MqttPage.vue';
import EventsPage from './components/Events/EventsPage.vue';
import EventsReport from './components/Reports/EventsReport.vue';
import Vue from 'vue';

window.Vue = require('vue');

locale.use(lang)

Vue.use(BootstrapVue);
Vue.use(VueRouter);
Vue.use(IconsPlugin);
Vue.use(VueSidebarMenu)
Vue.use(Leaflet)

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
        { path: '/udes', name: 'UDEs', component: UdePage },
        { path: '/ude-classes', name: 'Classes de UDEs', component: UdeClassPage },
        { path: '/emergency', name: 'Emergências', component: EmergenciesPage },
        { path: '/mqtt', name: 'MQTT', component: MqttPage },
        { path: '/events', name: 'Eventos', component: EventsPage },
        { path: '/reports', name: 'Relatórios', component: EventsReport },
    ]
})

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//App
Vue.component('app-user', require('./AppUser.vue').default);

// Multiselect
Vue.component("multiselect", Multiselect);

// Vue.component("el-datetime-picker", DateTimePicker);

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

// UDE
Vue.component("udes-page", require("./components/UDE/UdePage.vue").default);
Vue.component("udes-modal", require("./components/UDE/UdeModal.vue").default);

// UDE CLASS
Vue.component("ude-classes-page", require("./components/UdeClasses/UdeClassPage.vue").default);
Vue.component("ude-classes-modal", require("./components/UdeClasses/UdeClassModal.vue").default);

// EMERGENCIES
Vue.component("emergencies-page", require("./components/Emergencies/EmergenciesPage.vue").default);
Vue.component("emergencies-modal", require("./components/Emergencies/EmergenciesModal.vue").default);

// MQTT Topic
Vue.component("mqtt-page", require("./components/MQTT/MqttPage.vue").default);
Vue.component("mqtt-modal", require("./components/MQTT/MqttModal.vue").default);

// Eventos
Vue.component("events-page", require("./components/Events/EventsPage.vue").default);

// Relatórios
Vue.component("events-report", require("./components/Reports/EventsReport.vue").default);

// Charts
Vue.component("events-by-region-bar-chart", require("./components/Reports/charts/EventsByRegionBarChart.vue").default);
Vue.component("events-by-hour-line-chart", require("./components/Reports/charts/EventsByHourLineChart.vue").default);
Vue.component("events-by-date-bar-chart", require("./components/Reports/charts/EventByDateBarChart.vue").default);
Vue.component("events-by-emergency-bar-chart", require("./components/Reports/charts/EventsByEmergencyBarChart.vue").default);

const app = new Vue({
    router,
    store,
    el: '#app',
});
