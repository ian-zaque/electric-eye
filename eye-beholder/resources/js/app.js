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
import VueSidebarMenu from 'vue-sidebar-menu'
import 'vue-sidebar-menu/dist/vue-sidebar-menu.css'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

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
        // { path: '/:pathMatch(.*)', name: 'NotFound', component: BoardColaborador }              // Redireciona NotFoundUrl para BoardColaborador
    ]
})

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//App
Vue.component('app-user', require('./AppUser.vue').default);

// Sidebar
Vue.component("side-bar", require("./components/Sidebar/Sidebar.vue").default);
Vue.component("side-bar-link", require("./components/Sidebar/SidebarLink.vue").default);

const app = new Vue({
    router,
    store,
    el: '#app',
});
