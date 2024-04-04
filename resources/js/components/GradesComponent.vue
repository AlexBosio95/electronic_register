<template>
    <div>
        <button @click="toggleEditMode" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</button>
        <span v-for="(grade, index) in filteredGrades" :key="index" class="inline-flex items-center gap-1 rounded-full bg-white/10 px-2 py-1 text-xs font-semibold text-blue-300">
            {{ grade.note }}
            <span @click="deleteGrade(grade.id)" class="delete-button cursor-pointer">x</span>
        </span>
    </div>
</template>

<script>
export default {
  data() {
    return {
      editMode: false,
      grades: [],
    };
  },
  computed: {
    filteredGrades() {
      return this.grades.filter(grade => grade.type === 'mark');
    }
  },
  methods: {
    toggleEditMode() {
      this.editMode = !this.editMode;
    },
    deleteGrade(gradeId) {
      if (confirm('Sei sicuro di voler eliminare questo voto?')) {
        // Effettua una richiesta HTTP per eliminare il voto
        fetch(`/marks/${gradeId}`, {
            method: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Content-Type': 'application/json'
            },
          })
          .then(response => {
            if (response.ok) {
              // Rimuovi il voto dalla lista
              this.grades = this.grades.filter(grade => grade.id !== gradeId);
            } else {
              alert('Errore durante l\'eliminazione del voto.');
            }
          })
          .catch(error => {
            console.error('Si è verificato un errore:', error);
            alert('Si è verificato un errore durante la richiesta.');
          });
      }
    }
  },
  mounted() {
    // Recupera i voti tramite una richiesta HTTP
    fetch('/api/grades')
      .then(response => response.json())
      .then(data => {
        this.grades = data;
        console.log(data);
      })
      .catch(error => {
        console.error('Si è verificato un errore:', error);
        alert('Si è verificato un errore durante il recupero dei voti.');
      });
  }
};
</script>
