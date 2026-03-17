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

/* ===== HEADER ===== */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.page-header h1 {
    font-size: 2rem;
    font-weight: 700;
}

.btn-create {
    background: #3b82c4;
    color: white;
    padding: 10px 26px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
}

.btn-create:hover {
    background: #2c6fad;
}

/* ===== SEARCH ===== */
.search-container {
    background-color: #3b82c4;
    border-radius: 12px;
    padding: 20px 24px;
    display: flex;
    gap: 12px;
    align-items: center;
    margin-bottom: 28px;
}

.search-container input {
    flex: 1;
    padding: 12px 20px;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    color: #666;
    outline: none;
    background: #ffffff;
    box-shadow: inset 0 1px 3px rgba(0,0,0,0.08);
    font-style: italic;
}

.search-container input::placeholder {
    color: #aaa;
}

.btn-search {
    background-color: #ffffff;
    color: #1a1a2e;
    padding: 12px 28px;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.2s ease, box-shadow 0.2s ease;
    white-space: nowrap;
    text-decoration: none;
    display: inline-block;
}

.btn-search:hover {
    background-color: #e8f0fe;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    color: #1a1a2e;
    text-decoration: none;
}

.btn-reset {
    background-color: #e05c6a;
    color: #ffffff;
    padding: 12px 22px;
    border: none;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 700;
    cursor: pointer;
    transition: background-color 0.2s ease;
    white-space: nowrap;
    text-decoration: none;
    display: inline-block;
}

.btn-reset:hover {
    background-color: #c94d5a;
    color: #ffffff;
    text-decoration: none;
}

/* ===== GRID ===== */
.card-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 320px));
    gap: 20px;
    justify-content: start;
}

/* ===== CARD ===== */
.card-kamar {
    background: #4f86c6;
    border-radius: 16px;
    padding: 10px;
    box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    transition: 0.25s;
}

.card-kamar:hover {
    transform: translateY(-5px);
}

/* ===== IMAGE ===== */
.img-kamar {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 10px;
}

/* ===== BODY ===== */
.card-body {
    padding: 4px;
}

.card-nama {
    font-weight: 700;
    color: white;
    margin-bottom: 2px;
}

.card-tipe {
    font-size: 12px;
    color: #e5eefc;
    line-height: 1.3;
}

/* ===== INFO ===== */
.card-info-row {
    display: flex;
    justify-content: space-between;
    margin-top: 8px;
    border-top: 1px solid rgba(255,255,255,0.3);
    padding-top: 6px;
}

.card-harga {
    font-weight: bold;
    color: white;
}

.badge-tersedia {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #6ee7b7;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}

.badge-terisi {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    display: inline-block;
}

/* ===== BUTTON ===== */
.card-actions {
    display: flex;
    gap: 6px;
    margin-top: 8px;
}

.btn-edit {
    background: #4caf7d;
    color: #ffffff;
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.2s ease, box-shadow 0.2s ease;
}

.btn-edit:hover {
    opacity: 0.88;
    box-shadow: 0 2px 8px rgba(76, 175, 125, 0.45);
    text-decoration: none;
    color: #ffffff;
}

.btn-delete {
    background: #ef4444;
    color: white;
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.2s ease, box-shadow 0.2s ease;
}

.btn-delete:hover {
    opacity: 0.88;
    text-decoration: none;
    color: #ffffff;
}

/* ===== RESPONSIVE ===== */
@media (max-width: 900px) {
    .card-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 600px) {
    .card-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="page-header">
        <h1>Kelola Kamar</h1>
        <a href="/admin/kamar/create" class="btn-create">Create</a>
    </div>

    <!-- SEARCH -->
    <form method="get" action="/admin/kamar" class="search-container">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama kamar / nomor / tipe...">
        <button type="submit" class="btn-search">Search</button>
        <a href="/admin/kamar" class="btn-reset">Reset</a>
    </form>

    <!-- GRID -->
    <div class="card-grid">
        <?php foreach ($kamar as $k): ?>
        <div class="card-kamar">

            <!-- IMAGE -->
            <?php if (!empty($k['foto'])): ?>
                <img src="/uploads/kamar/<?= esc($k['foto']) ?>" class="img-kamar">
            <?php else: ?>
                <img src="https://via.placeholder.com/400x200" class="img-kamar">
            <?php endif; ?>

            <!-- BODY -->
            <div class="card-body">
                <div class="card-nama"><?= esc($k['nama_kamar']) ?></div>

                <div class="card-tipe">
                    <strong><?= esc($k['nama_tipe'] ?? '-') ?>:</strong>
                    <?= esc($k['fasilitas'] ?? '') ?>
                </div>

                <div class="card-info-row">
                    <div class="card-harga">
                        <?= number_format($k['total_harga'], 0, ',', '.') ?>
                    </div>

                    <?php if ($k['status_kamar'] == 'tersedia'): ?>
                        <div class="badge-tersedia">Ready</div>
                    <?php else: ?>
                        <div class="badge-terisi">Terisi</div>
                    <?php endif; ?>
                </div>

                <div class="card-actions">
                    <a href="/admin/kamar/edit/<?= $k['id_kamar'] ?>" class="btn-edit">Edit</a>
                    <a href="/admin/kamar/delete/<?= $k['id_kamar'] ?>"
                       onclick="return confirm('Yakin hapus kamar ini?')"
                       class="btn-delete">Delete</a>
                </div>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

</div>

<?= $this->endSection() ?>