<template>


<div id="app" class="flex justify-center items-center bg-gray-100">
    <div class="flex justify-center items-center space-x-40 py-4 px-4 bg-white shadow-md rounded-md border border-gray-300">
      <button 
        @click="previousMonth" 
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300"
      >
        Mese Precedente
      </button>
      <div class="w-32 text-xl font-semibold text-gray-800">{{ currentMonthName }}</div>
      <button 
        @click="nextMonth" 
        class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 transition duration-300"
      >
        Mese Successivo
      </button>
    </div>
  </div>



</template>

<script>


export default {
    
  data(){
    return {
    currentDate: new Date(),
  };
  },
   
  computed: {
    currentMonthName() {
      const options = { month: 'long' };
      return this.currentDate.toLocaleDateString('it-IT', options);
    }
  },
  methods: {
    previousMonth() {
      this.currentDate.setMonth(this.currentDate.getMonth() - 1);
      this.currentDate = new Date(this.currentDate); // Forza l'aggiornamento della data
    },
    nextMonth() {
      this.currentDate.setMonth(this.currentDate.getMonth() + 1);
      this.currentDate = new Date(this.currentDate); // Forza l'aggiornamento della data
    }
  }
}
</script>

<style>

</style>