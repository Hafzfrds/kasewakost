<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="<?= base_url('css/kasir/dashboard.css') ?>">

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