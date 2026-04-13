<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KamarModel;
use App\Models\TipeModel;

class KamarController extends BaseController
{
    protected $kamarModel;
    protected $tipeModel;

    public function __construct()
    {
        $this->kamarModel = new KamarModel();
        $this->tipeModel  = new TipeModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $data['kamar'] = $this->kamarModel
                ->select('kamar.*, tipe_kamar.nama_tipe, tipe_kamar.fasilitas')
                ->join('tipe_kamar', 'tipe_kamar.id_tipe = kamar.id_tipe', 'left')
                ->groupStart()
                    ->like('kamar.nama_kamar', $keyword)
                    ->orLike('kamar.nomor_kamar', $keyword)
                    ->orLike('tipe_kamar.nama_tipe', $keyword)
                ->groupEnd()
                ->findAll();
        } else {
            $data['kamar'] = $this->kamarModel->getKamarWithTipe();
        }

        $data['keyword'] = $keyword;

        return view('admin/kamar/index', $data);
    }

    public function create()
    {
        $data['tipe'] = $this->tipeModel->findAll();
        return view('admin/kamar/create', $data);
    }

    // SIMPAN KAMAR
    public function store()
    {
        $file = $this->request->getFile('foto');
        $namaFoto = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move('uploads/kamar/', $namaFoto);
        }

        $this->kamarModel->save([
            'nama_kamar'   => $this->request->getPost('nama_kamar'),
            'nomor_kamar'  => $this->request->getPost('nomor_kamar'),
            'harga'        => $this->request->getPost('harga'),
            'status_kamar' => $this->request->getPost('status_kamar'),
            'id_tipe'      => $this->request->getPost('id_tipe'),
            'foto'         => $namaFoto,
        ]);

        // LOG ACTIVITY
        logActivity(
            'INSERT KAMAR',
            'Menambahkan kamar nomor ' . $this->request->getPost('nomor_kamar')
        );

        return redirect()->to('/admin/kamar')->with('success', 'Data kamar berhasil ditambahkan');
    }

    // FORM EDIT
    public function edit($id)
    {
        $data['kamar'] = $this->kamarModel->find($id);
        $data['tipe']  = $this->tipeModel->findAll();

        return view('admin/kamar/edit', $data);
    }

    // UPDATE KAMAR
    public function update($id)
    {
        $file = $this->request->getFile('foto');
        $kamar = $this->kamarModel->find($id);

        $namaFoto = $kamar['foto'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFoto = $file->getRandomName();
            $file->move('uploads/kamar/', $namaFoto);
        }

        $this->kamarModel->update($id, [
            'nama_kamar'   => $this->request->getPost('nama_kamar'),
            'nomor_kamar'  => $this->request->getPost('nomor_kamar'),
            'harga'        => $this->request->getPost('harga'),
            'status_kamar' => $this->request->getPost('status_kamar'),
            'id_tipe'      => $this->request->getPost('id_tipe'),
            'foto'         => $namaFoto,
        ]);

        // LOG ACTIVITY
        logActivity(
            'UPDATE KAMAR',
            'Mengupdate kamar nomor ' . $this->request->getPost('nomor_kamar')
        );

        return redirect()->to('/admin/kamar')->with('success', 'Data kamar berhasil diupdate');
    }

    // HAPUS KAMAR
   public function delete($id)
{
    $kamar = $this->kamarModel->find($id);

    if (!$kamar) {
        return redirect()->to('/admin/kamar')
            ->with('error', 'Data kamar tidak ditemukan');
    }

    // CEK STATUS KAMAR 
    if ($kamar['status_kamar'] === 'terisi' || $kamar['status_kamar'] === 'booking') {
        return redirect()->to('/admin/kamar')
            ->with('error', 'Kamar tidak bisa dihapus karena sedang terisi atau dibooking');
    }

    $this->kamarModel->delete($id);

    // LOG ACTIVITY
    logActivity(
        'DELETE KAMAR',
        'Menghapus kamar nomor ' . $kamar['nomor_kamar']
    );

    return redirect()->to('/admin/kamar')
        ->with('success', 'Data kamar berhasil dihapus');
}
}