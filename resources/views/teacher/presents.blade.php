<x-app-layout>
    <x-menu :classes="$classes" :role="$user_role" :page="$page"></x-menu>

    <div class="w-full bg-[#1F2937] overflow-scroll border-l border-red-500">
        @if(count($students) > 0)
            <table class="table text-gray-400 border-separate space-y-6 text-sm w-full">
                <thead class="bg-gray-800 text-gray-500">
                    <tr>
                        <th class="p-3 text-left">
                            <div class="flex align-items-center">
                                <div class="ml-2">
                                    <div class="">STUDENT</div>
                                </div>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr class="bg-gray-800">
                        <td class="p-3">
                            <div class="flex align-items-center">
                                <div class="ml-2">
                                    <div class="">{{$student->name}} {{$student->surname}}</div>
                                </div>
                            </div>
                        </td>                          
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Non ci sono studenti in questa classe</p>
        @endif
    </div>
</x-app-layout>
