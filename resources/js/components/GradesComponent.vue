<template>
    <div class="relative w-full">

        <div v-if="mostraSuccesso" class="absolute bg-green-100 text-green-700 px-5 py-2 rounded-md ml-80">
            Voto aggiunto con successo.
        </div>

        <div class="flex mb-4 justify-between">
            <div>
                <button @click="toggleAddMode" class="mb-4 sm:mt-0 mr-2 inline-flex items-start justify-start px-6 py-3 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
                    <p class="text-sm font-medium leading-none text-white">Add Mark</p>
                </button>

                <button v-if="!addGradeFormMode" @click="toggleEditMode" class="mb-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
                    <p class="text-sm font-medium leading-none text-white">Edit Mark</p>
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
                                src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                alt="" />
                        </div>
                        <div>
                            <div class="font-medium">{{student.name}}</div>
                            <div class="text-sm">{{student.surname}}</div>
                        </div>
                    </th>
                    <td class="px-6 py-4 min-w-80">
                        <div class="flex gap-2">
                            <template v-if="filteredGrades(student.id).length === 0">
                                <span>Nessun voto</span>
                            </template>
                            <template v-else>
                                <span v-for="grade in filteredGrades(student.id)" :key="grade.id" class="inline-flex items-center gap-1 rounded-full bg-white/10 px-2 py-1 text-xs font-semibold text-blue-300">
                                    {{ grade.note }}
                                    <svg v-if="editMode" @click="deleteGrade(grade.id)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 cursor-pointer">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
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
        }
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
                // Effettua una richiesta HTTP per eliminare il voto
                fetch(`/marks/${gradeId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json'
                    },
                })
                .then(response => {
                    if (response.ok) {
                        // Rimuovi il voto dalla lista
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
        handleVotoCreato() {
            this.addGradeFormMode = false;
            this.mostraSuccesso = true;
            setTimeout(() => {
                this.mostraSuccesso = false;
            }, 3200);
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
            // Recupera i voti tramite una richiesta HTTP
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
