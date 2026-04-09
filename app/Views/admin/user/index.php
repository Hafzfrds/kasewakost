<?= $this->extend('layout/sidebaradmin') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/admin/user/index.css') ?>">

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
                            <a href="/admin/user/delete/<?= $u['id_user'] ?>" class="btn-delete"
                               onclick="return confirm('Yakin ingin menghapus user ini?')">Delete</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>