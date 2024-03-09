<div>
    <button @click="getStudentIdAndColumnHeaderMod; isOpenPut = true" 
        class="px-4 py-2 rounded focus:outline-none
        {{ $presenza->presence == 'P' ? 'bg-green-500 text-white' : ($presenza->presence == 'A' ? 'bg-red-500 text-white' : '') }}">
            {{ $presenza->presence }}
    </button>
</div>

<script>
    function getStudentIdAndColumnHeaderMod() {
        // Ottieni l'ID dello studente dal campo nascosto nella stessa riga
        var studentId = this.$el.closest('tr').querySelector('.student-id').value;
        
        // Ottieni l'intestazione della colonna dalla riga dell'intestazione corrispondente
        var columnIndex = this.$el.closest('td').cellIndex;
        var columnHeader = this.$el.closest('table').querySelector('thead tr th:nth-child(' + (columnIndex + 1) + ')').innerText;
        
        // Popola i campi hidden con id swtudente e l'ora corrente
        document.getElementById('student_id').value = studentId;
        document.getElementById('hiddenHour').value = columnHeader;   
    }
</script>
