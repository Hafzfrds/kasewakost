<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;

class OwnerController extends BaseController
{
    public function dashboard()
    {
        $db = \Config\Database::connect();

        $totalUsers = $db->table('users')->countAllResults();

        $totalKamar = $db->table('kamar')->countAllResults();

        $totalTipe = $db->table('tipe_kamar')->countAllResults();

        $kamarBooking = $db->table('kamar')
            ->where('status_kamar', 'booking')
            ->countAllResults();

        $kamarTerisi = $db->table('kamar')
            ->where('status_kamar', 'terisi')
            ->countAllResults();

        $totalPenghuni = $db->table('penghuni')->countAllResults();

        $transaksi = $db->table('detail_transaksi dt')
            ->select('dt.nama_penghuni, k.nama_kamar, t.tanggal_transaksi, t.jenis_transaksi')
            ->join('kamar k', 'k.id_kamar = dt.id_kamar')
            ->join('transaksi t', 't.id_transaksi = dt.id_transaksi')
            ->orderBy('t.tanggal_transaksi', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        return view('owner/dashboard', [
            'totalUsers' => $totalUsers,
            'totalKamar' => $totalKamar,
            'totalTipe' => $totalTipe,
            'kamarBooking' => $kamarBooking,
            'kamarTerisi' => $kamarTerisi,
            'totalPenghuni' => $totalPenghuni,
            'transaksi' => $transaksi
        ]);
    }
}