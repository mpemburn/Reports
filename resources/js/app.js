import TogglReport from './components/TogglReport.vue';
require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue'

const app = createApp({});

app.component('toggl-report', TogglReport);

app.mount('#app');
