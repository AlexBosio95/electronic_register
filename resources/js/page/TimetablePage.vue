<template>
    
    <PopUpComponent v-if="popUpShow"
            :message="current_error"
            :type="type"
        />

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
                    return;
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