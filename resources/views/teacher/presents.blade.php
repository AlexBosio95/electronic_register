<x-app-layout>
<div class="flex h-screen max-h-[720px] overflow-hidden">
    
    <x-menu :classes="$classes" :role="$user_role" :page="$page"></x-menu>

    <div class="w-full bg-[#1F2937] m-10 rounded-xl overflow-scroll">
        @if(count($students) > 0)
            <table class="table text-gray-400 border-separate space-y-6 text-sm w-full">
                <thead class="bg-gray-800 text-gray-500">
                    <tr>
                        <th class="p-3">Student ID</th>
                        <th class="p-3 text-left">name</th>
                        <th class="p-3 text-left">surname</th>
                        <th class="p-3 text-left">class</th>
                        <th class="p-3 text-left">Check</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr class="bg-gray-800">
                        <td class="p-3">
                            <div class="flex align-items-center">
                                <div class="ml-3">
                                    <div class="">{{$student->id}}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-3">
                            {{$student->name}}
                        </td>
                        <td class="p-3">
                            {{$student->surname}}
                        </td>
                        <td class="p-3">
                            {{$student->class->name}}
                        </td>
                        <td class="p-3">
                            
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>Non ci sono studenti in questa classe</p>
        @endif
    </div>
</div>
</x-app-layout>
