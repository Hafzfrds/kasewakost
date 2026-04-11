<?= $this->extend('layout/sidebaradmin') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/admin/kamar/index.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="page-header">
        <h1>Kelola Kamar</h1>
        <a href="/admin/kamar/create" class="btn-create">Create</a>
    </div>

    <!-- SEARCH -->
    <form method="get" action="/admin/kamar" class="search-container">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama kamar / nomor / tipe...">
        <button type="submit" class="btn-search">Search</button>
        <a href="/admin/kamar" class="btn-reset">Reset</a>
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
                    <div class="card-nama"><?= esc($k['nama_kamar']) ?></div>

                    <div class="card-tipe">
                        <strong><?= esc($k['nama_tipe'] ?? '-') ?>:</strong>
                        <?= esc($k['fasilitas'] ?? '') ?>
                    </div>

                    <div class="card-info-row">
                        <div class="card-harga">
                            Rp <?= number_format($k['harga'], 0, ',', '.') ?>
                        </div>

                        <?php if ($k['status_kamar'] == 'tersedia'): ?>
                            <div class="badge-tersedia">Ready</div>

                        <?php elseif ($k['status_kamar'] == 'booking'): ?>
                            <div class="badge-booking">Booking</div>

                        <?php else: ?>
                            <div class="badge-terisi">Terisi</div>
                        <?php endif; ?>
                    </div>

                    <div class="card-actions">
                        <a href="/admin/kamar/edit/<?= $k['id_kamar'] ?>" class="btn-edit">Edit</a>
                        <a href="/admin/kamar/delete/<?= $k['id_kamar'] ?>"
                            class="btn-delete btn-hapus"
                            data-id="<?= $k['id_kamar'] ?>">
                            Delete
                        </a>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    </div>

</div>
<?php if(session()->getFlashdata('success')): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: '<?= session()->getFlashdata('success'); ?>',
        showConfirmButton: false,
        timer: 2000
    });
});
</script>
<?php endif; ?>
<script>
document.querySelectorAll('.btn-hapus').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        const url = this.getAttribute('href');

        Swal.fire({
            title: 'Yakin hapus?',
            text: "Data kamar akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74c3c',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });
});
</script>
<?= $this->endSection() ?>