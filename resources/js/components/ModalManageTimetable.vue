<template>
    


    <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="bg-white p-8 rounded-lg z-50 shadow-md max-w-sm mx-auto relative">
                <!-- Pulsante di chiusura del modal -->
                <button @click="this.$emit('closeModal')" class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <!-- Contenuto del modal -->
                <h2 class="text-lg font-semibold mb-4">Modifica l'orario</h2>
                
                <div class="bg-white p-8 rounded-lg z-50 shadow-lg max-w-sm mx-auto relative">
                    <div class="flex justify-between items-center space-x-6">
                        <!-- Pulsante del docente -->
                        <div class="relative w-1/2">
                            <button
                                v-if="teacher_name != null"
                                @click="isOpenTeacher = !isOpenTeacher"
                                class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow-sm text-center font-semibold hover:bg-gray-200 transition duration-300 ease-in-out"
                            >
                                {{ teacher_name || 'Seleziona Docente' }}
                            </button>
                            <div v-if="isOpenTeacher && teachers != null" class="absolute z-50 mt-2 w-full rounded-lg shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                                <div class="py-2 max-h-60 overflow-y-auto">
                                <!-- Lista dei docenti -->
                                    <div class="divide-y divide-gray-200">
                                        <button
                                        v-for="current_teacher in teachers"
                                        :key="current_teacher.id"
                                        @click="showTeacherSubjects(current_teacher.id, current_teacher.name)"
                                        :class="{
                                            'bg-blue-500 text-white font-semibold': current_teacher.name === teacher, 
                                            'text-gray-700 hover:bg-blue-100 hover:text-blue-800': current_teacher.name !== teacher
                                        }"
                                        :disabled="current_teacher.name === teacher"
                                        class="block w-full px-4 py-2 text-sm font-medium transition duration-200 ease-in-out"
                                        >
                                        {{ current_teacher.name }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pulsante della materia -->
                        <div class="relative w-1/2">
                        <button
                            v-if="subject_name != null"
                            @click="isOpenSubject = !isOpenSubject"
                            class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded-lg shadow-sm text-center font-semibold hover:bg-gray-200 transition duration-300 ease-in-out"
                        >
                            {{ subject_name || 'Seleziona Materia' }}
                        </button>
                        <div v-if="isOpenSubject && subjects != null" class="absolute z-50 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1 max-h-60 overflow-y-auto">
                            <button
                                v-for="sub in subjects"
                                :key="sub.id"
                                @click="selectSubject(sub.id, sub.name)"
                                :class="{
                                'bg-blue-500 text-white font-semibold': sub.name === subject, 
                                'text-gray-700 hover:bg-blue-100': sub.name !== subject
                                }"
                                :disabled="sub.name === subject"
                                class="block w-full px-4 py-2 text-sm font-medium transition duration-200 ease-in-out"
                            >
                                {{ sub.name }}
                            </button>
                            </div>
                        </div>
                        </div>
                    </div>

                    <!-- Pulsante di conferma -->
                    <button
                        v-if="teacher_id != null && subject_id != null"
                        @click="updateTimetable()"
                        class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-4 rounded mt-6 transition duration-300 ease-in-out shadow-lg"
                    >
                        Conferma
                    </button>
                </div>

                
            </div>
        </div>
    </div>





</template>

<script>



export default {
    props: {
        subject: {
            type: String
        },
        teacher: {
            type: String
        },
        teachers: {
            type: Object
        },
        idToModify: {
            type: String
        }
    },
    data() {
        return {
            current_error: "",
            type: "error",
            popUpShow: false,
            isOpenTeacher: true,
            isOpenSubject: false,
            subjects: null,
            teacher_id: null,
            teacher_name: null,
            subject_id: null,
            subject_name: null
        };
    },
    methods: {
        showTeacherSubjects(teacherId, teacherName){

            this.teacher_id = teacherId;
            this.teacher_name = teacherName;

            //sistemiamo i flag per materie e prof
            this.isOpenSubject = true;
            this.isOpenTeacher = false;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');            

            fetch
            (`/api/getTeacherSubjects/${teacherId}`,
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
                    this.subjects = data.data;
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

        selectSubject(subjectId, subjectName){
            this.subject_id = subjectId;
            this.subject_name = subjectName;
            this.isOpenSubject = false;
        },
        updateTimetable(){








            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');            

            fetch
            (`/api/updateTimetable/${this.idToModify}/${this.subject_id}/${this.teacher_id}`,
                {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                }   
            )
            .then(response => response.json())
            .then(data => {
                if(data.result){
                   this.$emit('updateCalendar');
                } else {
                    this.popUpShow = true;
                    this.message = data.message;;
                    this.type = "error";

                    setTimeout(() => {
                        this.popUpShow = false;
                    }, 3200);
                }
            })


















            //setto a null tutti i valori che mi servono solo per cambiare l'orario
            this.subjects = null,
            this.teacher_id = null,
            this.teacher_name = null,
            this.subject_id = null,
            this.subject_name = null
        }
    }
}
</script>

<style>

</style>