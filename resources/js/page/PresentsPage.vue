<template>

    <div v-if="current_error && mostraTable === true" class="text-center top-2 bg-red-100 text-red-700 px-5 py-2 rounded-md">
        {{ current_error }}
    </div>
    <div v-else-if="students.length > 0 && mostraTable === true">
        <div class="container mx-auto p-4">
            <!-- Griglia -->
            <div class="overflow-x-auto bg-gray-100 rounded-lg shadow-md p-4">
                <table id="timeTable" class="table-auto w-full">
                    <!-- Intestazione delle colonne -->
                    <thead>
                        <tr v-if="timetable.length > 0" class="bg-gray-800 text-white">
                            <th class="px-4 py-2"></th> 
                            <th v-for="hour in timetable" :key="hour.id" class="px-4 py-2">
                                {{ (hour.time_start).slice(0, 5) }}
                            </th>    
                        </tr>
                    </thead>

                    <!-- Righe per gli studenti -->
                    <tbody>
                        <tr v-for="student in students" :key="student.id" class="bg-white">
                            <input type="hidden" v-model="student.id">
                            <td  class="px-4 py-2 border border-gray-200">{{ student.name }}</td>
                            
                            
                            <td v-for="index in presences[student.id].length" :key="index - 1" class="px-4 py-2 border border-gray-200 text-center"> 
                                <!-- Faccio un Componente bottone che prende in input la presenza e se vuota mette il più, altrimenti la P o la A
                                Poi da lì in qualche modo triggero l'apertura del modal-->
                                <button-modal :presenza="presences[student.id][index - 1][0]" :student="student.id" :hourPresence="timetable[index -1]['time_start']" :current_date="current_date" :presences="presences" :index="index - 1" :current_user="current_user"></button-modal>                              
                            </td>  
                            
                              
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>    
    </div>
    
</template>
  
<script>
import ButtonModal from '../components/ButtonModal.vue';

  export default {
    components:{
        ButtonModal
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
            timetable: [],
            presences: [],
            current_error: "",
            mostraTable: true
        };
    },
    methods: {
        getTimetable(){
            this.current_error = "";
            this.mostraTable = false;
            //console.log(this.current_date);
            const classParam = this.current_class ? this.current_class : '';
            const dateParam = this.current_date ? this.current_date : '';
            fetch(`/api/timetable/${classParam}/${dateParam}`)
            .then(response => response.json())
            .then(data => {
                if (!!data['message']){
                    //console.log(data['message']);
                    this.current_error = data['message'];
                    this.mostraTable = true;
                    return;
                }
                this.timetable = data['timetable'];
                this.presences = data['presences'];
                //console.log(this.timetable);
                //console.log(this.presences);
                this.mostraTable = true;
            })
            .catch(error => {
                console.error(error);               
            });
        },
        setErrorEmptyStudents(){
            if(this.students.length <= 0){
                this.current_error = "La classe non ha studenti associati";
            }
        }
    },
    watch: {
        current_class: "getTimetable",
        current_date: "getTimetable",
        students: "setErrorEmptyStudents"
    },
    beforeMount(){
        this.getTimetable();
    }
  };
  
  </script>