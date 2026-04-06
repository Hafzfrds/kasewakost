<?= $this->extend('layout/sidebarowner') ?>
<?= $this->section('content') ?>

<div class="page-wrapper">

    <h2 style="margin-bottom:20px;">📋 Log Activity</h2>

    <!-- FILTER -->
    <form method="get" style="margin-bottom:20px;">
        <input type="text" name="keyword" placeholder="Cari user / aktivitas..." value="<?= $keyword ?? '' ?>" style="padding:8px;">
        <button type="submit" style="padding:8px 12px;">Cari</button>
    </form>

    <!-- TABLE -->
    <div style="overflow-x:auto;">
        <table border="1" cellpadding="10" cellspacing="0" width="100%">
            <thead style="background:#2c3e50;color:white;">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aktivitas</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($log)) : ?>
                    <?php $no = 1; foreach ($log as $l) : ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= date('d-m-Y H:i', strtotime($l['tanggal'])) ?></td>
                            <td><?= $l['username'] ?></td>
                            <td><?= ucfirst($l['role']) ?></td>
                            <td>
                                <?php
                                    $warna = '#3498db';

                                    if ($l['aktivitas'] == 'LOGIN') $warna = '#2ecc71';
                                    if ($l['aktivitas'] == 'LOGOUT') $warna = '#e74c3c';
                                    if ($l['aktivitas'] == 'DELETE') $warna = '#c0392b';
                                ?>
                                <span style="
                                    padding:5px 10px;
                                    border-radius:5px;
                                    background:<?= $warna ?>;
                                    color:white;
                                ">
                                    <?= $l['aktivitas'] ?>
                                </span>
                            </td>
                            <td><?= $l['keterangan'] ?></td>
                        </tr>
                    <?php endforeach ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6" align="center">Tidak ada data log</td>
                    </tr>
                <?php endif ?>
            </tbody>
        </table>
    </div>

</div>

<?= $this->endSection() ?>