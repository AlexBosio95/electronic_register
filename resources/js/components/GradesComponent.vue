<template>
    <div class="relative w-full">

        <div v-if="mostraSuccesso" class="absolute bg-green-100 text-green-700 px-5 py-2 rounded-md ml-80">
            Voto aggiunto con successo.
        </div>

        <button @click="toggleAddMode" class="mb-4 sm:mt-0 mr-2 inline-flex items-start justify-start px-6 py-3 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
            <p class="text-sm font-medium leading-none text-white">Add Mark</p>
        </button>

        <button @click="toggleEditMode" class="mb-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
            <p class="text-sm font-medium leading-none text-white">Edit Mark</p>
        </button>

        <table class="w-full text-left text-sm text-white bg-[#1F2937] border-none rounded-xl" v-if="!addGradeFormMode">
            <thead class="bg-white/10">
                <tr class="">
                    <th scope="col" class="px-6 py-4 font-medium">Student</th>
                    <th scope="col" class="px-6 py-4 font-medium">Marks</th>
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
                            <span v-for="grade in filteredGrades(student.id)" :key="grade.id" class="inline-flex items-center gap-1 rounded-full bg-white/10 px-2 py-1 text-xs font-semibold text-blue-300">
                                {{ grade.note }}
                                <span v-if="editMode" @click="deleteGrade(grade.id)" class="delete-button cursor-pointer">x</span>
                            </span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <FormAddGradesComponent :students="students" :addGradeFormMode="addGradeFormMode" @votoCreato="handleVotoCreato"/>
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
            mostraSuccesso: false
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
    },
    mounted() {
        // Recupera i voti tramite una richiesta HTTP
        fetch('/api/grades')
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
};
</script>
