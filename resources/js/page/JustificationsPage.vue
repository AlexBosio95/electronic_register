<template>
    
    <PopUpComponent v-if="current_error && mostraTable === true"
        :message="current_error"
        :type="type"
    />


    <div v-else-if="students.length > 0 && mostraTable === true">
        <div class="container mx-auto p-4">
            <!-- Griglia -->
            <div class="overflow-x-auto bg-gray-100 rounded-lg shadow-md p-4">
                <table id="timeTable" class="table-auto w-full">
                    <!-- Intestazione delle colonne -->
                    <thead>
                        <th class="px-4 py-6 border">
                            <div class="flex justify-between space-x-2">
                                <button 
                                    @click="this.searchJustificated = !this.searchJustificated; searchJustifications(this.current_month)"
                                    :class="{'bg-red-500': !searchJustificated, 'bg-green-500': searchJustificated}"
                                    class="text-white px-4 py-2 rounded w-40 flex items-center justify-center">
                                    {{ searchJustificated ? 'Giustificate' : 'Non Giustificate' }}
                                </button>
                            </div>
                        </th>
                        <th class="px-4 py-6 border">
                            <menu-months @current-month="searchJustifications"></menu-months>
                        </th>
                    </thead>

                    <!-- Righe per gli studenti -->
                    <tbody>
                        <tr v-for="student in students" :key="student.id" class="bg-white">
                            <input type="hidden" v-model="student.id">
                            <td  class="px-2 py-6 w-40 border border-gray-200">{{ student.name }}</td>
                            <td  class="px-8 py-6 border border-gray-200">
                                <div class="flex space-x-4">
                                    <template v-for="item in justifications">
                                        <div v-if="item.student_id === student.id" :key="item.id" 
                                            :class="{'bg-red-500' : item.status=='pending', 'bg-green-500' : item.status=='approved'}"
                                            class = "text-white px-2 py-2 rounded"
                                            >  
                                            <button @click="openModal(item)">
                                                {{ transformDate(item.date) }}
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </td>
                        </tr>                      
                    </tbody>
                </table>
            </div>
        </div>    
    </div>

    <modal-absences v-if="selectedItem != null"
        :absence="selectedItem"
        @close="selectedItem= null"
        @update-justifications = "updateJustifications"
    >

    </modal-absences>



</template>

<script>

import PopUpComponent from '../components/common/PopUpComponent.vue';
import MenuMonths from '../components/menu/MenuMonths.vue';
import ModalManageAbsences from '../components/ModalManageAbsences.vue';
export default {
    components:{
        PopUpComponent,
        MenuMonths,
        ModalManageAbsences
    },
    props: {
        classes: {
            type: Object
        },
        students: {
            type: Array,
            default: () => []
        },
        current_class: {
            type: Number
        },
        current_date: {
            type: String
        },
        current_user: {
            type: Number
        }
    },
    data() {
        return {
            current_error: "",
            mostraTable: true,
            type: "error",
            searchJustificated: false,
            justifications : [],
            current_month: null,
            selectedItem : null
        };
    },
    methods: {
        setErrorEmptyStudents(){
            if(this.students.length <= 0){
                this.current_error = "La classe non ha studenti associati";
            }
        },
        searchJustifications(month){
            this.current_error = "";
            this.mostraTable = true;
            var type = 'pending';
            if(this.searchJustificated == true){
                var type = 'approved';
            }
            this.current_month = month;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            //la getJustification non funziona perchè non cambia la classe
            fetch(`/api/absences/${month}/${type}`,
                {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    }
                }   
            )
            .then(response => response.json())
            .then(data => {
                if(data.result){
                    this.justifications = data.data;
                } else {
                    this.popUpShow = true;
                    this.message = data.message;;
                    this.type = "error";

                    setTimeout(() => {
                        this.popUpShow = false;
                    }, 3200);
                }
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
                alert('Si è verificato un errore durante il recupero dei voti.');
            });
            
            //chiamata ajax per cercare le giustificazioni

        },
        transformDate(data){
            const dateParts = data.split("-");
            const day = dateParts[2];
            const month = dateParts[1];
            return `${day}/${month}`;
        },
        openModal(item){
            if (item.status != 'approved'){
                this.selectedItem = item;
            }
            
        },
        updateJustifications(justifications){
            this.justifications = justifications;
            this.selectedItem = null;
        }
    },
    watch: {
        students: "setErrorEmptyStudents",
        current_class() {
            this.searchJustifications(this.current_month);
        },
        current_date() {
            this.searchJustifications(this.current_month);
        }
    },
    beforeMount(){
        var data = new Date();
        this.current_month = data.getMonth() + 1;
    },
    mounted() {
        this.searchJustifications(this.current_month);
    }
}
</script>

<style>

</style>