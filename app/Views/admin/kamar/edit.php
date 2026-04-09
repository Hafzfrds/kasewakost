<?= $this->extend('layout/sidebaradmin') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/admin/kamar/edit.css') ?>">

<div class="page-wrapper">
    <div class="form-card">
        <h1>Edit Kamar</h1>

        <form action="/admin/kamar/update/<?= $kamar['id_kamar'] ?>" method="post" enctype="multipart/form-data">

            <div class="form-group">
                <label>Nama Kamar:</label>
                <input type="text" name="nama_kamar" value="<?= esc($kamar['nama_kamar']) ?>" required>
            </div>

            <div class="form-group">
                <label>Nomor Kamar:</label>
                <input type="text" name="nomor_kamar" value="<?= esc($kamar['nomor_kamar']) ?>" required>
            </div>

            <div class="form-group">
                <label>Harga:</label>
                <input type="number" name="harga" value="<?= esc($kamar['harga']) ?>" required>
            </div>

            <div class="form-group">
                <label>Tipe:</label>
                <select name="id_tipe">
                    <option value="">-- Pilih tipe --</option>
                    <?php foreach ($tipe as $t): ?>
                        <option value="<?= $t['id_tipe'] ?>"
                            <?= $kamar['id_tipe'] == $t['id_tipe'] ? 'selected' : '' ?>>
                            <?= esc($t['nama_tipe']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group">
                <label>Status:</label>
                <select name="status_kamar">
                    <option value="tersedia" <?= $kamar['status_kamar'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="terisi"   <?= $kamar['status_kamar'] == 'terisi'   ? 'selected' : '' ?>>Terisi</option>
                </select>
            </div>

            <div class="form-group">
                <label>Foto Sekarang:</label>
                <?php if ($kamar['foto']): ?>
                    <div class="foto-preview">
                        <img src="/uploads/kamar/<?= esc($kamar['foto']) ?>" alt="Foto Kamar">
                    </div>
                <?php else: ?>
                    <p class="foto-none">Tidak ada foto</p>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label>Ganti Foto:</label>
                <input type="file" name="foto">
                <div class="form-hint">* Kosongkan jika tidak ingin mengganti foto</div>
            </div>

            <hr class="form-divider">

            <div class="form-actions">
                <button type="submit" class="btn-simpan">Update</button>
                <a href="/admin/kamar" class="btn-batal">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>