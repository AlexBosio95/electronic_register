<template>
<div class="flex">
    <div class="w-60 bg-[#1F2937] flex flex-col items-center pt-5 pb-2 space-y-7 h-[720px]">
        <!-- menu items -->
        <div class="w-full pr-3 flex flex-col gap-y-1 text-gray-500 fill-gray-500 text-sm cursor-pointer">
            <calendar
                v-model="dateSelected"
                @date-selected="updateDateSelected"
            >

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
    <div v-if="page == 'Voti' " class="relative flex-grow bg-[#1F2937] overflow-scroll border-l border-red-500">
        <div class="py-5 px-10">
            <GradesComponent 
                :students="studentsByClass" 
                :classes="classes"
                :selectedDay="dateSelected"
            />
        </div>
    </div>
    <div v-else-if="page == 'Presenze' " class="relative flex-grow bg-[#1F2937] overflow-scroll border-l border-red-500">
        <div class="py-5 px-10">
            <attendance-component :students="studentsByClass" :current_class="selectedClass" :current_date="dateSelected"/>
        </div>
    </div>
</div>

</template>

<script>
import Calendar from './Calendar.vue';
import GradesComponent from './GradesComponent.vue';
import MenuClassesComponent from './MenuClassesComponent.vue';
import MenuSections from './MenuSections.vue';
import PresentsComponent from './PresentsComponent.vue';


export default {
    components:{
        MenuClassesComponent,
        MenuSections,
        PresentsComponent,
        Calendar,
        GradesComponent
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
        }
    },
    data() {
        return {
            sections: {
                dashboard: {
                    section_name: 'Presenze',
                    route_name: 'dashboard',
                    visibility: {
                        teacher: ['get', 'put', 'post', 'delete'],
                        student: ['get']
                    }
                },
                marks: {
                    section_name: 'Voti',
                    route_name: 'marks',
                    visibility: {
                        teacher: ['get', 'put', 'post', 'delete'],
                        student: ['get']
                    }
                },
                notes: {
                    section_name: 'Note disciplinari',
                    route_name: 'notes',
                    visibility: {
                        teacher: ['get', 'put', 'post', 'delete'],
                        student: ['get']
                    }
                },
                justifications: {
                    section_name: 'Giustificazioni/Assenze',
                    route_name: 'justifications',
                    visibility: {
                        teacher: ['get', 'put', 'post', 'delete'],
                        student: ['get']
                    }
                },
                plan: {
                    section_name: 'Registro Professori',
                    route_name: 'plan',
                    visibility: {
                        teacher: ['get', 'put', 'post', 'delete'],
                        student: ['get']
                    }
                },
                teachers: {
                    section_name: 'Professori',
                    route_name: 'teachers',
                    visibility: {}
                },
                students: {
                    section_name: 'Studenti',
                    route_name: 'students',
                    visibility: {}
                },
                classes: {
                    section_name: 'Classi',
                    route_name: 'classes',
                    visibility: {}
                },
                subjects: {
                    section_name: 'Materie',
                    route_name: 'subjects',
                    visibility: {}
                },
                timetable: {
                    section_name: 'Orario',
                    route_name: 'timetable',
                    visibility: {
                        teacher: ['get'],
                        student: ['get']
                    }
                }
            },
            selectedClass: this.classes[0]['id'],
            studentsByClass: [],
            dateSelected: null
        }
    },
    methods:{
        getStudentsByClass(){
            const classParam = this.selectedClass ? `&class=${this.selectedClass}` : '';
            fetch(`/api/students?${classParam}`)
            .then(response => response.json())
            .then(data => {
                this.studentsByClass = data;
                //console.log(data);
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
        //this.getStudentsByClass();
    },
    mounted() {
        this.getStudentsByClass();
    }
}
</script>