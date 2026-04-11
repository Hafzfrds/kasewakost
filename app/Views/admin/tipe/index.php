<?= $this->extend('layout/sidebaradmin') ?>
<?= $this->section('content') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="<?= base_url('css/admin/tipe/index.css') ?>">

<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <h1>Kelola Tipe</h1>
        <a href="/admin/tipe/create" class="btn-create">Create</a>
    </div>

    <!-- Search -->
    <form method="get" action="/admin/tipe" class="search-container">
        <input type="text" name="keyword" placeholder="Cari tipe..." value="<?= esc($_GET['keyword'] ?? '') ?>">
        <button type="submit" class="btn-search">Search</button>
        <a href="/admin/tipe" class="btn-reset">Reset</a>
    </form>



    <!-- Table -->
    <div class="table-wrapper">
        <table class="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tipe</th>
                    <th>Fasilitas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($tipe as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($p['nama_tipe']) ?></td>
                        <td><?= esc($p['fasilitas']) ?></td>
                        <td>
                            <div class="action-cell">
                                <a href="/admin/tipe/edit/<?= $p['id_tipe'] ?>" class="btn-edit">Edit</a>
                                <a href="/admin/tipe/delete/<?= $p['id_tipe'] ?>"
                                    class="btn-delete btn-hapus"
                                    data-id="<?= $p['id_tipe'] ?>">
                                    Hapus
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>
<?php $success = session()->getFlashdata('success'); ?>

<script>
document.addEventListener("DOMContentLoaded", function() {

    // =========================
    // SWEETALERT SUCCESS
    // =========================
    <?php if($success): ?>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '<?= $success ?>',
            showConfirmButton: false,
            timer: 2000
        });
    <?php endif; ?>


    // =========================
    // KONFIRMASI HAPUS
    // =========================
    document.querySelectorAll('.btn-hapus').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const url = this.getAttribute('href');

            Swal.fire({
                title: 'Yakin hapus?',
                text: "Data tipe akan dihapus permanen!",
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

});
</script>
<?= $this->endSection() ?>