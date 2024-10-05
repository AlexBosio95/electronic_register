<template>
    


    <div class="fixed z-10 inset-0 overflow-y-auto">
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
                <h2 class="text-lg font-semibold mb-4">Modifica l'orario</h2>
                
                <div class="bg-white p-8 rounded-lg z-50 shadow-md max-w-sm mx-auto relative">
                    
                    <div class="flex justify-between">
                        <button @click="isOpenSubject = !isOpenSubject" >{{ subject }}</button>
                        <div v-if="isOpenSubject && teachers != null" class="absolute z-50 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">

                                <button  v-for="teacher in teachers" :key="teacher.id" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ teacher.name }}</button>
                                <!-- Logica che, quando clicco il teacher che voglio, mette isOpenSubject a false, 
                                     fa una chiamata ajax che chiede le materie di quel prof in quella classe,
                                     le mostra a schermo e, una volta scelto, faccio la chiamata per aggiornare il DB
                                -->
                            </div>
                        </div>
                    
                        <button @click="isOpenTeacher = !isOpenTeacher" >{{ teacher }}</button>
                        <div v-if="isOpenTeacher" class="absolute z-50 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a  v-for="teacher in teachers" :key="teacher.id" href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">{{ teacher.name }}</a>
                                
                            </div>
                        </div>
                    </div>
                    
                    <button class="bg-green-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4" >Conferma</button>
                    
                </div>
                
            </div>
        </div>
    </div>





</template>

<script>



export default {
    props: {
        subject: {
            type: String
        },
        teacher: {
            type: String
        },
        teachers: {
            type: Object
        }
    },
    data() {
        return {
            current_error: "",
            type: "error",
            popUpShow: false,
            isOpenTeacher: false,
            isOpenSubject: false
        };
    },
    methods: {
        
    }
}
</script>

<style>

</style>