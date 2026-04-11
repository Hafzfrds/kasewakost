<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/kasir/produk.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php if(session()->getFlashdata('cetak')): ?>
<script>
    window.open("<?= base_url('kasir/transaksi/cetakStruk/' . session()->getFlashdata('cetak')) ?>", "_blank");
</script>
<?php endif; ?>
<div class="page-wrapper">

    <!-- SEARCH -->
    <form method="get" action="/kasir/produk" class="search-container">
        <input 
            type="text" 
            name="keyword" 
            value="<?= esc($keyword ?? '') ?>" 
            placeholder="Cari nomor kamar / tipe / fasilitas..."
            class="input-search"
        >
        <button type="submit" class="btn-search">Search</button>
        <a href="/kasir/produk" class="btn-reset">Reset</a>
    </form>
    <!-- GRID -->
    <div class="card-grid">
        <?php foreach($kamar as $k): ?>
        <div class="card-kamar">

            <!-- IMAGE -->
            <?php if (!empty($k['foto'])): ?>
                <img src="/uploads/kamar/<?= esc($k['foto']) ?>" class="img-kamar">
            <?php else: ?>
                <img src="https://via.placeholder.com/400x200" class="img-kamar">
            <?php endif; ?>

            <!-- BODY -->
            <div class="card-body">
                <div class="card-nama">Kamar <?= esc($k['nomor_kamar']) ?></div>

                <div class="card-tipe">
                    <strong><?= esc($k['nama_tipe'] ?? '-') ?>:</strong>
                    <?= esc($k['fasilitas'] ?? '') ?>
                </div>

                <div class="card-info-row">
                    <div class="card-harga">
                       Rp <?= number_format($k['harga'], 0, ',', '.') ?>
                    </div>

                    <?php if ($k['status_kamar'] == 'tersedia'): ?>
                        <span class="badge-tersedia">Tersedia</span>
                    <?php elseif ($k['status_kamar'] == 'booking'): ?>
                        <span class="badge-booking">Booking</span>
                    <?php else: ?>
                        <span class="badge-terisi">Terisi</span>
                    <?php endif; ?>
                </div>

                <div class="card-actions">
                    <?php if($k['status_kamar'] == 'tersedia'): ?>
                     <a href="/kasir/transaksi/bayar/<?= $k['id_kamar'] ?>" class="btn-bayar">Bayar</a>
<a href="/kasir/transaksi/booking/<?= $k['id_kamar'] ?>" class="btn-booking">Booking</a>

                    <?php elseif($k['status_kamar'] == 'booking'): ?>
                        <a href="/kasir/transaksi/pelunasan/<?= $k['id_kamar'] ?>" class="btn-pelunasan">Pelunasan</a>

                    <?php else: ?>
                        <button class="btn-terisi" disabled>Terisi</button>
                    <?php endif; ?>

                  
                </div>
            </div>

        </div>
        <?php endforeach; ?>
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
<?= $this->endSection() ?>