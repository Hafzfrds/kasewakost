<?= $this->extend('layout/sidebaradmin') ?>

<?= $this->section('content') ?>

<style>
/* ===== PAGE ===== */
.page-wrapper {
    padding: 32px 36px;
    min-height: 100vh;
    background-color: #f0f4f8;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* ===== FORM CARD ===== */
.form-card {
    background-color: #4f86c6;
    border-radius: 16px;
    padding: 32px 36px 28px;
    max-width: 100%;
    margin: 0 auto;
}

/* ===== TITLE ===== */
.form-card h1 {
    font-size: 1.8rem;
    font-weight: 700;
    color: #ffffff;
    margin: 0 0 24px;
}

/* ===== FORM GROUP ===== */
.form-group {
    margin-bottom: 14px;
}

.form-group label {
    display: block;
    font-size: 0.88rem;
    font-weight: 600;
    color: #ffffff;
    margin-bottom: 5px;
}

.form-group input[type="text"],
.form-group input[type="number"],
.form-group input[type="file"],
.form-group select {
    width: 100%;
    padding: 12px 16px;
    border: none;
    border-radius: 10px;
    font-size: 0.95rem;
    color: #2d2d2d;
    background-color: #ffffff;
    box-sizing: border-box;
    outline: none;
    transition: box-shadow 0.2s ease;
}

.form-group select {
    padding-right: 36px;
    appearance: auto;
    -webkit-appearance: auto;
}

.form-group input:focus,
.form-group select:focus {
    box-shadow: 0 0 0 3px rgba(255,255,255,0.5);
}

.form-group input[type="file"] {
    padding: 9px 16px;
    color: #555;
}

/* ===== FOTO PREVIEW ===== */
.foto-preview {
    margin-top: 6px;
    border-radius: 10px;
    overflow: hidden;
    display: inline-block;
    border: 3px solid rgba(255,255,255,0.4);
}

.foto-preview img {
    display: block;
    width: 200px;
    height: 140px;
    object-fit: cover;
}

.foto-none {
    font-size: 0.88rem;
    color: rgba(255,255,255,0.75);
    font-style: italic;
}

/* ===== HINT TEXT ===== */
.form-hint {
    font-size: 0.78rem;
    color: rgba(255,255,255,0.75);
    margin-top: 4px;
}

/* ===== DIVIDER ===== */
.form-divider {
    border: none;
    border-top: 1px solid rgba(255,255,255,0.35);
    margin: 20px 0;
}

/* ===== BUTTONS ===== */
.form-actions {
    display: flex;
    gap: 10px;
    align-items: center;
}

.btn-simpan {
    background-color: #2c6fad;
    color: #ffffff;
    padding: 10px 26px;
    border: none;
    border-radius: 8px;
    font-size: 0.92rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-simpan:hover {
    background-color: #1e5a96;
}

.btn-batal {
    background-color: #ef4444;
    color: #ffffff;
    padding: 10px 26px;
    border: none;
    border-radius: 8px;
    font-size: 0.92rem;
    font-weight: 600;
    cursor: pointer;
    transition: background-color 0.2s ease;
    text-decoration: none;
    display: inline-block;
}

.btn-batal:hover {
    background-color: #dc2626;
    color: #ffffff;
    text-decoration: none;
}
</style>

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