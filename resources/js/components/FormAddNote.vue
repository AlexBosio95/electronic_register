<template>
<div class="flex items-center justify-start relative w-full" v-if="addNoteFormMode">

    <div class="w-[500px]">
        <div class="mb-5">
            <label for="student" class="mb-3 block text-base font-medium text-white">Studente</label>
            <select v-model="selectedStudent" name="student" id="student" class="bg-gray-50 border border-gray-300 text-gray-900 text-m rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-red-500 dark:focus:border-red-500">
                <option v-for="student in students" :key="student.id" :value="student.id">{{student.name + ' ' + student.surname}}</option>
            </select>
        </div>

        <div>
            <textarea v-model="noteMessage" class="w-full p-2 border rounded mb-4"></textarea>
        </div>


        <div class="mb-3">
            <p class="text-white/60">Data Nota: {{selectedDay}}</p>
        </div>

        <div class="">
            <button @click="newNote" class="mt-3 hover:shadow-form rounded-md bg-red-600 hover:bg-red-800 py-3 px-12 text-center text-base font-semibold text-white outline-none">
                Salva Nota
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
import PopUpComponent from './common/PopUpComponent.vue';
export default {
    components: {PopUpComponent},
    props: {
            students: Array,
            addNoteFormMode: Boolean,
            selectedDay: String,
            current_user: Number
    },
    data() {
        return {
            selectedStudent: null,
            popUpShow: false,
            errorMessage: "",
            type: null,
            noteMessage: ""
        };
    },
    methods:{
        newNote(){
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const data = {
                student: this.selectedStudent,
                noteMessage: this.noteMessage,
                date: this.selectedDay,
                user: this.current_user
            };

            if (this.selectedStudent !== null && this.noteMessage !== "") {
                fetch('/api/note-add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(data),
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

                    } else {
                        this.$emit('NotaCreata');
                        this.selectedStudent = null;
                        this.noteMessage = "";
                    }
                    
                })
                .catch(error => {
                    console.log(error.message);
                    this.errorMessage = "Errore durante la creazione della nota";
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