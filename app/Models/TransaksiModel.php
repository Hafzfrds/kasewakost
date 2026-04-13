<?php

namespace App\Models;
use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'kode_transaksi',
        'tanggal_transaksi',
        'nama_penanggung_jawab',
        'no_hp',
        'total',
        'bayar',
        'kembalian',
        'jenis_transaksi',
        'status',
        'tanggal_booking',
        'jatuh_tempo_booking',
        'user_id',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}