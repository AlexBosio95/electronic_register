<template>
    
</template>

<script>



export default {
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
            popUpShow: false
        };
    },
    methods: {
        
    }
}
</script>

<style>

</style>