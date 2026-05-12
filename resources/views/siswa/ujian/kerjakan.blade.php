@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* NUCLEAR LOCKDOWN: Sembunyikan semua elemen navigasi tema */
    nav, aside, header, footer, .sidebar, .navbar, .main-header, .main-sidebar { 
        display: none !important; 
    }
    body { background-color: #f8fafc; overflow-x: hidden; }
    /* Paksa main content memenuhi layar tanpa margin tema */
    main, .content-wrapper, .content {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
        min-height: 100vh !important;
    }
    /* Mencegah seleksi teks (biar gak bisa copy-paste soal) */
    .unselectable {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
    }
</style>

<div class="max-w-7xl mx-auto pb-20 pt-4 md:pt-10 px-2 sm:px-4 unselectable">
    
    <div class="sticky top-2 md:top-4 z-50 mb-6 px-2 sm:px-0">
        <div class="bg-white/90 backdrop-blur-xl border border-gray-100 shadow-xl rounded-2xl md:rounded-3xl p-3 md:p-5 flex justify-between items-center">
            <div class="hidden md:block">
                <h2 class="font-black text-gray-800 uppercase tracking-tighter">{{ $ujian->judul }}</h2>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest">Siswa: {{ auth()->user()->name }}</p>
            </div>
            
            <div class="md:hidden">
                <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">Ujian Aktif</span>
                <h2 class="font-bold text-gray-800 text-xs truncate max-w-[120px]">{{ $ujian->judul }}</h2>
            </div>
            
            <div class="flex items-center gap-2 md:gap-4">
                <div class="bg-red-50 text-red-600 px-3 md:px-6 py-2 md:py-3 rounded-xl md:rounded-2xl font-black shadow-inner border border-red-100 flex items-center gap-2 md:gap-3">
                    <i class="fas fa-clock text-xs md:text-base animate-pulse"></i> 
                    <span id="timer" class="text-sm md:text-xl font-mono tracking-tighter">--:--</span>
                </div>
                <button type="button" onclick="confirmFinish()" class="bg-gray-900 hover:bg-black text-white px-4 md:px-6 py-2 md:py-3 rounded-xl md:rounded-2xl font-black text-[9px] md:text-[10px] uppercase tracking-widest shadow-lg transition active:scale-95">
                    Selesai
                </button>
            </div>
        </div>
    </div>

    <form action="/siswa/ujian/{{ $ujian->id }}/simpan" method="POST" id="formUjian">
        @csrf
        <input type="hidden" name="status_pengumpulan" id="status_pengumpulan" value="normal">
        <input type="hidden" name="catatan_pelanggaran" id="catatan_pelanggaran" value="">

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 md:gap-8">
            
            <div class="lg:col-span-8 space-y-4 md:space-y-6">
                @foreach($ujian->soals as $index => $soal)
                <div id="soal-card-{{ $index + 1 }}" class="bg-white rounded-2xl md:rounded-[2rem] shadow-sm border border-gray-100 p-5 md:p-10 transition-all">
                    <div class="flex items-start gap-3 md:gap-5 mb-6">
                        <div class="w-8 h-8 md:w-11 md:h-11 rounded-lg md:rounded-xl bg-gray-900 text-white flex items-center justify-center font-black shrink-0 shadow-lg text-sm md:text-base">
                            {{ $index + 1 }}
                        </div>
                        <p class="text-base md:text-xl font-bold text-gray-800 leading-relaxed whitespace-pre-wrap">{{ $soal->pertanyaan }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-2 md:gap-3">
                        @foreach(['a', 'b', 'c', 'd'] as $huruf)
                        @php $nama_kolom = 'pilihan_' . $huruf; @endphp
                        <label class="group relative flex items-center p-3 md:p-5 border-2 border-gray-50 rounded-xl md:rounded-2xl cursor-pointer transition-all hover:bg-emerald-50 hover:border-emerald-200">
                            <input type="radio" name="jawaban[{{ $soal->id }}]" value="{{ strtoupper($huruf) }}" 
                                   onchange="markAnswered({{ $index + 1 }})"
                                   class="hidden peer" required>
                            
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-lg md:rounded-xl bg-gray-100 text-gray-500 font-black flex items-center justify-center transition-all peer-checked:bg-emerald-600 peer-checked:text-white shrink-0 uppercase text-xs md:text-sm">
                                {{ $huruf }}
                            </div>
                            
                            <span class="ml-3 md:ml-4 text-xs md:text-base font-bold text-gray-600 peer-checked:text-emerald-900 transition-colors">
                                {{ $soal->$nama_kolom }}
                            </span>

                            <i class="fas fa-check-circle ml-auto text-emerald-500 opacity-0 peer-checked:opacity-100 transition-opacity text-sm md:text-lg"></i>
                        </label>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>

            <div class="lg:col-span-4">
                <div class="sticky top-20 md:top-28 bg-white rounded-2xl md:rounded-[2rem] border border-gray-100 shadow-sm p-5 md:p-6 text-center">
                    <h4 class="text-[9px] md:text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] mb-4 md:mb-6">Navigasi Soal</h4>
                    
                    <div class="grid grid-cols-5 gap-2 md:gap-3">
                        @foreach($ujian->soals as $index => $soal)
                        <a href="#soal-card-{{ $index + 1 }}" 
                           id="nav-number-{{ $index + 1 }}"
                           class="w-full aspect-square rounded-lg md:rounded-xl bg-gray-50 text-gray-400 border border-gray-100 flex items-center justify-center text-[10px] md:text-xs font-black transition-all hover:bg-gray-100">
                            {{ $index + 1 }}
                        </a>
                        @endforeach
                    </div>
                    
                    <div class="mt-6 md:mt-8 pt-4 md:pt-6 border-t border-dashed border-gray-200">
                        <p class="text-[8px] md:text-[9px] font-black text-red-500 uppercase leading-relaxed">
                            <i class="fas fa-lock mr-1"></i> Mode Aman Aktif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    /**
     * 1. ANTI-NaN & PERSISTENCE LOGIC
     */
    function getViolationCount() {
        let count = sessionStorage.getItem('v_count');
        if (count === null || isNaN(count)) return 0;
        return parseInt(count);
    }

    /**
     * 2. TIMER LOGIC
     */
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

    /**
     * 3. NAVIGATION LOCK (BACK & LINKS)
     */
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

    /**
     * 4. BROWSER CLOSE/REFRESH PREVENTER
     */
    window.onbeforeunload = function() {
        return "Sedang dalam pengerjaan ujian!";
    };

    /**
     * 5. ANTI-CHEAT DETECTION (TAB SWITCH)
     */
    document.addEventListener("visibilitychange", function() {
        if (document.hidden) {
            handleViolation("Meninggalkan tab ujian / Buka aplikasi lain");
        }
    });

    /**
     * 6. VIOLATION HANDLER
     */
    function handleViolation(alasan) {
        let count = getViolationCount() + 1;
        sessionStorage.setItem('v_count', count.toString());

        if (count >= 3) {
            finishUjian("AKSES DIPUTUS!", "Anda melakukan 3 kali pelanggaran. Ujian dihentikan.", "paksa", alasan);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'PERINGATAN KERAS!',
                html: `Dilarang meninggalkan halaman ujian!<br><br><span class="text-red-600 font-bold text-2xl">Pelanggaran: ${count} / 3</span>`,
                confirmButtonColor: '#ef4444',
                allowOutsideClick: false,
                confirmButtonText: 'SAYA MENGERTI'
            });
        }
    }

    /**
     * 7. FINAL SUBMISSION HANDLER
     */
    function finishUjian(title, text, status, alasan = "") {
        window.onbeforeunload = null; 
        document.getElementById('status_pengumpulan').value = status;
        document.getElementById('catatan_pelanggaran').value = (status === 'paksa') ? "PELANGGARAN: " + alasan : "";
        sessionStorage.removeItem('v_count');

        Swal.fire({
            title: title,
            text: text,
            icon: (status === 'paksa') ? 'error' : 'warning',
            showConfirmButton: false,
            timer: 3000,
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {
                formUjian.submit();
            }
        });
    }

    function confirmFinish() {
        Swal.fire({
            title: 'Kumpulkan Sekarang?',
            text: "Pastikan semua soal sudah terjawab dengan benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#10b981',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Selesai!',
            cancelButtonText: 'Cek Lagi'
        }).then((result) => {
            if (result.isConfirmed) {
                finishUjian("Berhasil!", "Jawaban Anda sedang dikirim...", "normal");
            }
        });
    }

    function markAnswered(number) {
        const navNum = document.getElementById('nav-number-' + number);
        if(navNum) {
            navNum.classList.remove('bg-gray-50', 'text-gray-400');
            navNum.classList.add('bg-emerald-500', 'text-white', 'border-emerald-600', 'shadow-md');
        }
    }
</script>
@endsection