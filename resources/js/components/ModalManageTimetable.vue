<template>
    



    <div class="relative inline-block text-left">
        <button @click="isOpenSubject = !isOpenSubject" >{{ subject }}</button>
        <div v-if="isOpenSubject" class="absolute z-50 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Opzione 1</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Opzione 2</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Opzione 3</a>
            </div>
        </div>
    </div>
    <br>


    <div class="relative inline-block text-left">
        <button @click="isOpenTeacher = !isOpenTeacher" >{{ teacher }}</button>
        <div v-if="isOpenTeacher" class="absolute z-50 mt-2 w-full rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
            <div class="py-1">
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Opzione 1</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Opzione 2</a>
                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Opzione 3</a>
            </div>
        </div>
    </div>






</template>

<script>



export default {
    props: {
        subject: {
            type: String
        },
        teacher: {
            type: String
        }
    },
    data() {
        return {
            current_error: "",
            type: "error",
            popUpShow: false,
            isOpenTeacher: false,
            isOpenSubject: false
        };
    },
    methods: {
        
    }
}
</script>

<style>

</style>