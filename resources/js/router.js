//import vue

import Vue from 'vue';
import Router from 'vue-router';
import vacations from "./admin/pages/vacations";
import employees from "./admin/pages/employees";
import login from "./admin/pages/login";



Vue.use(Router)


const routes=[
    {
        path:'/employees',
        component:employees
    },
    {
        path:'/vacations',
        component:vacations
    },
    {
        path:'/login',
        component:login
    },

]

export default new Router({
    mode:'history',
    routes
})
