<template>
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
        
    
</template>

<script>
export default {
    props: {
        classes: {
            type: Array,
            required: true
        },
        user_role: {
            type: String,
            required: true
        },
        page: {
            type: String,
            required: true
        },
        sections: {
            type: Object,
            required: true
        }

    },
    data() {
        return {
            isOpen: false,
            selectedClass: this.classes[0]['name'],
            selectedClassId: this.classes[0]['id']
        }
    },
    methods: {
        toggleDropdown() {
            this.isOpen = !this.isOpen;
        },
        selectClass(classe){
            this.selectedClass = classe.name;
            this.selectedClassId = classe.id;
            //console.log(this.classes);
            this.$emit('class-selected', classe);
            this.isOpen = !this.isOpen;
        }
    }
}
</script>