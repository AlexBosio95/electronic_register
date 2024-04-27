<template>
    <div class="relative w-full">
        <div v-if="mostraSuccesso" class="absolute bg-green-200 text-green-700 py-2 rounded-md inset-x-80 top-10 text-center font-semibold">
            Voto aggiunto con successo
        </div>

        <div class="flex mb-4 justify-between">
            <div>
                <button @click="toggleAddMode" class="mb-4 sm:mt-0 mr-2 inline-flex items-start justify-start px-5 py-2 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
                    <span class="text-white mr-2 text-sm font-semibold">Aggiungi voti</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                        <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                    </svg>
                </button>

                <button v-if="!addGradeFormMode" @click="toggleEditMode" class="mb-4 sm:mt-0 inline-flex items-start justify-start px-5 py-2 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
                    <span class="text-white mr-2 text-sm font-semibold">Elimina voti</span>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                    </svg>
                </button>
            </div>

            <select v-if="!addGradeFormMode" v-model="selectedSubject" @change="getGrade" class="ml-4 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-60 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500 max-h-10">
                <option v-for="subject in subjectOptions" :key="subject.id" :value="subject.id">{{ subject.name }}</option>
            </select>
        </div>

        <table class="w-full min-w-[900px] text-left text-sm text-white bg-[#1F2937] border-none rounded-xl" v-if="!addGradeFormMode">
            <thead class="bg-white/10">
                <tr class="">
                    <th scope="col" class="px-6 py-4 font-medium">Studente</th>
                    <th scope="col" class="px-6 py-4 font-medium">Voti</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/10">
                <tr class="hover:bg-white/10" v-for="student in students" :key="student.id">
                    <th class="flex gap-3 px-6 py-4 font-normal">
                        <div class="relative h-10 w-10">
                            <img
                                class="h-full w-full rounded-full object-cover object-center"
                                :src="'images/default.jpg'"
                                alt="" />
                        </div>
                        <div>
                            <div class="font-medium">{{student.name}}</div>
                            <div class="text-sm">{{student.surname}}</div>
                        </div>
                    </th>
                    <td class="px-6 py-4 min-w-80 pb-8">
                        <div class="flex gap-3">
                            <template v-if="filteredGrades(student.id).length === 0">
                                <span>Nessun voto</span>
                            </template>
                            <template v-else>
                                <span v-for="grade in filteredGrades(student.id)" :key="grade.id" :class="{ 'shake': editMode}" class="inline-flex items-center rounded-lg px-8 py-1 text-s font-semibold text-white uppercase relative bg-white/10">
                                    {{grade.note}}
                                    <span class="absolute top-8 left-0 text-white/70 text-xs">{{ grade.data }}</span>

                                    <svg v-if="editMode" @click="deleteGrade(grade.id)" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 ml-2 cursor-pointer">
                                        <path fill-rule="evenodd" d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </template>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <FormAddGradesComponent 
        :subjectOptions="subjectOptions"
        :students="students" 
        :addGradeFormMode="addGradeFormMode"
        :selectedSubject="selectedSubject"
        :selectedDay="selectedDay" 
        @votoCreato="handleVotoCreato"/>
    </div>
</template>

<script>
import FormAddGradesComponent from '../components/FormAddGradesComponent.vue';
export default {
    components: {FormAddGradesComponent},
    data() {
        return {
            editMode: false,
            grades: [],
            addGradeFormMode: false,
            gradesValue: [],
            subjets: [],
            mostraSuccesso: false,
            subjectOptions: [],
            selectedSubject: null,
        };
        
    },
    props: {
        students: {
            type: Array,
            default: () => []
        },
        selectedDay: String,
        classes: Array
    },
    methods: {
        toggleEditMode() {
            this.editMode = !this.editMode;
        },
        toggleAddMode() {
            this.addGradeFormMode = !this.addGradeFormMode;
        },
        deleteGrade(gradeId) {
            if (confirm('Sei sicuro di voler eliminare questo voto?')) {
                fetch(`/marks/${gradeId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {
                    if (response.ok) {
                        this.grades = this.grades.filter(grade => grade.id !== gradeId);
                    } else {
                        alert('Errore durante l\'eliminazione del voto.');
                    }
                })
                .catch(error => {
                    console.error('Si è verificato un errore:', error);
                    alert('Si è verificato un errore durante la richiesta.');
                });
            }
        },
        filteredGrades(studentId) {
            return this.grades.filter(grade => grade.student_id === studentId);
        },
        handleVotoCreato(selectedSubjectMark) {
            this.addGradeFormMode = false;
            this.mostraSuccesso = true;
            this.selectedSubject = selectedSubjectMark;

            setTimeout(() => {
                this.mostraSuccesso = false;
            }, 3200);

            setTimeout(() => {
                this.getGrade();
            }, 400);
        },
        getSubjectOptions(){
            axios.get('/api/subject-options')
                .then(response => {
                    this.subjectOptions = response.data;
                })
                .catch(error => {
                    console.error('Errore nel recupero delle opzioni di materia:', error);
                });
        },
        getGrade(){
            const subjectParam = this.selectedSubject ? `&subject=${this.selectedSubject}` : '';
            fetch(`/api/grades?${subjectParam}`)
            .then(response => response.json())
            .then(data => {
                this.grades = data;
                console.log(data);
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
                alert('Si è verificato un errore durante il recupero dei voti.');
            });
        }
    },
    mounted() {
        this.getSubjectOptions();
        if (this.subjectOptions.length > 0) {
            this.selectedSubject = this.subjectOptions[0].id;
            // Effettua la chiamata HTTP per recuperare i voti
            this.getGrades();
        }
    }
};
</script>

<style scoped>

    .shake {
    animation: shake 0.5s infinite alternate;
    }

    @keyframes shake {
    0% {
    transform: translate(-1px, -1px) rotate(0deg);
    }
    25% {
        transform: translate(1px, 1px) rotate(-1deg);
    }
    50% {
        transform: translate(2px, 0px) rotate(1deg);
    }
    75% {
        transform: translate(-1px, 1px) rotate(0deg);
    }
    100% {
        transform: translate(-1px, -1px) rotate(0deg);
    }
    }

</style>
