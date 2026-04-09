<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial;
            font-size: 12px;
        }
        .box {
            border: 1px solid black;
            padding: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
        }
        .line {
            border-bottom: 1px dashed black;
        }
        .total {
            font-weight: bold;
        }
        .right {
            text-align: right;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>KWITANSI PEMBAYARAN PERPANJANG</h2>

    <table>
        <tr>
            <td>Kode</td>
            <td>: <?= $transaksi['kode_transaksi']; ?></td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>: <?= $transaksi['tanggal_transaksi']; ?></td>
        </tr>
        <tr>
            <td>Penanggung Jawab</td>
            <td>: <?= $transaksi['nama_penanggung_jawab']; ?></td>
        </tr>
        <tr>
            <td>Jenis Transaksi</td>
            <td>: PERPANJANG</td>
        </tr>
    </table>

    <br>

    <table>
        <tr class="line">
            <td>Kamar</td>
            <td>Lama</td>
            <td>Harga</td>
            <td>Subtotal</td>
        </tr>

        <?php foreach ($detail as $d): ?>
        <tr>
            <td><?= $d['nama_kamar']; ?></td>
            <td><?= $d['lama_sewa']; ?> bln</td>
            <td>Rp <?= number_format($d['harga'],0,',','.'); ?></td>
            <td>Rp <?= number_format($d['subtotal'],0,',','.'); ?></td>
        </tr>
        <?php endforeach; ?>

        <tr class="line">
            <td colspan="3" class="right total">Total</td>
            <td>Rp <?= number_format($transaksi['total'],0,',','.'); ?></td>
        </tr>

        <tr>
            <td colspan="3" class="right">Bayar</td>
            <td>Rp <?= number_format($transaksi['bayar'],0,',','.'); ?></td>
        </tr>

        <tr>
            <td colspan="3" class="right">Kembalian</td>
            <td>
                Rp <?= number_format($transaksi['kembalian'],0,',','.'); ?>
            </td>
        </tr>

    </table>

    <br><br>
    <center>Terima Kasih</center>

</div>

</body>
</html>