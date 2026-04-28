@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto pb-20">
    <div class="bg-white shadow-sm border-b sticky top-0 z-50 p-4 mb-6 flex justify-between items-center rounded-xl">
        <h2 class="font-bold text-gray-800">{{ $ujian->judul }}</h2>
        <div class="bg-red-100 text-red-600 px-4 py-2 rounded-lg font-mono font-bold">
            <i class="fas fa-clock mr-2"></i> <span id="timer">--:--</span>
        </div>
    </div>

    <form action="/siswa/ujian/{{ $ujian->id }}/simpan" method="POST" id="formUjian">
        @csrf
        @foreach($ujian->soals as $index => $soal)
        <div class="bg-white rounded-2xl shadow-sm border p-6 mb-6">
            <p class="font-bold text-gray-800 mb-4">{{ $index + 1 }}. {{ $soal->pertanyaan }}</p>
            
            <div class="space-y-3">
                @foreach(['a', 'b', 'c', 'd'] as $huruf)
                @php 
                $nama_kolom = 'pilihan_' . $huruf; // Sesuaikan 'pilihan_' dengan nama kolom di DB kamu
            @endphp
                <label class="flex items-center p-3 border rounded-xl hover:bg-blue-50 cursor-pointer transition">
                <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ strtoupper($huruf) }}" required class="w-4 h-4 text-blue-600">
                    <span class="ml-3 text-gray-700">
                    {{ strtoupper($huruf) }}. {{ $soal->$nama_kolom }}
                </span>
            </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-blue-700 shadow-lg">
            SELESAI & KIRIM JAWABAN
        </button>
    </form>
</div>

<script>
    // Timer Sederhana
    let time = {{ $ujian->durasi }} * 60;
    const timerEl = document.getElementById('timer');

    setInterval(() => {
        let minutes = Math.floor(time / 60);
        let seconds = time % 60;
        timerEl.innerHTML = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        if (time > 0) time--;
        else document.getElementById('formUjian').submit();
    }, 1000);
</script>
@endsection