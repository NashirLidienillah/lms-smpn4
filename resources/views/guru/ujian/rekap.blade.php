@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto pb-20">
    
    {{-- Toast Notifikasi Sukses Buka Akses --}}
    @if(session('success'))
        <div id="toast-success" class="fixed top-5 right-5 flex items-center w-full max-w-xs p-4 mb-4 text-gray-700 bg-white rounded-2xl shadow-xl border-l-4 border-emerald-500 z-50 transition-all duration-500">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-emerald-500 bg-emerald-100 rounded-lg"><i class="fas fa-check"></i></div>
            <div class="ml-3 text-sm font-medium">{{ session('success') }}</div>
            <button type="button" class="ml-auto bg-white text-gray-400 hover:text-gray-900 rounded-lg p-1.5 hover:bg-gray-100 h-8 w-8 transition" onclick="document.getElementById('toast-success').remove()"><i class="fas fa-times"></i></button>
        </div>
        <script>setTimeout(() => { document.getElementById('toast-success')?.remove(); }, 3500);</script>
    @endif

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-black text-gray-800 tracking-tight">Rekap Nilai CBT</h1>
            <p class="text-gray-500 text-sm mt-1">Ujian: <span class="font-bold text-emerald-600">{{ $ujian->judul }}</span> | Total Soal: {{ $ujian->soals->count() }} Butir</p>
        </div>
        <a href="/guru/ujian/{{ $ujian->id }}" class="bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm flex items-center">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Dapur Ujian
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-emerald-50/50 border-b border-emerald-100">
                    <tr>
                        <th class="px-6 py-5 text-[10px] font-black text-emerald-800 uppercase tracking-widest">Nama Siswa</th>
                        <th class="px-6 py-5 text-[10px] font-black text-emerald-800 uppercase tracking-widest text-center">Benar</th>
                        <th class="px-6 py-5 text-[10px] font-black text-emerald-800 uppercase tracking-widest text-center">Salah</th>
                        <th class="px-6 py-5 text-[10px] font-black text-emerald-800 uppercase tracking-widest text-center">Skor Akhir</th>
                        <th class="px-6 py-5 text-[10px] font-black text-emerald-800 uppercase tracking-widest text-center">Status Akses</th>
                        <th class="px-6 py-5 text-[10px] font-black text-emerald-800 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($rekap as $userId => $jawaban)
                        @php
                            $totalSoal = $ujian->soals->count();
                            $benar = $jawaban->where('is_benar', true)->count();
                            $salah = $totalSoal - $benar;
                            $skor = ($totalSoal > 0) ? round(($benar / $totalSoal) * 100, 2) : 0;
                            
                            $namaSiswa = $jawaban->first()->user->name;

                            // Trik Ninja: Mengambil data HasilUjian secara dinamis untuk mengecek status blokir
                            $hasilUjian = \App\Models\HasilUjian::where('ujian_id', $ujian->id)->where('siswa_id', $userId)->first();
                            $status = $hasilUjian ? $hasilUjian->status : 'selesai'; 
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-sm group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                        {{ substr($namaSiswa, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-gray-800">{{ $namaSiswa }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg text-sm font-black">{{ $benar }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-red-50 text-red-500 px-3 py-1 rounded-lg text-sm font-black">{{ $salah }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-lg font-black {{ $skor >= 70 ? 'text-emerald-600' : 'text-red-500' }}">
                                    {{ $skor }}
                                </span>
                            </td>
                            
                            {{-- Kolom Status --}}
                            <td class="px-6 py-4 text-center">
                                @if($status === 'diblokir')
                                    <span class="inline-flex items-center gap-1.5 bg-red-100 text-red-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider animate-pulse">
                                        <i class="fas fa-ban"></i> Diblokir
                                    </span>
                                @elseif($status === 'mengerjakan')
                                    <span class="inline-flex items-center gap-1.5 bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">
                                        <i class="fas fa-spinner fa-spin"></i> Mengerjakan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">
                                        <i class="fas fa-check-circle"></i> Selesai
                                    </span>
                                @endif
                            </td>

                            {{-- Kolom Aksi (Tombol Buka Akses) --}}
                            <td class="px-6 py-4 text-center">
                                @if($status === 'diblokir' && $hasilUjian)
                                    <form id="form-buka-akses-{{ $hasilUjian->id }}" action="/guru/ujian/buka-akses/{{ $hasilUjian->id }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" 
                                                onclick="konfirmasiBukaAkses('form-buka-akses-{{ $hasilUjian->id }}', '{{ $namaSiswa }}')" 
                                                class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl transition-all text-[10px] font-black flex items-center gap-2 shadow-lg shadow-amber-200 active:scale-95 uppercase tracking-widest mx-auto">
                                            <i class="fas fa-unlock-alt"></i> Buka Akses
                                        </button>
                                    </form>
                                @else
                                    <span class="text-gray-300 text-sm">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="w-16 h-16 bg-gray-50 text-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 text-3xl shadow-inner"><i class="fas fa-inbox"></i></div>
                                <h4 class="font-bold text-gray-400">Belum ada siswa yang terekam.</h4>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- SCRIPT: SweetAlert Buka Akses --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function konfirmasiBukaAkses(formId, namaSiswa) {
        Swal.fire({
            title: 'Buka Akses Ujian?',
            html: `Apakah Anda yakin ingin memberikan kesempatan lagi kepada <b>${namaSiswa}</b> untuk melanjutkan ujian ini?<br><br><span class="text-xs text-amber-600 font-bold bg-amber-50 p-2 rounded block border border-amber-100">Jawaban yang sudah diisi sebelumnya tidak akan hilang.</span>`,
            icon: 'warning',
            iconColor: '#f59e0b',
            showCancelButton: true,
            confirmButtonColor: '#f59e0b', // Amber-500
            cancelButtonColor: '#f1f5f9', 
            cancelButtonText: '<span style="color: #475569">Batal</span>',
            confirmButtonText: 'Ya, Izinkan Kembali!',
            reverseButtons: true,
            customClass: {
                confirmButton: 'shadow-lg shadow-amber-200 font-bold text-white',
                cancelButton: 'font-bold'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Membuka Blokir...',
                    text: 'Mohon tunggu sebentar.',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endsection