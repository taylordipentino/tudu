import Vue from 'vue';
import VueRouter from 'vue-router';

import Home from '@/js/views/Home';
import AddTask from '@/js/views/AddTask';

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history', 
    routes: [
        {
            path: '/', 
            name: 'home', 
            component: Home, 
        }, 
        {
            path: '/add-task', 
            name: 'add-task', 
            component: AddTask, 
        }, 
    ], 
});

export default router;
