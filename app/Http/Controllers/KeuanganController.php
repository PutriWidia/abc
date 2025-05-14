<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Karyawan;
use App\Models\LaporanKaryawan;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        // $periode = $request->input('periode', 'harian');
        // $laporans = Laporan::query();

        // if ($periode == 'harian') {
        //     $laporans->whereDate('tanggal', now()->toDateString());
        // } elseif ($periode == 'mingguan') {
        //     $laporans->whereBetween('tanggal', [now()->startOfWeek(), now()->endOfWeek()]);
        // } elseif ($periode == 'bulanan') {
        //     $laporans->whereMonth('tanggal', now()->month);
        // }

       // Kelompokkan laporan per karyawan
        // $data = Karyawan::whereIn('id', $laporans->pluck('id'))->get();
        $data = LaporanKaryawan::all();

        return view('keuangan-admin', compact('data'));
    }

    public function getdata($username)
    {
        // dd($username);
        $data = Laporan::whereDate('tanggal', now()->toDateString())->where('nama_karyawan', $username)
        ->get();

        $pendapatan = Laporan::whereDate('tanggal', now()->toDateString())
        ->sum('harga');
        // $laporan = Laporan::where('id', $request->id)->first();
        return view('laporan-keuangan-harian', compact('data', 'pendapatan'));
    }
}

