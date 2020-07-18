import './bootstrap';
import Vue from 'vue'; 

// Routes
import Routes from '@/js/routes.js';

// Main component
import App from '@/js/components/App';

// Reserve the app variable for export
var app;

// Only create the Vue instance if the root element exists
if (document.getElementById('app') !== null) {
    app = new Vue({
        el: '#app',
        router: Routes, 
        render: h => h(App),
    });
}

export default app;
