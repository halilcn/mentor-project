import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import Vuelidate from 'vuelidate'
import {errors} from "@/helpers/errors";
import {helper} from "@/helpers/helper";
import filters from "@/filters/index";
import moment from 'moment'


//Set Default Locale
moment.locale("tr");

//Import Global Errors
Vue.prototype.$errors = errors;
Vue.prototype.$helper = helper;
Vue.prototype.moment = moment

//Mixin
Vue.mixin({
    filters: filters
})

Vue.config.productionTip = false
Vue.use(Vuelidate);


//socketsocket
/*import Echo from 'laravel-echo'

window.io = require('socket.io-client');

export var echo_instance = new Echo({
    broadcaster: "socket.io",
    host: 'http://127.0.0.1:6001', //http://localhost:6001
    auth: {
        headers: {
            Authorization: "Bearer 67|opivFX92YmCpN8BBYx9zXwg7kWs4ytKSurbIHHns"
        }
    }
})

Vue.prototype.$echo = echo_instance;*/

new Vue({
    router,
    store,
    render: h => h(App)
}).$mount('#app')
