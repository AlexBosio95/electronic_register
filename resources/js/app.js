import Alpine from 'alpinejs'
window.Alpine = Alpine
Alpine.start()
import axios from 'axios';
window.axios = axios;
import { createApp } from 'vue';

// Pagine
import GradesPage from './page/GradesPage.vue';
import PresentsPage from './page/PresentsPage.vue';
import DefaultPage from './page/DefaultPage.vue';
import NotesPage from './page/NotesPage.vue';
import JustificationsPage from './page/JustificationsPage.vue';
import PlanPage from './page/PlanPage.vue';

// Componenti
import MenuClassesComponent from './components/menu/MenuClassesComponent.vue';
import MainComponent from './components/MainComponent.vue';
import MenuSections from './components/menu/MenuSections.vue';
import Calendar from './components/menu/Calendar.vue';
import ButtonModal from './components/ButtonModal.vue';
import ModalManageAttendance from './components/ModalManageAttendance.vue';
import ModalManageTimetable from './components/ModalManageTimetable.vue';
import PopUpComponent from './components/common/PopUpComponent.vue'
import MenuMonths from './components/menu/MenuMonths.vue';
import ModalManageAbsences from './components/ModalManageAbsences.vue';

const app = createApp({});

// Pagine
app.component('attendance-component', PresentsPage);
app.component('grades-component', GradesPage);
app.component('notes-component', NotesPage);
app.component('default-component', DefaultPage);
app.component('justification-component', JustificationsPage);
app.component('plan-component', PlanPage);

// Componenti
app.component('menu-classes-component', MenuClassesComponent);
app.component('main-component', MainComponent);
app.component('menu-sections', MenuSections);
app.component('calendar', Calendar);
app.component('button-modal', ButtonModal);
app.component('manage-attendance', ModalManageAttendance);
app.component('popup-component', PopUpComponent);
app.component('menu-months', MenuMonths);
app.component('modal-absences', ModalManageAbsences);
app.component('modal-manage-timetable', ModalManageTimetable);

app.mount('#app');

