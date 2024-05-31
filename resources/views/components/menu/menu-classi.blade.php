@props(['classes'])

<div>
    <div class="py-2 ps-2">
        <form action="{{ route('dashboard.index') }}" method="get">
            @csrf
            <div x-data="{ isOpenMenu: false }" class="relative inline-block text-left">
                <!-- Bottone principale del dropdown -->
                <button @click="isOpenMenu = !isOpenMenu" type="button" class="inline-flex justify-center w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                    Seleziona una classe
                    <!-- Icona della freccia giù -->
                    <svg class="-mr-1 ml-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
            
                <!-- Dropdown menu -->
                <div x-show="isOpenMenu" class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5">
                    <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                        <!-- Opzioni del dropdown -->
                        @foreach ($classes as $class)
                            <button @click="isOpenMenu = false" type="button" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900" role="menuitem">
                                {{ $class->name }}
                            </button>
                        @endforeach
                        @if(count($classes) == 0)
                            <button type="button" class="block px-4 py-2 text-sm text-gray-700 cursor-not-allowed" role="menuitem">
                                Nessuna classe disponibile
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
        </form>
    </div>
</div>
