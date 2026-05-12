<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS SMPN 4 Kota Serang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

    <div x-show="sidebarOpen" 
         x-transition.opacity 
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-black bg-opacity-50 md:hidden"
         style="display: none;">
    </div>

    <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-blue-800 text-white flex flex-col transform transition-transform duration-300 md:relative md:translate-x-0"
           :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}">
        
        <div class="h-16 flex items-center justify-between px-6 font-bold text-xl border-b border-blue-700">
            <span>LMS SMPN 4</span>
            <button @click="sidebarOpen = false" class="md:hidden text-white focus:outline-none">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            {{-- Menu Berdasarkan Role --}}
            @if(Auth::user()->role === 'admin')
                <a href="/admin/dashboard" class="block py-2.5 px-4 rounded transition {{ Request::is('admin/dashboard*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-home w-6 text-center mr-2"></i> Dashboard
                </a>
                <a href="/admin/tahun-akademik" class="block py-2.5 px-4 rounded transition {{ Request::is('admin/tahun-akademik*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-calendar-check w-6 text-center mr-2"></i> Tahun Akademik
                </a>
                <a href="/admin/users" class="block py-2.5 px-4 rounded transition {{ Request::is('admin/users*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-users w-6 text-center mr-2"></i> Data Pengguna
                </a>
                <a href="/admin/kelas" class="block py-2.5 px-4 rounded transition {{ Request::is('admin/kelas*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-chalkboard w-6 text-center mr-2"></i> Data Kelas
                </a>
                <a href="/admin/mapel" class="block py-2.5 px-4 rounded transition {{ Request::is('admin/mapel*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-book-open w-6 text-center mr-2"></i> Mata Pelajaran
                </a>
                <a href="/admin/rombel" class="block py-2.5 px-4 rounded transition {{ Request::is('admin/rombel*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-users-cog w-6 text-center mr-2"></i> Rombongan Belajar
                </a>
                <a href="/admin/guru-mapel" class="block py-2.5 px-4 rounded transition {{ Request::is('admin/guru-mapel*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-chalkboard-teacher w-6 text-center mr-2"></i> Jadwal Pelajaran
                </a>
            @elseif(Auth::user()->role === 'guru')
                <a href="/guru/dashboard" class="block py-2.5 px-4 rounded transition {{ Request::is('guru/dashboard*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-home w-6 text-center mr-2"></i> Dashboard Guru
                </a>
            @elseif(Auth::user()->role === 'siswa')
                <a href="/siswa/dashboard" class="block py-2.5 px-4 rounded transition {{ Request::is('siswa/dashboard*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-home w-6 text-center mr-2"></i> Dashboard Siswa
                </a>
                <a href="{{ route('siswa.transkrip') }}" class="block py-2.5 px-4 rounded transition {{ Request::is('siswa/transkrip*') ? 'bg-blue-700' : 'hover:bg-blue-700' }}">
                    <i class="fas fa-chart-line w-6 text-center mr-2"></i> Transkrip Nilai
                </a>
            @endif
        </nav>
    </aside>

    <div class="flex-1 flex flex-col min-w-0"> <header class="h-16 bg-white shadow-sm flex items-center justify-between px-4 md:px-6 z-10">
            <div class="flex items-center">
                <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-700 focus:outline-none md:hidden mr-4">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="text-gray-600 font-medium truncate">
                    Halo, <span class="text-blue-600 font-bold">{{ Auth::user()->name }}</span>
                </div>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition flex items-center">
                    <i class="fas fa-sign-out-alt md:mr-2"></i>
                    <span class="hidden md:inline">Keluar</span> </button>
            </form>
        </header>

        <main class="flex-1 p-4 md:p-6 overflow-y-auto bg-gray-50">
            @yield('content')
        </main>
        
    </div>

</body>
</html>