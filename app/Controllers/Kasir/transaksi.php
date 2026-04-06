<?php

namespace App\Controllers\Kasir;

use App\Controllers\BaseController;
use App\Models\TransaksiModel;
use App\Models\DetailTransaksiModel;
use App\Models\PenghuniModel;
use App\Models\KamarModel;
use Dompdf\Dompdf;
use App\Models\LogActivityModel;
class Transaksi extends BaseController
{
    // ===============================
    // FORM BAYAR LANGSUNG
    // ===============================
    public function bayar($id_kamar)
    {
        $kamarModel = new KamarModel();
        $data['kamar'] = $kamarModel->find($id_kamar);

        return view('kasir/transaksi/bayarlangsung', $data);
    }

    // ===============================
    // SIMPAN BAYAR LANGSUNG
    // ===============================
   public function simpanBayar()
{
    $transaksiModel = new TransaksiModel();
    $detailModel    = new DetailTransaksiModel();
    $penghuniModel  = new PenghuniModel();
    $kamarModel     = new KamarModel();

    $id_kamar      = $this->request->getPost('id_kamar');
    $harga         = $this->request->getPost('harga');
    $lama_sewa     = $this->request->getPost('lama_sewa');
    $tanggal_masuk = $this->request->getPost('tanggal_masuk');
    $jatuh_tempo   = $this->request->getPost('jatuh_tempo');

   $subtotal  = $harga * $lama_sewa;
$bayar     = $this->request->getPost('bayar');

// VALIDASI UANG KURANG
if ($bayar < $subtotal) {
    return redirect()->back()->withInput()->with('error', 'Uang tidak cukup untuk melakukan pembayaran');
}

$kembalian = $bayar - $subtotal;
    // ================= SIMPAN TRANSAKSI =================
    $transaksiModel->insert([
        'kode_transaksi' => 'TRX' . date('YmdHis'),
        'nama_penanggung_jawab' => $this->request->getPost('penanggung_jawab'),
        'no_hp' => $this->request->getPost('no_hp'),
        'tanggal_transaksi' => date('Y-m-d'),
        'total' => $subtotal,
        'bayar' => $bayar,
        'kembalian' => $kembalian,
        'jenis_transaksi' => 'bayar_langsung',
        'status' => 'lunas'
    ]);

    $id_transaksi = $transaksiModel->insertID();

    // ================= DETAIL TRANSAKSI =================
    $detailModel->insert([
        'id_transaksi' => $id_transaksi,
        'id_kamar' => $id_kamar,
        'harga' => $harga,
        'lama_sewa' => $lama_sewa,
        'tanggal_masuk' => $tanggal_masuk,
        'jatuh_tempo' => $jatuh_tempo,
        'subtotal' => $subtotal,
        'status_sewa' => 'aktif'
    ]);

    $id_detail = $detailModel->insertID();

    // ================= SIMPAN PENGHUNI 1 =================
    $penghuniModel->insert([
        'id_detail'     => $id_detail,
        'nama_penghuni' => $this->request->getPost('penghuni1'),
        'nik'           => $this->request->getPost('nik1'),
        'no_hp'         => $this->request->getPost('hp1'),
        'alamat'        => $this->request->getPost('alamat1'),
    ]);

    $id_penghuni = $penghuniModel->insertID();

    // UPDATE detail_transaksi dengan penghuni
    $detailModel->update($id_detail, [
        'id_penghuni' => $id_penghuni,
        'nama_penghuni' => $this->request->getPost('penghuni1')
    ]);

    // ================= PENGHUNI 2 =================
    if ($this->request->getPost('penghuni2')) {
        $penghuniModel->insert([
            'id_detail'     => $id_detail,
            'nama_penghuni' => $this->request->getPost('penghuni2'),
            'nik'           => $this->request->getPost('nik2'),
            'no_hp'         => $this->request->getPost('hp2'),
            'alamat'        => $this->request->getPost('alamat2'),
        ]);
    }

    // ================= UPDATE STATUS KAMAR =================
    $kamarModel->update($id_kamar, [
        'status_kamar' => 'terisi'
    ]);

    $this->logAktivitas(
    'Bayar Langsung',
    'Bayar kamar ID ' . $id_kamar . ' total ' . $subtotal
);
   return redirect()->to('/kasir/transaksi/cetakStruk/' . $id_transaksi);
}

