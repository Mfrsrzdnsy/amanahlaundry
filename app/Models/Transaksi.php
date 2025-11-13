<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi'; // ← WAJIB

    protected $fillable = [
        'kode_invoice',
        'id_pelanggan',
        'tgl_masuk',
        'tgl_selesai',
        'status',
        'dibayar',
        'total',
        'foto',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
