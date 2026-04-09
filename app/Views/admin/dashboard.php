<?= $this->extend('layout/sidebaradmin') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('css/admin/dashboard.css') ?>">


<div class="page-wrapper">

    <h2>Admin</h2>
    <p>Selamat datang di role admin</p>

    <!-- TOP CARD: 3 kolom -->
    <div class="grid">
        <div class="card-box">
            <div class="card-body">
                <i class="fa-solid fa-user"></i>
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

    <!-- SECOND CARD: 2 kolom -->
    <div class="grid-2">
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
    </div>

    <!-- TABLE -->
    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>tanggal</th>
                    <th>Nama</th>
                    <th>Kamar</th>
                    <th>jenis transaksi</th>
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