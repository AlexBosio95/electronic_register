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
        PopUpComponent,
        MenuMonths
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

    },
}
</script>

<style>

</style>