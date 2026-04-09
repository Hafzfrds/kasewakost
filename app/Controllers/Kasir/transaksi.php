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
    'bayar' => $subtotal, // 🔥 INI WAJIB DITAMBAHKAN
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
         'status'        => 'sedang menghuni' 
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
            'status'        => 'menunggu pembayaran'
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

    // 🔥 TAMBAHAN BARU
    $tanggal_booking      = $this->request->getPost('tanggal_booking');
    $jatuh_tempo_booking  = $this->request->getPost('jatuh_tempo_booking');

    $subtotal = $harga * $lama_sewa;
    $dp       = $this->request->getPost('dp');

    // ================= VALIDASI DP =================
    if ($dp <= 0) {
        return redirect()->back()->withInput()->with('error', 'DP harus diisi');
    }

    // ================= SIMPAN TRANSAKSI =================
    $transaksiModel->insert([
        'kode_transaksi' => 'TRX' . date('YmdHis'),
        'nama_penanggung_jawab' => $this->request->getPost('penanggung_jawab'),
        'no_hp' => $this->request->getPost('no_hp'),
        'tanggal_transaksi' => date('Y-m-d'),

        // 🔥 DATA BOOKING BARU
        'tanggal_booking' => $tanggal_booking,
        'jatuh_tempo_booking' => $jatuh_tempo_booking,

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
        'status_sewa' => 'booking',
        'bayar' => $dp
    ]);

    $id_detail = $detailModel->insertID();

    // ================= SIMPAN PENGHUNI 1 =================
    $penghuniModel->insert([
        'id_detail'     => $id_detail,
        'nama_penghuni' => $this->request->getPost('penghuni1'),
        'nik'           => $this->request->getPost('nik1'),
        'no_hp'         => $this->request->getPost('hp1'),
        'alamat'        => $this->request->getPost('alamat1'),
        'status'        => 'menunggu pembayaran'
    ]);

    $id_penghuni = $penghuniModel->insertID();

    // UPDATE detail_transaksi
    $detailModel->update($id_detail, [
        'id_penghuni'   => $id_penghuni,
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
            'status'        => 'menunggu pembayaran'
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

       $detail['sisa_bayar'] = $detail['subtotal'] - $detail['bayar'];
        $data['detail'] = $detail;

        return view('kasir/transaksi/pelunasan', $data);
    }

    // ===============================
    // SIMPAN PELUNASAN
    // ===============================
  public function simpanPelunasan()
{
    $transaksiModel = new TransaksiModel();
    $detailModel    = new DetailTransaksiModel();
    $kamarModel     = new KamarModel();
    $penghuniModel  = new PenghuniModel(); // ✅ WAJIB

    $id_detail = $this->request->getPost('id_detail');
    $bayar     = $this->request->getPost('bayar');

    // ================= AMBIL DATA =================
    $detail = $detailModel->find($id_detail);
    if (!$detail) {
        return redirect()->back()->with('error', 'Detail tidak ditemukan');
    }

    $transaksi = $transaksiModel->find($detail['id_transaksi']);

    $total       = $detail['subtotal'];
    $sudahBayar  = $detail['bayar']; // DP

    // ================= SIMPAN DATA UNTUK STRUK =================
    session()->setFlashdata('bayar_lama', $sudahBayar);
    session()->setFlashdata('bayar_sekarang', $bayar);

    // ================= HITUNG TOTAL =================
    $totalBayar = $sudahBayar + $bayar;
    $sisa       = $total - $totalBayar;

    // ================= VALIDASI =================
    if ($totalBayar < $total) {
        return redirect()->back()->with('error', 'Uang pelunasan masih kurang');
    }

    $kembalian = abs($sisa);

    // ================= UPDATE KAMAR =================
    $kamarModel->update($detail['id_kamar'], [
        'status_kamar' => 'terisi'
    ]);

    // ================= UPDATE DETAIL =================
    $detailModel->update($id_detail, [
        'status_sewa' => 'aktif',
        'bayar'       => $totalBayar
    ]);

    // ================= UPDATE STATUS PENGHUNI =================
    $penghuniModel->where('id_detail', $id_detail)->set([
        'status' => 'sedang menghuni'
    ])->update();

    // ================= UPDATE TRANSAKSI =================
    $transaksiModel->update($detail['id_transaksi'], [
        'status'    => 'lunas',
        'bayar'     => $totalBayar,
        'kembalian' => $kembalian
    ]);

    // ================= LOG =================
    $this->logAktivitas(
        'Pelunasan',
        'Pelunasan transaksi ID ' . $detail['id_transaksi']
    );

    // ================= REDIRECT =================
    return redirect()->to('/kasir/transaksi/struk_pelunasan/' . $id_detail);
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
    $lama           = (int) $this->request->getPost('lama_sewa');
    $bayar          = (int) $this->request->getPost('bayar');
    $total          = (int) $this->request->getPost('total');

    // =========================
    // AMBIL DATA LAMA
    // =========================
    $detailLama = $detailModel->find($id_detail_lama);
    if (!$detailLama) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // =========================
    // VALIDASI
    // =========================
    if ($bayar < $total) {
        return redirect()->back()->with('error', 'Uang tidak cukup untuk perpanjangan');
    }

    $kembalian = $bayar - $total;

    // =========================
    // HITUNG JATUH TEMPO BARU
    // =========================
    $jatuhTempoBaru = date(
        'Y-m-d',
        strtotime($detailLama['jatuh_tempo'] . " +{$lama} month")
    );

    // =========================
    // 1. SIMPAN TRANSAKSI BARU
    // =========================
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

    // =========================
    // 2. INSERT DETAIL BARU (INI KUNCI UTAMA 🔥)
    // =========================
    $detailModel->insert([
        'id_transaksi'   => $id_transaksi_baru,
        'id_kamar'       => $detailLama['id_kamar'],
        'id_penghuni'    => $detailLama['id_penghuni'],
        'nama_penghuni'  => $detailLama['nama_penghuni'],
        'harga'          => $detailLama['harga'],
        'lama_sewa'      => $lama,
        'tanggal_masuk'  => $detailLama['tanggal_masuk'],
        'jatuh_tempo'    => $jatuhTempoBaru,
        'subtotal'       => $total,
        'bayar'          => $bayar,
        'status_sewa'    => 'aktif'
    ]);

    // =========================
    // 3. UPDATE DETAIL LAMA (OPSIONAL TAPI DISARANKAN)
    // =========================
    $detailModel->update($id_detail_lama, [
        'status_sewa' => 'selesai'
    ]);

    // =========================
    // 4. LOG AKTIVITAS
    // =========================
    $this->logAktivitas(
        'Perpanjang Sewa',
        'Perpanjang kamar ID ' . $detailLama['id_kamar'] . ' selama ' . $lama . ' bulan'
    );

    // =========================
    // 5. REDIRECT STRUK
    // =========================
    return redirect()->to(base_url('kasir/transaksi/struk_perpanjang/' . $id_transaksi_baru));
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

public function struk_perpanjang($id_transaksi)
{
    $db = \Config\Database::connect();

    $transaksi = $db->table('transaksi')
        ->where('id_transaksi', $id_transaksi)
        ->get()
        ->getRowArray();

    $detail = $db->table('detail_transaksi')
        ->join('kamar', 'kamar.id_kamar = detail_transaksi.id_kamar')
        ->where('detail_transaksi.id_transaksi', $id_transaksi)
        ->get()
        ->getResultArray();

    $data = [
        'transaksi' => $transaksi,
        'detail' => $detail
    ];

    $html = view('kasir/transaksi/struk_perpanjang_pdf', $data);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A5', 'portrait');
    $dompdf->render();

    // TRUE = download otomatis
    $dompdf->stream('Struk_Perpanjang.pdf', ['Attachment' => true]);
}

public function struk_pelunasan($id_detail)
{
    $db = \Config\Database::connect();

    $transaksi = $db->table('detail_transaksi')
        ->join('transaksi', 'transaksi.id_transaksi = detail_transaksi.id_transaksi')
        ->join('penghuni', 'penghuni.id_penghuni = detail_transaksi.id_penghuni')
        ->join('kamar', 'kamar.id_kamar = detail_transaksi.id_kamar')
        ->where('detail_transaksi.id_detail', $id_detail)
        ->get()
        ->getRowArray();

    if (!$transaksi) {
        return redirect()->back()->with('error', 'Data tidak ditemukan');
    }

    // 🔥 AMBIL DATA SEBELUM & SAAT PELUNASAN
    $bayar_lama      = session()->getFlashdata('bayar_lama') ?? 0;
    $bayar_sekarang  = session()->getFlashdata('bayar_sekarang') ?? 0;

    $total     = $transaksi['total'];
    $kembalian = $transaksi['kembalian'];

    // 🔥 INI YANG KAMU MAU
    $sisaBayar = $total - $bayar_lama;

    $transaksi['sisa_bayar'] = $sisaBayar;
    $transaksi['uang_bayar'] = $bayar_sekarang;
    $transaksi['kembalian']  = $kembalian;

    $data['transaksi'] = $transaksi;

    $html = view('kasir/transaksi/struk_pelunasan_pdf', $data);

    $dompdf = new \Dompdf\Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A5', 'portrait');
    $dompdf->render();
    $dompdf->stream('Struk_Pelunasan.pdf', ['Attachment' => true]);
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