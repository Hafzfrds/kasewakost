<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;

class Riwayat extends BaseController
{
 public function index()
{
    $db = \Config\Database::connect();

    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');
    $keyword       = $this->request->getGet('keyword');

    $builder = $db->table('transaksi')
        ->select('
            transaksi.id_transaksi,
            transaksi.kode_transaksi,
            transaksi.total,
            transaksi.bayar,
            transaksi.kembalian,
            transaksi.jenis_transaksi,
            transaksi.status,
            transaksi.tanggal_transaksi,
            dt.tanggal_masuk,
            dt.jatuh_tempo,
            kamar.nama_kamar,
             kamar.nomor_kamar,
            COALESCE(penghuni.nama_penghuni, "-") as nama_penghuni,
            users.username as username_kasir
        ')
        ->join('detail_transaksi dt', 'dt.id_transaksi = transaksi.id_transaksi', 'left')
        ->join('kamar', 'kamar.id_kamar = dt.id_kamar', 'left')
        ->join('penghuni', 'penghuni.id_penghuni = dt.id_penghuni', 'left')
        ->join('users', 'users.id_user = transaksi.user_id', 'left');

    // FILTER TANGGAL
    
    if (!empty($tanggal_awal) && !empty($tanggal_akhir)) {
        $builder->where('DATE(transaksi.tanggal_transaksi) >=', $tanggal_awal);
        $builder->where('DATE(transaksi.tanggal_transaksi) <=', $tanggal_akhir);
    }
   // SEARCH 

    if (!empty($keyword)) {
        $builder->groupStart()
            ->like('penghuni.nama_penghuni', $keyword)
            ->orLike('kamar.nama_kamar', $keyword)
            ->orLike('transaksi.kode_transaksi', $keyword)
            ->orLike('transaksi.jenis_transaksi', $keyword)
        ->groupEnd();
    }

    $builder->orderBy('transaksi.id_transaksi', 'DESC');

    $data['riwayat'] = $builder->get()->getResultArray();

    
    $pendapatan = $db->table('transaksi')
        ->selectSum('total')
        ->where('status', 'lunas') // kalau status kamu beda, ganti di sini
        ->get()
        ->getRow()
        ->total ?? 0;

    $data['pendapatan_kasir'] = $pendapatan;

    return view('kasir/riwayat/index', $data);
}
}
