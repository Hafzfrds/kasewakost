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
        'foto', // ✅ tambahin ini
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
            tipe_kamar.fasilitas,
            tipe_kamar.harga_tambahan,
            (kamar.harga + IFNULL(tipe_kamar.harga_tambahan,0)) as total_harga
        ')
        ->join('tipe_kamar', 'tipe_kamar.id_tipe = kamar.id_tipe', 'left')
        ->findAll();
}
}