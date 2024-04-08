<template>
<div class="z-99 absolute top-30 left-30" v-if="addGradeFormMode">
    <div class="flex items-center justify-center p-12 bg-[#1F2937] rounded-xl">
        <div class="mx-auto w-full min-w-[350px]">
            <div class="mb-5">
                <label for="student" class="mb-3 block text-base font-medium text-white">Studente</label>
                <select v-model="selectedStudent" name="student" id="student" class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                    <option v-for="student in students" :key="student.id" :value="student.id">{{student.name + ' ' + student.surname}}</option>
                </select>
            </div>

            <div class="mb-5">
                <label for="grade" class="mb-3 block text-base font-medium text-white">Voto</label>
                <select v-model="selectedGrade" name="grade" id="grade" class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                    <option v-for="gradeOption in gradeOptions" :key="gradeOption.id" :value="gradeOption.id">{{gradeOption.name}}</option>
                </select>
            </div>

            <div class="mb-5">
                <label for="subject" class="mb-3 block text-base font-medium text-white">Materia</label>
                <select v-model="selectedSubjectMark" name="subject" id="subject" class="w-full appearance-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
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
            selectedSubjectMark: null
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
                    'X-CSRF-TOKEN': csrfToken // Includi il token CSRF nell'header
                }
            };

            axios.post('/marks', data, options)
            .then(response => {
                console.log('Voto creato con successo:', response.data);
                this.selectedStudent = null;
                this.selectedGrade = null;
                this.selectedSubjectMark = null;
                this.$emit('votoCreato');
            })
            .catch(error => {
                console.error('Errore durante la creazione del voto:', error);
            });
        }
    }
}
</script>

<style>

</style>