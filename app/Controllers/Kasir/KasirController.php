<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;

class KasirController extends BaseController
{
    public function dashboard()
    {
        $db = \Config\Database::connect();

      
        $kamarBooking = $db->table('kamar')
            ->where('status_kamar', 'booking')
            ->countAllResults();

      
        $kamarTerisi = $db->table('kamar')
            ->where('status_kamar', 'terisi')
            ->countAllResults();

 
        $kamarReady = $db->table('kamar')
            ->where('status_kamar', 'tersedia')
            ->countAllResults();

      
        $transaksi = $db->table('detail_transaksi dt')
            ->select('dt.nama_penghuni, k.nama_kamar, t.tanggal_transaksi, t.jenis_transaksi')
            ->join('kamar k', 'k.id_kamar = dt.id_kamar')
            ->join('transaksi t', 't.id_transaksi = dt.id_transaksi')
            ->orderBy('t.tanggal_transaksi', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        return view('kasir/dashboard', [
            'kamarBooking' => $kamarBooking,
            'kamarTerisi' => $kamarTerisi,
            'kamarReady' => $kamarReady,
            'transaksi' => $transaksi
        ]);
    }
}