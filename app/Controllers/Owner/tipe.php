<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\TipeModel;

class Tipe extends BaseController
{
    public function index()
    {
        $model = new TipeModel();
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $tipe = $model->like('nama_tipe', $keyword)
                          ->orLike('fasilitas', $keyword)
                          ->findAll();
        } else {
            $tipe = $model->findAll();
        }

        return view('owner/tipe_lihat', [
            'tipe' => $tipe
        ]);
    }
}