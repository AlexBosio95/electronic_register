<template>
<div class="flex items-center justify-start relative w-full" v-if="addGradeFormMode">

    <div class="w-[400px]">
        <div class="mb-5">
            <label for="student" class="mb-3 block text-base font-medium text-white">Studente</label>
            <select v-model="selectedStudent" name="student" id="student" class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                <option v-for="student in students" :key="student.id" :value="student.id">{{student.name + ' ' + student.surname}}</option>
            </select>
        </div>

        <div class="mb-5">
            <label for="grade" class="mb-3 block text-base font-medium text-white">Voto</label>
            <select v-model="selectedGrade" name="grade" id="grade" class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                <option v-for="gradeOption in gradeOptions" :key="gradeOption.id" :value="gradeOption.id">{{gradeOption.name}}</option>
            </select>
        </div>

        <div class="mb-5">
            <label for="subject" class="mb-3 block text-base font-medium text-white">Materia</label>
            <select v-model="selectedSubjectMark" name="subject" id="subject" class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                <option v-for="subjectOption in subjectOptions" :key="subjectOption.id" :value="subjectOption.id">{{subjectOption.name}}</option>
            </select>
        </div>

        <div class="mb-3">
            <p class="text-white/60">Data voto: {{selectedDay}}</p>
        </div>

        <div class="">
            <button @click="newGrade" class="mt-3 hover:shadow-form rounded-md bg-red-600 hover:bg-red-800 py-3 px-12 text-center text-base font-semibold text-white outline-none">
                Aggiungi Voto
            </button>
        </div>

        <PopUpComponent v-if="popUpShow"
            :message="errorMessage"
            :type="type"
        />

    </div>
</div>
</template>

<script>
import PopUpComponent from '../components/common/PopUpComponent.vue';
export default {
    components: {PopUpComponent},
    props: {
            students: Array,
            addGradeFormMode: Boolean,
            selectedSubject: Number,
            subjectOptions: Array,
            selectedDay: String,
            current_user: Number
    },
    data() {
        return {
            selectedStudent: null,
            selectedGrade: null,
            gradeOptions: [],
            selectedSubjectMark: null,
            popUpShow: false,
            errorMessage: "",
            type: null
        };
    },
    mounted() {
        this.getGradeOptions()
    },
    methods:{
        getGradeOptions(){
            fetch('/api/grade-options')
            .then(response => response.json())
            .then(data => {

                if (!data.result){
                    this.popUpShow = true;
                    this.errorMessage = "Errore formattazione dei dati";
                    this.type = "error";

                    setTimeout(() => {
                        this.popUpShow = false;
                        this.errorMessage = "";
                        this.type = null;
                    }, 3200);

                    setTimeout(() => {
                        this.getGrade();
                    }, 400);
                } else {
                    this.gradeOptions = data.data;
                }
            })
        },
        newGrade(){
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const data = {
                student: this.selectedStudent,
                grade: this.selectedGrade,
                subject: this.selectedSubjectMark,
                date: this.selectedDay,
                user: this.current_user
            };

            if (this.selectedStudent !== null && this.selectedGrade !== null && this.selectedSubjectMark !== null) {
                fetch('/api/marks', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data),
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (!data.result){
                        //GESTIONE ERRORE CON POP-UP RIVEDERE ANCHE IL TRY CATCH
                        this.popUpShow = true;
                        this.errorMessage = "Errore formattazione dei dati";
                        this.type = "error";

                        setTimeout(() => {
                            this.popUpShow = false;
                            this.errorMessage = "";
                            this.type = null;
                        }, 3200);

                        setTimeout(() => {
                            this.getGrade();
                        }, 400);
                    } else {
                        this.$emit('votoCreato', this.selectedSubjectMark);
                        this.selectedStudent = null;
                        this.selectedGrade = null;
                        this.selectedSubjectMark = null;
                    }
                    
                })
                .catch(error => {
                    console.log(error.message);
                    this.errorMessage = "Errore durante la creazione del voto";
                    this.popUpShow = true;
                    this.type = "error";
                    setTimeout(() => {
                        this.popUpShow = false;
                        this.type = null;
                        this.errorMessage = "";
                    }, 2200);
                });
            } else {
                this.errorMessage = "Non hai compilato tutti i campi";
                this.popUpShow = true;
                setTimeout(() => {
                    this.popUpShow = false;
                }, 2200);
            }
        }
    }
}
</script>

<style>

</style>