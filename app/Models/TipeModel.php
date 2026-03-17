<?php

namespace App\Models;

use CodeIgniter\Model;

class TipeModel extends Model
{
    protected $table = 'tipe_kamar';
    protected $primaryKey = 'id_tipe';

    protected $allowedFields = [
        'nama_tipe',
        'fasilitas',
        'harga_tambahan'
    ];
}