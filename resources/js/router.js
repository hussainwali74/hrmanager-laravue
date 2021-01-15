//import vue

import Vue from 'vue';
import Router from 'vue-router';
import employees from "./admin/pages/employees";
import login from "./admin/pages/login";
import passwordReset from "./admin/pages/passwordReset";
import vacationsList from './admin/pages/vacationsList';
import addVacation from './admin/pages/addVacation';
import Vacations from './admin/pages/vacations';
Vue.use(Router)


const routes = [
    // {
    //     path: '',
    //     redirect: '/myvacationslist'
    // },

    {
        path: '/employees',
        component: employees
    },
    {
        path: '/addvacation',
        component: addVacation,
    },
    // {
    //     path: '/myvacationslist',
    //     component: vacationsList
    // },
    {
        path: '/password-reset',
        component: passwordReset
    },
    {
        path: '/login',
        component: login
    },

]

export default new Router({
    mode: 'history',
    routes
})
