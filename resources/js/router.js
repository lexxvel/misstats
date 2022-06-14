import VueRouter from "vue-router";

import Vue from "vue";

Vue.use(VueRouter);

import App from "./components/views/App.vue"
import Login from "./components/views/Login.vue"
import Register from "./components/views/Register.vue"
import Task from "./components/views/Task.vue"
import Basket from "./components/views/Basket.vue"
import Orders from "./components/views/Orders.vue"
import Persons from "./components/views/Persons.vue"
import Person from "./components/views/Person.vue"
import Graphs from "./components/views/Graphs"

const routes = [
    {
        path: "/",
        name: 'mane',
        component: App
    },
    {
        path: "/register",
        name: 'register',
        component: Register      
    },
    {
        path: "/login",
        name: 'login',
        component: Login
    },
    {
        path: '/task/:id',
        name: 'task',
        component: Task
    },
    {
        path: '/basket',
        name: 'basket',
        component: Basket
    }, 
    {
        path: '/orders',
        name: 'orders',
        component: Orders
    },
    {
        path: '/persons',
        name: 'persons',
        component: Persons
    },
    {
        path: '/person/:id',
        name: 'person',
        component: Person
    },
    {
        path: '/graphs',
        name: 'graphs',
        component: Graphs
    }

]

export default new VueRouter( {
    mode: "history",
    routes
}

)