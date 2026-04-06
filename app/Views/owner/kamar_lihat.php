<?= $this->extend('layout/sidebarowner') ?>
<?= $this->section('content') ?>

<style>
.page-wrapper {
    padding: 32px 36px;
    min-height: 100vh;
    background-color: #f0f4f8;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

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

/* SEARCH */
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
    outline: none;
    background: #ffffff;
    font-style: italic;
}

.btn-search {
    background-color: #ffffff;
    color: #1a1a2e;
    padding: 12px 28px;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    cursor: pointer;
    text-decoration: none;
}

.btn-reset {
    background-color: #e05c6a;
    color: #ffffff;
    padding: 12px 22px;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    text-decoration: none;
}

/* GRID */
.card-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 320px));
    gap: 20px;
}

/* CARD */
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

/* IMAGE */
.img-kamar {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 10px;
}

/* BODY */
.card-body {
    padding: 4px;
}

.card-nama {
    font-weight: 700;
    color: white;
}

.card-tipe {
    font-size: 12px;
    color: #e5eefc;
    margin-top: 4px;
}

/* INFO */
.card-info-row {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    border-top: 1px solid rgba(255,255,255,0.3);
    padding-top: 6px;
}

.card-harga {
    font-weight: bold;
    color: white;
}

/* BADGE */
.badge-tersedia {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #6ee7b7;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-booking {
    background-color: #fef9c3;
    color: #854d0e;
    border: 1px solid #fde68a;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-terisi {
    background-color: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

/* RESPONSIVE */
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
        <h1>Data Kamar</h1>
    </div>

    <!-- SEARCH -->
    <form method="get" action="/owner/kamar" class="search-container">
        <input type="text" name="keyword" value="<?= esc($keyword ?? '') ?>" placeholder="Cari nama kamar / nomor / tipe...">
        <button type="submit" class="btn-search">Search</button>
        <a href="/owner/kamar" class="btn-reset">Reset</a>
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
                <div class="card-nama">
                    <?= esc($k['nama_kamar']) ?> (<?= esc($k['nomor_kamar']) ?>)
                </div>

                <div class="card-tipe">
                    <strong><?= esc($k['nama_tipe'] ?? '-') ?>:</strong>
                    <?= esc($k['fasilitas'] ?? '-') ?>
                </div>

                <div class="card-info-row">
                    <div class="card-harga">
                        Rp <?= number_format($k['harga'], 0, ',', '.') ?>
                    </div>

                    <?php if ($k['status_kamar'] == 'tersedia'): ?>
                        <div class="badge-tersedia">Tersedia</div>
                    <?php elseif ($k['status_kamar'] == 'booking'): ?>
                        <div class="badge-booking">Booking</div>
                    <?php else: ?>
                        <div class="badge-terisi">Terisi</div>
                    <?php endif; ?>
                </div>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

</div>

<?= $this->endSection() ?>