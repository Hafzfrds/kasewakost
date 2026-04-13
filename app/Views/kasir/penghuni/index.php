<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="<?= base_url('css/kasir/penghuni/index.css') ?>">

<div class="page-wrapper">

    <div class="page-header">
        <h1>Data Penghuni</h1>
    </div>

    <!-- Search -->
    <form method="get" action="/kasir/penghuni" class="search-container">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari kamar...">
        <button type="submit" class="btn-search">Search</button>
        <a href="/kasir/penghuni" class="btn-reset">Reset</a>
    </form>

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
                    foreach ($dataDetail as $d): ?>

                        <?php $utama = $d['list_penghuni'][0] ?? null; ?>

                        
                        <tr onclick="toggleDetail(<?= $d['id_detail'] ?>)" style="cursor:pointer;">
                            <td><?= $no++ ?></td>
                            <td><?= $utama['nama_penghuni'] ?? '-' ?></td>
                            <td>
                                <?= esc($d['nama_kamar']) . '-' . str_pad($d['nomor_kamar'], 2, '0', STR_PAD_LEFT) ?>
                            </td>

                            <td><?= number_format($d['uang_masuk']) ?></td>
                            <td><?= number_format(max(0, $d['sisa_bayar'])) ?></td>
                            <td><?= $d['tanggal_masuk'] ?></td>
                            <td><?= $d['jatuh_tempo'] ?></td>

                            <!-- STATUS BAYAR -->
                            <td>
                                <?php if ($d['sisa_bayar'] > 0): ?>
                                    <span class="badge-pending">Booking</span>
                                <?php else: ?>
                                    <span class="badge-lunas">Lunas</span>
                                <?php endif; ?>
                            </td>

                            <!-- STATUS PENGHUNI  -->
                            <td>
                                <?php if ($utama && $utama['status'] == 'menunggu pembayaran'): ?>
                                    <span class="badge-pending">Menunggu</span>

                                <?php elseif ($utama && $utama['status'] == 'sedang menghuni'): ?>
                                    <span class="badge-lunas">Menghuni</span>

                                <?php else: ?>
                                    <span class="badge-danger">Keluar</span>
                                <?php endif; ?>
                            </td>

                            <!-- AKSI -->
                            <td>
                                <?php if ($utama && $utama['status'] != 'keluar'): ?>

                                    <?php if ($d['sisa_bayar'] > 0): ?>
                                        <a href="/kasir/transaksi/pelunasan/<?= $d['id_detail'] ?>" class="btn-action btn-warning">
                                            Pelunasan
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($d['status_sewa'] != 'booking'): ?>
                                        <a href="/kasir/transaksi/perpanjang/<?= $d['id_detail'] ?>" class="btn-action btn-primary">
                                            Perpanjang
                                        </a>
                                    <?php endif; ?>

                                    <a href="javascript:void(0)"
                                        class="btn-action btn-danger"
                                        onclick="event.stopPropagation(); konfirmasiKeluar(<?= $utama['id_penghuni'] ?>)">
                                        Berhentikan
                                    </a>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>

                
                        <tr id="detail-<?= $d['id_detail'] ?>" class="row-detail" style="display:none;">
                            <td colspan="10">
                                <div class="detail-box">
                                    <div class="detail-title">Detail Semua Penghuni</div>

                                    <?php foreach ($d['list_penghuni'] as $p): ?>

                                        <div class="penghuni-paragraf">
                                            <b><?= $p['nama_penghuni'] ?></b> |
                                            NIK: <?= $p['nik'] ?? '-' ?> |
                                            Alamat: <?= $p['alamat'] ?? '-' ?> |
                                            No HP: <?= $p['no_hp'] ?? '-' ?> |
                                            Status: <?= $p['status'] ?>
                                        </div>

                                    <?php endforeach; ?>
                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
    </div>

</div>

<?php if(session()->getFlashdata('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: "<?= session()->getFlashdata('success'); ?>",
        showConfirmButton: false,
        timer: 2000
    });
</script>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal',
        text: "<?= session()->getFlashdata('error'); ?>"
    });
</script>
<?php endif; ?>

<!-- AUTO DOWNLOAD PERPANJANG -->
<?php if(session()->getFlashdata('cetak_perpanjang')): ?>
<script>
    window.open("<?= base_url('kasir/transaksi/struk_perpanjang/' . session()->getFlashdata('cetak_perpanjang')) ?>", "_blank");
</script>
<?php endif; ?>

<!-- AUTO DOWNLOAD PELUNASAN -->
<?php if(session()->getFlashdata('cetak_pelunasan')): ?>
<script>
    let idDetail = "<?= session()->getFlashdata('cetak_pelunasan') ?>";
    let bayarLama = "<?= session()->getFlashdata('bayar_lama') ?>";
    let bayarSekarang = "<?= session()->getFlashdata('bayar_sekarang') ?>";
    window.open("<?= base_url('kasir/transaksi/struk_pelunasan/') ?>" + idDetail + "?bayar_lama=" + bayarLama + "&bayar_sekarang=" + bayarSekarang, "_blank");
</script>
<?php endif; ?>

<script>
    // FUNGSI YANG SEBELUMNYA HILANG (PENYEBAB ERROR)
    function konfirmasiKeluar(id) {
        Swal.fire({
            title: 'Yakin ingin menghentikan penghuni ini?',
            text: "Penghuni akan ditandai keluar dan kamar menjadi tersedia.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Berhentikan!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Arahkan ke controller untuk memproses penghentian
                window.location.href = '/kasir/penghuni/berhentikan/' + id;
            }
        });
    }

    function toggleDetail(id) {
        let row = document.getElementById('detail-' + id);
        row.style.display = (row.style.display === 'table-row') ? 'none' : 'table-row';
    }
</script>

<?= $this->endSection() ?>