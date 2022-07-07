import TogglReport from './components/TogglReport.vue';
require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

import { createApp } from 'vue'
import HackCheck from "./components/HackCheck";

const app = createApp({});

app.component('toggl-report', TogglReport);
app.component('hack-check', HackCheck);

app.mount('#app');
