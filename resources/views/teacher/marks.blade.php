<x-app-layout>
    <div class="flex h-screen max-h-[720px] overflow-hidden">
        
        <x-menu :classes="$classes" :role="$user_role" :page="$page"></x-menu>

        <div class="py-5 px-10">

            <button onclick="popuphandler(true)" class="mb-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
                <p class="text-sm font-medium leading-none text-white">Add Mark</p>
            </button>

            <button id="editButton" class="mb-4 sm:mt-0 inline-flex items-start justify-start px-6 py-3 bg-red-600 hover:bg-red-800 focus:outline-none rounded">
                <p class="text-sm font-medium leading-none text-white">Edit Mark</p>
            </button>

            <!-- Includi il componente Vue qui -->
            <grades-component></grades-component>

        </div>
    </div>
</x-app-layout>
