<template>
    
    <div class="w-60 bg-[#1F2937] flex flex-col items-center pt-5 pb-2 space-y-7 h-[720px]">
        <!-- menu items -->
        <div class="w-full pr-3 flex flex-col gap-y-1 text-gray-500 fill-gray-500 text-sm cursor-pointer">
            <!-- Menu che serve per la selezione della classe--> 
            <div>
                <div class="py-2 ps-2">                   
                    <div class="relative">
                        <button @click="toggleDropdown" type="button" v-if="classes.length > 0" class="inline-flex justify-center w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                            <span>{{ selectedClass }}</span>
                            <input name= "selected_class" type="hidden" v-model="selectedClassId">
                            <svg class="-mr-1 ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
            
                        <button v-else type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm cursor-not-allowed opacity-50">
                        Nessuna classe disponibile
                        </button>
                        <div v-show="isOpen && classes.length > 0" class="mt-2 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                            <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                <!-- Utilizza un v-for per creare un pulsante per ogni classe -->
                                <button v-for="classItem in classes" :key="classItem.id" @click="selectClass(classItem)" type="button" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                {{ classItem.name }}
                                </button>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            <div class="font-QuicksandMedium pl-4 text-gray-400/60 text-xs text-[11px] uppercase">Menu</div>


    
        </div>
    
    </div>
    
  </template>
  
  <script>
  export default {
    props: {
        classes: {
            type: String,
            required: true
        },
        role: {
            type: String,
            required: true
        },
        page: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            isOpen: false,
            selectedClass: 'Seleziona la tua classe' ,
            selectedClassId: null
        }
    },
    methods: {
        toggleDropdown() {
            this.isOpen = !this.isOpen;
        },
        selectClass(classe){
            this.selectedClass = classe.name;
            this.selectedClassId = classe.id;
            this.isOpen = !this.isOpen;
            axios.get('/dashboard')
                .then(response => {
                    
                })
                .catch(error => {
                    console.error('Errore durante la chiamata AJAX:', error);
                });
        }
    }
  }
  </script>
  