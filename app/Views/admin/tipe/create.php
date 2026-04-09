<?= $this->extend('layout/sidebaradmin') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/admin/tipe/create.css') ?>">

<div class="page-wrapper">
    <div class="form-card">
        <h1>Tambah Tipe</h1>

        <form action="/admin/tipe/store" method="post">

            <div class="form-group">
                <label>Nama Tipe:</label>
                <input type="text" name="nama_tipe" placeholder="Nama Tipe" required>
            </div>

            <div class="form-group">
                <label>Fasilitas:</label>
                <textarea name="fasilitas" placeholder="Contoh: AC, Wifi, Lemari, Meja belajar" required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-simpan">Simpan</button>
                <a href="/admin/tipe" class="btn-batal">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>