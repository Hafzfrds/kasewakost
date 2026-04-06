<h2>Booking Kamar</h2>

<form action="<?= base_url('kasir/transaksi/simpanBooking') ?>" method="post">

<input type="hidden" name="id_kamar" value="<?= $kamar['id_kamar']; ?>">
<input type="hidden" id="harga" name="harga" value="<?= $kamar['harga']; ?>">

<label>Nama Penanggung Jawab</label>
<input type="text" name="penanggung_jawab" required>

<label>No HP Penanggung Jawab</label>
<input type="text" name="no_hp" required>

<label>Kamar Dipilih</label>
<input type="text" value="<?= $kamar['nama_kamar']; ?>" readonly>

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
<input type="number" id="lama_sewa" name="lama_sewa" value="1">

<label>Tanggal Jatuh Tempo</label>
<input type="date" id="jatuh_tempo" name="jatuh_tempo" readonly>

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

function hitungSisa(){
    let total = document.getElementById('total').value;
    let dp = document.getElementById('dp').value;
    document.getElementById('sisa').value = total - dp;
}
</script>