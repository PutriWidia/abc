<?php

namespace App\Http\Controllers;
use App\Models\Laporan;
use App\Models\Catatan;
use App\Models\Pengeluaran;
use Illuminate\Support\Facades\Auth;


use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index()
    {
        session(['previous_page' => url()->previous()]);
        
        // Ambil data laporan harian yang diperlukan
        $data = Laporan::whereDate('tanggal', now()->toDateString())->where('nama_karyawan', Auth::guard('karyawan')->user()->username)
        ->get();

        $pendapatan = Laporan::whereDate('tanggal', now()->toDateString())
        ->sum('harga');

        // Kirimkan data ke view
        return view('laporan-keuangan-harian', compact('data', 'pendapatan'));
    }

    public function tambah(Request $request)
{
    try {
        $laporan = $request->input('laporan');
        
        foreach ($laporan as $item) {
            // Cek apakah data catatan ada berdasarkan idData
            // $deleteData = Catatan::find($item['idData']);
            
            // if ($deleteData) {
                // Menyimpan laporan ke database
                $laporanBaru = Laporan::create([
                    'nama_karyawan' => Auth::guard('karyawan')->user()->username,
                    'nama_permainan' => $item['nama_permainan'],
                    'harga' => preg_replace('/[^\d]/', '', $item['harga']),
                    'status_pembayaran' => $item['status'],
                    'tanggal' => now(),
                ]);

                // Hanya hapus catatan jika laporan berhasil disimpan
                // if ($laporanBaru) {
                //     $deleteData->delete();
                //     Pengeluaran::query()->delete();
                // }
            // }
        }

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => $e->getMessage()]);
    }
}


}
