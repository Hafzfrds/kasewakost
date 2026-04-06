<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $db = \Config\Database::connect();

        // Total Users
        $totalUsers = $db->table('users')->countAllResults();

        // Total Kamar
        $totalKamar = $db->table('kamar')->countAllResults();

        // Total Tipe
        $totalTipe = $db->table('tipe_kamar')->countAllResults();

        // Kamar Booking
        $kamarBooking = $db->table('kamar')
            ->where('status_kamar', 'booking')
            ->countAllResults();

        // Kamar Terisi
        $kamarTerisi = $db->table('kamar')
            ->where('status_kamar', 'terisi')
            ->countAllResults();

        // Data transaksi terbaru (join)
        $transaksi = $db->table('detail_transaksi dt')
            ->select('dt.nama_penghuni, k.nama_kamar, t.tanggal_transaksi, t.jenis_transaksi')
            ->join('kamar k', 'k.id_kamar = dt.id_kamar')
            ->join('transaksi t', 't.id_transaksi = dt.id_transaksi')
            ->orderBy('t.tanggal_transaksi', 'DESC')
            ->limit(5)
            ->get()
            ->getResult();

        return view('admin/dashboard', [
            'totalUsers' => $totalUsers,
            'totalKamar' => $totalKamar,
            'totalTipe' => $totalTipe,
            'kamarBooking' => $kamarBooking,
            'kamarTerisi' => $kamarTerisi,
            'transaksi' => $transaksi
        ]);
    }
}