<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanKaryawan extends Model
{
    protected $table = 'laporankaryawan'; // Nama tabel yang sesuai dengan database

    protected $fillable = [
    'nama_karyawan', 'pendapatan', 'pengeluaran', 'pendapatan_bersih', 'tanggal'
    ];
}
