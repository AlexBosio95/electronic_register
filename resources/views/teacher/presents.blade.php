<x-app-layout>


    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul class="flex items-center justify-between">
                <div>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
                <button onclick="window.location='{{ route('dashboard.index') }}'" class="absolute top-0 right-0 m-4 text-gray-600 hover:text-gray-800 focus:outline-none hover:bg-red-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </ul>
        </div>
    @endif

    @if(count($classes) > 0)
        <main-component :classes="{{ $classes }}" :user_role="{{ json_encode($user_role) }}" :page="{{ json_encode($page) }}" :sections="{{ json_encode($sections) }}"></main-component>
    @endif
</x-app-layout>