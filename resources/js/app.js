import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

import axios from 'axios';
window.axios = axios;
import { createApp } from 'vue';
import GradesComponent from './components/GradesComponent.vue';
import MenuClassesComponent from './components/MenuClassesComponent.vue';
import MainComponent from './components/MainComponent.vue';
import MenuSections from './components/MenuSections.vue';
import PresentsComponent from './components/PresentsComponent';

const app = createApp({});

app.component('grades-component', GradesComponent);
app.component('menu-classes-component', MenuClassesComponent);
app.component('main-component', MainComponent);
app.component('menu-sections', MenuSections);

app.mount('#app');

