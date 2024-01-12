<x-app-layout>
<div class="flex h-screen max-h-[720px] overflow-hidden">
    
    <x-menu :classes="$classes"></x-menu>

    <div class="w-full bg-[#1F2937] m-10 rounded-xl overflow-scroll">
        <table class="table text-gray-400 border-separate space-y-6 text-sm w-full">
            <thead class="bg-gray-800 text-gray-500">
                <tr>
                    <th class="p-3">Student ID</th>
                    <th class="p-3 text-left">Student</th>
                    <th class="p-3 text-left">Teacher</th>
                    <th class="p-3 text-left">Subject</th>
                    <th class="p-3 text-left">Event</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr class="bg-gray-800">
                    <td class="p-3">
                        <div class="flex align-items-center">
                            <div class="ml-3">
                                <div class="">{{$student->students->id}}</div>
                            </div>
                        </div>
                    </td>
                    <td class="p-3">
                        {{$student->students->name}}
                    </td>
                    <td class="p-3">
                        {{$student->teachers->name}}
                    </td>
                    <td class="p-3">
                        {{$student->subjects->name}}
                    </td>
                    <td class="p-3">
                        {{$student->events->name}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-app-layout>
