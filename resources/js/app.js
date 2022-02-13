import TogglReport from './components/TogglReport.vue';
require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue'
import CoolJs from "./components/CoolJs";

const app = createApp({});

app.component('toggl-report', TogglReport);
app.component('cool-js', CoolJs);

app.mount('#app');
