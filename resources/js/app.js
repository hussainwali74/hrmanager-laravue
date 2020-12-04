require('./bootstrap');

//load vue  to dom

window.Vue=require('vue')
//define component

Vue.component('mainapp',require('./Component/mainapp').default)
import router from "./router";
import common from "./common";
import VueProgressBar from 'vue-progressbar'

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




import ViewUI from 'view-design';
import 'view-design/dist/styles/iview.css';

Vue.mixin(common)

Vue.use(ViewUI);
Vue.use(VueProgressBar, options)



const  app=new Vue({
    el:'#app',
    router
})


