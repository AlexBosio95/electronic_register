<template>
    <div :class="typeClasses" class="absolute inset-x-80 top-10">
        {{ message }}
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        },
        type: {
            type: String,
            required: true,
            validator: function (value) {
                return ['good', 'warning', 'error'].indexOf(value) !== -1
            }
        }
    },
    computed: {
        typeClasses() {
            let baseClasses = 'py-2 rounded-md text-center font-semibold';
            switch (this.type) {
                case 'good':
                    return `${baseClasses} bg-green-200 text-green-700`;
                case 'warning':
                    return `${baseClasses} bg-yellow-200 text-yellow-700`;
                case 'error':
                    return `${baseClasses} bg-red-200 text-red-700`;
                default:
                    return baseClasses;
            }
        }
    }
}
</script>

<style>
/* Aggiungi stili personalizzati qui se necessario */
</style>