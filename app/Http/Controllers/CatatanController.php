<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CatatanController extends Controller
{
    // Menampilkan semua catatan
    public function index()
    {
        // Ambil semua data catatan dari database
        $catatan = Catatan::whereDate('created_at', Carbon::today())->where('nama_karyawan', Auth::guard('karyawan')->user()->username)->get();
        // Kirim data catatan ke view
        return view('catatan', compact('catatan'));
    }

    // Menambahkan catatan baru
    public function tambah(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama_permainan' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'status' => 'required|string|in:Lunas,Belum',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $waktuMulai = Carbon::now(); // Mengambil waktu saat ini

        // Tentukan durasi waktu berdasarkan permainan
        if ($validated['nama_permainan'] == 'Skuter') {
            $waktuSelesai = $waktuMulai->addMinutes(20); // Skuter 20 menit
        } elseif ($validated['nama_permainan'] == 'Melukis') {
            $waktuSelesai = null; // Styrofoam tidak ada waktu (biarkan kosong atau strip)
        } else {
            $waktuSelesai = $waktuMulai->addMinutes(15); // Selain skuter, durasi 15 menit
        }

        // Format waktu mulai dan selesai
        $formattedWaktu = $waktuMulai->format('H:i') . ' - ' . ($waktuSelesai ? $waktuSelesai->format('H:i') : '-');

        // Simpan data catatan baru ke dalam database
        Catatan::create([
            'nama_karyawan' => Auth::guard('karyawan')->user()->username,
            'nama' => $validated['nama_permainan'],
            'harga' => $validated['harga'],
            'status' => $validated['status'],
            'keterangan' => $validated['keterangan'] ?? '',  // Jika tidak ada keterangan, kosongkan
            'waktu' => $request->input('waktu'),  // Waktu saat data ditambahkan
        ]);

        // Redirect ke halaman yang sama dan tampilkan pesan sukses
        return redirect()->route('catatan.index')->with('success', 'Catatan berhasil ditambahkan!');
    }

    // Update status catatan
    public function update(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        // Cari catatan berdasarkan ID
        $catatan = Catatan::find($id);

        // Pastikan catatan ada
        if (!$catatan) {
            return response()->json(['success' => false]);
        }

        // Update status catatan
        $catatan->status = $status;
        $catatan->save();

        return response()->json(['success' => true]);
    }

    public function store(Request $request){

        $permainan = $request->input('nama_permainan');
        $waktu = $request->input('waktu');
        $harga = $this->calculateHarga($permainan);

        // Lakukan proses penyimpanan catatan
        Catatan::create([
            'nama_karyawan' => Auth::guard('karyawan')->user()->username,
            'nama' => $permainan,
            'waktu' => $waktu,
            'harga' => $harga,
            'status' => $request->input('status'),
            'keterangan' => $request->input('keterangan'),
        ]);
    }

    public function updateStatus(Request $request){

        $catatan = Catatan::find($request->id);
        if ($catatan) {
            $catatan->status = $request->status;
            $catatan->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function updateCheckbox(Request $request)
    {
        $item = Catatan::find($request->id);
        if ($item) {
            $item->checked = $request->checked;
            $item->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false], 404);
    }

    public function updateKeterangan(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:catatans,id',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $catatan = Catatan::find($validated['id']);
        $catatan->keterangan = $validated['keterangan'];
        $catatan->save();

        return response()->json(['success' => true]);
    }

    // Controller untuk update permainan
    public function updatePermainan(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|integer',
            'nama_permainan' => 'required|string',
            'harga' => 'required|integer',
        ]);

        $catatan = Catatan::find($validatedData['id']);
        if ($catatan) {
            $catatan->nama = $validatedData['nama_permainan'];
            $catatan->harga = $validatedData['harga'];
            $catatan->save();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Catatan tidak ditemukan']);
        }
    }


}
