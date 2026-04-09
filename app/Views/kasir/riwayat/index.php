<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/owner/riwayat.css') ?>">

<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <h1>Riwayat Transaksi</h1>
        <span class="badge-total">Total: <?= count($riwayat) ?> Record</span>
    </div>

    <!-- Filter -->
    <form method="get" class="search-container">
        <label>Tanggal Awal:</label>
        <input type="date" name="tanggal_awal" value="<?= $_GET['tanggal_awal'] ?? '' ?>">

        <label>Tanggal Akhir:</label>
        <input type="date" name="tanggal_akhir" value="<?= $_GET['tanggal_akhir'] ?? '' ?>">

        <label>Cari:</label>
        <input type="text" name="keyword" placeholder="Nama / Kamar / Kode..."
            value="<?= $_GET['keyword'] ?? '' ?>">

        <button type="submit" class="btn-search">Filter</button>
    </form>

    <?php 
    $booking       = array_filter($riwayat, fn($r) => $r['jenis_transaksi'] == 'booking');
    $bayarLangsung = array_filter($riwayat, fn($r) => $r['jenis_transaksi'] == 'bayar_langsung');
    $perpanjang    = array_filter($riwayat, fn($r) => $r['jenis_transaksi'] == 'perpanjang');
    ?>

    <!-- ================= BAYAR LANGSUNG ================= -->
    <?php if(!empty($bayarLangsung)): ?>
    <div class="section-card">
        <div class="section-header">
            <h2>Bayar Langsung (Check-In)</h2>
        </div>

        <div class="table-wrapper">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Penghuni / Kamar</th>
                        <th>Tgl Transaksi</th>
                        <th>Masa Sewa</th>
                        <th>Pembayaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($bayarLangsung as $r): ?>
                    <tr>
                        <td><span class="cell-code"><?= $r['kode_transaksi'] ?></span></td>
                        <td>
                            <span class="cell-name"><?= $r['nama_penghuni'] ?? 'N/A' ?></span>
                            <span class="badge-kamar"><?= $r['nama_kamar'] ?? 'Kamar -' ?></span>
                        </td>
                        <td class="cell-date"><?= date('d/m/Y', strtotime($r['tanggal_transaksi'])) ?></td>
                        <td>
                            <span class="cell-sub">Masuk: <?= $r['tanggal_masuk'] ?? '-' ?></span>
                            <span class="cell-tempo">Tempo: <?= $r['jatuh_tempo'] ?? '-' ?></span>
                        </td>
                        <td class="cell-money">Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                        <td>
                            <span class="<?= $r['status'] == 'lunas' ? 'badge-lunas' : 'badge-pending' ?>">
                                <?= strtoupper($r['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= PERPANJANG ================= -->
    <?php if(!empty($perpanjang)): ?>
    <div class="section-card">
        <div class="section-header">
            <h2>Perpanjang Sewa</h2>
        </div>

        <div class="table-wrapper">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama & Kamar</th>
                        <th>Tgl Bayar</th>
                        <th>Jatuh Tempo Baru</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($perpanjang as $r): ?>
                    <tr>
                        <td><span class="cell-code"><?= $r['kode_transaksi'] ?></span></td>
                        <td>
                            <span class="cell-name"><?= $r['nama_penanggung_jawab'] ?></span>
                            <span class="cell-sub"><?= $r['nama_kamar'] ?? 'Data Terhapus' ?></span>
                        </td>
                        <td class="cell-date"><?= date('d/m/Y', strtotime($r['tanggal_transaksi'])) ?></td>
                        <td class="cell-due"><?= $r['jatuh_tempo'] ?? '-' ?></td>
                        <td class="cell-money">Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                        <td><span class="badge-tercatat">TERCATAT</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= BOOKING ================= -->
    <?php if(!empty($booking)): ?>
    <div class="section-card">
        <div class="section-header">
            <h2>Booking</h2>
        </div>

        <div class="table-wrapper">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Penghuni</th>
                        <th>Tgl Transaksi</th>
                        <th>Kamar</th>
                        <th>DP Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($booking as $r): ?>
                    <tr>
                        <td><span class="cell-code"><?= $r['kode_transaksi'] ?></span></td>
                        <td>
                            <span class="cell-name"><?= $r['nama_penghuni'] ?? $r['nama_penanggung_jawab'] ?></span>
                        </td>
                        <td class="cell-date"><?= date('d/m/Y', strtotime($r['tanggal_transaksi'])) ?></td>
                        <td><?= $r['nama_kamar'] ?? '-' ?></td>
                        <td class="cell-money">Rp <?= number_format($r['bayar'], 0, ',', '.') ?></td>
                        <td><span class="badge-pending"><?= strtoupper($r['status']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>