import axios from 'axios';
window.axios = axios;
import { createApp } from 'vue';
import GradesComponent from './components/GradesComponent.vue';
import MenuClassesComponent from './components/MenuClassesComponent.vue';
import MainComponent from './components/MainComponent.vue';
import MenuSections from './components/MenuSections.vue';
import PresentsComponent from './components/PresentsComponent.vue';
import Calendar from './components/Calendar.vue';
import ButtonModal from './components/ButtonModal.vue';
import ModalManageAttendance from './components/ModalManageAttendance.vue';
import DefaultComponent from './components/DefaultComponent.vue';

const app = createApp({});

app.component('grades-component', GradesComponent);
app.component('menu-classes-component', MenuClassesComponent);
app.component('main-component', MainComponent);
app.component('menu-sections', MenuSections);
app.component('attendance-component', PresentsComponent);
app.component('calendar', Calendar);
app.component('button-modal', ButtonModal);
app.component('manage-attendance', ModalManageAttendance);
app.component('default-component', DefaultComponent);

app.mount('#app');

