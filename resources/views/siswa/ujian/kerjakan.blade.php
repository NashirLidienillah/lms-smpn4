@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    nav, aside, header, footer, .sidebar, .navbar, .main-header, .main-sidebar { 
        display: none !important; 
    }
    body { background-color: #f8fafc; overflow-x: hidden; }
    main, .content-wrapper, .content {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        min-height: 100vh !important;
    }
    .unselectable {
        -webkit-user-select: none; -moz-user-select: none; -ms-user-select: none; user-select: none;
    }
</style>

<div class="max-w-7xl mx-auto pb-20 pt-4 md:pt-10 px-2 sm:px-4 unselectable">
    
    {{-- 1. INCLUDE PANEL BAR ATAS & TIMER --}}
    @include('siswa.ujian.components._exam_header')

    <form action="/siswa/ujian/{{ $ujian->id }}/simpan" method="POST" id="formUjian">
        @csrf
        <input type="hidden" name="status_pengumpulan" id="status_pengumpulan" value="normal">
        <input type="hidden" name="catatan_pelanggaran" id="catatan_pelanggaran" value="">

        {{-- GRID TATA LETAK UTAMA CBT --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8">
            
            {{-- 2. INCLUDE LIST SOAL PILIHAN GANDA (KIRI) --}}
            @include('siswa.ujian.components._exam_questions')

            {{-- 3. INCLUDE MAP KOTAK NAVIGASI SOAL (KANAN) --}}
            @include('siswa.ujian.components._exam_sidebar')

        </div>
    </form>
</div>

{{-- SCRIPT KEAMANAN CBT --}}
<script>
    function getViolationCount() {
        let count = sessionStorage.getItem('v_count');
        if (count === null || isNaN(count)) return 0;
        return parseInt(count);
    }

    let time = {{ $ujian->durasi }} * 60;
    const timerEl = document.getElementById('timer');
    const formUjian = document.getElementById('formUjian');

    const countdown = setInterval(() => {
        let minutes = Math.floor(time / 60);
        let seconds = time % 60;
        timerEl.innerHTML = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        if (time <= 300) timerEl.parentElement.classList.add('animate-pulse');
        if (time > 0) {
            time--;
        } else {
            clearInterval(countdown);
            finishUjian("Waktu Habis!", "Jawaban Anda akan dikirim otomatis.", "normal");
        }
    }, 1000);

    history.pushState(null, null, location.href);
    window.onpopstate = function () {
        history.go(1);
        handleViolation("Mencoba klik tombol Back Browser");
    };

    document.querySelectorAll('a').forEach(link => {
        if(!link.id.includes('nav-number-')) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                handleViolation("Mencoba navigasi ke halaman lain");
            });
        }
    });

    window.onbeforeunload = function() { return "Sedang dalam pengerjaan ujian!"; };

    document.addEventListener("visibilitychange", function() {
        if (document.hidden) { handleViolation("Meninggalkan tab ujian / Buka aplikasi lain"); }
    });

    function handleViolation(alasan) {
        let count = getViolationCount() + 1;
        sessionStorage.setItem('v_count', count.toString());
        if (count >= 3) {
            finishUjian("AKSES DIPUTUS!", "Anda melakukan 3 kali pelanggaran. Ujian dihentikan.", "paksa", alasan);
        } else {
            Swal.fire({
                icon: 'error', title: 'PERINGATAN KERAS!',
                html: `Dilarang meninggalkan halaman ujian!<br><br><span class="text-red-600 font-bold text-2xl">Pelanggaran: ${count} / 3</span>`,
                confirmButtonColor: '#ef4444', allowOutsideClick: false, confirmButtonText: 'SAYA MENGERTI'
            });
        }
    }

    function finishUjian(title, text, status, alasan = "") {
        window.onbeforeunload = null; 
        document.getElementById('status_pengumpulan').value = status;
        document.getElementById('catatan_pelanggaran').value = (status === 'paksa') ? "PELANGGARAN: " + alasan : "";
        sessionStorage.removeItem('v_count');
        if (status === 'paksa') {
            let inputCheat = document.createElement('input');
            inputCheat.type = 'hidden'; inputCheat.name = 'is_cheat'; inputCheat.value = '1';
            formUjian.appendChild(inputCheat);
        }
        Swal.fire({
            title: title, text: text, icon: (status === 'paksa') ? 'error' : 'warning',
            showConfirmButton: false, timer: 3000, allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); },
            willClose: () => { formUjian.submit(); }
        });
    }

    function confirmFinish() {
        Swal.fire({
            title: 'Kumpulkan Sekarang?',
            text: "Pastikan semua soal sudah terjawab dengan benar.",
            icon: 'question', showCancelButton: true, confirmButtonColor: '#2563eb', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Selesai!', cancelButtonText: 'Cek Lagi'
        }).then((result) => {
            if (result.isConfirmed) { finishUjian("Berhasil!", "Jawaban Anda sedang dikirim...", "normal"); }
        });
    }

    function markAnswered(number) {
        const navNum = document.getElementById('nav-number-' + number);
        if(navNum) {
            navNum.classList.remove('bg-gray-50', 'text-gray-400');
            navNum.classList.add('bg-blue-600', 'text-white', 'border-blue-700', 'shadow-md');
        }
    }
</script>
@endsection