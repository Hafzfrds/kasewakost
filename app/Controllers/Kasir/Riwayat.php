<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;

class Riwayat extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        // Ambil input filter
        $tanggal_awal  = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $keyword       = $this->request->getGet('keyword');

        $builder = $db->table('transaksi')
            ->select('
                transaksi.id_transaksi,
                transaksi.kode_transaksi,
                transaksi.nama_penanggung_jawab,
                transaksi.total,
                transaksi.bayar,
                transaksi.kembalian,
                transaksi.jenis_transaksi,
                transaksi.status,
                transaksi.tanggal_transaksi,
                dt.tanggal_masuk,
                dt.jatuh_tempo,
                kamar.nama_kamar,
                penghuni.nama_penghuni
            ')
            ->join('detail_transaksi dt', 'dt.id_transaksi = transaksi.id_transaksi', 'left')
            ->join('kamar', 'kamar.id_kamar = dt.id_kamar', 'left')
            ->join('penghuni', 'penghuni.id_penghuni = dt.id_penghuni', 'left');

        // =============================
        // FILTER TANGGAL
        // =============================
        if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
            $builder->where('DATE(transaksi.tanggal_transaksi) >=', $tanggal_awal);
            $builder->where('DATE(transaksi.tanggal_transaksi) <=', $tanggal_akhir);
        }

        // =============================
        // SEARCH KEYWORD
        // =============================
        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('penghuni.nama_penghuni', $keyword)
                ->orLike('kamar.nama_kamar', $keyword)
                ->orLike('transaksi.kode_transaksi', $keyword)
                ->orLike('transaksi.jenis_transaksi', $keyword)
                ->orLike('transaksi.nama_penanggung_jawab', $keyword)
            ->groupEnd();
        }

        // Urutkan terbaru
        $builder->orderBy('transaksi.id_transaksi', 'DESC');

        $data['riwayat'] = $builder->get()->getResultArray();

        return view('kasir/riwayat/index', $data);
    }


    
}