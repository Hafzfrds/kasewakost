<?php

namespace App\Models;
use CodeIgniter\Model;

class PenghuniModel extends Model
{
    protected $table = 'penghuni';
    protected $primaryKey = 'id_penghuni';

    protected $allowedFields = [
        'id_detail',
        'id_kamar',
        'nama_penghuni',
        'nik',
        'no_hp',
        'alamat',
        'status',
        'tanggal_masuk',
        'tanggal_keluar'
    ];
}