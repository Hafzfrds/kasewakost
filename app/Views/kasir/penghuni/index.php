<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="<?= base_url('css/kasir/penghuni/index.css') ?>">


<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <h1>Data Penghuni</h1>
    </div>

    <!-- Search -->
    <form method="get" action="/kasir/penghuni" class="search-container">
        <input
            type="text"
            name="keyword"
            value="<?= esc($keyword ?? '') ?>"
            placeholder="Cari nama penghuni / kamar...">
        <button type="submit" class="btn-search">Search</button>
        <a href="/kasir/penghuni" class="btn-reset">Reset</a>
    </form>

    <!-- Table -->
    <div class="section-card">
        <div class="table-wrapper">
            <table class="trx-table">
                <thead>
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
                </thead>

                <tbody>
                    <?php $no = 1;
                    foreach ($penghuni as $p): ?>

                        <!-- ROW UTAMA -->
                        <tr onclick="toggleDetail(<?= $p['id_penghuni'] ?>)" style="cursor:pointer;">
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
                                    <span class="badge-pending">Booking</span>
                                <?php else: ?>
                                    <span class="badge-lunas">Lunas</span>
                                <?php endif; ?>
                            </td>

                            <!-- STATUS PENGHUNI -->
                            <td>
                                <?php if ($p['status'] == 'menunggu pembayaran'): ?>
                                    <span class="badge-pending">Menunggu Pembayaran</span>

                                <?php elseif ($p['status'] == 'sedang menghuni'): ?>
                                    <span class="badge-lunas">Sedang Menghuni</span>

                                <?php else: ?>
                                    <span class="badge-danger">Keluar</span>
                                <?php endif; ?>
                            </td>

                            <!-- AKSI -->
                            <td>
                                <?php if ($p['status'] != 'keluar'): ?>

                                    <?php if ($p['sisa_bayar'] > 0): ?>
                                        <a href="/kasir/transaksi/pelunasan/<?= $p['id_detail'] ?>" class="btn-action btn-warning">
                                            Pelunasan
                                        </a>
                                    <?php endif; ?>

                                    <a href="/kasir/transaksi/perpanjang/<?= $p['id_detail'] ?>" class="btn-action btn-primary">
                                        Perpanjang
                                    </a>

                                    <a href="javascript:void(0)"
                                        class="btn-action btn-danger"
                                        onclick="event.stopPropagation(); konfirmasiKeluar(<?= $p['id_penghuni'] ?>)">
                                        Berhentikan
                                    </a>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>

                        <!-- ROW DETAIL -->
                        <tr id="detail-<?= $p['id_penghuni'] ?>" class="row-detail">
                            <td colspan="10">
                                <div class="detail-box">
                                    <div class="detail-title">Detail Penghuni:</div>

                                    <div class="detail-item">
                                        <span>NIK</span>
                                        <b><?= $p['nik'] ?? '-' ?></b>
                                    </div>

                                    <div class="detail-item">
                                        <span>Alamat</span>
                                        <b><?= $p['alamat'] ?? '-' ?></b>
                                    </div>

                                    <div class="detail-item">
                                        <span>No HP</span>
                                        <b><?= $p['no_hp'] ?? '-' ?></b>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

</div>
<?php if(session()->getFlashdata('cetak_perpanjang') || session()->getFlashdata('cetak_pelunasan')): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {

    let id = null;
    let url = null;
    let pesan = '';

    // ================= PERPANJANG =================
    <?php if(session()->getFlashdata('cetak_perpanjang')): ?>
        id = "<?= session()->getFlashdata('cetak_perpanjang') ?>";
        url = "<?= base_url('kasir/transaksi/struk_perpanjang/') ?>" + id;
        pesan = 'Perpanjangan berhasil, struk diunduh...';
    <?php endif; ?>

    // ================= PELUNASAN =================
    <?php if(session()->getFlashdata('cetak_pelunasan')): ?>
        id = "<?= session()->getFlashdata('cetak_pelunasan') ?>";
        url = "<?= base_url('kasir/transaksi/struk_pelunasan/') ?>" + id;
        pesan = 'Pelunasan berhasil, struk diunduh...';
    <?php endif; ?>

    Swal.fire({
        title: 'Berhasil!',
        text: pesan,
        icon: 'success',
        timer: 2000,
        timerProgressBar: true,
        showConfirmButton: false,
        didOpen: () => {

            // 🔥 DOWNLOAD STRUK
            setTimeout(() => {
                let link = document.createElement('a');
                link.href = url;
                link.target = '_blank';
                link.click();
            }, 500);

        }
    });

});
</script>
<?php endif; ?>


<script>
// ================= BERHENTIKAN =================
function konfirmasiKeluar(id) {

    Swal.fire({
        title: 'Yakin?',
        text: "Penghuni akan dihentikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, berhentikan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "/kasir/penghuni/berhentikan/" + id;
        }
    });

}
</script>
<!-- SCRIPT TOGGLE -->
<script>
    function toggleDetail(id) {
        let row = document.getElementById('detail-' + id);

        if (row.style.display === 'table-row') {
            row.style.display = 'none';
        } else {
            row.style.display = 'table-row';
        }
    }
</script>


<?= $this->endSection() ?>