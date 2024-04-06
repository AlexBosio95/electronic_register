<x-app-layout>
    <div class="flex h-screen max-h-[720px] overflow-hidden">
        
        <x-menu :classes="$classes" :role="$user_role" :page="$page"></x-menu>

        <div class="py-5 px-10">

            <!-- Includi il componente Vue qui -->
            <grades-component :students="{{ json_encode($students) }}"></grades-component>

        </div>
    </div>
</x-app-layout>
