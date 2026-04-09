<?= $this->extend('layout/sidebarkasir') ?>
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

.btn-cart {
    background: #2c3e50;
    color: white;
    padding: 10px 26px;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.95rem;
}

.btn-cart:hover {
    background: #1a252f;
    color: white;
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
    font-size: 1rem;
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
    align-items: center;
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

.badge-booking {
    background-color: #fef3c7;
    color: #92400e;
    border: 1px solid #fcd34d;
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
    flex-wrap: wrap;
}

.btn-bayar {
    background: #27ae60;
    color: #ffffff;
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.2s ease, box-shadow 0.2s ease;
}

.btn-bayar:hover {
    opacity: 0.88;
    box-shadow: 0 2px 8px rgba(39, 174, 96, 0.45);
    text-decoration: none;
    color: #ffffff;
}

.btn-booking {
    background: #f39c12;
    color: #ffffff;
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.2s ease;
}

.btn-booking:hover {
    opacity: 0.88;
    text-decoration: none;
    color: #ffffff;
}

.btn-pelunasan {
    background: #8e44ad;
    color: #ffffff;
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: opacity 0.2s ease;
}

.btn-pelunasan:hover {
    opacity: 0.88;
    text-decoration: none;
    color: #ffffff;
}

.btn-terisi {
    background: #e74c3c;
    color: #ffffff;
    padding: 6px 16px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: default;
}

.btn-tambah {
    background: #3498db;
    color: #ffffff;
    padding: 6px 14px;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 700;
    text-decoration: none;
    transition: opacity 0.2s ease;
}

.btn-tambah:hover {
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

    .page-wrapper {
        padding: 20px 16px;
    }
}
</style>

<div class="page-wrapper">

    
    <!-- GRID -->
    <div class="card-grid">
        <?php foreach($kamar as $k): ?>
        <div class="card-kamar">

            <!-- IMAGE -->
            <?php if (!empty($k['foto'])): ?>
                <img src="/uploads/kamar/<?= esc($k['foto']) ?>" class="img-kamar">
            <?php else: ?>
                <img src="https://via.placeholder.com/400x200" class="img-kamar">
            <?php endif; ?>

            <!-- BODY -->
            <div class="card-body">
                <div class="card-nama">Kamar <?= esc($k['nomor_kamar']) ?></div>

                <div class="card-tipe">
                    <strong><?= esc($k['nama_tipe'] ?? '-') ?>:</strong>
                    <?= esc($k['fasilitas'] ?? '') ?>
                </div>

                <div class="card-info-row">
                    <div class="card-harga">
                       Rp <?= number_format($k['harga'], 0, ',', '.') ?>
                    </div>

                    <?php if ($k['status_kamar'] == 'tersedia'): ?>
                        <span class="badge-tersedia">Tersedia</span>
                    <?php elseif ($k['status_kamar'] == 'booking'): ?>
                        <span class="badge-booking">Booking</span>
                    <?php else: ?>
                        <span class="badge-terisi">Terisi</span>
                    <?php endif; ?>
                </div>

                <div class="card-actions">
                    <?php if($k['status_kamar'] == 'tersedia'): ?>
                     <a href="/kasir/transaksi/bayar/<?= $k['id_kamar'] ?>" class="btn-bayar">Bayar</a>
<a href="/kasir/transaksi/booking/<?= $k['id_kamar'] ?>" class="btn-booking">Booking</a>

                    <?php elseif($k['status_kamar'] == 'booking'): ?>
                        <a href="/kasir/transaksi/pelunasan/<?= $k['id_kamar'] ?>" class="btn-pelunasan">Pelunasan</a>

                    <?php else: ?>
                        <button class="btn-terisi" disabled>Terisi</button>
                    <?php endif; ?>

                  
                </div>
            </div>

        </div>
        <?php endforeach; ?>
    </div>

</div>

<?= $this->endSection() ?>