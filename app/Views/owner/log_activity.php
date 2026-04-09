<?= $this->extend('layout/sidebarowner') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/owner/log.css') ?>">

<div class="page-wrapper">

    <!-- Header -->
    <div class="page-header">
        <h1>Log Activity</h1>
    </div>

    <!-- Filter / Search -->
    <form method="get">
        <div class="search-container">
            <input type="text" name="keyword" placeholder="Cari user / aktivitas..." value="<?= $keyword ?? '' ?>">
            <button type="submit" class="btn-search">Cari</button>
            <?php if (!empty($keyword)): ?>
                <a href="<?= base_url('log-activity') ?>" class="btn-reset">Reset</a>
            <?php endif; ?>
        </div>
    </form>

    <!-- Tabel -->
    <div class="table-wrapper">
        <table class="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th style="text-align:center;">Aktivitas</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($log)) : ?>
                    <?php $no = 1; foreach ($log as $l) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($l['tanggal'])) ?></td>
                            <td><?= $l['username'] ?></td>
                            <td><?= ucfirst($l['role']) ?></td>
                            <td style="text-align:center;">
                          <?php
    $badgeClass = 'badge-info';
    if ($l['aktivitas'] == 'LOGIN')  $badgeClass = 'badge-login';
    if ($l['aktivitas'] == 'LOGOUT') $badgeClass = 'badge-logout';
    if ($l['aktivitas'] == 'DELETE') $badgeClass = 'badge-delete';
    if ($l['aktivitas'] == 'UPDATE') $badgeClass = 'badge-update';
    if ($l['aktivitas'] == 'CREATE') $badgeClass = 'badge-info';
?>
<span class="badge-activity <?= $badgeClass ?>">
    <?= $l['aktivitas'] ?>
</span>
                            </td>
                            <td><?= $l['keterangan'] ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" class="td-empty">Tidak ada data log</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>