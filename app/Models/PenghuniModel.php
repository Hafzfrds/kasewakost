<?php

namespace App\Models;
use CodeIgniter\Model;

class PenghuniModel extends Model
{
    protected $table = 'penghuni';
    protected $primaryKey = 'id_penghuni';

    protected $allowedFields = [
        'id_detail',
        'nama_penghuni',
        'nik',
        'no_hp',
        'alamat'
    ];
}