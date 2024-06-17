<template>
    <div class="relative w-full max-h-[650px]">
        <div>
            <button :disabled="editMode" @click="toggleAddMode" class="mb-4 sm:mt-0 mr-2 inline-flex items-start justify-start px-5 py-2 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
                <span class="text-white mr-2 text-sm font-semibold">Aggiungi Nota</span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-white">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25ZM12.75 9a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V15a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V9Z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>

        <div class="overflow-y-scroll overflow-x-hidden max-h-[600px]" v-if="!addNoteFormMode">
            <table class="w-full text-left text-sm text-white bg-[#1F2937] border-none">
                <thead class="bg-slate-700 sticky top-0">
                    <tr class="">
                        <th scope="col" class="px-6 py-4 font-medium">Studente</th>
                        <th scope="col" class="px-6 py-4 font-medium">Insegnante</th>
                        <th scope="col" class="px-6 py-4 font-medium">Nota</th>
                        <th scope="col" class="px-6 py-4 font-medium">Data</th>
                        <th scope="col" class="px-6 py-4 font-medium text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    <tr class="hover:bg-white/10" v-for="note in notes" :key="note.id">
                        <th class="px-6 py-4 min-w-60 pb-8">
                            <div class="flex-col">
                                <div>{{note.student.surname}}</div>
                                <div class="font-normal">{{note.student.name}}</div>
                            </div>
                        </th>
                        <td class="px-6 py-4 min-w-60 pb-8">
                            <div class="flex-col">
                                <div class="font-bold">{{note.teacher.surname}}</div>
                                <div>{{note.teacher.name}}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 min-w-80 pb-8">{{getShortNote(note.note)}}</td>
                        <td class="px-6 py-4 min-w-40 pb-8">{{note.data}}</td>
                        <td class="px-6 py-4 w-80 pb-8">
                            <div class="flex justify-center">
                                <!-- Button edit -->
                                <button :disabled="editMode" @click="editNote(note)" class="mr-3 inline-flex px-5 py-2 bg-yellow-600 hover:bg-yellow-800 focus:outline-none rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                    </svg>
                                </button>
                                <!-- Button delete -->
                                <button :disabled="editMode" @click="deleteNote(note.id)"  class="inline-flex px-5 py-2 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 text-white">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="editMode" class="absolute top-20 left-20 bg-white p-5 rounded shadow-lg">
            <h2 class="text-xl mb-4">Modifica Nota</h2>
            <textarea v-model="editableNote.note" class="w-full p-2 border rounded mb-4"></textarea>
            <button @click="saveNote" class="bg-blue-600 hover:bg-blue-800 text-white px-4 py-2 rounded">Salva</button>
            <button @click="cancelEdit" class="ml-2 bg-gray-600 hover:bg-gray-800 text-white px-4 py-2 rounded">Annulla</button>
        </div>

        <FormAddNote 
            :students="students"
            :selectedDay="selectedDay"
            :current_user="current_user"
            :addNoteFormMode="addNoteFormMode"
            @NotaCreata="handleNotaCreata"
        />

        <PopUpComponent v-if="popUpShow"
            :message="message"
            :type="type"
        />

    </div>
</template>

<script>
import PopUpComponent from '../components/common/PopUpComponent.vue';
import FormAddNote from '../components/FormAddNote.vue';
export default {
    components: {PopUpComponent, FormAddNote},
data() {
        return {
            editMode: false,
            popUpShow: false,
            message: "",
            type: null,
            notes: [],
            editableNote: {},
            addNoteFormMode: false,
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
    mounted() {
        if (this.students && this.students.length > 0) {
            this.getNotes(this.students);
        }
    },
    watch: {
        students(newStudents) {
            if (newStudents && newStudents.length > 0) {
                this.getNotes(newStudents);
            }
        }
    },
    methods: {
        getNotes() {
            const studentIds = this.students.map(student => student.id).join(',');
            fetch(`/api/notes?students=${studentIds}`)
                .then(response => response.json())
                .then(data => {
                    if(!data.result) {
                        this.popUpShow = true;
                        this.message = data.message;
                        this.type = "error";

                        setTimeout(() => {
                            this.popUpShow = false;
                            this.message = "";
                            this.type = null;
                        }, 3200);

                    } else {
                        this.notes = data.data;
                    }
                })
                .catch(error => {
                    console.error('Si è verificato un errore:', error);
                    alert('Si è verificato un errore durante il recupero delle note.');
                });
        },
        getShortNote(note) {
            return note.length > 70 ? note.substring(0, 70) + '...' : note;
        },
        deleteNote(noteId) {
            if (confirm('Sei sicuro di voler eliminare questa nota?')) {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(`/api/notes/${noteId}`,{
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if(!data.result){
                        this.popUpShow = true;
                        this.message = data.message;
                        this.type = "error";

                        setTimeout(() => {
                            this.popUpShow = false;
                            this.message = "";
                            this.type = null;
                        }, 3200);

                    } else {
                        this.notes = this.notes.filter(note => note.id !== noteId);
                        this.popUpShow = true;
                        this.message = data.message;
                        this.type = "good";

                        setTimeout(() => {
                            this.popUpShow = false;
                            this.message = "";
                            this.type = null;
                        }, 3200);
                    }
                })
                .catch(error => {
                    if (error.response && error.response.status === 404) {
                        alert('Errore: Nota non trovata.');
                    } else {
                        alert('Errore durante l\'eliminazione della nota.');
                    }
                    console.error('Si è verificato un errore:', error);
                });
            }
        },
        editNote(note) {
        this.editMode = true;
        this.editableNote = { ...note };
        },
        saveNote() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/api/notes/${this.editableNote.id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ note: this.editableNote.note })
            })
            .then(response => response.json())
            .then(data => {
                if (data.result) {
                    this.notes = this.notes.map(note => note.id === this.editableNote.id ? this.editableNote : note);
                    this.editMode = false;
                    this.popUpShow = true;
                    this.message = data.message;
                    this.type = "good";

                    setTimeout(() => {
                        this.popUpShow = false;
                        this.message = "";
                        this.type = null;
                    }, 3200);
                } else {
                    this.popUpShow = true;
                    this.message = data.message;
                    this.type = "error";

                    setTimeout(() => {
                        this.popUpShow = false;
                        this.message = "";
                        this.type = null;
                    }, 3200);
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
                alert('Si è verificato un errore durante il salvataggio della nota.');
            });
        },
        cancelEdit() {
            this.editMode = false;
            this.editableNote = {};
        },
        toggleAddMode(){
            this.addNoteFormMode = !this.addNoteFormMode;
        },
        handleNotaCreata(){
            this.addNoteFormMode = false;
            this.popUpShow = true;
            this.message = "Voto aggiunto con successo";
            this.type = "good";

            setTimeout(() => {
                this.popUpShow = false;
                this.message = "";
                this.type = null;
            }, 3200);

            setTimeout(() => {
                this.getNotes();
            }, 400);
        }

    }
}
</script>

<style>

</style>