<template>
    <PopUpComponent v-if="popUpShow"
                :message="message"
                :type="type"
            />

    <div class="container mx-auto p-4">
        <!-- Mostra il bottone per alternare tra aggiunta e visualizzazione -->
        <div class="mb-4">
            <button
                v-if="isAddingNote"
                @click="toggleView"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800 transition-all w-full">
                Visualizza vecchie note
            </button>
            <button
                v-else
                @click="toggleView"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-800 transition-all w-full">
                Aggiungi nuove note
            </button>
        </div>

        <!-- Sezione per aggiungere nuove note -->
        <div v-if="isAddingNote" class="flex flex-col space-y-4 mb-8">

        <div class="flex mb-4 justify-between w-full">
            <!-- Seleziona Ora -->
            <div class="w-1/2">
                <label for="time" class="block text-sm font-medium text-gray-700">Seleziona Ora:</label>
                <input type="time" v-model="selectedTime" class="mt-2 p-2 bg-gray-700 text-white rounded-lg w-full" />
            </div>

            <!-- Seleziona Materia -->
            <div class="w-1/2 ml-4">
                <label for="subject" class="block text-sm font-medium text-gray-700">Seleziona Materia:</label>
                <select v-if="!addGradeFormMode" v-model="selectedSubject" @change="getGrade" class="mt-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
                <option v-for="subject in subjectOptions" :key="subject.id" :value="subject.id">{{ subject.name }}</option>
                </select>
            </div>
        </div>

            <!-- Inserimento note della lezione -->
            <div>
                <label for="note" class="block text-sm font-medium text-gray-700">Note della lezione:</label>
                <textarea v-model="lessonNote" placeholder="Inserisci le note della lezione..." class="mt-2 p-4 bg-gray-700 text-white rounded-lg w-full h-40"></textarea>
            </div>

            <!-- Bottone per salvare le note -->
            <div>
                <button @click="salvaRegistro" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-800 transition-all w-full">
                Salva Note
                </button>
            </div>
        </div>

        <!-- Sezione per visualizzare le vecchie note -->
        <div v-else class="mb-8">
            <h3 class="text-lg font-medium text-white mb-4">Visualizza vecchie note</h3>

            <!-- Selezione dell'intervallo di date -->
            <div class="flex space-x-4 mb-4">
                <div>
                    <label for="start-date" class="block text-sm font-medium text-gray-700">Data Inizio:</label>
                    <input type="date" v-model="startDate" class="mt-2 p-2 bg-gray-700 text-white rounded-lg w-full" />
                </div>
                <div>
                    <label for="end-date" class="block text-sm font-medium text-gray-700">Data Fine:</label>
                    <input type="date" v-model="endDate" class="mt-2 p-2 bg-gray-700 text-white rounded-lg w-full" />
                </div>
                <div class="flex items-end">
                    <button @click="fetchOldNotes" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-800 transition-all">
                        Cerca
                    </button>
                </div>
            </div>

            <!-- Mostra le vecchie note -->
            <div v-if="oldNotes.length > 0">
                <h4 class="text-md font-medium text-white mb-2">Note trovate:</h4>
                <ul class="bg-gray-800 rounded-lg p-4 space-y-2">
                    <li v-for="note in oldNotes" :key="note.id" class="text-white p-2 bg-gray-700 rounded">
                        <p><strong>{{ formatDateTime(note.created_at) }}</strong></p>
                        <p>{{ note.note }}</p>
                    </li>
                </ul>
            </div>
            <div v-else class="text-white">Nessuna nota trovata per l'intervallo di date selezionato.</div>
        </div>
    </div>
</template>

