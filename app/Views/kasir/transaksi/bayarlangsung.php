<?= $this->extend('layout/sidebarkasir') ?>
<?= $this->section('content') ?>
<h2>Bayar Langsung</h2>
<?php if (session()->getFlashdata('error')) : ?>
    <div style="background:red;color:white;padding:10px;margin-bottom:10px;">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>
<form action="<?= base_url('kasir/transaksi/simpanBayar') ?>" method="post">

<input type="hidden" name="id_kamar" value="<?= $kamar['id_kamar']; ?>">
<input type="hidden" id="harga" name="harga" value="<?= $kamar['harga']; ?>">

<!-- ================= PENANGGUNG JAWAB ================= -->
<label>Nama Penanggung Jawab</label>
<input type="text" name="penanggung_jawab" required>

<label>No HP Penanggung Jawab</label>
<input type="text" name="no_hp" required>

<!-- ================= DATA KAMAR ================= -->
<label>Kamar Dipilih</label>
<input type="text" value="<?= $kamar['nama_kamar']; ?>" readonly>

<label>Harga per Bulan</label>
<input type="text" value="<?= $kamar['harga']; ?>" readonly>

<!-- ================= PENGHUNI 1 ================= -->
<h3>Penghuni 1</h3>

<label>Nama Penghuni 1</label>
<input type="text" name="penghuni1" required>

<label>NIK Penghuni 1</label>
<input type="text" name="nik1" required>

<label>No HP Penghuni 1</label>
<input type="text" name="hp1" required>

<label>Alamat Penghuni 1</label>
<textarea name="alamat1" required></textarea>

<!-- ================= PENGHUNI 2 ================= -->
<h3>Penghuni 2 (Opsional)</h3>

<label>Nama Penghuni 2</label>
<input type="text" name="penghuni2">

<label>NIK Penghuni 2</label>
<input type="text" name="nik2">

<label>No HP Penghuni 2</label>
<input type="text" name="hp2">

<label>Alamat Penghuni 2</label>
<textarea name="alamat2"></textarea>

<!-- ================= SEWA ================= -->
<label>Tanggal Masuk</label>
<input type="date" id="tanggal_masuk" name="tanggal_masuk" required>

<label>Lama Sewa (bulan)</label>
<input type="number" id="lama_sewa" name="lama_sewa" value="1" min="1">

<label>Tanggal Jatuh Tempo</label>
<input type="date" id="jatuh_tempo" name="jatuh_tempo" readonly>

<!-- ================= PEMBAYARAN ================= -->
<label>Total Harga</label>
<input type="text" id="total" readonly>

<label>Uang Bayar</label>
<input type="number" id="bayar" name="bayar" required>

<label>Kembalian</label>
<input type="text" id="kembalian" readonly>

<button type="submit">Simpan</button>

</form>

<script>
document.getElementById('tanggal_masuk').addEventListener('change', hitung);
document.getElementById('lama_sewa').addEventListener('input', hitung);
document.getElementById('bayar').addEventListener('input', hitungKembalian);

function hitung() {
    let harga = document.getElementById('harga').value;
    let lama = document.getElementById('lama_sewa').value;
    let tglMasuk = document.getElementById('tanggal_masuk').value;

    if(tglMasuk){
        let date = new Date(tglMasuk);
        date.setMonth(date.getMonth() + parseInt(lama));
        document.getElementById('jatuh_tempo').value = date.toISOString().split('T')[0];
    }

    let total = harga * lama;
    document.getElementById('total').value = total;
}

function hitungKembalian(){
    let total = document.getElementById('total').value;
    let bayar = document.getElementById('bayar').value;

    let kembali = bayar - total;
    document.getElementById('kembalian').value = kembali;
}
</script>

<?= $this->endSection() ?>