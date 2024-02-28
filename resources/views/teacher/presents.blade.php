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
        
                                <!-- Componente del modal con il calendario -->
                                <td x-data="{ showModal: false, calendario: calendar()
                                 }">
                                    <!-- Pulsante per aprire il modal -->
                                    <button @click="updateHiddenDate(calendario.DayMonthAndYear); showModal = true" class="hover:bg-blue-800 text-white font-bold py-2 px-4 rounded"><span x-text="calendario.DayMonthAndYear"></span></button>
                                    
                                    <!-- Modal -->
                                    <div x-data="calendario" x-show="showModal" class="fixed z-10 inset-0 overflow-y-auto" x-cloak>
                                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                            <!-- Sfondo scuro del modal -->
                                            <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="showModal = false">
                                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                                            </div>
                                            
                                            <!-- Contenitore del modal -->
                                            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                                            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full h-screen" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
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
                                                    <button @click="showModal = false" type="button" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">
                                                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                    <!-- Contenuto del calendario -->
                                                    <div class="mt-5">
                                                        <x-calendar></x-calendar>
                                                    </div>
                                                </div>                                   
                                            </div>
                                        </div>
                                    </div>
                                </td>

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
                                    <td class="px-4 py-2 border border-gray-200">{{ $student->name}} {{$student->id }}</td>
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
                            <input type="hidden" id="hiddenDate" value="">
                            <div class="flex justify-between">
                                <!-- Pulsanti per confermare la presenza o l'assenza -->
                                <button type="submit" @click.stop value="P" class="bg-green-500 text-white px-4 py-2 rounded focus:outline-none">Presente</button>
                                <button type="submit" @click.stop value="A" class="bg-red-500 text-white px-4 py-2 rounded focus:outline-none">Assente</button>
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