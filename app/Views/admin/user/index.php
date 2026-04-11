<?= $this->extend('layout/sidebaradmin') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/admin/user/index.css') ?>">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <h1>Kelola User</h1>
        <a href="/admin/user/create" class="btn-create">Create</a>
    </div>

    <!-- Search -->
    <form method="get" action="/admin/user" class="search-container">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari username / nama / role...">
        <button type="submit" class="btn-search">Search</button>
        <a href="/admin/user" class="btn-reset">Reset</a>
    </form>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $i => $u): ?>
                    <tr>
                        <td><?= $i + 1 ?></td>
                        <td><?= esc($u['username']) ?></td>
                        <td><?= esc($u['nama']) ?></td>
                        <td><?= esc($u['role']) ?></td>
                        <td><?= esc($u['status_user']) == 'aktif'
                                ? '<span class="badge-aktif">Aktif</span>'
                                : '<span class="badge-nonaktif">Nonaktif</span>' ?></td>
                        <td>
                            <div class="action-cell">
                                <a href="/admin/user/edit/<?= $u['id_user'] ?>" class="btn-edit">Edit</a>
                                <a href="/admin/user/delete/<?= $u['id_user'] ?>"
                                    class="btn-delete btn-hapus"
                                    data-id="<?= $u['id_user'] ?>">
                                    Delete
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
                text: "User akan dihapus permanen!",
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