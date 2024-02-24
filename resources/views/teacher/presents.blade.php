<x-app-layout>
    <x-menu :classes="$classes" :role="$user_role" :page="$page"></x-menu>

    <div x-data="{ isOpen: false }" class="relative w-full bg-[#1F2937] overflow-scroll border-l border-red-500">
        @if(count($students) > 0)
            <div class="container mx-auto p-4">
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
                                            <button @click="isOpen = true" class="focus:outline-none inline-block align-middle">
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
            
            <!-- Modal -->
            <div x-show="isOpen" @click.away="isOpen = false" class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-black opacity-50"></div>
                    <div class="bg-white p-8 rounded-lg z-50 shadow-md max-w-sm mx-auto relative">
                        <!-- Pulsante di chiusura del modal -->
                        <button @click="isOpen = false" class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <!-- Contenuto del modal -->
                        <h2 class="text-lg font-semibold mb-4">Seleziona la presenza</h2>
                        <form action="{{ route('dashboard.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <div class="flex justify-between">
                                <!-- Pulsanti per confermare la presenza o l'assenza -->
                                <button type="submit" @click.stop value="presente" class="bg-green-500 text-white px-4 py-2 rounded focus:outline-none">Presente</button>
                                <button type="submit" @click.stop value="assente" class="bg-red-500 text-white px-4 py-2 rounded focus:outline-none">Assente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <p>Non ci sono studenti in questa classe</p>
        @endif
    </div>
    
</x-app-layout>