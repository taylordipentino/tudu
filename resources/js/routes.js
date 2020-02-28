import Vue from 'vue';
import VueRouter from 'vue-router';

import Dashboard from '@/js/views/Dashboard';
import AddTask from '@/js/views/AddTask';
import About from '@/js/views/About';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history', 
    routes: [
        {
            path: '/', 
            name: 'dashboard', 
            component: Dashboard, 
        }, 
        {
            path: '/add-task', 
            name: 'add-task', 
            component: AddTask, 
        }, 
        {
            path: '/about', 
            name: 'about', 
            component: About, 
        }, 
    ], 
});

export default router;
