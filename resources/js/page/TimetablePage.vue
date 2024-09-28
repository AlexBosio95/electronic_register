<template>
    
    <PopUpComponent v-if="popUpShow"
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
                        <th class="px-4 py-2"></th> 
                            <th v-for="day in days" :key="day" class="px-4 py-2">
                                {{ day }}
                            </th> 
                    </thead>

                    <!-- Righe per gli studenti -->
                    <tbody>
                        
                        
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
            type: "error",
            popUpShow: false,
            timetable: [],
            days: [],
            mostraTable: true
        };
    },
    methods: {
        searchTimetable(){

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            

            fetch(`/api/getTimetableByClass/${this.current_class}`,
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
                    this.timetable = data.data.timetable;
                    this.days = data.data.days;
                    console.log(this.days);
                } else {
                    this.popUpShow = true;
                    this.message = data.message;;
                    this.type = "error";

                    setTimeout(() => {
                        this.popUpShow = false;
                    }, 3200);
                }
            })
           

        }
    },
    mounted(){
        this.searchTimetable();
    },
    watch: {
        current_class(){
            this.searchTimetable();
        }
    }
}
</script>

<style>

</style>