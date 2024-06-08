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
                        <th class="px-4 py-6">
                            <div class="flex justify-between space-x-2">
                                <button 
                                    @click="searchJustification('justificated')"
                                    :class="{'bg-blue-500': !searchJustificated, 'bg-green-500': searchJustificated}"
                                    class="bg-blue-500 text-white px-2 py-1 rounded">
                                    Giustificate
                                </button>
                                <button 
                                    @click="searchJustification('notJustificated')"
                                    :class="{'bg-blue-500': searchJustificated, 'bg-green-500': !searchJustificated}"
                                    class="bg-blue-500 text-white px-2 py-1 rounded">
                                    Non Giustificate
                                </button>
                            </div>
                        </th>
                        <th class="px-4 py-6">Calendario</th>
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
export default {
    components:{
        PopUpComponent
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
            searchJustificated: false
        };
    },
    methods: {
        setErrorEmptyStudents(){
            if(this.students.length <= 0){
                this.current_error = "La classe non ha studenti associati";
            }
        },
        searchJustification(toSearch){
            if(toSearch == "justificated"){
                this.searchJustificated = true;
            } else if (toSearch == "notJustificated"){
                this.searchJustificated = false;
            }
            //chiamata ajax per cercare le giustificazioni
        }
    },
    watch: {
        students: "setErrorEmptyStudents"
    }
}
</script>

<style>

</style>