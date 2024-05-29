import axios from 'axios';
window.axios = axios;
import { createApp } from 'vue';

// Pagine
import GradesPage from './Page/GradesPage.vue';
import PresentsPage from './Page/PresentsPage.vue';
import DefaultPage from './Page/DefaultPage.vue';
import NotesPage from './Page/NotesPage.vue';
import JustificationsPage from './Page/JustificationsPage.vue';

// Componenti
import MenuClassesComponent from './components/menu/MenuClassesComponent.vue';
import MainComponent from './components/MainComponent.vue';
import MenuSections from './components/menu/MenuSections.vue';
import Calendar from './components/Calendar.vue';
import ButtonModal from './components/ButtonModal.vue';
import ModalManageAttendance from './components/ModalManageAttendance.vue';


const app = createApp({});

// Pagine
app.component('attendance-component', PresentsPage);
app.component('grades-component', GradesPage);
app.component('notes-component', NotesPage);
app.component('default-component', DefaultPage);
app.component('justification-component', JustificationsPage);

// Componenti
app.component('menu-classes-component', MenuClassesComponent);
app.component('main-component', MainComponent);
app.component('menu-sections', MenuSections);
app.component('calendar', Calendar);
app.component('button-modal', ButtonModal);
app.component('manage-attendance', ModalManageAttendance);


app.mount('#app');

