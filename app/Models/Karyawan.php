<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Karyawan extends Authenticatable
{
    use HasFactory;

    protected $table = 'karyawans';

    protected $fillable = [
        'username',
        'email',
        'jenis_kelamin',
        'no_telp',
        'password',
        'foto',
    ];

    protected $hidden = ['password'];
}
