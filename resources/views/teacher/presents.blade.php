<x-app-layout>
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
                        <th class="p-3 text-center">Attend</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                    <tr class="bg-gray-800">
                        <td class="p-3">
                            <div class="flex items-center justify-center">
                                <div class="ml-3">
                                    {{$student->id}}
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
                            <form method="POST" action="{{route('students.update', ['student' => $student->id])}}">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="student_id" value="{{ $student->id }}">
                                <div class="flex items-center justify-center">
                                    <button type="submit" name="presence" value="A" class="{{ $currentPresences[$student->id] == 'A' ? 'bg-red-700 hover:bg-red-900 text-white font-bold py-2 px-4 rounded' : 'bg-transparent hover:bg-red-900 text-white font-bold py-2 px-4 rounded'}}">A</button>
                                    <button type="submit" name="presence" value="P" class="{{ $currentPresences[$student->id] == 'P' ? 'bg-green-700 hover:bg-green-900 text-white font-bold py-2 px-4 rounded' : 'bg-transparent hover:bg-green-900 text-white font-bold py-2 px-4 rounded'}}">P</button>
                                </div>
                            </form>
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
