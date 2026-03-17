<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\TipeModel;

class TipeController extends BaseController
{
    protected $tipeModel;

    public function __construct()
    {
        $this->tipeModel = new TipeModel();
    }

    // 📋 List tipe kamar
  public function index()
{
    $keyword = $this->request->getGet('keyword');

    if ($keyword) {
        $data['tipe'] = $this->tipeModel
            ->like('nama_tipe', $keyword)
            ->orLike('fasilitas', $keyword)
            ->orderBy('id_tipe', 'DESC') // 🔥 terbaru di atas
            ->findAll();
    } else {
        $data['tipe'] = $this->tipeModel
            ->orderBy('id_tipe', 'DESC') // 🔥 terbaru di atas
            ->findAll();
    }

    $data['keyword'] = $keyword;

    return view('admin/tipe/index', $data);
}

    // ➕ Form tambah
    public function create()
    {
        return view('admin/tipe/create');
    }

    // 💾 Simpan
    public function store()
    {
        $this->tipeModel->save([
            'nama_tipe'      => $this->request->getPost('nama_tipe'),
            'fasilitas'      => $this->request->getPost('fasilitas'),
            'harga_tambahan' => $this->request->getPost('harga_tambahan'),
        ]);

        return redirect()->to('/admin/tipe')->with('success', 'Tipe berhasil ditambahkan');
    }

    // ✏️ Form edit
    public function edit($id)
    {
        $data['tipe'] = $this->tipeModel->find($id);
        return view('admin/tipe/edit', $data);
    }

    // 🔄 Update
    public function update($id)
    {
        $this->tipeModel->update($id, [
            'nama_tipe'      => $this->request->getPost('nama_tipe'),
            'fasilitas'      => $this->request->getPost('fasilitas'),
            'harga_tambahan' => $this->request->getPost('harga_tambahan'),
        ]);

        return redirect()->to('/admin/tipe')->with('success', 'Tipe berhasil diupdate');
    }

    // ❌ Hapus
    public function delete($id)
    {
        $this->tipeModel->delete($id);
        return redirect()->to('/admin/tipe')->with('success', 'Tipe berhasil dihapus');
    }
}