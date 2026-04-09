<?php

namespace App\Models;
use CodeIgniter\Model;

class DetailTransaksiModel extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_transaksi',
        'id_kamar',
        'id_penghuni', // ✅ WAJIB DITAMBAH
        'nama_penghuni',
        'foto_ktp',
        'harga',
        'lama_sewa',
        'tanggal_masuk',
        'jatuh_tempo',
        'subtotal',
        'status_sewa',
        'bayar'      
    ];
}