<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;

class Penghuni extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('detail_transaksi');

        $builder->join('transaksi', 'transaksi.id_transaksi = detail_transaksi.id_transaksi');
        $builder->join('penghuni', 'penghuni.id_penghuni = detail_transaksi.id_penghuni');
        $builder->join('kamar', 'kamar.id_kamar = detail_transaksi.id_kamar');

        // ================= SELECT NORMAL =================
        $builder->select('
            penghuni.id_penghuni,
            penghuni.status,
            penghuni.nama_penghuni,
            penghuni.id_kamar,
            kamar.nama_kamar,
            detail_transaksi.bayar as uang_masuk,
            detail_transaksi.subtotal as total,
            (detail_transaksi.subtotal - detail_transaksi.bayar) as sisa_bayar,
            detail_transaksi.status_sewa,
            detail_transaksi.id_detail
        ');

        // ================= LOGIC TANGGAL =================
        // 🔥 kalau masih booking → pakai tanggal booking
        // 🔥 kalau sudah lunas (aktif) → pakai tanggal masuk asli

        $builder->select("
            CASE 
                WHEN detail_transaksi.status_sewa = 'booking' 
                THEN transaksi.tanggal_booking 
                ELSE detail_transaksi.tanggal_masuk 
            END as tanggal_masuk
        ", false);

        $builder->select("
            CASE 
                WHEN detail_transaksi.status_sewa = 'booking' 
                THEN transaksi.jatuh_tempo_booking 
                ELSE detail_transaksi.jatuh_tempo 
            END as jatuh_tempo
        ", false);

        $builder->orderBy('detail_transaksi.id_detail', 'DESC');

        $data['penghuni'] = $builder->get()->getResultArray();

        return view('kasir/penghuni/index', $data);
    }

    // =============================
    // BERHENTIKAN PENGHUNI
    // =============================
    public function berhentikan($id_penghuni)
    {
        $db = \Config\Database::connect();

        $penghuni = $db->table('penghuni')
            ->where('id_penghuni', $id_penghuni)
            ->get()
            ->getRowArray();

        if (!$penghuni) {
            return redirect()->back()->with('error', 'Penghuni tidak ditemukan');
        }

        $detail = $db->table('detail_transaksi')
            ->where('id_detail', $penghuni['id_detail'])
            ->get()
            ->getRowArray();

        $db->transStart();

        // 1. Update penghuni
        $db->table('penghuni')
            ->where('id_penghuni', $id_penghuni)
            ->update([
                'status' => 'keluar',
                'tanggal_keluar' => date('Y-m-d')
            ]);

        // 2. Update kamar
        if ($detail && $detail['id_kamar']) {
            $db->table('kamar')
                ->where('id_kamar', $detail['id_kamar'])
                ->update([
                    'status_kamar' => 'tersedia'
                ]);
        }

        // 3. Update detail transaksi
        $db->table('detail_transaksi')
            ->where('id_detail', $penghuni['id_detail'])
            ->update([
                'status_sewa' => 'selesai'
            ]);

        $db->transComplete();

        return redirect()->to('/kasir/penghuni')->with('success', 'Penghuni berhasil dihentikan');
    }
}