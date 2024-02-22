<x-app-layout>
    <x-menu :classes="$classes" :role="$user_role" :page="$page"></x-menu>

    <div class="w-full bg-[#1F2937] overflow-scroll border-l border-red-500">
        @if(count($students) > 0)
        <div class="container mx-auto p-4">
            <!-- Oggetto per selezionare il giorno corrente -->
            <div class="flex justify-end mb-4">
                <!-- Aggiungi qui il codice per l'oggetto di selezione del giorno corrente -->
                <!-- Ad esempio, un bottone che quando cliccato apre il calendario -->
            </div>
        
            <!-- Griglia -->
            <div class="overflow-x-auto bg-gray-100 rounded-lg shadow-md p-4">
                <table class="table-auto w-full">
                    <!-- Intestazione delle colonne -->
                    <thead>
                        <tr class="bg-gray-800 text-white">
                            <th class="px-4 py-2"></th> <!-- Cella vuota nell'angolo -->
                            <!-- Colonne per le ore -->
                            @for ($hour = 1; $hour <= 8; $hour++)
                                <th class="px-4 py-2">{{ $hour }}° ora</th>
                            @endfor
                        </tr>
                    </thead>
                    <!-- Righe per gli studenti -->
                    <tbody>
                        @foreach ($students as $student)
                            <tr class="bg-white">
                                <td class="px-4 py-2 border border-gray-200">{{ $student->name }}</td>
                                <!-- Qui puoi aggiungere la logica per le presenze/assenze degli studenti -->
                                <!-- Ad esempio, per rappresentare se uno studente è presente o assente -->
                                @for ($hour = 1; $hour <= 8; $hour++)
                                    <td class="px-4 py-2 border border-gray-200 text-center">
                                        <!-- Aggiungi qui la logica per rappresentare la presenza o assenza -->
                                        <button class="focus:outline-none inline-block align-middle">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 bg-green-500 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                            </svg>
                                        </button>
                                    </td>
                                @endfor
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
        
        
        @else
            <p>Non ci sono studenti in questa classe</p>
        @endif
    </div>
</x-app-layout>
