window.Vue = require('vue');

import Vue from 'vue';
import axios from 'axios';
import wysiwyg from "vue-wysiwyg";

Vue.prototype.$http = axios
Vue.use(wysiwyg, {
    image: {
        uploadURL: "/uploads",
        dropzoneOptions: {},
          hideModules: { "bold": true },

      },

}); // config is optional. more below



 require('./backend');


// new Vue({
//     router
// }).$mount('#app');


const app = new Vue({
    el: '#app',  
});