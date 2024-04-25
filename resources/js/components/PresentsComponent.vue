<template>


    <div v-if="students.length > 0">



        <div class="container mx-auto p-4">
            <!-- Griglia -->
            <div class="overflow-x-auto bg-gray-100 rounded-lg shadow-md p-4">
                <table id="timeTable" class="table-auto w-full">
                    <!-- Intestazione delle colonne -->
                    <thead>
                        <tr v-if="timetable.length > 0" class="bg-gray-800 text-white">
                            <th class="px-4 py-2"></th> 
                            <th v-for="hour in timetable" :key="hour.id" class="px-4 py-2">
                                {{ hour.time_start }}
                            </th>    
                        </tr>
                    </thead>

                    <!-- Righe per gli studenti -->
                    <tbody>
                        <tr v-for="student in students" :key="student.id" class="bg-white">
                            <input type="hidden" v-model="student.id">
                            <td  class="px-4 py-2 border border-gray-200">{{ student.name }}</td>
                            
                            
                            <td v-for="index in presences[student.id].length" :key="index - 1" class="px-4 py-2 border border-gray-200 text-center"> 
                                
                                <tr v-if=" presences[student.id][index - 1]  !== '' ">{{  presences[student.id][index - 1] }}</tr>
                                <tr v-else> </tr>
                            </td>    
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>    



    </div>
    
    
</template>
  
<script>
  
  
  export default {
    props: {
        classes: {
            type: Array
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

    },
    data() {
        return {
            timetable: [],
            presences: []
        };
    },
    methods: {
        getTimetable(){
            //console.log(this.current_date);
            const classParam = this.current_class ? this.current_class : '';
            const dateParam = this.current_date ? this.current_date : '';
            fetch(`/api/timetable/${classParam}/${dateParam}`)
            .then(response => response.json())
            .then(data => {
                this.timetable = data['timetable'];
                this.presences = data['presences'];
                console.log(this.timetable);
                console.log(this.presences);
            })
            .catch(error => {
                console.error('Si è verificato un errore:');
                alert('Si è verificato un errore durante il recupero dell orario');
            });
        }      
    },
    watch: {
        current_class: "getTimetable"
    }
  };
  
  </script>