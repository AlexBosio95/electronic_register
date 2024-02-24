<!-- Dentro il tag <script> del tuo componente -->
    <script>
        function calendar() {
            return {
                showCalendar: false,
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                weekdays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                currentDate: new Date(),
                currentYear: new Date().getFullYear(),
                currentMonth: new Date().getMonth(),
                get days() {
                    const firstDayOfMonth = new Date(this.currentYear, this.currentMonth, 1).getDay();
                    const daysInMonth = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                    const days = Array.from({ length: firstDayOfMonth > 0 ? firstDayOfMonth - 1 : 6 }, (_, i) => '');
                    for (let day = 1; day <= daysInMonth; day++) {
                        days.push(day);
                    }
                    return days;
                },
                get monthAndYear() {
                    return `${this.months[this.currentMonth]} ${this.currentYear}`;
                },
                previousMonth() {
                    this.currentMonth = this.currentMonth === 0 ? 11 : this.currentMonth - 1;
                    this.currentYear = this.currentMonth === 11 ? this.currentYear - 1 : this.currentYear;
                },
                nextMonth() {
                    this.currentMonth = this.currentMonth === 11 ? 0 : this.currentMonth + 1;
                    this.currentYear = this.currentMonth === 0 ? this.currentYear + 1 : this.currentYear;
                }
            };
        }
        
        // Invoca la funzione calendar() per inizializzare lo stato del calendario
        let { showCalendar, months, weekdays, currentDate, currentYear, currentMonth, days, monthAndYear, previousMonth, nextMonth } = calendar();
    </script>
    
    <!-- Dentro il template del tuo componente -->
    
    <div x-show="true" class="absolute z-10 bg-white border text-black border-gray-200 shadow-md mt-2">
        <div class="container mx-auto p-4">
            <div class="flex justify-between mb-4">
                <button @click.stop="previousMonth">&lt;</button>
                <h2 x-text="monthAndYear" class="text-lg font-semibold"></h2>
                <button @click.stop="nextMonth">&gt;</button>
            </div>
            <div class="grid grid-cols-7 gap-2">
                <template x-for="(day, index) in days" :key="index">
                    <div class="p-2 bg-gray-100 border border-gray-200 rounded">
                        <span x-text="day"></span>
                    </div>
                </template>
            </div>
        </div>
    </div>
    
    