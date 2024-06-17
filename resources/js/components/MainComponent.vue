<template>
<div class="flex">
    <div class="w-60 bg-[#1F2937] flex flex-col items-center pt-5 pb-2 space-y-7 h-[720px]">
        <!-- menu items -->
        <div class="w-full pr-3 flex flex-col gap-y-1 text-gray-500 fill-gray-500 text-sm cursor-pointer">
            <calendar
                v-model="dateSelected"
                @date-selected="updateDateSelected">

            </calendar>
            <menu-classes-component 
                v-model="selectedClass" 
                @class-selected="updateSelectedClass" 
                :classes="classes" 
                :user_role="user_role" 
                :page="page" 
                :sections="sections">
            </menu-classes-component>
            <div class="font-QuicksandMedium pl-4 text-gray-400/60 text-xs text-[11px] uppercase">Menu</div>
            <menu-sections 
                :classes="classes" 
                :user_role="user_role" 
                :page="page" 
                :sections="sections">
            </menu-sections>
        </div>
    </div>
    <!-- Componenti Vue -->
    <div class="relative flex-grow bg-[#1F2937] overflow-scroll border-l border-red-500">
    <div class="py-5 px-10">
        <component 
            :is="getPageComponent().component" 
            v-bind="getPageComponent().props"
        />

        <PopUpComponent v-if="popUpShow"
            :message="message"
            :type="type"
        />
    </div>
</div>
</div>

</template>

<script>
import PopUpComponent from '../components/common/PopUpComponent.vue';
import Calendar from './menu/Calendar.vue';
import MenuClassesComponent from '../components/menu/MenuClassesComponent.vue';
import MenuSections from '../components/menu/MenuSections.vue';
import PresentsPage from '../page/PresentsPage.vue';
import DefaultPage from '../page/DefaultPage.vue';
import NotesPage from '../page/NotesPage.vue';
import GradesPage from '../page/GradesPage.vue';
import JustificationsPage from '../page/JustificationsPage.vue';


export default {
    components:{
        MenuClassesComponent,
        MenuSections,
        PresentsPage,
        Calendar,
        GradesPage,
        DefaultPage,
        NotesPage,
        JustificationsPage,
        PopUpComponent
    },
    props: {
        classes: {
            type: Object,
            required: true
        },
        user_role: {
            type: String,
            required: true
        },
        page: {
            type: String,
            required: true
        },
        sections: {
            type: Object,
            required: true
        },
        current_user: {
            type: Number
        }
    },
    data() {
        return {
            selectedClass: this.classes[0]['id'],
            studentsByClass: [],
            dateSelected: null,
            message: "",
            type: null,
            popUpShow: false
        }
    },
    methods:{
        getStudentsByClass(){
            const classParam = this.selectedClass ? `&class=${this.selectedClass}` : '';
            fetch(`/api/students?${classParam}`)
            .then(response => response.json())
            .then(data => {
                if(data.result){
                    this.studentsByClass = data.data;
                } else {
                    this.popUpShow = true;
                    this.message = data.message;;
                    this.type = "error";

                    setTimeout(() => {
                        this.popUpShow = false;
                    }, 3200);

                    setTimeout(() => {
                        this.getGrade();
                    }, 400);
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
                alert('Si è verificato un errore durante il recupero dei voti.');
            });
        },
        updateSelectedClass(selectedClass) {
            this.selectedClass = selectedClass.id;
        },
        updateDateSelected(dateSelected){
            this.dateSelected = dateSelected;
        },
        getPageComponent() {
        let component = null;
        let props = {};
        
        switch (this.page) {
            case 'Voti':
                component = 'GradesPage';
                props = {
                    students: this.studentsByClass,
                    classes: this.classes,
                    selectedDay: this.dateSelected,
                    current_user: this.current_user
                };
                break;
            case 'Presenze':
                component = 'PresentsPage';
                props = {
                    students: this.studentsByClass,
                    current_class: this.selectedClass,
                    current_date: this.dateSelected,
                    current_user: this.current_user
                };
                break;
            case 'Note':
                component = 'NotesPage';
                props = {
                    students: this.studentsByClass,
                    current_class: this.selectedClass,
                    selectedDay: this.dateSelected,
                    current_user: this.current_user
                };
                break;
            case 'Giustificazioni':
                component = 'JustificationsPage';
                props = {
                    students: this.studentsByClass,
                    current_class: this.selectedClass,
                    current_date: this.dateSelected,
                    current_user: this.current_user
                };
                break;
            default:
                component = 'DefaultPage';
                props = {};
                break;
        }
        
        return { component, props };
    }
    },
    watch:{
        selectedClass: 'getStudentsByClass'
    },
    beforeMount() {
        const months= ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        const currentDate = new Date();
        const currentDay= currentDate.getDate();
        const currentYear= currentDate.getFullYear();
        const currentMonth= currentDate.getMonth();
        this.dateSelected = `${currentDay} ${months[currentMonth]} ${currentYear}`;
    },
    mounted() {
        this.getStudentsByClass();
    }
}
</script>