    // ===============================
    // FORM BOOKING
    // ===============================
    public function booking($id_kamar)
    {
        $kamarModel = new KamarModel();
        $data['kamar'] = $kamarModel->find($id_kamar);

        return view('kasir/transaksi/booking', $data);
    }

    // ===============================
    // SIMPAN BOOKING (DP)
    // ===============================
    public function simpanBooking()
{
    $transaksiModel = new TransaksiModel();
    $detailModel    = new DetailTransaksiModel();
    $penghuniModel  = new PenghuniModel();
    $kamarModel     = new KamarModel();

    $id_kamar      = $this->request->getPost('id_kamar');
    $harga         = $this->request->getPost('harga');
    $lama_sewa     = $this->request->getPost('lama_sewa');
    $tanggal_masuk = $this->request->getPost('tanggal_masuk');
    $jatuh_tempo   = $this->request->getPost('jatuh_tempo');

    $subtotal = $harga * $lama_sewa;
    $dp       = $this->request->getPost('dp');

    // ================= SIMPAN TRANSAKSI =================
    $transaksiModel->insert([
        'kode_transaksi' => 'TRX' . date('YmdHis'),
        'nama_penanggung_jawab' => $this->request->getPost('penanggung_jawab'),
        'no_hp' => $this->request->getPost('no_hp'),
        'tanggal_transaksi' => date('Y-m-d'),
        'total' => $subtotal,
        'bayar' => $dp,
        'kembalian' => 0,
        'jenis_transaksi' => 'booking',
        'status' => 'booking'
    ]);

    $id_transaksi = $transaksiModel->insertID();

    // ================= DETAIL TRANSAKSI =================
    $detailModel->insert([
        'id_transaksi' => $id_transaksi,
        'id_kamar' => $id_kamar,
        'harga' => $harga,
        'lama_sewa' => $lama_sewa,
        'tanggal_masuk' => $tanggal_masuk,
        'jatuh_tempo' => $jatuh_tempo,
        'subtotal' => $subtotal,
        'status_sewa' => 'booking'
    ]);

    $id_detail = $detailModel->insertID();

    // ================= SIMPAN PENGHUNI 1 =================
    $penghuniModel->insert([
        'id_detail'     => $id_detail,
        'nama_penghuni' => $this->request->getPost('penghuni1'),
        'nik'           => $this->request->getPost('nik1'),
        'no_hp'         => $this->request->getPost('hp1'),
        'alamat'        => $this->request->getPost('alamat1'),
    ]);

    $id_penghuni = $penghuniModel->insertID();

    // UPDATE detail_transaksi biar tidak NULL
    $detailModel->update($id_detail, [
        'id_penghuni'   => $id_penghuni,
        'nama_penghuni' => $this->request->getPost('penghuni1')
    ]);

    // ================= SIMPAN PENGHUNI 2 (OPSIONAL) =================
    if ($this->request->getPost('penghuni2')) {
        $penghuniModel->insert([
            'id_detail'     => $id_detail,
            'nama_penghuni' => $this->request->getPost('penghuni2'),
            'nik'           => $this->request->getPost('nik2'),
            'no_hp'         => $this->request->getPost('hp2'),
            'alamat'        => $this->request->getPost('alamat2'),
        ]);
    }

    // ================= UPDATE STATUS KAMAR =================
    $kamarModel->update($id_kamar, [
        'status_kamar' => 'booking'
    ]);

    $this->logAktivitas(
    'Booking Kamar',
    'Booking kamar ID ' . $id_kamar . ' DP ' . $dp
);

   return redirect()->to('/kasir/transaksi/cetakStruk/' . $id_transaksi);
}

