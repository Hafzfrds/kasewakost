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
        $data['kamar'] = $this->kamarModel->getKamarWithTipe();
        return view('kasir/produk', $data);
    }
}