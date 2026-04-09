<?= $this->extend('layout/sidebarowner') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/owner/lihatuser.css') ?>">

<div class="page-wrapper">
    <div class="page-header">
        <h1>Data User</h1>
    </div>

    <!-- SEARCH -->
    <form method="get" action="/owner/user" class="search-container">
        <input type="text" name="keyword" placeholder="Cari user..." value="<?= esc($_GET['keyword'] ?? '') ?>">
        <button type="submit" class="btn-search">Search</button>
        <a href="/owner/user" class="btn-reset">Reset</a>
    </form>

    <!-- TABLE -->
    <div class="table-wrapper">
        <table class="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($user as $u): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($u->username) ?></td>
                    <td><?= esc($u->nama) ?></td>
                    <td><?= esc($u->role) ?></td>
                    <td style="text-align:center;">
                        <?php if ($u->status_user == 'aktif'): ?>
                            <span class="badge-aktif">Aktif</span>
                        <?php else: ?>
                            <span class="badge-nonaktif">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>