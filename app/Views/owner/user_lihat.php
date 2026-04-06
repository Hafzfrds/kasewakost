<?= $this->extend('layout/sidebarowner') ?>
<?= $this->section('content') ?>

<h2>Data User</h2>

<table>
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
        <?php $no=1; foreach($user as $u): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $u->username ?></td>
            <td><?= $u->nama ?></td>
            <td><?= $u->role ?></td>
            <td>
                <?php if($u->status_user == 'aktif'): ?>
                    <span style="color:green;">Aktif</span>
                <?php else: ?>
                    <span style="color:red;">Nonaktif</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>