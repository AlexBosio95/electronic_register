import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()


import { createApp } from 'vue';
import GradesComponent from './components/GradesComponent.vue';

const app = createApp({});

app.component('grades-component', GradesComponent);

app.mount('#app');
