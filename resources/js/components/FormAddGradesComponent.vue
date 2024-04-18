<template>
<div class="z-99 absolute top-30 left-30" v-if="addGradeFormMode">

    <div v-if="mostraErrore" class="w-80 right-20 text-center top-2 absolute bg-red-100 text-red-700 px-5 py-2 rounded-md ml-80">
        {{errorMessage}}
    </div>

    <div class="flex items-center justify-center p-16 bg-[#1F2937] rounded-xl">
        <div class="mx-auto w-full min-w-[350px]">
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

            <div class="">
                <button @click="newGrade" class="mt-3 hover:shadow-form rounded-md bg-red-600 hover:bg-red-800 py-3 px-12 text-center text-base font-semibold text-white outline-none">
                    Aggiungi Voto
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    props: {
            students: Array,
            addGradeFormMode: Boolean,
            selectedSubject: Number,
            subjectOptions: Array
    },
    data() {
        return {
            selectedStudent: null,
            selectedGrade: null,
            gradeOptions: [],
            selectedSubjectMark: null,
            mostraErrore: false,
            errorMessage: ""
        };
    },
    mounted() {
        this.getGradeOptions()
    },
    methods:{
        getGradeOptions(){
            axios.get('/api/grade-options')
                .then(response => {
                    this.gradeOptions = response.data;
                })
                .catch(error => {
                    console.error('Errore nel recupero delle opzioni di voto:', error);
                });
        },
        newGrade(){
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const data = {
                student: this.selectedStudent,
                grade: this.selectedGrade,
                subject: this.selectedSubjectMark
            };

            const options = {
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken 
                }
            };

            if (this.selectedStudent !== null && this.selectedGrade !== null && this.selectedSubjectMark !== null) {
                axios.post('/marks', data, options)
                .then(response => {
                    this.$emit('votoCreato', this.selectedSubjectMark);
                    this.selectedStudent = null;
                    this.selectedGrade = null;
                    this.selectedSubjectMark = null;
                })
                .catch(error => {
                    this.errorMessage = "Errore durante la creazione del voto";
                    this.mostraErrore = true;
                    setTimeout(() => {
                        this.mostraErrore = false;
                    }, 2200);
                });
            } else {
                this.errorMessage = "Non hai compilato tutti i campi";
                this.mostraErrore = true;
                setTimeout(() => {
                    this.mostraErrore = false;
                }, 2200);
            }
        }
    }
}
</script>

<style>

</style>