<template>

    <div v-if="presenza == ''">
        <button @click="isOpenModal = true" 
            class="focus:outline-none inline-block align-middle">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 bg-gray-500 text-white rounded" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
            </svg>
        </button>
    </div>
    <div v-else-if="presenza == 'P'">
        <button @click="isOpenModal = true"
        class="px-4 py-2 rounded focus:outline-none bg-green-500 text-white">
            {{ presenza }}
        </button>
    </div>
    <div v-else-if="presenza == 'A'">
        <button @click="isOpenModal = true"
        class="px-4 py-2 rounded focus:outline-none bg-red-500 text-white">
            {{ presenza }}
        </button>
    </div>
    <modal-manage-attendance v-if="isOpenModal" :student="student" @closeModal="closeModal"></modal-manage-attendance>

    
</template>
  
<script>

import ModalManageAttendance from './ModalManageAttendance.vue';
  
  export default {
    components: { 
        ModalManageAttendance 
    },
    props: {
        presenza: {
            type: String
        },
        student:{
            type: String
        }
    },
    data() {
        return {
            isOpenModal: false 
        };
    },
    methods: {
        closeModal(){
            this.isOpenModal = false;
        }
    }
  };
  
</script>