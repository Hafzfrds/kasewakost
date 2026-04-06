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

    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $data['tipe'] = $this->tipeModel
                ->groupStart()
                    ->like('nama_tipe', $keyword)
                    ->orLike('fasilitas', $keyword)
                ->groupEnd()
                ->orderBy('id_tipe', 'DESC')
                ->findAll();
        } else {
            $data['tipe'] = $this->tipeModel
                ->orderBy('id_tipe', 'DESC')
                ->findAll();
        }

        $data['keyword'] = $keyword;

        return view('admin/tipe/index', $data);
    }

    public function create()
    {
        return view('admin/tipe/create');
    }

    // SIMPAN
    public function store()
    {
        $this->tipeModel->save([
            'nama_tipe' => $this->request->getPost('nama_tipe'),
            'fasilitas' => $this->request->getPost('fasilitas'),
        ]);

        // LOG
        logActivity(
            'INSERT TIPE',
            'Menambahkan tipe kamar ' . $this->request->getPost('nama_tipe')
        );

        return redirect()->to('/admin/tipe')->with('success', 'Tipe berhasil ditambahkan');
    }

    public function edit($id)
    {
        $data['tipe'] = $this->tipeModel->find($id);

        if (!$data['tipe']) {
            return redirect()->to('/admin/tipe')->with('error', 'Data tidak ditemukan');
        }

        return view('admin/tipe/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $this->tipeModel->update($id, [
            'nama_tipe' => $this->request->getPost('nama_tipe'),
            'fasilitas' => $this->request->getPost('fasilitas'),
        ]);

        // LOG
        logActivity(
            'UPDATE TIPE',
            'Mengupdate tipe kamar ' . $this->request->getPost('nama_tipe')
        );

        return redirect()->to('/admin/tipe')->with('success', 'Tipe berhasil diupdate');
    }

    // DELETE
    public function delete($id)
    {
        $tipe = $this->tipeModel->find($id);

        $this->tipeModel->delete($id);

        // LOG
        logActivity(
            'DELETE TIPE',
            'Menghapus tipe kamar ' . $tipe['nama_tipe']
        );

        return redirect()->to('/admin/tipe')->with('success', 'Tipe berhasil dihapus');
    }
}