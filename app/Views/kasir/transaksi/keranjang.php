<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<h2>Keranjang Transaksi</h2>

<?php if (!empty($keranjang)) : ?>
    <table border="1" cellpadding="10">
        <tr>
            <th>Nama Kamar</th>
            <th>Harga</th>
            <th>Aksi</th>
        </tr>

        <?php $total = 0; ?>
        <?php foreach ($keranjang as $k) : ?>
            <tr>
                <td><?= $k['nama_kamar'] ?></td>
                <td><?= $k['harga'] ?></td>
                <td>
                    <a href="<?= base_url('kasir/transaksi/hapusKeranjang/'.$k['id_kamar']) ?>">
                        Hapus
                    </a>
                </td>
            </tr>
            <?php $total += $k['harga']; ?>
        <?php endforeach; ?>

        <tr>
            <td><b>Total</b></td>
            <td colspan="2"><b><?= $total ?></b></td>
        </tr>
    </table>

    <br>

    <a href="<?= base_url('kasir/transaksi/formBayarKeranjang') ?>">Bayar Langsung</a>
    <a href="<?= base_url('kasir/transaksi/formBookingKeranjang') ?>">Booking</a>

<?php else : ?>
    <p>Keranjang masih kosong</p>
<?php endif; ?>

<?= $this->endSection() ?>