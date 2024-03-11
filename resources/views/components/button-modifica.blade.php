<div>
    <button @click="getStudentIdAndColumnHeaderMod({{ $presenza->id }}); isOpenPut = true" 
        class="px-4 py-2 rounded focus:outline-none
        {{ $presenza->presence == 'P' ? 'bg-green-500 text-white' : ($presenza->presence == 'A' ? 'bg-red-500 text-white' : '') }}">
            {{ $presenza->presence }}
    </button>
    <input type="hidden" id="idPresenza" name="idPresenza" value="{{ $presenza->id }}">
</div>

<script>
    function getStudentIdAndColumnHeaderMod(idPresenza) {
        //var idPresenza = document.getElementById('idPresenza').value;
        document.getElementById('form-modifica').action = "{{ route('dashboard.update', ':valore') }}".replace(':valore', idPresenza);
    }
</script>
