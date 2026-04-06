<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>
<h2>Booking Keranjang</h2>

<form action="<?= base_url('kasir/transaksi/simpanBookingKeranjang') ?>" method="post">

<!-- PENANGGUNG JAWAB -->
<label>Nama Penanggung Jawab</label>
<input type="text" name="penanggung_jawab" required>

<label>No HP Penanggung Jawab</label>
<input type="text" name="no_hp" required>

<hr>

<!-- DATA KAMAR -->
<?php $no = 0; ?>
<?php foreach($keranjang as $k): ?>
<?php $no++; ?>

<h3>Kamar <?= $k['nama_kamar']; ?></h3>

<input type="hidden" name="id_kamar[]" value="<?= $k['id_kamar']; ?>">
<input type="hidden" class="harga_kamar" value="<?= $k['harga']; ?>">

<label>Harga per Bulan</label>
<input type="text" value="<?= $k['harga']; ?>" readonly>

<!-- Penghuni 1 -->
<h4>Penghuni 1</h4>

<label>Nama Penghuni 1</label>
<input type="text" name="penghuni1_<?= $no ?>" required>

<label>NIK Penghuni 1</label>
<input type="text" name="nik1_<?= $no ?>" required>

<label>No HP Penghuni 1</label>
<input type="text" name="hp1_<?= $no ?>" required>

<label>Alamat Penghuni 1</label>
<textarea name="alamat1_<?= $no ?>" required></textarea>

<!-- Penghuni 2 -->
<h4>Penghuni 2 (Opsional)</h4>

<label>Nama Penghuni 2</label>
<input type="text" name="penghuni2_<?= $no ?>">

<label>NIK Penghuni 2</label>
<input type="text" name="nik2_<?= $no ?>">

<label>No HP Penghuni 2</label>
<input type="text" name="hp2_<?= $no ?>">

<label>Alamat Penghuni 2</label>
<textarea name="alamat2_<?= $no ?>"></textarea>

<hr>
<?php endforeach; ?>

<!-- SEWA -->
<label>Tanggal Masuk</label>
<input type="date" id="tanggal_masuk" name="tanggal_masuk" required>

<label>Lama Sewa (bulan)</label>
<input type="number" id="lama_sewa" name="lama_sewa" value="1">

<label>Tanggal Jatuh Tempo</label>
<input type="date" id="jatuh_tempo" name="jatuh_tempo" readonly>

<!-- TOTAL -->
<label>Total Harga</label>
<input type="text" id="total" readonly>

<label>Uang Booking (DP)</label>
<input type="number" id="dp" name="dp" required>

<label>Sisa Bayar</label>
<input type="text" id="sisa" readonly>

<button type="submit">Simpan Booking</button>
</form>

<script>
document.getElementById('tanggal_masuk').addEventListener('change', hitung);
document.getElementById('lama_sewa').addEventListener('input', hitung);
document.getElementById('dp').addEventListener('input', hitungSisa);

function hitung() {
    let lama = document.getElementById('lama_sewa').value;
    let tglMasuk = document.getElementById('tanggal_masuk').value;

    // jatuh tempo
    if(tglMasuk){
        let date = new Date(tglMasuk);
        date.setMonth(date.getMonth() + parseInt(lama));
        document.getElementById('jatuh_tempo').value = date.toISOString().split('T')[0];
    }

    // total semua kamar
    let hargaKamar = document.querySelectorAll('.harga_kamar');
    let total = 0;

    hargaKamar.forEach(function(h){
        total += parseInt(h.value) * lama;
    });

    document.getElementById('total').value = total;
}

function hitungSisa(){
    let total = document.getElementById('total').value;
    let dp = document.getElementById('dp').value;
    document.getElementById('sisa').value = total - dp;
}
</script>

<?= $this->endSection() ?>