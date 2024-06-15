<template>
    <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-black opacity-50"></div>
            <div class="bg-white p-8 rounded-lg z-50 shadow-md max-w-sm mx-auto relative">
                <!-- Pulsante di chiusura del modal -->
                <button @click="this.$emit('close')" class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <p class="text-lg">Ore di Assenza in tutto il giorno: {{ absence.hours }}</p>
          
          <label for="justification" class="block text-gray-700 font-bold mb-2">Motivi della Giustificazione:</label>
          <textarea id="justification" v-model="reasons" rows="4" class="w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none focus:border-blue-500"></textarea>
          
          <button @click="submitJustification(absence.id)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4">
            Giustifica
          </button>
            </div>
        </div>
    </div>
</template>
<script>


export default {
    props: {
        absence:{
            type: Object
        }
    },
    data() {
        return {
            reasons: ''
        };
    },
    methods: {
        submitJustification(id){
            


            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const url = `/api/justification/${id}`;
            const data = {
                status: 'approved',
                reason: this.reasons
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
                } else {
                    this.$emit('update-justifications', data.data);
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