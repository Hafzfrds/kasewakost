<?php

namespace App\Models;

use CodeIgniter\Model;

class KamarModel extends Model
{
    protected $table = 'kamar';
    protected $primaryKey = 'id_kamar';

    protected $allowedFields = [
        'nama_kamar',
        'nomor_kamar',
        'harga',
        'status_kamar',
        'id_tipe',
        'foto',
        'created_at',
        'updated_at'
    ];

    protected $useTimestamps = true;

    // Join ke tipe kamar
    public function getKamarWithTipe()
    {
        return $this->select('
                kamar.*, 
                tipe_kamar.nama_tipe, 
                tipe_kamar.fasilitas
            ')
            ->join('tipe_kamar', 'tipe_kamar.id_tipe = kamar.id_tipe', 'left')
            ->orderBy('kamar.id_kamar', 'DESC')
            ->findAll();
    }
}