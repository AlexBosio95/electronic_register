<x-app-layout>
    <x-menu :classes="$classes" :role="$user_role" :page="$page"></x-menu>

    <div x-data="{ isOpen: false, isOpenPut: false }" class="relative w-full bg-[#1F2937] overflow-scroll border-l border-red-500">
        @if(count($students) > 0)
            <div class="container mx-auto p-4">
                <!-- Griglia -->
                <div class="overflow-x-auto bg-gray-100 rounded-lg shadow-md p-4">
                    <table id="timeTable" class="table-auto w-full">
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

                                @if(count($timetable))
                                    @foreach ($timetable as $hour)
                                        @if($hour->day_of_week == strftime('%A'))
                                            <th class="px-4 py-2">{{ $hour->time_start }}</th>
                                        @endif    
                                    @endforeach
                                @endif
                            </tr>
                        </thead>
                        <!-- Righe per gli studenti -->
                        <tbody>
                            @foreach ($students as $s => $student)
                                <tr class="bg-white">
                                    <input type="hidden" value="{{ $student->id }}" class="student-id">
                                    <td class="px-4 py-2 border border-gray-200">{{ $student->name}}</td>
                                    <!-- Qui puoi aggiungere la logica per le presenze/assenze degli studenti -->
                                    <!-- Ad esempio, per rappresentare se uno studente è presente o assente -->
                                    @if(count($timetable))
                                        @php
                                            $h = -1;
                                        @endphp
                                        @foreach ($timetable as $hour)                               
                                            @if($hour->day_of_week == strftime('%A'))
                                                <td class="px-4 py-2 border border-gray-200 text-center">
                                                    <!-- Aggiungi qui la logica per rappresentare la presenza o assenza -->
                                                    @php
                                                        $h +=1;
                                                        $buttonModalShown = false;
                                                    @endphp
                                                    @foreach ($student->presences as $presence)
                                                        @if($presence->data == date("Y-m-d") && config('timetable')[$h] == $presence->hour)
                                                            <x-button-modifica :presenza="$presence"></x-button-modifica>
                                                            @php
                                                                $buttonModalShown = true;
                                                            @endphp
                                                        @endif                                                       
                                                    @endforeach
                                                    @if (!$buttonModalShown)
                                                        <x-button-modal></x-button-modal>
                                                    @endif                                                    
                                                </td>
                                            @endif    
                                        @endforeach
                                    @endif
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
                            <input type="hidden" id="student_id" name="student_id" value="">
                            <input type="hidden" id="hiddenDate" name="hiddenDate" value="{{ date('j F Y') }}">
                            <input type="hidden" id="hiddenHour" name="hiddenHour" value="">
                            <div class="flex justify-between">
                                <!-- Pulsanti per confermare la presenza o l'assenza -->
                                <button type="submit" @click.stop value="P" name="attendance" class="bg-green-500 text-white px-4 py-2 rounded focus:outline-none">Presente</button>
                                <button type="submit" @click.stop value="A" name="attendance" class="bg-red-500 text-white px-4 py-2 rounded focus:outline-none">Assente</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>



            

            

            <!-- Modal -->
            <div x-show="isOpenPut" @click.away="isOpenPut = false" class="fixed z-10 inset-0 overflow-y-auto">
                <div class="flex items-center justify-center min-h-screen pt-4 px-4 text-center sm:block sm:p-0">
                    <div class="fixed inset-0 bg-black opacity-50"></div>
                    <div class="bg-white p-8 rounded-lg z-50 shadow-md max-w-sm mx-auto relative">
                        <!-- Pulsante di chiusura del modal -->
                        <button @click="isOpenPut = false" class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <!-- Contenuto del modal -->
                        <h2 class="text-lg font-semibold mb-4">Modifica la presenza</h2>
                        <form action="{{ route('dashboard.store') }}" method="POSt">
                            @csrf
                            <div class="flex justify-between">
                                <!-- Pulsanti per confermare la presenza o l'assenza -->
                                <button type="submit" @click.stop value="P" name="attendance" class="bg-green-500 text-white px-4 py-2 rounded focus:outline-none">Presente</button>
                                <button type="submit" @click.stop value="A" name="attendance" class="bg-red-500 text-white px-4 py-2 rounded focus:outline-none">Assente</button>
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