<template>
    
    <PopUpComponent v-if="popUpShow"
            :message="current_error"
            :type="type"
        />

        <div v-else-if="students.length > 0 && mostraTable === true">
        <div class="container mx-auto p-4">
            <!-- Griglia -->
            <div class="overflow-x-auto bg-gray-100 rounded-lg shadow-md p-4">
                <table id="timeTable" class="table-auto w-full">
                    <!-- Intestazione delle colonne -->
                    <thead>
                        <th class="px-4 py-2"></th> 
                            <th v-for="day in days" :key="day" class="px-4 py-2">
                                {{ day }}
                            </th> 
                    </thead>

                    <!-- Righe per gli studenti -->
                    <tbody>

                        <tr v-for="(entries, timeStart) in timetable" :key="timeStart">
                            <td class="px-4 py-2 border">{{ timeStart }}</td>

                            <td v-for="entry in entries" :key="entry.day_of_week" class="px-4 py-2 border text-center">
                                <!--{{ entry.subject_name }} <br> {{ entry.teacher_name }} -->
                                <button @click="openModal(entry)"> 
                                    {{ entry.subject_name }} <br> {{ entry.teacher_name }}
                                </button>
                            </td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>    
    </div>


    <modal-manage-timetable v-if="selectedSubject != null && selectedTeacher != null" 
        :subject="selectedSubject" 
        :teacher="selectedTeacher"
        :teachers="teachers"
        :idToModify="idToModify"
        @closeModal="closeAll"
        @updateCalendar="updateCalendar"
        >
    </modal-manage-timetable>

</template>

<script>

import PopUpComponent from '../components/common/PopUpComponent.vue';
import ModalManageTimetable from '../components/ModalManageTimetable.vue';
export default {
    components:{
        PopUpComponent,
        ModalManageTimetable
    },
    props: {
        students: {
            type: Array,
            default: () => []
        },
        current_class: {
            type: Number
        },
        current_date: {
            type: String
        },
        current_user: {
            type: Number
        }
    },
    data() {
        return {
            current_error: "",
            type: "error",
            popUpShow: false,
            timetable: [],
            days: [],
            mostraTable: true,
            selectedSubject: null,
            selectedTeacher: null,
            teachers: null
        };
    },
    methods: {
        searchTimetable(){

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            

            fetch(`/api/getTimetableByClass/${this.current_class}`,
                {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                }   
            )
            .then(response => response.json())
            .then(data => {
                if(data.result){
                    this.timetable = data.data.timetable;
                    this.days = data.data.days;
                } else {
                    this.popUpShow = true;
                    this.message = data.message;;
                    this.type = "error";

                    setTimeout(() => {
                        this.popUpShow = false;
                    }, 3200);
                }
            })
           

        },

        openModal(entry){
            this.selectedTeacher = entry.teacher_name;
            this.selectedSubject = entry.subject_name;
            this.idToModify = entry.id;
            this.seacherTeachersByClass();
        },
        closeAll(){
            this.selectedTeacher = null;
            this.selectedSubject = null;
            this.teachers = null;
        },
        seacherTeachersByClass(){

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(`/api/getTeacherPerClass/${this.current_class}`,
                {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                }   
            )
            .then(response => response.json())
            .then(data => {
                if (data.result){
                    this.teachers = data.data;
                } else {
                    this.popUpShow = true;
                    this.message = data.message;;
                    this.type = "error";

                    setTimeout(() => {
                        this.popUpShow = false;
                    }, 3200);
                }
            })

        },
        updateCalendar(){
            this.searchTimetable();
            this.closeAll();
        }

    },
    mounted(){
        this.searchTimetable();
    },
    watch: {
        current_class(){
            this.searchTimetable();
        }
    }
}
</script>

<style>

</style>