<?= $this->extend('layout/sidebarowner') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/owner/lihatkamar.css') ?>">

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="page-header">
        <h1>Data Kamar</h1>
    </div>

    <!-- SEARCH -->
    <form method="get" action="/owner/kamar" class="search-container">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama kamar / nomor / tipe...">
        <button type="submit" class="btn-search">Search</button>
        <a href="/owner/kamar" class="btn-reset">Reset</a>
    </form>

    <!-- GRID -->
    <div class="card-grid">
        <?php foreach ($kamar as $k): ?>
        <div class="card-kamar">

            <!-- IMAGE -->
            <?php if (!empty($k['foto'])): ?>
                <img src="/uploads/kamar/<?= esc($k['foto']) ?>" class="img-kamar">
            <?php else: ?>
                <img src="https://via.placeholder.com/400x200" class="img-kamar">
            <?php endif; ?>

            <!-- BODY -->
            <div class="card-body">
                <div class="card-nama">
                    <?= esc($k['nama_kamar']) ?> (<?= esc($k['nomor_kamar']) ?>)
                </div>

                <div class="card-tipe">
                    <strong><?= esc($k['nama_tipe'] ?? '-') ?>:</strong>
                    <?= esc($k['fasilitas'] ?? '-') ?>
                </div>

                <div class="card-info-row">
                    <div class="card-harga">
                        Rp <?= number_format($k['harga'], 0, ',', '.') ?>
                    </div>

                    <?php if ($k['status_kamar'] == 'tersedia'): ?>
                        <div class="badge-tersedia">Tersedia</div>
                    <?php elseif ($k['status_kamar'] == 'booking'): ?>
                        <div class="badge-booking">Booking</div>
                    <?php else: ?>
                        <div class="badge-terisi">Terisi</div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

</div>

<?= $this->endSection() ?>