<?= $this->extend('layout/sidebaradmin') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/admin/tipe/edit.css') ?>">

<div class="page-wrapper">
    <div class="form-card">
        <h1>Edit Tipe</h1>

        <form action="/admin/tipe/update/<?= $tipe['id_tipe'] ?>" method="post">

            <div class="form-group">
                <label>Nama Tipe:</label>
                <input type="text" name="nama_tipe" value="<?= esc($tipe['nama_tipe']) ?>" required>
            </div>

            <div class="form-group">
                <label>Fasilitas:</label>
                <textarea name="fasilitas" required><?= esc($tipe['fasilitas']) ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-simpan">Update</button>
                <a href="/admin/tipe" class="btn-batal">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>