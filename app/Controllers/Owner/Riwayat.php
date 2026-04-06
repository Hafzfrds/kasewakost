<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;

class Riwayat extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data['riwayat'] = $db->table('transaksi')
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
            ->join('penghuni', 'penghuni.id_penghuni = dt.id_penghuni', 'left')
            ->orderBy('transaksi.id_transaksi', 'DESC')
            ->get()
            ->getResultArray();

        return view('owner/riwayat/index', $data);
    }
}