    // ===============================
    // FORM PELUNASAN
    // ===============================
    public function pelunasan($id_detail)
    {
        $detailModel = new DetailTransaksiModel();

        $detail = $detailModel
            ->select('detail_transaksi.*, transaksi.total, transaksi.bayar, transaksi.nama_penanggung_jawab, transaksi.no_hp, kamar.nama_kamar, penghuni.nama_penghuni')
            ->join('transaksi', 'transaksi.id_transaksi = detail_transaksi.id_transaksi')
            ->join('kamar', 'kamar.id_kamar = detail_transaksi.id_kamar')
            ->join('penghuni', 'penghuni.id_penghuni = detail_transaksi.id_penghuni')
            ->where('detail_transaksi.id_detail', $id_detail)
            ->first();

        if (!$detail) {
            return redirect()->to('/kasir/penghuni')->with('error', 'Data tidak ditemukan');
        }

        $detail['sisa_bayar'] = $detail['total'] - $detail['bayar'];
        $data['detail'] = $detail;

        return view('kasir/transaksi/pelunasan', $data);
    }

    // ===============================
    // SIMPAN PELUNASAN
    // ===============================
   public function simpanPelunasan()
{
    $transaksiModel = new TransaksiModel();
    $detailModel = new DetailTransaksiModel();
    $kamarModel = new KamarModel();

    $id_detail = $this->request->getPost('id_detail');
    $bayar     = $this->request->getPost('bayar');

    $detail = $detailModel->find($id_detail);
    if (!$detail) {
        return redirect()->back()->with('error', 'Detail tidak ditemukan');
    }

    $transaksi = $transaksiModel->find($detail['id_transaksi']);

    $total       = $transaksi['total'];
    $sudahBayar  = $transaksi['bayar'];

    // HITUNG TOTAL BAYAR
    $totalBayar = $sudahBayar + $bayar;

    // HITUNG SISA
    $sisa = $total - $totalBayar;

    // VALIDASI UANG KURANG
    if ($totalBayar < $total) {
        return redirect()->back()->with('error', 'Uang pelunasan masih kurang');
    }

    // JIKA SUDAH LUNAS
    $status = 'lunas';
    $kembalian = abs($sisa);

    $kamarModel->update($detail['id_kamar'], [
        'status_kamar' => 'terisi'
    ]);

    $detailModel->update($id_detail, [
        'status_sewa' => 'aktif'
    ]);

    // UPDATE TRANSAKSI
    $transaksiModel->update($detail['id_transaksi'], [
        'bayar' => $totalBayar,
        'kembalian' => $kembalian,
        'status' => $status
    ]);

    $this->logAktivitas(
    'Pelunasan',
    'Pelunasan transaksi ID ' . $detail['id_transaksi']
);
    return redirect()->to('/kasir/penghuni')->with('success', 'Pelunasan berhasil');
}

    // ===============================
    // FORM PERPANJANG
    // ===============================
    public function perpanjang($id_detail)
    {
        $detailModel = new DetailTransaksiModel();

        $data['detail'] = $detailModel
            ->select('detail_transaksi.*, kamar.nama_kamar, kamar.harga as harga_sewa, transaksi.total as total_sebelumnya, penghuni.nama_penghuni')
            ->join('kamar', 'kamar.id_kamar = detail_transaksi.id_kamar')
            ->join('penghuni', 'penghuni.id_penghuni = detail_transaksi.id_penghuni')
            ->join('transaksi', 'transaksi.id_transaksi = detail_transaksi.id_transaksi')
            ->where('detail_transaksi.id_detail', $id_detail)
            ->first();

        if (!$data['detail']) {
            return redirect()->to('/kasir/penghuni')->with('error', 'Data tidak ditemukan');
        }

        return view('kasir/transaksi/perpanjang', $data);
    }

