
import { createWebHistory, createRouter } from "vue-router";

import Home from '@/pages/Home.vue';
import Dashboard from '@/pages/Dashboard.vue';
import ItemList from '@/pages/item/Index.vue';
import AddItem from '@/pages/item/Add.vue';
import EditItem from '@/pages/item/Edit.vue';
import Login from '@/pages/user/Login.vue';
import Register from '@/pages/user/Register.vue';

export const routes = [
    {
        name: 'home',
        path: '/',
        component: Home
    },
    {
        name: 'dashboard',
        path: '/dashboard',
        component: Dashboard
    },
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'register',
        path: '/register',
        component: Register
    },
    {
        name: 'items',
        path: '/items',
        component: ItemList
    },
    {
        name: 'additem',
        path: '/items/add',
        component: AddItem
    },
    {
        name: 'edititem',
        path: '/items/edit/:id',
        component: EditItem
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes: routes,
});

router.beforeEach((to, from, next) => {
    if (to.path !== '/login') {
        let token = localStorage.getItem('token')
        if (token == null) {
            next({
            path: '/login',
            params: { nextUrl: to.fullPath }
            })
        }
    }
    next()
});
  

export default router;