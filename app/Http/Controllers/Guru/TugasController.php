<?php
namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tugas;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    // Menyimpan Tugas Baru
    public function store(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'batas_waktu' => 'required|date',
            'file_tugas' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
        ]);
        $tugas = new Tugas();
        $tugas->guru_mapel_id = $id;
        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->batas_waktu = $request->batas_waktu;

        // Jika guru menyertakan file soal tambahan
        if ($request->hasFile('file_tugas')) {
            $file = $request->file('file_tugas');
            $filename = time() . '_Tugas_' . str_replace(' ', '_', $file->getClientOriginalName());
            $path = $file->storeAs('tugas', $filename, 'public');
            $tugas->file_tugas = $filename;
        }

        $tugas->save();

        return back()->with('success', 'Tugas baru berhasil diberikan ke siswa!');
    }

    public function edit($id)
    {
        $tugas = Tugas::findOrFail($id);
        return view('guru.tugas.edit', compact('tugas'));
    }

    public function update(Request $request, $id)
    {
        $tugas = Tugas::findOrFail($id);
        
        $tugas->judul = $request->judul;
        $tugas->deskripsi = $request->deskripsi;
        $tugas->batas_waktu = $request->batas_waktu;

        // Jika guru upload lampiran soal baru
        if ($request->hasFile('file_tugas')) {
            // Hapus file lama
            if ($tugas->file_tugas && Storage::disk('public')->exists('tugas/' . $tugas->file_tugas)) {
                Storage::disk('public')->delete('tugas/' . $tugas->file_tugas);
            }
            $file = $request->file('file_tugas');
            $filename = time() . '_Tugas_' . str_replace(' ', '_', $file->getClientOriginalName());
            $file->storeAs('tugas', $filename, 'public');
            $tugas->file_tugas = $filename;
        }

        $tugas->save();
        return redirect('/guru/kelas/' . $tugas->guru_mapel_id)->with('success', 'Tugas berhasil diperbarui!');
    }

    // Menampilkan daftar siswa yang sudah/belum kumpul tugas
    public function koreksi($id)
    {
        $tugas = \App\Models\Tugas::findOrFail($id);
        
        // Ambil data pengumpulan tugas beserta data siswanya
        $pengumpulan = \App\Models\PengumpulanTugas::with('siswa')
                        ->where('tugas_id', $id)
                        ->get();

        return view('guru.tugas.koreksi', compact('tugas', 'pengumpulan'));
    }

    // Menyimpan nilai dari guru ke database
    public function simpanNilai(Request $request, $pengumpulan_id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
            'catatan_guru' => 'nullable|string'
        ]);

        $pengumpulan = \App\Models\PengumpulanTugas::findOrFail($pengumpulan_id);
        
        $pengumpulan->update([
            'nilai' => $request->nilai,
            'catatan_guru' => $request->catatan_guru
        ]);

        return back()->with('success', 'Nilai berhasil disimpan!');
    }

    public function destroy($id)
    {
        $tugas = Tugas::findOrFail($id);

        if ($tugas->file_tugas) {
            Storage::disk('public')->delete('tugas/' . $tugas->file_tugas);
        }

        $tugas->delete();
        return back()->with('success', 'Tugas berhasil dihapus!');
    }
}