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

            <!-- STATUS -->
            <div class="form-group">
                <label>Status:</label>
                <select name="status_kamar">
                    <option value="tersedia" <?= $kamar['status_kamar'] == 'tersedia' ? 'selected' : '' ?>>Tersedia</option>
                    <option value="terisi" <?= $kamar['status_kamar'] == 'terisi' ? 'selected' : '' ?>>Terisi</option>
                    <option value="booking" <?= $kamar['status_kamar'] == 'booking' ? 'selected' : '' ?>>Booking</option>
                </select>
            </div>

           
            <div class="form-group">
                <label>Foto Kamar:</label>

                <?php if (!empty($kamar['foto'])): ?>
                    <img id="preview-img"
                         src="/uploads/kamar/<?= esc($kamar['foto']) ?>"
                         alt="Foto Kamar"
                         style="max-width:200px; border-radius:8px; margin-top:10px;">
                <?php else: ?>
                    <img id="preview-img"
                         src=""
                         alt="Preview Foto"
                         style="max-width:200px; display:none; border-radius:8px; margin-top:10px;">
                    <p id="no-img-text" class="foto-none">Tidak ada foto</p>
                <?php endif; ?>
            </div>

            <!-- INPUT FOTO -->
            <div class="form-group">
                <label>Ganti Foto:</label>
                <input type="file" name="foto" id="foto" accept="image/*" onchange="previewFoto(event)">
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

<script>
function previewFoto(event) {
    const input = event.target;
    const preview = document.getElementById('preview-img');
    const text = document.getElementById('no-img-text');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';

            if (text) {
                text.style.display = 'none';
            }
        }

        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?= $this->endSection() ?>