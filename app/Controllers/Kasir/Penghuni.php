<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;

class Penghuni extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $data['penghuni'] = $db->table('detail_transaksi')
            ->join('transaksi', 'transaksi.id_transaksi = detail_transaksi.id_transaksi')
            ->join('penghuni', 'penghuni.id_penghuni = detail_transaksi.id_penghuni')
            ->join('kamar', 'kamar.id_kamar = detail_transaksi.id_kamar')
            ->select('
                penghuni.nama_penghuni,
                kamar.nama_kamar,
                transaksi.bayar as uang_masuk,
                transaksi.total,
                (transaksi.total - transaksi.bayar) as sisa_bayar,
                detail_transaksi.tanggal_masuk,
                detail_transaksi.jatuh_tempo,
                detail_transaksi.status_sewa,
                detail_transaksi.id_detail
            ')
            ->orderBy('detail_transaksi.id_detail','DESC')
            ->get()
            ->getResultArray();

        return view('kasir/penghuni/index', $data);
    }
}