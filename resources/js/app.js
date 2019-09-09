/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.Swal = require('sweetalert2');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

import BootstrapVue from 'bootstrap-vue';
import { ValidationProvider, extend, ValidationObserver } from 'vee-validate';
import * as rules from 'vee-validate/dist/rules';
import es from 'vee-validate/dist/locale/es';

// Register it globally

for (let rule in rules) {
    extend(rule, {
      ...rules[rule],
      message: es.messages[rule]
    });
}

Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);

Vue.use(BootstrapVue);


Vue.component('servicios', require('./components/Servicios.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data :{
        menu : 0,
        reservar: 0
    }
});


