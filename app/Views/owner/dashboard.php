<?= $this->extend('layout/sidebarowner') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('css/owner/dashboard.css') ?>">

<div class="page-wrapper">

    <h2>Owner</h2>
    <p>Selamat datang di role owner</p>

    <!-- BARIS 1 -->
    <div class="grid">
        <div class="card-box">
            <div class="card-body">
                <i class="fa-solid fa-users"></i>
                <h2><?= $totalUsers ?></h2>
            </div>
            <div class="card-title">Total Users</div>
        </div>

        <div class="card-box">
            <div class="card-body">
                <i class="fa-solid fa-bed"></i>
                <h2><?= $totalKamar ?></h2>
            </div>
            <div class="card-title">Total Kamar</div>
        </div>

        <div class="card-box">
            <div class="card-body">
                <i class="fa-solid fa-layer-group"></i>
                <h2><?= $totalTipe ?></h2>
            </div>
            <div class="card-title">Total Tipe</div>
        </div>
    </div>

    <!-- BARIS 2 -->
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
                <i class="fa-solid fa-person-shelter"></i>
                <h2><?= $totalPenghuni ?></h2>
            </div>
            <div class="card-title">Total Penghuni</div>
        </div>

        <div class="card-box">
            <div class="card-body">
                <i class="fa-solid fa-bed"></i>
                <h2><?= $kamarTerisi ?></h2>
            </div>
            <div class="card-title">Kamar Terisi</div>
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