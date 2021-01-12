require('./bootstrap');

//load vue  to dom

window.Vue=require('vue')

Vue.component('mainapp',require('./Component/mainapp').default)

import VueProgressBar from 'vue-progressbar'

import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';
// import locale from 'element-ui/lib/locale/lang/en'

import locale from 'view-design/dist/locale/en-US';
Vue.use(ViewUI, { locale });

import router from "./router";
import store from "./store";
import common from "./common";
const options = {
    color: '#0099ff',
    failedColor: '#874b4b',
    thickness: '5px',
    transition: {
        speed: '0.2s',
        opacity: '0.6s',
        termination: 300
    },
    autoRevert: true,
    inverse: false
}

Vue.mixin(common)
Vue.use(ViewUI);
Vue.use(VueProgressBar, options)

const  app=new Vue({
    el:'#app',
    router,
    store
})