    // ===============================
    // SIMPAN PERPANJANG
    // ===============================
    public function simpanPerpanjang()
{
    $transaksiModel = new TransaksiModel();
    $detailModel    = new DetailTransaksiModel();

    $id_detail_lama = $this->request->getPost('id_detail');
    $lama           = $this->request->getPost('lama_sewa');
    $bayar          = $this->request->getPost('bayar');
    $total          = $this->request->getPost('total');

    // Ambil data detail lama
    $detailLama = $detailModel->find($id_detail_lama);
    if (!$detailLama) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // VALIDASI UANG KURANG
    if ($bayar < $total) {
        return redirect()->back()->with('error', 'Uang tidak cukup untuk perpanjangan');
    }

    // Hitung kembalian
    $kembalian = $bayar - $total;

    // Hitung jatuh tempo baru
    $jatuhTempoBaru = date('Y-m-d', strtotime($detailLama['jatuh_tempo'] . " +$lama month"));

    // INSERT TRANSAKSI BARU
    $transaksiModel->insert([
        'kode_transaksi'        => 'TRX' . date('YmdHis'),
        'nama_penanggung_jawab' => $detailLama['nama_penghuni'],
        'tanggal_transaksi'     => date('Y-m-d'),
        'total'                 => $total,
        'bayar'                 => $bayar,
        'kembalian'             => $kembalian,
        'jenis_transaksi'       => 'perpanjang',
        'status'                => 'lunas'
    ]);

    $id_transaksi_baru = $transaksiModel->insertID();

    // INSERT DETAIL TRANSAKSI BARU
    $detailModel->insert([
        'id_transaksi'  => $id_transaksi_baru,
        'id_kamar'      => $detailLama['id_kamar'],
        'id_penghuni'   => $detailLama['id_penghuni'],
        'harga'         => $detailLama['harga'],
        'lama_sewa'     => $lama,
        'tanggal_masuk' => $detailLama['tanggal_masuk'],
        'jatuh_tempo'   => $jatuhTempoBaru,
        'subtotal'      => $total,
        'status_sewa'   => 'aktif'
    ]);

    // UPDATE DETAIL LAMA JADI SELESAI
    $detailModel->update($id_detail_lama, [
        'status_sewa' => 'selesai'
    ]);

    $this->logAktivitas(
    'Perpanjang Sewa',
    'Perpanjang kamar ID ' . $detailLama['id_kamar'] . ' selama ' . $lama . ' bulan'
);
    return redirect()->to('/kasir/riwayat')->with('success', 'Perpanjangan berhasil dicatat');
}
   public function tambahKeranjang($id_kamar)
{
    $session = session();
    $kamarModel = new \App\Models\KamarModel();

    $kamar = $kamarModel->find($id_kamar);

    if (!$kamar) {
        return redirect()->back()->with('error', 'Kamar tidak ditemukan');
    }

    $keranjang = $session->get('keranjang') ?? [];

    // Gunakan id_kamar sebagai index
    $keranjang[$id_kamar] = [
        'id_kamar'   => $kamar['id_kamar'],
        'nama_kamar' => $kamar['nama_kamar'],
        'harga'      => $kamar['harga']
    ];

    $session->set('keranjang', $keranjang);

    return redirect()->to('/kasir/transaksi/keranjang');
}
public function keranjang()
{
    $session = session();
    $data['keranjang'] = $session->get('keranjang') ?? [];

    return view('kasir/transaksi/keranjang', $data);
}

public function hapusKeranjang($id_kamar)
{
    $session = session();
    $keranjang = $session->get('keranjang');

    unset($keranjang[$id_kamar]);

    $session->set('keranjang', $keranjang);

    return redirect()->to('/kasir/transaksi/keranjang');
}

public function formBayarKeranjang()
{
    $session = session();
    $data['keranjang'] = $session->get('keranjang') ?? [];

    return view('kasir/transaksi/bayar_keranjang', $data);
}

public function simpanBayarKeranjang()
{
    $session = session();
    $keranjang = $session->get('keranjang');

    if (!$keranjang) {
        return redirect()->back()->with('error', 'Keranjang kosong');
    }

    $transaksiModel = new TransaksiModel();
    $detailModel    = new DetailTransaksiModel();
    $penghuniModel  = new PenghuniModel();
    $kamarModel     = new KamarModel();

    $lama_sewa     = $this->request->getPost('lama_sewa');
    $tanggal_masuk = $this->request->getPost('tanggal_masuk');
    $jatuh_tempo   = $this->request->getPost('jatuh_tempo');

    // ================= HITUNG TOTAL =================
    $total = 0;
    foreach ($keranjang as $k) {
        $total += $k['harga'] * $lama_sewa;
    }

    $bayar = $this->request->getPost('bayar');

    if ($bayar < $total) {
        return redirect()->back()->withInput()->with('error', 'Uang tidak cukup untuk membayar semua kamar');
    }

    $kembalian = $bayar - $total;

    // ================= SIMPAN TRANSAKSI =================
    $transaksiModel->insert([
        'kode_transaksi' => 'TRX' . date('YmdHis'),
        'nama_penanggung_jawab' => $this->request->getPost('penanggung_jawab'),
        'no_hp' => $this->request->getPost('no_hp'),
        'tanggal_transaksi' => date('Y-m-d'),
        'total' => $total,
        'bayar' => $bayar,
        'kembalian' => $kembalian,
        'jenis_transaksi' => 'bayar_langsung',
        'status' => 'lunas'
    ]);

    $id_transaksi = $transaksiModel->insertID();

    // ================= LOOP SETIAP KAMAR =================
    $no = 0;
    foreach ($keranjang as $k) {
        $no++;

        $subtotal = $k['harga'] * $lama_sewa;

        // INSERT DETAIL DULU
        $detailModel->insert([
            'id_transaksi' => $id_transaksi,
            'id_kamar' => $k['id_kamar'],
            'harga' => $k['harga'],
            'lama_sewa' => $lama_sewa,
            'tanggal_masuk' => $tanggal_masuk,
            'jatuh_tempo' => $jatuh_tempo,
            'subtotal' => $subtotal,
            'status_sewa' => 'aktif'
        ]);

        $id_detail = $detailModel->insertID();

        // ================= PENGHUNI 1 =================
        $penghuniModel->insert([
            'id_detail'     => $id_detail,
            'nama_penghuni' => $this->request->getPost('penghuni1_' . $no),
            'nik'           => $this->request->getPost('nik1_' . $no),
            'no_hp'         => $this->request->getPost('hp1_' . $no),
            'alamat'        => $this->request->getPost('alamat1_' . $no),
        ]);

        $id_penghuni = $penghuniModel->insertID();

        // UPDATE DETAIL BIAR ADA PENGHUNI UTAMA
        $detailModel->update($id_detail, [
            'id_penghuni'   => $id_penghuni,
            'nama_penghuni' => $this->request->getPost('penghuni1_' . $no)
        ]);

        // ================= PENGHUNI 2 (OPSIONAL) =================
        if ($this->request->getPost('penghuni2_' . $no)) {
            $penghuniModel->insert([
                'id_detail'     => $id_detail,
                'nama_penghuni' => $this->request->getPost('penghuni2_' . $no),
                'nik'           => $this->request->getPost('nik2_' . $no),
                'no_hp'         => $this->request->getPost('hp2_' . $no),
                'alamat'        => $this->request->getPost('alamat2_' . $no),
            ]);
        }

        // UPDATE STATUS KAMAR
        $kamarModel->update($k['id_kamar'], [
            'status_kamar' => 'terisi'
        ]);
    }

    // HAPUS KERANJANG
    $session->remove('keranjang');

    $this->logAktivitas(
    'Bayar Banyak Kamar',
    'Bayar beberapa kamar total ' . $total
);
    return redirect()->to('/kasir/transaksi/cetakStruk/' . $id_transaksi);
}
public function formBookingKeranjang()
{
    $session = session();
    $data['keranjang'] = $session->get('keranjang') ?? [];

    return view('kasir/transaksi/booking_keranjang', $data);
}

public function simpanBookingKeranjang()
{
    $session = session();
    $keranjang = $session->get('keranjang');

    if (!$keranjang) {
        return redirect()->back()->with('error', 'Keranjang kosong');
    }

    $transaksiModel = new TransaksiModel();
    $detailModel    = new DetailTransaksiModel();
    $penghuniModel  = new PenghuniModel();
    $kamarModel     = new KamarModel();

    $lama_sewa     = $this->request->getPost('lama_sewa');
    $tanggal_masuk = $this->request->getPost('tanggal_masuk');
    $jatuh_tempo   = $this->request->getPost('jatuh_tempo');

    // ================= HITUNG TOTAL =================
    $total = 0;
    foreach ($keranjang as $k) {
        $total += $k['harga'] * $lama_sewa;
    }

    $dp = $this->request->getPost('dp');

    // ================= SIMPAN TRANSAKSI =================
    $transaksiModel->insert([
        'kode_transaksi' => 'TRX' . date('YmdHis'),
        'nama_penanggung_jawab' => $this->request->getPost('penanggung_jawab'),
        'no_hp' => $this->request->getPost('no_hp'),
        'tanggal_transaksi' => date('Y-m-d'),
        'total' => $total,
        'bayar' => $dp,
        'kembalian' => 0,
        'jenis_transaksi' => 'booking',
        'status' => 'booking'
    ]);

    $id_transaksi = $transaksiModel->insertID();

    // ================= LOOP SETIAP KAMAR =================
    $no = 0;
    foreach ($keranjang as $k) {
        $no++;

        $subtotal = $k['harga'] * $lama_sewa;

        // INSERT DETAIL
        $detailModel->insert([
            'id_transaksi' => $id_transaksi,
            'id_kamar' => $k['id_kamar'],
            'harga' => $k['harga'],
            'lama_sewa' => $lama_sewa,
            'tanggal_masuk' => $tanggal_masuk,
            'jatuh_tempo' => $jatuh_tempo,
            'subtotal' => $subtotal,
            'status_sewa' => 'booking'
        ]);

        $id_detail = $detailModel->insertID();

        // ================= PENGHUNI 1 =================
        $penghuniModel->insert([
            'id_detail'     => $id_detail,
            'nama_penghuni' => $this->request->getPost('penghuni1_' . $no),
            'nik'           => $this->request->getPost('nik1_' . $no),
            'no_hp'         => $this->request->getPost('hp1_' . $no),
            'alamat'        => $this->request->getPost('alamat1_' . $no),
        ]);

        $id_penghuni = $penghuniModel->insertID();

        // UPDATE DETAIL DENGAN PENGHUNI UTAMA
        $detailModel->update($id_detail, [
            'id_penghuni'   => $id_penghuni,
            'nama_penghuni' => $this->request->getPost('penghuni1_' . $no)
        ]);

        // ================= PENGHUNI 2 (OPSIONAL) =================
        if ($this->request->getPost('penghuni2_' . $no)) {
            $penghuniModel->insert([
                'id_detail'     => $id_detail,
                'nama_penghuni' => $this->request->getPost('penghuni2_' . $no),
                'nik'           => $this->request->getPost('nik2_' . $no),
                'no_hp'         => $this->request->getPost('hp2_' . $no),
                'alamat'        => $this->request->getPost('alamat2_' . $no),
            ]);
        }

        // UPDATE STATUS KAMAR
        $kamarModel->update($k['id_kamar'], [
            'status_kamar' => 'booking'
        ]);
    }

    // HAPUS KERANJANG
    $session->remove('keranjang');

    $this->logAktivitas(
    'Booking Banyak Kamar',
    'Booking beberapa kamar total ' . $total
);
  return redirect()->to('/kasir/transaksi/cetakStruk/' . $id_transaksi);
}

public function resetKeranjang()
{
    session()->remove('keranjang');
    $this->logAktivitas(
    'Reset Keranjang',
    'Menghapus semua keranjang'
);
    return redirect()->back();
}

public function cetakStruk($id_transaksi)
{
    $this->logAktivitas(
    'Cetak Struk',
    'Cetak struk transaksi ID ' . $id_transaksi
);
    $db = \Config\Database::connect();

    $data['transaksi'] = $db->table('transaksi')
        ->where('id_transaksi', $id_transaksi)
        ->get()->getRowArray();

    $data['detail'] = $db->table('detail_transaksi')
        ->join('kamar', 'kamar.id_kamar = detail_transaksi.id_kamar')
        ->where('id_transaksi', $id_transaksi)
        ->get()->getResultArray();

    $html = view('kasir/transaksi/struk_pdf', $data);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A5', 'portrait');
    $dompdf->render();
    $dompdf->stream('struk.pdf', ['Attachment' => true]);
}
private function logAktivitas($aktivitas, $keterangan)
{
    $logModel = new LogActivityModel();
    $session = session();

    $logModel->insert([
        'id_user'    => $session->get('id_user'),
        'username'   => $session->get('username'),
        'role'       => $session->get('role'),
        'aktivitas'  => $aktivitas,
        'keterangan' => $keterangan,
        'tanggal'    => date('Y-m-d H:i:s')
    ]);
}

}