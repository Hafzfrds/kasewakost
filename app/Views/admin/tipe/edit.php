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
.form-group textarea {
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
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.form-group textarea {
    resize: vertical;
    min-height: 100px;
}

.form-group input:focus,
.form-group textarea:focus {
    box-shadow: 0 0 0 3px rgba(255,255,255,0.5);
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

            <div class="form-group">
                <label>Harga Tambahan:</label>
                <input type="number" name="harga_tambahan" value="<?= esc($tipe['harga_tambahan']) ?>" required>
            </div>

            <hr class="form-divider">

            <div class="form-actions">
                <button type="submit" class="btn-simpan">Update</button>
                <a href="/admin/tipe" class="btn-batal">Batal</a>
            </div>

        </form>
    </div>
</div>

<?= $this->endSection() ?>