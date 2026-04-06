v<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark">Riwayat Transaksi</h2>
        <span class="badge bg-success p-2">Total: <?= count($riwayat) ?> Record</span>
    </div>

    <style>
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 2rem; }
        .table-responsive { padding: 15px; }
        .table thead th { background-color: #f8f9fa; color: #444; border-bottom: 2px solid #2e7d32; text-transform: uppercase; font-size: 0.85rem; }
        .badge-status { font-size: 0.8rem; padding: 5px 10px; border-radius: 20px; }
        h3.section-title { font-size: 1.25rem; font-weight: bold; color: #2e7d32; padding: 15px 15px 0; display: flex; align-items: center; }
        h3.section-title i { margin-right: 10px; }
        .text-money { font-family: 'Courier New', Courier, monospace; font-weight: bold; color: #1b5e20; }
    </style>

    <?php 
    // Filter data berdasarkan jenis
    $booking = array_filter($riwayat, fn($r) => $r['jenis_transaksi'] == 'booking');
    $bayarLangsung = array_filter($riwayat, fn($r) => $r['jenis_transaksi'] == 'bayar_langsung');
    $perpanjang = array_filter($riwayat, fn($r) => $r['jenis_transaksi'] == 'perpanjang');
    ?>

    <?php if(!empty($bayarLangsung)): ?>
    <div class="card">
        <h3 class="section-title">💸 Bayar Langsung (Check-In)</h3>
        <div class="table-responsive">
            <table class="table table-hover">
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
                        <td><small class="text-muted"><?= $r['kode_transaksi'] ?></small></td>
                        <td>
                            <strong><?= $r['nama_penghuni'] ?? 'N/A' ?></strong><br>
                            <small class="badge bg-info text-dark"><?= $r['nama_kamar'] ?? 'Kamar -' ?></small>
                        </td>
                        <td><?= date('d/m/Y', strtotime($r['tanggal_transaksi'])) ?></td>
                        <td>
                            <small>Masuk: <?= $r['tanggal_masuk'] ?? '-' ?></small><br>
                            <small class="text-danger">Tempo: <?= $r['jatuh_tempo'] ?? '-' ?></small>
                        </td>
                        <td class="text-end">
                            <span class="text-money">Rp <?= number_format($r['total'], 0, ',', '.') ?></span>
                        </td>
                        <td>
                            <span class="badge badge-status <?= $r['status'] == 'lunas' ? 'bg-success' : 'bg-warning' ?>">
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

    <?php if(!empty($perpanjang)): ?>
    <div class="card">
        <h3 class="section-title">🔄 Perpanjang Sewa</h3>
        <div class="table-responsive">
            <table class="table table-hover">
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
                        <td><small class="text-muted"><?= $r['kode_transaksi'] ?></small></td>
                        <td>
                            <strong><?= $r['nama_penanggung_jawab'] ?></strong><br>
                            <small class="text-muted"><?= $r['nama_kamar'] ?? 'Data Terhapus' ?></small>
                        </td>
                        <td><?= date('d/m/Y', strtotime($r['tanggal_transaksi'])) ?></td>
                        <td class="text-primary fw-bold"><?= $r['jatuh_tempo'] ?? '-' ?></td>
                        <td class="text-end text-money">Rp <?= number_format($r['total'], 0, ',', '.') ?></td>
                        <td><span class="badge bg-success badge-status">TERCATAT</span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

    <?php if(!empty($booking)): ?>
    <div class="card shadow-sm">
        <h3 class="section-title">📅 Booking (DP)</h3>
        <div class="table-responsive">
            <table class="table table-hover">
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
                        <td><?= $r['kode_transaksi'] ?></td>
                        <td><?= $r['nama_penghuni'] ?? $r['nama_penanggung_jawab'] ?></td>
                        <td><?= date('d/m/Y', strtotime($r['tanggal_transaksi'])) ?></td>
                        <td><?= $r['nama_kamar'] ?? '-' ?></td>
                        <td class="text-money">Rp <?= number_format($r['bayar'], 0, ',', '.') ?></td>
                        <td><span class="badge bg-warning text-dark badge-status"><?= strtoupper($r['status']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?>

</div>

<?= $this->endSection() ?>