<script>
import PopUpComponent from '../components/common/PopUpComponent.vue';
export default {
    components:{
        PopUpComponent,
    },
    props: {
        students: Array,  // Elenco degli studenti della classe
        current_class: Number,  // Informazioni sulla classe selezionata
        selectedDay: String,  // Data selezionata
        current_user: Number,  // ID dell'insegnante corrente
    },
    data() {
        return {
        isAddingNote: true,  // Stato per alternare tra aggiunta e visualizzazione
        selectedDateTime: '', // Data e Ora combinate
        lessonNote: '',       // Note inserite dall'insegnante
        startDate: '',        // Data inizio per la ricerca delle vecchie note
        endDate: '',          // Data fine per la ricerca delle vecchie note
        oldNotes: [],         // Array di vecchie note trovate
        selectedSubject: null,
        subjectOptions: [],
        selectedTime: null,
        type: "error",
        popUpShow: false,
        message: "",
        };
    },
    methods: {
        toggleView() {
            this.isAddingNote = !this.isAddingNote;  // Alterna tra le due visualizzazioni
        },
        salvaRegistro() {
            if (!this.selectedTime || !this.lessonNote || !this.selectedSubject) {
                alert("Devi inserire l'ora, la materia e le note della lezione.");
                return;
            }

            // Converti la `selectedDay` nel formato corretto `Y-m-d`
            const date = new Date(this.selectedDay);
            const formattedDate = date.toISOString().split('T')[0];

            const registroData = {
                class_id: this.current_class,  
                datetime: `${formattedDate}T${this.selectedTime}`,
                note: this.lessonNote,
                teacher_id: this.current_user,
                subject_id: this.selectedSubject
            };

            // Chiamata API per salvare i dati
            fetch('/api/salva-note', {
                method: 'POST',
                headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify(registroData),
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.result){
                        this.popUpShow = true;
                        this.errorMessage = data.message;
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
                        this.popUpShow = true;
                        this.selectedSubject = null;
                        this.message = "Registro aggiornato con successo";
                        this.type = "good";
                        this.lessonNote = "";
                        this.selectedTime = null;

                        setTimeout(() => {
                            this.popUpShow = false;
                            this.message = "";
                            this.type = null;
                        }, 3200);
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    alert('Si è verificato un errore.');
                });
        },
        getSubjectOptions(){
            fetch('/api/subject-options')
                .then(response => response.json())
                .then(data => {
                    if (!data.result){
                        this.popUpShow = true;
                        this.message = data.message;
                        this.type = "error";

                        setTimeout(() => {
                            this.popUpShow = false;
                            this.message = "";
                            this.type = null;
                        }, 3200);

                        setTimeout(() => {
                            this.getGrade();
                        }, 400);
                    } else {
                        this.subjectOptions = data.data;
                    }
                })
                .catch(error => {
                    console.error('Errore nel recupero delle opzioni di materia:', error);
                });
        },
        fetchOldNotes() {
            if (!this.startDate || !this.endDate) {
                alert("Seleziona un intervallo di date.");
                return;
            }

            const requestData = {
                class_id: this.current_class,
                teacher_id: this.current_user,
                start_date: this.startDate,
                end_date: this.endDate,
            };

            fetch(`/api/vecchie-note?class_id=${requestData.class_id}&start_date=${requestData.start_date}&end_date=${requestData.end_date}&teacher_id=${requestData.teacher_id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.result) {
                        this.oldNotes = data.data || [];  // Utilizza data.data
                    } else {
                        alert('Errore nel recupero delle note: ' + data.message);
                        this.oldNotes = [];
                    }
                })
                .catch(error => {
                    console.error('Errore:', error);
                    alert('Si è verificato un errore.');
                    this.oldNotes = [];
                });
            },
            resetForm() {
            this.selectedDateTime = '';
            this.lessonNote = '';
        },
        toggleView() {
            this.isAddingNote = !this.isAddingNote;
        },
        formatDateTime(datetime) {
            const options = {
                year: 'numeric', 
                month: '2-digit', 
                day: '2-digit', 
                hour: '2-digit', 
                minute: '2-digit'
            };
            return new Date(datetime).toLocaleDateString('it-IT', options);
        },
    },
    mounted() {
        this.getSubjectOptions();
        if (this.subjectOptions.length > 0) {
            this.selectedSubject = this.subjectOptions[0].id;
        }
    },
    watch: {
        current_class(newValue) {
            if (newValue) {
                this.fetchOldNotes();
            }
        }
    }
    };
</script>

<style scoped>
/* Aggiungi eventuali stili personalizzati qui */
</style>
