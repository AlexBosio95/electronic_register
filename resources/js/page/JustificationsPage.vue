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
                            <td  class="px-8 py-6 border border-gray-200"></td>
                        </tr>                      
                    </tbody>
                </table>
            </div>
        </div>    
    </div>


</template>

<script>

import PopUpComponent from '../components/common/PopUpComponent.vue';
import MenuMonths from '../components/menu/MenuMonths.vue';
export default {
    components:{
        PopUpComponent,
        MenuMonths
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
            current_month: null
        };
    },
    methods: {
        setErrorEmptyStudents(){
            if(this.students.length <= 0){
                this.current_error = "La classe non ha studenti associati";
            }
        },
        searchJustifications(month){

            this.current_month = month;
            fetch(`/api/absences/${month}`)
            .then(response => response.json())
            .then(data => {
                if(data.result){
                    this.justifications = data.data;
                    console.log(this.justifications);
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

        }
    },
    watch: {
        students: "setErrorEmptyStudents"
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