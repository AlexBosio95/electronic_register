<template>
   <div class="flex">
    <div class="w-60 bg-[#1F2937] flex flex-col items-center pt-5 pb-2 space-y-7 h-[720px]">
        <!-- menu items -->
        <div class="w-full pr-3 flex flex-col gap-y-1 text-gray-500 fill-gray-500 text-sm cursor-pointer">
            <calendar></calendar>
            <menu-classes-component :classes="classes" :user_role="user_role" :page="page" :sections="sections"></menu-classes-component>
            <div class="font-QuicksandMedium pl-4 text-gray-400/60 text-xs text-[11px] uppercase">Menu</div>
            <menu-sections :classes="classes" :user_role="user_role" :page="page" :sections="sections"></menu-sections>
        </div>
    </div>
    <!-- Componenti Vue -->
    <div class="relative flex-grow bg-[#1F2937] overflow-scroll border-l border-red-500">
        
    </div>
</div>

</template>

<script>
import Calendar from './Calendar.vue';
import MenuClassesComponent from './MenuClassesComponent.vue';
import MenuSections from './MenuSections.vue';
import PresentsComponent from './PresentsComponent.vue';


export default {
    components:{
        MenuClassesComponent,
        MenuSections,
        PresentsComponent,
        Calendar
    },
    props: {
        classes: {
            type: String,
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
            }
        }
    }
}
</script>