<div>
    <button @click="getStudentIdAndColumnHeader; isOpen = true" class="focus:outline-none inline-block align-middle">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 bg-green-500 text-white rounded" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
    </button>
</div>

<script>
    function getStudentIdAndColumnHeader() {
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
