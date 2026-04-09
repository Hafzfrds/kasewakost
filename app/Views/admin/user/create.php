<?= $this->extend('layout/sidebaradmin') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/admin/user/create.css') ?>">

<div class="page-wrapper">
    <div class="form-card">
        <h1>Tambah User</h1>

        <form action="/admin/user/store" method="post">

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="form-group">
                <label>Nama:</label>
                <input type="text" name="nama" placeholder="Nama" required>
            </div>

            <div class="form-group">
                <label>Role:</label>
                <select name="role">
                    <option value="admin">Admin</option>
                    <option value="kasir">Kasir</option>
                    <option value="owner">Owner</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status_user">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                </select>
            </div>

            <hr class="form-divider">

            <div class="form-actions">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a href="/admin/user" class="btn-batal">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>