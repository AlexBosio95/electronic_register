<template>


    <div v-if="students.length > 0">



        <div class="container mx-auto p-4">
            <!-- Griglia -->
            <div class="overflow-x-auto bg-gray-100 rounded-lg shadow-md p-4">
                <table id="timeTable" class="table-auto w-full">
                    <!-- Intestazione delle colonne -->
                    <thead>
                        <tr v-if="timetable.length > 0" class="bg-gray-800 text-white">
                            <th v-for="hour in timetable" :key="hour.id" class="px-4 py-2">
                                {{ hour.time_start }}
                            </th>    
                        </tr>
                    </thead>
                    <!-- Righe per gli studenti -->
                    <tbody>
                        <!-- @foreach ($students as $s => $student)
                            <tr class="bg-white">
                                <input type="hidden" value="{{ $student->id }}" class="student-id">
                                <td class="px-4 py-2 border border-gray-200">{{ $student->name}}</td>
                                
                                @if(count($timetable))                                        
                                    @for ($i = 0; $i< count($res[$student->id]); $i++)                                   
                                        <td class="px-4 py-2 border border-gray-200 text-center">
                                            @if(empty($res[$student->id][$i][0]))
                                                <x-button-modal></x-button-modal>
                                            @else
                                                <x-button-modifica :presenza="$res[$student->id][$i]"></x-button-modifica>    
                                            @endif
                                        </td>     
                                    @endfor
                                @endif
                            </tr>
                        @endforeach -->
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
            type: Array,
            required: true
        },
        students: {
            type: Array,
            default: () => []
        },
        current_class: {
            type: Number,
            required: true
        },
        current_date: {
            type: String,
            required: true
        },

    },
    data() {
        return {
            timetable: []
        };
    },
    methods: {
        getTimetable(){
            console.log(this.current_date);
            const classParam = this.current_class ? this.current_class : '';
            const dateParam = this.current_date ? this.current_date : '';
            fetch(`/api/timetable/${classParam}/${dateParam}`)
            .then(response => response.json())
            .then(data => {
                this.timetable = data;
                console.log(this.timetable);
            })
            .catch(error => {
                console.error('Si è verificato un errore:', error);
                alert('Si è verificato un errore durante il recupero dell'.orario);
            });
        }
    },
    watch: {
        current_class: "getTimetable"    
    }
  };
  
  </script>