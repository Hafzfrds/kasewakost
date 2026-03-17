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

    // 📋 Tampilkan semua kamar
   public function index()
{
    $keyword = $this->request->getGet('keyword');

    if ($keyword) {
        $data['kamar'] = $this->kamarModel
            ->select('kamar.*, tipe_kamar.nama_tipe, tipe_kamar.fasilitas,
                (kamar.harga + IFNULL(tipe_kamar.harga_tambahan,0)) as total_harga')
            ->join('tipe_kamar', 'tipe_kamar.id_tipe = kamar.id_tipe', 'left')
            ->like('kamar.nama_kamar', $keyword)
            ->orLike('kamar.nomor_kamar', $keyword)
            ->orLike('tipe_kamar.nama_tipe', $keyword)
            ->findAll();
    } else {
        $data['kamar'] = $this->kamarModel->getKamarWithTipe();
    }

    $data['keyword'] = $keyword;

    return view('admin/kamar/index', $data);
}

    // ➕ Form tambah kamar
    public function create()
    {
        $data['tipe'] = $this->tipeModel->findAll();

        return view('admin/kamar/create', $data);
    }

    // 💾 Simpan data kamar
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

    return redirect()->to('/admin/kamar')->with('success', 'Data kamar berhasil ditambahkan');
}

    // ✏️ Form edit kamar
    public function edit($id)
    {
        $data['kamar'] = $this->kamarModel->find($id);
        $data['tipe']  = $this->tipeModel->findAll();

        return view('admin/kamar/edit', $data);
    }

    // 🔄 Update kamar
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

    return redirect()->to('/admin/kamar')->with('success', 'Data kamar berhasil diupdate');
}

    // ❌ Hapus kamar
    public function delete($id)
    {
        $this->kamarModel->delete($id);

        return redirect()->to('/admin/kamar')->with('success', 'Data kamar berhasil dihapus');
    }
}