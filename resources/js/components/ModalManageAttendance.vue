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
                <h2 class="text-lg font-semibold mb-4">Seleziona la presenza</h2>
                
                    <button type="submit" @click.stop value="P" name="attendance" class="bg-green-500 text-white px-4 py-2 rounded focus:outline-none">Presente</button>
                    <button type="submit" @click.stop value="A" name="attendance" class="bg-red-500 text-white px-4 py-2 rounded focus:outline-none">Assente</button>
                    
            </div>
        </div>
    </div>















    
</template>
  
<script>


  
  export default {
    props: {
        student:{
            type: String
        }
    },
    data() {
        return {
                
        };
    },
    methods: {
        
    }
  };
  
  </script>