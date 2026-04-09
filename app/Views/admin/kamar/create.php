<?= $this->extend('layout/sidebaradmin') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/admin/kamar/create.css') ?>">

<div class="page-wrapper">
    <div class="form-card">
        <h1>Tambah Kamar</h1>

        <form action="/admin/kamar/store" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nama Kamar:</label>
                <input type="text" name="nama_kamar" placeholder="Nama Kamar" required>
            </div>

            <div class="form-group">
                <label>Nomor Kamar:</label>
                <input type="text" name="nomor_kamar" placeholder="Nomor Kamar" required>
            </div>

            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="harga" placeholder="Harga" required>
            </div>

            <div class="form-group">
                <label>Tipe:</label>
                <select name="id_tipe">
                    <option value="">-- Pilih tipe --</option>
                    <?php foreach ($tipe as $p): ?>
                        <option value="<?= $p['id_tipe'] ?>">
                            <?= esc($p['nama_tipe']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status_kamar">
                    <option value="tersedia">Tersedia</option>
                    <option value="terisi">Terisi</option>
                </select>
            </div>

            <div class="form-group">
                <label>Foto Kamar:</label>
                <input type="file" name="foto">
            </div>

            <hr class="form-divider">

            <div class="form-actions">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a href="/admin/kamar" class="btn-batal">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>