<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS SMPN 4 Kota Serang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex h-screen overflow-hidden">

    <aside class="w-64 bg-blue-800 text-white flex flex-col">
        <div class="h-16 flex items-center justify-center font-bold text-xl border-b border-blue-700">
            LMS SMPN 4
        </div>
        
        <nav class="flex-1 px-4 py-6 space-y-2">
            {{-- Menu Dinamis Berdasarkan Role --}}
            @if(Auth::user()->role === 'admin')
                <a href="/admin/dashboard" class="block py-2.5 px-4 rounded transition bg-blue-700 hover:bg-blue-600">
                    <i class="fas fa-home mr-2"></i> Dashboard Admin
                </a>
                <a href="/admin/users" class="block py-2.5 px-4 rounded transition hover:bg-blue-700">
                    <i class="fas fa-users mr-2"></i> Kelola User
                </a>
            @elseif(Auth::user()->role === 'guru')
                <a href="/guru/dashboard" class="block py-2.5 px-4 rounded transition bg-blue-700 hover:bg-blue-600">
                    <i class="fas fa-home mr-2"></i> Dashboard Guru
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition hover:bg-blue-700">
                    <i class="fas fa-book mr-2"></i> Materi & Tugas
                </a>
            @elseif(Auth::user()->role === 'siswa')
                <a href="/siswa/dashboard" class="block py-2.5 px-4 rounded transition bg-blue-700 hover:bg-blue-600">
                    <i class="fas fa-home mr-2"></i> Dashboard Siswa
                </a>
                <a href="#" class="block py-2.5 px-4 rounded transition hover:bg-blue-700">
                    <i class="fas fa-tasks mr-2"></i> Tugas Saya
                </a>
            @endif
        </nav>
    </aside>

    <div class="flex-1 flex flex-col">
        
        <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">
            <div class="text-gray-600 font-medium">
                Selamat datang, <span class="text-blue-600 font-bold">{{ Auth::user()->name }}</span>
            </div>
            
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition">
                    <i class="fas fa-sign-out-alt mr-1"></i> Keluar
                </button>
            </form>
        </header>

        <main class="flex-1 p-6 overflow-y-auto bg-gray-50">
            @yield('content')
        </main>
        
    </div>

</body>
</html>