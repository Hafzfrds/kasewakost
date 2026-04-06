<?php

namespace App\Models;
use CodeIgniter\Model;

class KeranjangModel extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';

    protected $allowedFields = [
        'id_kamar',
        'session_id',
        'created_at'
    ];

    public function getKeranjang($session_id)
    {
        return $this->db->table('keranjang')
            ->join('kamar', 'kamar.id_kamar = keranjang.id_kamar')
            ->join('tipe_kamar', 'tipe_kamar.id_tipe = kamar.id_tipe')
            ->where('keranjang.session_id', $session_id)
            ->get()
            ->getResultArray();
    }
}