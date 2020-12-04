//import vue

import Vue from 'vue';
import Router from 'vue-router';
import myfirstcomponent from "./Component/pages/myfirstcomponent";
import mysecondcomponent from "./Component/pages/mysecondcomponent";
import hooks from "./Component/basics/hooks";
import methods from "./Component/basics/methods";
import home from "./Component/home";
import tag from "./admin/pages/tag";
import category from "./admin/pages/category";



Vue.use(Router)


const routes=[
    //projects  routes

    {
       path:'/',
        component:home
    },
    {
        path:'/tag',
        component:tag
    },
    {
        path:'/category',
        component:category
    },





    //tutorial routes
    {
        path:'/my-vue-router',
        component:myfirstcomponent
    },
    {
        path:'/second-route',
        component:  mysecondcomponent
    },
    {
        path:'/hooks',
        component: hooks
    },
    {
        path:'/methods',
        component: methods
    }
]

export default new Router({
    mode:'history',
    routes
})
