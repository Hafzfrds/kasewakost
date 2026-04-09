<?= $this->extend('layout/sidebaradmin') ?>
<?= $this->section('content') ?>

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

    <!-- Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

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
                <?php $no = 1; foreach ($tipe as $p): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($p['nama_tipe']) ?></td>
                    <td><?= esc($p['fasilitas']) ?></td>
                    <td>
                        <div class="action-cell">
                            <a href="/admin/tipe/edit/<?= $p['id_tipe'] ?>" class="btn-edit">Edit</a>
                            <a href="/admin/tipe/delete/<?= $p['id_tipe'] ?>"
                               onclick="return confirm('Yakin hapus?')"
                               class="btn-delete">Hapus</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>