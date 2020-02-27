import './bootstrap';
import Vue from 'vue'; 

// Routes
import Routes from '@/js/routes.js';

// Main component
import App from '@/js/components/App';

const app = new Vue({
    el: '#app',
    router: Routes, 
    render: h => h(App),
});

export default app;
