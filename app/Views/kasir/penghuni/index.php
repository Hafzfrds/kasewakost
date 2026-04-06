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
}
img {
    width: 60px;
    border-radius: 6px;
}
.btn-pelunasan {
    background: #f1c40f;
    padding: 6px 12px;
    border-radius: 6px;
    text-decoration: none;
    color: black;
    margin-right: 5px;
}
.btn-perpanjang {
    background: #3498db;
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
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php $no=1; foreach($penghuni as $p): ?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= $p['nama_penghuni'] ?></td>
    <td><?= $p['nama_kamar'] ?></td>
    <td>
    <?php 
        $uangMasuk = $p['uang_masuk'];
        $sisa = $p['sisa_bayar'];

        if($sisa <= 0){
            $sisa = 0;
        }
    ?>
    <?= number_format($uangMasuk) ?>
</td>

<td><?= number_format($sisa) ?></td>
    <td><?= $p['tanggal_masuk'] ?></td>
    <td><?= $p['jatuh_tempo'] ?></td>

    <!-- STATUS -->
    <td>
        <?php if($p['sisa_bayar'] > 0): ?>
            <span class="status-booking">Booking</span>
        <?php else: ?>
            <span class="status-lunas">Lunas</span>
        <?php endif; ?>
    </td>

    <!-- AKSI -->
    <td>
        <?php if($p['sisa_bayar'] > 0): ?>
            <a href="/kasir/transaksi/pelunasan/<?= $p['id_detail'] ?>" class="btn-pelunasan">
                Pelunasan
            </a>
        <?php endif; ?>

        <a href="/kasir/transaksi/perpanjang/<?= $p['id_detail'] ?>" class="btn-perpanjang">
            Perpanjang
        </a>
    </td>
</tr>
<?php endforeach; ?>
</table>

<?= $this->endSection() ?>