import VueRouter from "vue-router";

import Vue from "vue";

Vue.use(VueRouter);

import App from "./components/views/App.vue"
import Login from "./components/views/Login.vue"
import Task from "./components/views/Task.vue"
import Persons from "./components/views/Persons.vue"
import Person from "./components/views/Person.vue"
import Graphs from "./components/views/Graphs"
import HelloPage from "./components/views/Hello.vue"
import Sprints from "./components/views/Sprints.vue"

const routes = [
    {
        path: "/",
        name: 'Hello',
        component: HelloPage
    },
    {
        path: "/tasks",
        name: 'tasks',
        component: App
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
    },
    {
        path: '/sprints',
        name: 'sprints',
        component: Sprints
    }

]

export default new VueRouter( {
    mode: "history",
    routes
}

)