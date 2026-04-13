<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Transaksi</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        .total {
            margin-top: 15px;
            text-align: right;
            font-weight: bold;
            font-size: 13px;
        }
    </style>
</head>
<body>

<h2>Riwayat Transaksi</h2>

<table>
    <thead>
        <tr>
            <th>Kode</th>
            <th>Nama</th>
            <th>Kamar</th>
            <th>Tanggal</th>
            <th>Jenis</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>
        <?php 
        $totalPendapatan = 0;
        foreach($riwayat as $r): 
            $totalPendapatan += $r['total'];
        ?>
        <tr>
            <td><?= $r['kode_transaksi'] ?></td>
            <td><?= $r['nama_penghuni'] ?? '-' ?></td>
            <td><?= $r['nama_kamar'] ?? '-' ?></td>
            <td><?= date('d-m-Y', strtotime($r['tanggal_transaksi'])) ?></td>
            <td><?= $r['jenis_transaksi'] ?></td>
            <td>Rp <?= number_format($r['total'],0,',','.') ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- TOTAL PENDAPATAN -->
<div class="total">
    Total Pendapatan: Rp <?= number_format($totalPendapatan, 0, ',', '.') ?>
</div>

</body>
</html>