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

    // ================= SELECT =================
    $builder->select('
    penghuni.id_penghuni,
    penghuni.nama_penghuni,
    penghuni.status,
    penghuni.nik,
    penghuni.alamat,
    penghuni.no_hp,
    kamar.nomor_kamar as nama_kamar, 
    detail_transaksi.bayar as uang_masuk,
    detail_transaksi.subtotal as total,
    (detail_transaksi.subtotal - detail_transaksi.bayar) as sisa_bayar,
    detail_transaksi.status_sewa,
    detail_transaksi.id_detail
');
    // ================= LOGIC TANGGAL =================
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

    // ================= SEARCH =================
    $keyword = $this->request->getGet('keyword');

    if ($keyword) {
        $builder->groupStart()
            ->like('penghuni.nama_penghuni', $keyword)
            ->orLike('kamar.nomor_kamar', $keyword) // ✅ FIX
            ->orLike('penghuni.status', $keyword)
        ->groupEnd();
    }

    // ================= ORDER =================
    $builder->where('detail_transaksi.status_sewa !=', 'perpanjang');
    $builder->orderBy('detail_transaksi.id_detail', 'DESC');

    // ================= EXECUTE =================
    $data['penghuni'] = $builder->get()->getResultArray();
    $data['keyword'] = $keyword;

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