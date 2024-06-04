<template>
    <div class="fixed z-10 inset-0 overflow-y-auto">
        <PopUpComponent v-if="popUpShow"
            :message="message"
            :type="type"
        />
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="bg-white p-8 rounded-lg z-50 shadow-md max-w-sm mx-auto relative">
                <!-- Pulsante di chiusura del modal -->
                <button @click="this.$emit('closeModal')" class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <!-- Contenuto del modal -->
                <h2 class="text-lg font-semibold mb-4">Seleziona la presenza</h2>
                <div class="flex justify-between">
                    <button @click="getPresence('P')" class="bg-green-500 text-white px-4 py-2 rounded-full focus:outline-none flex-1 ml-2" >Presente</button>
                    <button @click="getPresence('A')" class="bg-red-500 text-white px-4 py-2 rounded-full focus:outline-none flex-1 ml-2">Assente</button>
                    <button v-if="this.presences[this.student][this.index][0] != '' && this.presences[this.student][this.index][1] != ''" @click="getPresence('DEL')" class="bg-gray-800 text-white px-4 py-2 rounded-full focus:outline-none flex-1 ml-2">Elimina</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import PopUpComponent from '../components/common/PopUpComponent.vue';
export default {
        components: {PopUpComponent},
    props: {
        student:{
            type: Number
        },
        hourPresence: {
            type: String
        },
        current_date: {
            type: String
        },
        presences: {
            type: Object
        },
        index: {
            type: Number
        },
        current_user: {
            type: Number
        }
    },
    data() {
        return {
            message: "",
            type: null,
            popUpShow: false
        };
    },
    methods: {
        getPresence(presenza){
            /* if(presenza != 'A' && presenza != 'P' && presenza != 'DEL')
            {
                console.log("Inserito un valore sbagliato");
            } */
            this.current_presence = presenza;
            //console.log(this.current_presence);
            //console.log(this.student);
            //console.log(this.hourPresence);
            //console.log(this.index);
            //console.log(this.presences[this.student][this.index][0]);
            
            //Al momento attuale si fa solo una insert, prossima cosa da fare
            //è decidere se un update o una insert

            if (presenza == 'DEL')
            {
                this.deleteApi();
            }
            else if(this.presences[this.student][this.index][0] == '' && this.presences[this.student][this.index][1] == '' && (presenza == 'A' || presenza == 'P'))
            {
                this.buildApiInsert();
            }
            else
            {
                this.buildApiUpdate();
            }
            this.$emit('closeModal');
        },
        buildApiInsert() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log(this.current_user);
            const data = {
                student_id: this.student,
                hiddenHour: this.hourPresence.slice(0, 5),
                attendance: this.current_presence,
                hiddenDate: this.current_date,
                current_user: this.current_user
            };

            const options = {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(data)
            };

            fetch('/api/dashboard', options)
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

                    setTimeout(() => {
                        this.getGrade();
                    }, 400);
                } else {
                    this.presences[this.student][this.index][0] = this.current_presence;
                    this.presences[this.student][this.index][1] = data.data.recordId;
                }
                
            })
            .catch(error => {
                /* this.errorMessage = "Errore durante l'inserimento della presenza";
                this.mostraErrore = true;
                setTimeout(() => {
                    this.mostraErrore = false;
                }, 2200); */
            });
        },
        buildApiUpdate() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = `/api/dashboard/${this.presences[this.student][this.index][1]}`;
            const data = {
                attendance_mod: this.current_presence,
            };

            fetch(url, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if (!data.result) {
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
                    this.presences[this.student][this.index][0] = this.current_presence;
                }
                
            })
            .catch(error => {
                console.log('Errore durante la richiesta PUT:', error.message);
                // Gestisci l'errore qui, ad esempio mostrando un messaggio all'utente
            });
            
        },
        deleteApi() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = `/api/dashboard/${this.presences[this.student][this.index][1]}`;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.result) {
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
                    this.presences[this.student][this.index][0] = '';
                    this.presences[this.student][this.index][1] = '';
                    return;
                }              
            })
            .catch(error => {
                console.log('Errore durante la richiesta PUT:', error.message);
                // Gestisci l'errore qui, ad esempio mostrando un messaggio all'utente
            });
        }
    }
    };

</script>