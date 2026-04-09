<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<h1>Data Penghuni</h1>

<style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th {
        background: #5b87b2;
        color: white;
        padding: 10px;
    }

    td {
        padding: 10px;
        border-bottom: 1px solid #ccc;
        white-space: nowrap;
        /* TAMBAHKAN INI: Biar tombol sejajar ke samping, tidak turun ke bawah lalu numpuk */
    }

    img {
        width: 60px;
        border-radius: 6px;
    }

    .btn-pelunasan,
    .btn-perpanjang,
    .btn-keluar {
        display: inline-block;
        margin-right: 5px;
        /* Beri jarak */
        margin-top: 5px;
        /* Beri jarak atas bawah */
    }

    .btn-perpanjang {
        background: #3498db;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        color: white;
    }

    .btn-keluar {
        background: #e74c3c;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        color: white;
    }

    .status-booking {
        color: orange;
        font-weight: bold;
    }

    .status-lunas {
        color: green;
        font-weight: bold;
    }

    .status-keluar {
        color: red;
        font-weight: bold;
    }
</style>

<table>
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kamar</th>
        <th>Uang Masuk</th>
        <th>Sisa Bayar</th>
        <th>Masuk</th>
        <th>Jatuh Tempo</th>
        <th>Status Bayar</th>
        <th>Status Penghuni</th>
        <th>Aksi</th>
    </tr>

    <?php $no = 1;
    foreach ($penghuni as $p): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $p['nama_penghuni'] ?></td>
            <td><?= $p['nama_kamar'] ?></td>

            <td>
                <?php
                $uangMasuk = $p['uang_masuk'];
                $sisa = $p['sisa_bayar'];

                if ($sisa <= 0) {
                    $sisa = 0;
                }
                ?>
                <?= number_format($uangMasuk) ?>
            </td>

            <td><?= number_format($sisa) ?></td>
            <td><?= $p['tanggal_masuk'] ?></td>
            <td><?= $p['jatuh_tempo'] ?></td>

            <!-- STATUS BAYAR -->
            <td>
                <?php if ($p['sisa_bayar'] > 0): ?>
                    <span class="status-booking">Booking</span>
                <?php else: ?>
                    <span class="status-lunas">Lunas</span>
                <?php endif; ?>
            </td>

            <!-- STATUS PENGHUNI -->
            <td>
                <?php if ($p['status'] == 'menunggu pembayaran'): ?>
    <span class="status-booking">Menunggu Pembayaran</span>

<?php elseif ($p['status'] == 'sedang menghuni'): ?>
    <span class="status-lunas">Sedang Menghuni</span>

<?php else: ?>
    <span class="status-keluar">Keluar</span>
<?php endif; ?>
            </td>

            <!-- AKSI -->
            <td>

                <?php if ($p['status'] != 'keluar'): ?>

                    <?php if ($p['sisa_bayar'] > 0): ?>
                        <a href="/kasir/transaksi/pelunasan/<?= $p['id_detail'] ?>" class="btn-pelunasan">
                            Pelunasan
                        </a>
                    <?php endif; ?>

                    <a href="/kasir/transaksi/perpanjang/<?= $p['id_detail'] ?>" class="btn-perpanjang">
                        Perpanjang
                    </a>

                    <a href="/kasir/penghuni/berhentikan/<?= $p['id_penghuni'] ?>"
                        class="btn-keluar"
                        onclick="return confirm('Yakin penghuni keluar?')">
                        Berhentikan
                    </a>
                                            

                <?php else: ?>
                    -
                <?php endif; ?>

            </td>
        </tr>
    <?php endforeach; ?>
</table>

<?= $this->endSection() ?>