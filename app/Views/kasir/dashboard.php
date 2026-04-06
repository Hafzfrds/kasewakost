<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
/* ===== DASHBOARD KASIR CSS ===== */
.page-wrapper {
    padding: 30px 35px;
    background-color: #dde6f0;
    min-height: 100vh;
}

.page-wrapper > h2 {
    font-size: 2rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 2px;
}

.page-wrapper > p {
    font-size: 0.9rem;
    font-weight: 600;
    color: #1a1a2e;
    margin-bottom: 25px;
}

/* 3-column grid */
.grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 18px;
    margin-bottom: 28px;
}

/* Card wrapper */
.card-box {
    background: #578FCA;
    border-radius: 14px;
    color: #fff;
    min-height: 200px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(74, 134, 184, 0.25);
}

/* Icon + number area */
.card-body {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 16px;
    padding: 20px;
}

.card-body i {
    font-size: 3.8rem;
    opacity: 0.95;
}

.card-body h2 {
    font-size: 3.8rem;
    font-weight: 800;
    color: #fff;
    line-height: 1;
    margin: 0;
}

/* Title strip at bottom */
.card-title {
    background: rgba(0, 0, 0, 0.18);
    text-align: center;
    padding: 13px 10px;
    font-size: 1.1rem;
    font-weight: 700;
    color: rgba(255, 255, 255, 0.97);
    letter-spacing: 0.02em;
}

/* Table */
.table-box {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.07);
}

.table-box table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.92rem;
}

.table-box thead tr {
    background: #578FCA;
    color: #fff;
}

.table-box thead th {
    padding: 13px 18px;
    font-weight: 600;
    text-align: left;
    font-size: 0.9rem;
    letter-spacing: 0.02em;
}

.table-box tbody tr {
    border-bottom: 1px solid #eef2f7;
    transition: background 0.15s;
}

.table-box tbody tr:last-child {
    border-bottom: none;
}

.table-box tbody tr:hover {
    background: #f0f6fc;
}

.table-box tbody td {
    padding: 12px 18px;
    color: #2c3e50;
    font-size: 0.92rem;
}

.table-box tbody td:first-child {
    font-weight: 600;
    color: #1a1a2e;
}
</style>

<div class="page-wrapper">

    <h2>Kasir</h2>
    <p>Selamat datang di role kasir</p>

    <!-- CARD: 3 kolom -->
    <div class="grid">
        <div class="card-box">
            <div class="card-body">
                <i class="fa-solid fa-bed"></i>
                <h2><?= $kamarBooking ?></h2>
            </div>
            <div class="card-title">Kamar Booking</div>
        </div>

        <div class="card-box">
            <div class="card-body">
                <i class="fa-solid fa-bed"></i>
                <h2><?= $kamarTerisi ?></h2>
            </div>
            <div class="card-title">Kamar Terisi</div>
        </div>

        <div class="card-box">
            <div class="card-body">
                <i class="fa-solid fa-circle-check"></i>
                <h2><?= $kamarReady ?></h2>
            </div>
            <div class="card-title">Kamar Ready</div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama</th>
                    <th>Kamar</th>
                    <th>Jenis Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($transaksi as $t): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $t->tanggal_transaksi ?></td>
                    <td><?= $t->nama_penghuni ?></td>
                    <td><?= $t->nama_kamar ?></td>
                    <td><?= $t->jenis_transaksi ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>