<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

class Riwayat extends BaseController
{
    public function index()
{
    $db = \Config\Database::connect();

    $tanggal_awal  = $this->request->getGet('tanggal_awal');
    $tanggal_akhir = $this->request->getGet('tanggal_akhir');
    $keyword       = $this->request->getGet('keyword');

    $builder = $db->table('transaksi');

    $builder->select('
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
        penghuni.nama_penghuni
    ');

    $builder->join('(SELECT id_transaksi, 
                    MAX(tanggal_masuk) as tanggal_masuk,
                    MAX(jatuh_tempo) as jatuh_tempo,
                    MAX(id_kamar) as id_kamar,
                    MAX(id_penghuni) as id_penghuni
             FROM detail_transaksi 
             GROUP BY id_transaksi) dt', 
             'dt.id_transaksi = transaksi.id_transaksi', 'left');

    $builder->join('kamar', 'kamar.id_kamar = dt.id_kamar', 'left');
    $builder->join('penghuni', 'penghuni.id_penghuni = dt.id_penghuni', 'left');

    if (!empty($tanggal_awal)) {
        $builder->where('DATE(transaksi.tanggal_transaksi) >=', $tanggal_awal);
    }

    if (!empty($tanggal_akhir)) {
        $builder->where('DATE(transaksi.tanggal_transaksi) <=', $tanggal_akhir);
    }

    if (!empty($keyword)) {
        $builder->groupStart()
            ->like('transaksi.kode_transaksi', $keyword)
            ->orLike('penghuni.nama_penghuni', $keyword)
            ->orLike('kamar.nama_kamar', $keyword)
            ->groupEnd();
    }

    $builder->orderBy('transaksi.id_transaksi', 'DESC');

    $data['riwayat'] = $builder->get()->getResultArray();


    $today = date('Y-m-d');

    $pendapatanHariIni = $db->table('transaksi')
        ->selectSum('total')
        ->where('DATE(tanggal_transaksi)', $today)
        ->where('status', 'lunas') // kalau status kamu beda, ganti di sini
        ->get()
        ->getRow()
        ->total ?? 0;

    $data['pendapatan_hari_ini'] = $pendapatanHariIni;

    return view('owner/riwayat/index', $data);
}
    public function exportPdf()
    {
        $db = \Config\Database::connect();

        $tanggal_awal  = $this->request->getGet('tanggal_awal');
        $tanggal_akhir = $this->request->getGet('tanggal_akhir');
        $keyword       = $this->request->getGet('keyword');

        $builder = $db->table('transaksi');

        $builder->select('
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
            penghuni.nama_penghuni
        ');

        $builder->join('(SELECT id_transaksi, 
                        MAX(tanggal_masuk) as tanggal_masuk,
                        MAX(jatuh_tempo) as jatuh_tempo,
                        MAX(id_kamar) as id_kamar,
                        MAX(id_penghuni) as id_penghuni
                 FROM detail_transaksi 
                 GROUP BY id_transaksi) dt', 
                 'dt.id_transaksi = transaksi.id_transaksi', 'left');

        $builder->join('kamar', 'kamar.id_kamar = dt.id_kamar', 'left');
        $builder->join('penghuni', 'penghuni.id_penghuni = dt.id_penghuni', 'left');

      
        if (!empty($tanggal_awal)) {
            $builder->where('DATE(transaksi.tanggal_transaksi) >=', $tanggal_awal);
        }

        if (!empty($tanggal_akhir)) {
            $builder->where('DATE(transaksi.tanggal_transaksi) <=', $tanggal_akhir);
        }

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('transaksi.kode_transaksi', $keyword)
                ->orLike('penghuni.nama_penghuni', $keyword)
                ->orLike('kamar.nama_kamar', $keyword)
                ->groupEnd();
        }

        $builder->orderBy('transaksi.id_transaksi', 'DESC');

        $data['riwayat'] = $builder->get()->getResultArray();

       
        $dompdf = new Dompdf();
        $html = view('owner/riwayat/pdf', $data);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('riwayat-transaksi.pdf', ['Attachment' => false]);
    }
}