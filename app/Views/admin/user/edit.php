<?= $this->extend('layout/sidebaradmin') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/admin/user/edit.css') ?>">

<div class="page-wrapper">
    <div class="form-card">
        <h1>Edit User</h1>

        <form action="/admin/user/update/<?= $user['id_user'] ?>" method="post">

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?= esc($user['username']) ?>" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" placeholder="Kosongkan jika tidak diubah">
                <div class="form-hint">* Kosongkan jika tidak ingin mengubah password</div>
            </div>

            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" value="<?= esc($user['nama']) ?>" required>
            </div>

            <div class="form-group">
                <label>Role:</label>
                <select name="role">
                    <option value="admin"  <?= $user['role'] == 'admin'  ? 'selected' : '' ?>>Admin</option>
                    <option value="kasir"  <?= $user['role'] == 'kasir'  ? 'selected' : '' ?>>Kasir</option>
                    <option value="owner"  <?= $user['role'] == 'owner'  ? 'selected' : '' ?>>Owner</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status_user">
                    <option value="aktif"    <?= $user['status_user'] == 'aktif'    ? 'selected' : '' ?>>Aktif</option>
                    <option value="nonaktif" <?= $user['status_user'] == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                </select>
            </div>

            <hr class="form-divider">

            <div class="form-actions">
                <button type="submit" class="btn-simpan">Update</button>
                <a href="/admin/user" class="btn-batal">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>