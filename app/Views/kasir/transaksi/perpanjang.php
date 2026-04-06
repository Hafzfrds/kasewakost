<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>

<h1>Perpanjang Sewa Kost</h1>
<?php if (session()->getFlashdata('error')) : ?>
    <div style="background:red;color:white;padding:10px;margin-bottom:10px;">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>
<form action="/kasir/transaksi/perpanjang/simpan" method="post">

<input type="hidden" name="id_detail" value="<?= $detail['id_detail'] ?>">
<input type="hidden" id="harga" value="<?= $detail['harga_sewa'] ?>">

<label>Nama Penyewa</label>
<input type="text" value="<?= $detail['nama_penghuni'] ?>" readonly>

<label>Kamar</label>
<input type="text" value="<?= $detail['nama_kamar'] ?>" readonly>

<label>Harga Sewa / Bulan</label>
<input type="text" value="<?= number_format($detail['harga_sewa']) ?>" readonly>

<label>Perpanjang Berapa Bulan</label>
<input type="number" name="lama_sewa" id="bulan" required>

<label>Diperpanjang Hingga</label>
<input type="date" name="jatuh_tempo" id="tempo" readonly>

<label>Total Sewa</label>
<input type="text" name="total" id="total" readonly>

<label>Uang Bayar</label>
<input type="number" name="bayar" id="bayar" required>

<label>Kembalian</label>
<input type="text" id="kembalian" readonly>

<button type="submit">Bayar</button>
</form>

<script>
document.getElementById('bulan').addEventListener('input', function(){
    let bulan = this.value;
    let harga = document.getElementById('harga').value;

    let total = bulan * harga;
    document.getElementById('total').value = total;

    // hitung jatuh tempo dari tanggal jatuh tempo sebelumnya
    let oldDate = new Date("<?= $detail['jatuh_tempo'] ?>");
    oldDate.setMonth(oldDate.getMonth() + parseInt(bulan));
    document.getElementById('tempo').value = oldDate.toISOString().split('T')[0];
});

document.getElementById('bayar').addEventListener('input', function(){
    let bayar = parseFloat(this.value);
    let total = parseFloat(document.getElementById('total').value);

    let kembali = bayar - total;
    document.getElementById('kembalian').value = kembali;
});
</script>

<?= $this->endSection() ?>