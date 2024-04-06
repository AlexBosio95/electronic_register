import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()

import axios from 'axios';
window.axios = axios;
import { createApp } from 'vue';
import GradesComponent from './components/GradesComponent.vue';
import MenuClassesComponent from './components/MenuClassesComponent.vue';

const app = createApp({});

app.component('grades-component', GradesComponent);
app.component('menu-classes-component', MenuClassesComponent);

app.mount('#app');

