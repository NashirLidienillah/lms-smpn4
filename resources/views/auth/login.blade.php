<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LMS SMPN 4 Kota Serang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased overflow-hidden">

    <div class="min-h-screen flex">
        
        <div class="hidden lg:flex lg:w-1/2 relative items-center justify-center overflow-hidden bg-blue-900">
            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1400&auto=format&fit=crop" 
                 alt="Background SMPN 4" 
                 class="absolute inset-0 w-full h-full object-cover opacity-60 mix-blend-overlay">
            
            <div class="absolute inset-0 bg-gradient-to-br from-blue-900/90 to-indigo-800/80"></div>

            <div class="relative z-10 text-center px-12 max-w-2xl">
                <div class="w-24 h-24 bg-white/10 backdrop-blur-md rounded-3xl border border-white/20 flex items-center justify-center mx-auto mb-8 shadow-2xl">
                    <i class="fas fa-graduation-cap text-4xl text-white"></i>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-black text-white mb-4 tracking-tight leading-tight">
                    Portal Belajar <br> SMPN 4 Kota Serang
                </h1>
                <p class="text-blue-100 text-lg font-medium leading-relaxed opacity-90">
                    Sistem Manajemen Pembelajaran digital untuk mendukung kegiatan belajar mengajar yang interaktif dan mandiri.
                </p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex flex-col items-center justify-center p-8 sm:p-12 lg:p-24 bg-white relative">
            
            <div class="w-full max-w-md">
                
                <div class="lg:hidden flex items-center gap-3 mb-10">
                    <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h1 class="text-xl font-black text-gray-900 tracking-tight">LMS SMPN 4</h1>
                </div>

                <div class="mb-8 text-center lg:text-left">
                    <h2 class="text-3xl lg:text-4xl font-black text-gray-900 mb-2 tracking-tight">Selamat Datang 👋</h2>
                    <p class="text-gray-500 font-medium">Silakan masuk dengan akun Anda untuk melanjutkan.</p>
                </div>

                {{-- Notifikasi Error (Dipercantik) --}}
                @if($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6 flex items-start gap-3 shadow-sm animate-pulse">
                        <i class="fas fa-exclamation-circle mt-1"></i>
                        <div>
                            <p class="font-bold text-sm">Gagal Masuk!</p>
                            <p class="text-xs">{{ $errors->first() }}</p>
                        </div>
                    </div>
                @endif

                <form action="/login" method="POST" class="space-y-5">
                    @csrf
                    
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Username</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-blue-600">
                                <i class="fas fa-user text-gray-400 group-focus-within:text-blue-500"></i>
                            </div>
                            <input type="text" name="username" value="{{ old('username') }}" required 
                                   class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" 
                                   placeholder="Masukkan username">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Password</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-blue-600">
                                <i class="fas fa-lock text-gray-400 group-focus-within:text-blue-500"></i>
                            </div>
                            <input type="password" name="password" required 
                                   class="w-full pl-11 pr-4 py-3.5 bg-gray-50 border border-gray-200 rounded-2xl text-sm font-medium focus:bg-white focus:ring-4 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none" 
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl transition-all duration-300 shadow-xl shadow-blue-200 hover:shadow-blue-300 flex justify-center items-center gap-3 mt-6 group">
                        Masuk ke Sistem
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

            </div>

            <div class="absolute bottom-6 text-center text-xs text-gray-400 font-medium w-full">
                &copy; 2026 - Muhammad Nashir Lidienillah
            </div>

        </div>
    </div>

</body>
</html>