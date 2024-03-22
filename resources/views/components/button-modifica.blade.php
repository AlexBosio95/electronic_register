<div>
    <button @click="getStudentIdAndColumnHeaderMod({{ $presenza[1] }}); isOpenPut = true" 
        class="px-4 py-2 rounded focus:outline-none
        {{ $presenza[0]== 'P' ? 'bg-green-500 text-white' : ($presenza[0] == 'A' ? 'bg-red-500 text-white' : '') }}">
            {{ $presenza[0] }}
    </button>
    <input type="hidden" id="idPresenza" name="idPresenza" value="{{ $presenza[1] }}">
</div>

<script>
    function getStudentIdAndColumnHeaderMod(idPresenza) {
        //var idPresenza = document.getElementById('idPresenza').value;
        document.getElementById('form-modifica').action = "{{ route('dashboard.update', ':valore') }}".replace(':valore', idPresenza);
    }
</script>
