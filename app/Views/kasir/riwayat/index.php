<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/owner/riwayat.css') ?>">

<div class="page-wrapper">

    <div class="page-header">
        <h1>Riwayat Transaksi</h1>

        <div class="header-right">
            <span class="badge-total">
                Total: <?= count($riwayat) ?> Record
            </span>

           <span class="badge-income">
                Pendapatan Hari Ini: Rp <?= number_format($pendapatan_hari_ini ?? 0, 0, ',', '.') ?>
            </span>

        </div>
    </div>

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

// BAYAR LANGSUNG 
    <?php if (!empty($bayarLangsung)): ?>
    <div class="section-card">
        <div class="section-header">
            <h2>Bayar Langsung (Check-In)</h2>
        </div>

        <div class="table-wrapper">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kamar</th>
                        <th>Tgl Transaksi</th>
                        <th>Nominal</th>
                        <th>Username Kasir</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($bayarLangsung as $r): ?>
                    <tr>
                        <td><?= $r['kode_transaksi'] ?></td>
                        <td><?= $r['nama_penghuni'] ?></td>
                        <td><?= esc($r['nama_kamar']) . '-' . str_pad($r['nomor_kamar'], 2, '0', STR_PAD_LEFT) ?></td>
                        <td><?= date('d/m/Y', strtotime($r['tanggal_transaksi'])) ?></td>
                        <td>Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                        <td><?= $r['username_kasir'] ?? '-' ?></td>
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

    //perpanjang
    <?php if (!empty($perpanjang)): ?>
    <div class="section-card">
        <div class="section-header">
            <h2>Perpanjang Sewa</h2>
        </div>

        <div class="table-wrapper">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kamar</th>
                        <th>Tgl Bayar</th>
                        <th>Nominal</th>
                        <th>Username Kasir</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($perpanjang as $r): ?>
                    <tr>
                        <td><?= $r['kode_transaksi'] ?></td>
                        <td><?= $r['nama_penghuni'] ?></td>
                        <td><?= esc($r['nama_kamar']) . '-' . str_pad($r['nomor_kamar'], 2, '0', STR_PAD_LEFT) ?></td>
                        <td><?= date('d/m/Y', strtotime($r['tanggal_transaksi'])) ?></td>
                        <td>Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                        <td><?= $r['username_kasir'] ?? '-' ?></td>
                        <td><span class="badge-tercatat">TERCATAT</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <!-- ================= BOOKING ================= -->
    <?php if (!empty($booking)): ?>
    <div class="section-card">
        <div class="section-header">
            <h2>Booking</h2>
        </div>

        <div class="table-wrapper">
            <table class="trx-table">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Kamar</th>
                        <th>Tgl Transaksi</th>
                        <th>Nominal</th>
                        <th>Username Kasir</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($booking as $r): ?>
                    <tr>
                        <td><?= $r['kode_transaksi'] ?></td>

                        <td><?= $r['nama_penghuni'] ?></td>

                        <td><?= esc($r['nama_kamar']) . '-' . str_pad($r['nomor_kamar'], 2, '0', STR_PAD_LEFT) ?></td>

                        <td><?= date('d/m/Y', strtotime($r['tanggal_transaksi'])) ?></td>

                        <td>Rp <?= number_format($r['bayar'], 0, ',', '.') ?></td>

                        <td><?= $r['username_kasir'] ?? '-' ?></td>

                        <td>
                            <span class="badge-pending">
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

</div>

<?= $this->endSection() ?>