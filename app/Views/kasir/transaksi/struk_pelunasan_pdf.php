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
    <h2>KWITANSI PELUNASAN</h2>

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
            <td>Nama Penghuni</td>
            <td>: <?= $transaksi['nama_penghuni']; ?></td>
        </tr>
        <tr>
            <td>Kamar</td>
            <td>: <?= $transaksi['nama_kamar']; ?></td>
        </tr>
    </table>

    <br>

   <table>
    <tr class="line">
        <td>Keterangan</td>
        <td class="right">Jumlah</td>
    </tr>

   <tr>
    <td>Sisa Bayar</td>
    <td class="right">
        Rp <?= number_format($transaksi['sisa_bayar'],0,',','.'); ?>
    </td>
</tr>

<tr>
    <td>Uang Bayar</td>
    <td class="right">
        Rp <?= number_format($transaksi['uang_bayar'],0,',','.'); ?>
    </td>
</tr>

<tr class="line">
    <td>Kembalian</td>
    <td class="right">
        Rp <?= number_format($transaksi['kembalian'],0,',','.'); ?>
    </td>
</tr>
</table>

    <br><br>

    <center>
        <p>Terima Kasih</p>
    </center>
</div>

</body>
</html>