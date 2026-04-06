<h2>Pelunasan</h2>
<?php if (session()->getFlashdata('error')) : ?>
    <div style="background:red;color:white;padding:10px;margin-bottom:10px;">
        <?= session()->getFlashdata('error'); ?>
    </div>
<?php endif; ?>
<form action="/kasir/transaksi/pelunasan/simpan" method="post">

<input type="hidden" name="id_detail" value="<?= $detail['id_detail'] ?>">
<input type="hidden" id="sisa" value="<?= $detail['sisa_bayar'] ?>">

<label>Nama Penanggung Jawab</label>
<input type="text" value="<?= $detail['nama_penanggung_jawab'] ?>" readonly>

<label>No HP</label>
<input type="text" value="<?= $detail['no_hp'] ?>" readonly>

<label>Kamar</label>
<input type="text" value="<?= $detail['nama_kamar'] ?>" readonly>

<label>Total</label>
<input type="text" value="<?= number_format($detail['total']) ?>" readonly>

<label>DP / Sudah Dibayar</label>
<input type="text" value="<?= number_format($detail['bayar']) ?>" readonly>

<label>Sisa Bayar</label>
<input type="text" value="<?= number_format($detail['sisa_bayar']) ?>" readonly>

<label>Uang Bayar</label>
<input type="number" id="bayar" name="bayar" required>

<label>Kembalian</label>
<input type="text" id="kembalian" readonly>

<br><br>
<button type="submit">Simpan Pelunasan</button>

</form>

<script>
document.getElementById('bayar').addEventListener('input', function(){
    let sisa = document.getElementById('sisa').value;
    let bayar = this.value;

    let kembali = bayar - sisa;

    if(kembali < 0){
        document.getElementById('kembalian').value = 0;
    } else {
        document.getElementById('kembalian').value = kembali;
    }
});
</script>