<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\KamarModel;

class Produk extends BaseController
{
    protected $kamarModel;

    public function __construct()
    {
        $this->kamarModel = new KamarModel();
    }

    public function index()
{
    $db = \Config\Database::connect();
    $builder = $db->table('kamar');

    $builder->select('kamar.*, tipe_kamar.nama_tipe, tipe_kamar.fasilitas');
    $builder->join('tipe_kamar', 'tipe_kamar.id_tipe = kamar.id_tipe', 'left');

    $keyword = $this->request->getGet('keyword');

    if ($keyword) {
        $builder->groupStart()
            ->like('kamar.nomor_kamar', $keyword)
            ->orLike('tipe_kamar.nama_tipe', $keyword)
            ->orLike('tipe_kamar.fasilitas', $keyword)
        ->groupEnd();
    }

    $data['kamar'] = $builder->get()->getResultArray();
    $data['keyword'] = $keyword;

    return view('kasir/produk', $data);
}
}