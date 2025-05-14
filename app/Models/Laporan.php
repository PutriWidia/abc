<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan_keuangan'; 
    
    protected $fillable = [
        'nama_karyawan','nama_permainan', 'harga', 'status_pembayaran', 'tanggal',
    ];

    protected $dates = ['tanggal']; 

    protected $attributes = [
        'status_pembayaran' => 'belum dibayar'
    ];
}
