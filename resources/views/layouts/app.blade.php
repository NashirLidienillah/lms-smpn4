<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS SMPN 4 Kota Serang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Mempercantik Scrollbar agar tidak terlihat kaku */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #cbd5e1; }
    </style>
</head>
<body class="bg-gray-50 flex h-screen overflow-hidden text-gray-800 antialiased" x-data="{ sidebarOpen: false }">

    {{-- Overlay untuk Mobile --}}
    <div x-show="sidebarOpen" 
         x-transition.opacity 
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-slate-900/40 backdrop-blur-sm md:hidden"
         style="display: none;">
    </div>

    {{-- Sidebar (Clean & Seamless Style) --}}
    <aside class="fixed inset-y-0 left-0 z-50 w-72 bg-white border-r border-gray-100 flex flex-col transform transition-transform duration-300 shadow-[4px_0_24px_rgba(0,0,0,0.02)] md:relative md:translate-x-0"
           :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
        
        {{-- Logo Area --}}
        <div class="h-20 flex items-center justify-between px-8 border-b border-gray-50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-blue-600 text-white rounded-xl flex items-center justify-center text-sm shadow-md shadow-blue-200">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <span class="font-black text-xl tracking-tight text-gray-800">LMS <span class="text-blue-600">SMPN 4</span></span>
            </div>
            <button @click="sidebarOpen = false" class="md:hidden w-8 h-8 rounded-lg bg-gray-50 text-gray-400 hover:text-red-500 hover:bg-red-50 flex items-center justify-center focus:outline-none transition">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        
        <nav class="flex-1 px-5 py-6 space-y-1.5 overflow-y-auto">
            
            {{-- ============================================== --}}
            {{-- MENU ADMIN --}}
            {{-- ============================================== --}}
            @if(Auth::user()->role === 'admin')
                
                {{-- Dashboard Utama --}}
                <a href="/admin/dashboard" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('admin/dashboard*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-home w-6 text-center mr-3 {{ Request::is('admin/dashboard*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Dashboard
                </a>

                {{-- Section: Konfigurasi Awal --}}
                <div class="px-4 mt-8 mb-2">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Setup Akademik</span>
                </div>
                <a href="/admin/tahun-akademik" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('admin/tahun-akademik*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-calendar-check w-6 text-center mr-3 {{ Request::is('admin/tahun-akademik*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Tahun Ajaran
                </a>

                {{-- Section: Master Data --}}
                <div class="px-4 mt-6 mb-2 border-t border-gray-50 pt-5">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Data Induk Sekolah</span>
                </div>
                <a href="/admin/users" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('admin/users*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-users w-6 text-center mr-3 {{ Request::is('admin/users*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Data Pengguna
                </a>
                <a href="/admin/kelas" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('admin/kelas*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-chalkboard w-6 text-center mr-3 {{ Request::is('admin/kelas*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Data Kelas
                </a>
                <a href="/admin/mapel" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('admin/mapel*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-book-open w-6 text-center mr-3 {{ Request::is('admin/mapel*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Mata Pelajaran
                </a>

                {{-- Section: Manajemen KBM --}}
                <div class="px-4 mt-6 mb-2 border-t border-gray-50 pt-5">
                    <span class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Kelola Pembelajaran</span>
                </div>
                <a href="/admin/rombel" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('admin/rombel*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-users-cog w-6 text-center mr-3 {{ Request::is('admin/rombel*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Pembagian Kelas
                </a>
                <a href="/admin/guru-mapel" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('admin/guru-mapel*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-calendar-days w-6 text-center mr-3 {{ Request::is('admin/guru-mapel*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Jadwal Pelajaran
                </a>

            {{-- ============================================== --}}
            {{-- MENU GURU --}}
            {{-- ============================================== --}}
            @elseif(Auth::user()->role === 'guru')
                <a href="/guru/dashboard" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('guru/dashboard*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-home w-6 text-center mr-3 {{ Request::is('guru/dashboard*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Beranda Guru
                </a>

            {{-- ============================================== --}}
            {{-- MENU SISWA --}}
            {{-- ============================================== --}}
            @elseif(Auth::user()->role === 'siswa')
                <a href="/siswa/dashboard" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('siswa/dashboard*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-home w-6 text-center mr-3 {{ Request::is('siswa/dashboard*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Beranda Siswa
                </a>
                <a href="{{ route('siswa.transkrip') }}" class="flex items-center py-3 px-4 rounded-xl transition-all {{ Request::is('siswa/transkrip*') ? 'bg-blue-50 text-blue-700 font-bold shadow-sm' : 'text-gray-500 hover:bg-gray-50 hover:text-blue-600 font-medium' }}">
                    <i class="fas fa-chart-line w-6 text-center mr-3 {{ Request::is('siswa/transkrip*') ? 'text-blue-600' : 'text-gray-400' }}"></i> Lihat Nilai
                </a>
            @endif

        </nav>
    </aside>

    {{-- Main Content Area --}}
    <div class="flex-1 flex flex-col min-w-0"> 
        
        {{-- Navbar Atas --}}
        <header class="h-20 bg-white/80 backdrop-blur-xl border-b border-gray-100 flex items-center justify-between px-6 md:px-10 z-10 sticky top-0">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="text-gray-400 hover:text-blue-600 hover:bg-blue-50 w-10 h-10 rounded-xl flex items-center justify-center focus:outline-none md:hidden mr-4 transition">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="hidden md:flex items-center bg-gray-50 px-4 py-2 rounded-xl border border-gray-100">
                    <i class="fas fa-calendar-day mr-2.5 text-blue-500 text-sm"></i>
                    <span class="text-sm text-gray-600 font-bold tracking-tight">
                        {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    </span>
                </div>
            </div>
            
            <div class="flex items-center gap-5 md:gap-8">
                
                {{-- User Info Area --}}
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <div class="text-gray-800 font-black text-sm leading-tight">{{ Auth::user()->name }}</div>
                        <div class="text-[10px] text-blue-500 uppercase tracking-widest font-black mt-0.5">{{ Auth::user()->role }}</div>
                    </div>
                    
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 shadow-sm flex items-center justify-center text-blue-700 font-black text-sm relative">
                        {{ substr(Auth::user()->name, 0, 1) }}
                        {{-- Online Status Dot --}}
                        <div class="absolute -bottom-1 -right-1 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full"></div>
                    </div>
                </div>

                <div class="w-px h-8 bg-gray-100 hidden sm:block"></div>

                {{-- Tombol Keluar yang Jelas --}}
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="group flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white rounded-xl font-bold text-sm transition-all shadow-sm" title="Keluar dari Aplikasi">
                        <i class="fas fa-sign-out-alt transition-transform group-hover:-translate-x-1"></i>
                        <span class="hidden sm:inline">Keluar</span> 
                    </button>
                </form>

            </div>
        </header>

        <main class="flex-1 p-4 md:p-8 overflow-y-auto bg-gray-50/50">
            @yield('content')
        </main>
        
    </div>

</body>
</html>