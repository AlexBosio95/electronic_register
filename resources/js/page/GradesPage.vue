<template>
    <div class="relative w-full">

        <PopUpComponent v-if="popUpShow"
            :message="message"
            :type="type"
        />

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
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-white">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
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
        :current_user="current_user" 
        @votoCreato="handleVotoCreato"/>
    </div>
</template>

<script>
import PopUpComponent from '../components/common/PopUpComponent.vue';
import FormAddGradesComponent from '../components/FormAddGradesComponent.vue';
export default {
    components: {FormAddGradesComponent, PopUpComponent},
    data() {
        return {
            editMode: false,
            grades: [],
            addGradeFormMode: false,
            gradesValue: [],
            subjets: [],
            popUpShow: false,
            subjectOptions: [],
            selectedSubject: null,
            message: "Voto aggiunto con successo",
            type: "good"
        };
        
    },
    props: {
        students: {
            type: Array,
            default: () => []
        },
        selectedDay: String,
        classes: Array,
        current_user: {
            type: Number
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
                axios.delete(`/api/marks/${gradeId}`)
                    .then(response => {
                        this.grades = this.grades.filter(grade => grade.id !== gradeId);
                    })
                    .catch(error => {
                        if (error.response && error.response.status === 404) {
                            alert('Errore: Voto non trovato.');
                        } else {
                            alert('Errore durante l\'eliminazione del voto.');
                        }
                        console.error('Si è verificato un errore:', error);
                    });
            }
        },
        filteredGrades(studentId) {
            return this.grades.filter(grade => grade.student_id === studentId);
        },
        handleVotoCreato(selectedSubjectMark) {
            this.addGradeFormMode = false;
            this.popUpShow = true;
            this.selectedSubject = selectedSubjectMark;

            setTimeout(() => {
                this.popUpShow = false;
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
