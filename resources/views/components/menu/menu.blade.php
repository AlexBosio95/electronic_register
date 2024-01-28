@props(['classes', 'role', 'page'])

<div>
    <div class="w-80 bg-[#1F2937] flex flex-col items-center pt-5 pb-2 space-y-7 h-[720px]">
        <!-- menu items -->
        <div class="w-full pr-3 flex flex-col gap-y-1 text-gray-500 fill-gray-500 text-sm cursor-pointer">
            <x-menu-classi :classes="$classes"></x-menu-classi>

            <div class="font-QuicksandMedium pl-4 text-gray-400/60 text-xs text-[11px] uppercase">Menu</div>
    
            <x-menu-sezione :role="$role" :page="$page"></x-menu-sezione>
        </div>
    
    </div>
</div>