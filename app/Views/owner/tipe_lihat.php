<?= $this->extend('layout/sidebarowner') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/owner/lihattipe.css') ?>">

<div class="page-wrapper">

    <div class="page-header">
        <h1>Lihat Tipe Kamar</h1>
    </div>

    <!-- Search -->
    <form method="get" action="/owner/tipe" class="search-container">
        <input type="text" name="keyword" placeholder="Cari tipe..." value="<?= esc($_GET['keyword'] ?? '') ?>">
        <button type="submit" class="btn-search">Search</button>
        <a href="/owner/tipe" class="btn-reset">Reset</a>
    </form>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Tipe</th>
                    <th>Fasilitas</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1;
                foreach ($tipe as $p): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= esc($p['nama_tipe']) ?></td>
                        <td><?= esc($p['fasilitas']) ?></td>
                   </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>