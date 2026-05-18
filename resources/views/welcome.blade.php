<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LMS CBT - SMPN 4 Kota Serang</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700,800" rel="stylesheet" />
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
        @endif
    </head>
    <body class="bg-slate-50/50 text-gray-800 font-sans antialiased min-h-screen flex flex-col justify-center items-center p-4 md:p-8">
        
        {{-- Main Container Layout Split Screen (Bento Box Style) --}}
        <main class="w-full max-w-5xl bg-white rounded-[2rem] border border-gray-100 shadow-2xl flex flex-col-reverse lg:flex-row overflow-hidden transition-all">
            
            {{-- SEKTOR KIRI: FORM AKSES & PORTAL SELAMAT DATANG --}}
            <div class="flex-1 p-8 md:p-14 flex flex-col justify-between space-y-12">
                
                {{-- Identitas Sekolah --}}
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-md shadow-blue-100">
                        <i class="fas fa-school text-sm"></i>
                    </div>
                    <div>
                        <span class="block text-[9px] font-black text-gray-400 uppercase tracking-widest leading-none mb-1">E-Learning Portal</span>
                        <h2 class="font-black text-gray-800 text-sm tracking-tight">SMPN 4 Kota Serang</h2>
                    </div>
                </div>

                {{-- Kalimat Ucapan Selamat Datang --}}
                <div class="space-y-4">
                    <span class="bg-blue-50 border border-blue-100 text-blue-700 text-[10px] font-black px-3.5 py-1.5 rounded-full uppercase tracking-widest inline-block shadow-sm">
                        <i class="fas fa-sparkles mr-1"></i> Pembelajaran Digital Aktif
                    </span>
                    <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight leading-tight">
                        Selamat Datang di Portal LMS & CBT
                    </h1>
                    <p class="text-gray-500 text-sm md:text-base font-medium leading-relaxed max-w-md">
                        Pusat kendali materi belajar mandiri, penugasan esai, dan pelaksanaan ujian online berbasis komputer untuk seluruh siswa dan guru.
                    </p>
                </div>

                {{-- Sistem Autentikasi / Tombol Masuk --}}
                <div class="pt-4 border-t border-gray-50 flex flex-col sm:flex-row items-center gap-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" 
                               class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-black px-8 py-4 rounded-xl shadow-lg shadow-blue-200 transition-all text-xs uppercase tracking-widest text-center active:scale-95 flex items-center justify-center gap-2">
                                <i class="fas fa-gauge text-sm"></i> Masuk Ke Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="w-full sm:w-auto bg-blue-600 hover:bg-blue-700 text-white font-black px-10 py-4 rounded-xl shadow-lg shadow-blue-200 transition-all text-xs uppercase tracking-widest text-center active:scale-95 flex items-center justify-center gap-2">
                                <i class="fas fa-right-to-bracket text-sm"></i> Login Akun
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" 
                                   class="w-full sm:w-auto bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold px-8 py-4 rounded-xl shadow-sm transition-all text-xs uppercase tracking-widest text-center active:scale-95">
                                    Daftar Siswa Baru
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>

                {{-- Footer Info --}}
                <div class="text-[10px] font-medium text-gray-400">
                    &copy; 2026 LMS CBT SMPN 4 Kota Serang. All rights reserved.
                </div>
            </div>

            {{-- SEKTOR KANAN: OVERLAY FOTO SEKOLAH --}}
            <div class="w-full lg:w-[460px] min-h-[250px] lg:min-h-full shrink-0 relative bg-blue-900 overflow-hidden">
                
                {{-- FOTO UTAMA SEKOLAH --}}
                {{-- Catatan: Simpan foto gedung/gerbang SMPN 4 kamu di folder public/images/smpn4.jpg --}}
                <img src="{{ asset('images/smpn4.jpg') }}" 
                     alt="SMPN 4 Kota Serang" 
                     class="absolute inset-0 w-full h-full object-cover object-center scale-105 filter brightness-95 contrast-105"
                     onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=800';">

                {{-- Efek Lapisan Kaca / Gradient Gelap Overlay --}}
                <div class="absolute inset-0 bg-gradient-to-t from-blue-950/95 via-blue-900/40 to-transparent"></div>
                
                {{-- Ornamen Floating Watermark Sekolah di Atas Foto --}}
                <div class="absolute bottom-0 inset-x-0 p-8 md:p-10 text-white space-y-2">
                    <div class="w-9 h-9 rounded-xl bg-white/20 backdrop-blur-md flex items-center justify-center border border-white/20 mb-2">
                        <i class="fas fa-graduation-cap text-sm text-yellow-300"></i>
                    </div>
                    <h3 class="text-lg font-black tracking-tight leading-tight uppercase">Cerdas, Berbudi, Berprestasi</h3>
                    <p class="text-xs text-blue-100 font-medium opacity-80 leading-relaxed">
                        Mewujudkan generasi unggul yang siap berkompetisi di era digitalisasi pendidikan nasional.
                    </p>
                </div>
            </div>

        </main>
    </body>
</html>