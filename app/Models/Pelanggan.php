<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = 'pelanggan'; // ← Tambahkan ini

    protected $fillable = ['nama', 'no_hp', 'alamat'];
}
