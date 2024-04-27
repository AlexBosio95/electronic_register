<template>
    <div class="py-2 ps-2">
        <button @click="showCalendar = !showCalendar" class="inline-flex justify-center w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-gray-100"><span>{{ dayMonthAndYear }}</span></button>
        <!-- Modal -->
        <div v-if="showCalendar === true" class="fixed z-10 inset-0 overflow-y-auto" x-cloak>
            <div class="flex items-center justify-center h-5/6 pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <!-- Sfondo scuro del modal -->
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showModal = false">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>
                
                <!-- Contenitore del modal -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full h-5/6" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <!-- Contenuto del modal -->
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <!-- Titolo del modal -->
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-headline">
                                    Calendario
                                </h3>
                            </div>
                        </div>
                        <button @click="showCalendar = false" type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <!-- Contenuto del calendario -->
                        <div class="mt-5">
                            <div x-show="true" class="absolute z-10 bg-white border text-black border-gray-200 shadow-md mt-2">
                                <div class="container mx-auto p-4">
                                    <div class="flex justify-between mb-4">
                                        <button @click="previousMonth(); changeButtonColor(null)">&lt;</button>
                                        <h2 class="text-lg font-semibold">{{ dayMonthAndYear }}</h2>
                                        <button @click="nextMonth(); changeButtonColor(null)">&gt;</button>
                                    </div>
                                    <div class="grid grid-cols-7 gap-2">
                                        <template v-for="(day, index) in days" :key="index">
                                            <div class="p-2 bg-gray-100 border border-gray-200 rounded text-center">
                                                <button @click="setCurrentDay(day); changeButtonColor($event.target.parentElement.parentElement)">
                                                    <span>{{ day }}</span>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </div>                                   
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        classes: {
            type: String,
            required: true
        },
        user_role: {
            type: String,
            required: true
        },
        page: {
            type: String,
            required: true
        },
        dayMonthAndYear: {
            type: String,
            requeired: true
        }
    },
    data() {
        const currentDate = new Date();
        return {
            showCalendar: false,
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            weekdays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            currentDate: currentDate,
            currentDay: currentDate.getDate(),
            currentYear: currentDate.getFullYear(),
            currentMonth: currentDate.getMonth() 
        };
    },
    computed: {
        dayMonthAndYear() {
            const $day = `${this.currentDay} ${this.months[this.currentMonth]} ${this.currentYear}`;
            this.$emit('current-date', $day);
            return $day;
        },
        days() {
            const firstDayOfMonth = new Date(this.currentYear, this.currentMonth, 1).getDay();
            const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
            const days = Array.from({ length: firstDayOfMonth > 0 ? firstDayOfMonth - 1 : 6 }, (_, i) => '');
            for (let day = 1; day <= daysInMonth; day++) {
                days.push(day);
            }
            return days;
        }
    },
    methods: {
        SetdayMonthAndYear() {
            // Ottieni la data corrente nel formato "giorno mese anno"
            this.dayMonthAndYear = `${this.currentDay} ${this.months[this.currentMonth]} ${this.currentYear}`;
        },
        previousMonth() {
            this.currentMonth = this.currentMonth === 0 ? 11 : this.currentMonth - 1;
            this.currentYear = this.currentMonth === 11 ? this.currentYear - 1 : this.currentYear;
        },
        nextMonth() {
            this.currentMonth = this.currentMonth === 11 ? 0 : this.currentMonth + 1;
            this.currentYear = this.currentMonth === 0 ? this.currentYear + 1 : this.currentYear;
        },
        changeButtonColor(parentDiv) {
            // Rimuovo la classe 'bg-blue-500' da tutti gli elementi del div con classe .bg-gray-100 
            document.querySelectorAll('.bg-blue-500').forEach(function(element) {
                element.classList.remove('bg-blue-500');
            });
            if(parentDiv != null){
                // Aggiungo la classe 'bg-blue-500' all'elemento div padre del bottone corrente
            parentDiv.classList.remove('bg-gray-100');
            parentDiv.classList.add('bg-blue-500');
            }
        },
        setCurrentDay(day) {
            this.currentDay = day;
        }
    }
};
    
</script>