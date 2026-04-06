<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;

class Kamar extends BaseController
{
    public function index()
    {
        if(session()->get('role') != 'owner'){
            return redirect()->to('/');
        }

        $db = \Config\Database::connect();
        $keyword = $this->request->getGet('keyword');

        $builder = $db->table('kamar');
        $builder->select('kamar.*, tipe_kamar.nama_tipe, tipe_kamar.fasilitas');
        $builder->join('tipe_kamar', 'tipe_kamar.id_tipe = kamar.id_tipe', 'left');

        if ($keyword) {
            $builder->like('nama_kamar', $keyword);
            $builder->orLike('nomor_kamar', $keyword);
            $builder->orLike('nama_tipe', $keyword);
        }

        $data['kamar'] = $builder->get()->getResultArray();
        $data['keyword'] = $keyword;

        return view('owner/kamar_lihat', $data);
    }
}