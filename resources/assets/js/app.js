/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue';
import VueRouter from 'vue-router';
import VueProgressBar from 'vue-progressbar';
import swal from 'sweetalert2'
import Gate from './Gate'

Vue.prototype.$gate = new Gate(window.user);

Vue.use(VueRouter);


require('./bootstrap');

window.swal = swal;
window.Vue = require('vue');

const toast = swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

window.toast = toast;

window.Fire = new Vue();

const options = {
    color: '#bffaf3',
    failedColor: '#874b4b',
    height: '5px'
};
Vue.use(VueProgressBar, options);

const routes = [
    {
        path: '/company/:id',
        component: require('./components/DetailCompany').default,
    },
    {
        path: '/dashboard',
        component: require('./components/DashBoard').default,
    },
    {
        path: '/profile',
        component: require('./components/Profile').default
    },
    {
        path: '/users',
        component: require('./components/User').default,
        name: 'users',
    },
    {
        path: '/jobs',
        component: require('./components/Job').default,
        name: 'jobs',
    },
    {
        path: '/companies',
        component: require('./components/Company').default,
        name: 'companies',
    },
    {
        path: '/developer',
        component: require('./components/Developer').default
    },
    {
        path: '*',
        component: require('./components/NotFound').default
    }
];


const router = new VueRouter({
    mode: 'history',
    routes
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('dashboard', require('./components/DashBoard.vue').default);
// Vue.component('profile', require('./components/Profile.vue').default);


Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue').default
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue').default
);

Vue.component(
    'not-found',
    require('./components/NotFound.vue').default
);
Vue.component(
    'detail',
    require('./components/Detail.vue').default
);
Vue.component(
    'introduce',
    require('./components/Introduce.vue').default
);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

export default new Vue({
    el: '#app',
    router,
    data: {
        search: ''
    },
    methods: {
        // greet: _.debounce(() => {
        //     console.log(this.$root);
        //     Fire.$emit('searching');
        // }, 1000),

        greet: function (event) {
            if (this.$root.$route.name !== 'users') {
                this.$root.$router.push({name: 'users'});
            }
            setTimeout(function () {
                Fire.$emit('searching');
            }, 1000);
        }
    }
});
