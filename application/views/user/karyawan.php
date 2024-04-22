<style>
    .d {


        white-space: nowrap;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                <!-- <a href="http://192.168.1.178/simrs2/cetak/catatanharian/lap_bulanan.php?tanggal=<?php echo $tanggalcari; ?>&&userid=<?= $user['id']; ?>" target="_blank" class="laporan-register"><span class="label label-success">Cetak</span></a> -->
                <!-- <?php echo $tanggalcari; ?> -->
                    <h3 class="box-title"><?= $title; ?>
                    <!-- <span class="label label-info">jumlah alat : <?php echo number_format($total_rows, 0, ",", ".") ?></span>&nbsp;&nbsp; -->

                </h3>
            </div>

            <div class="box-body">
                <?php if (empty($karyawan)) : ?>
                    <div class="alert alert-danger" role="alert">
                        data belum dicari atau tidak ditemukan
                    </div>
                <?php else : ?>
                    <div class="box-body-padding">
                        <div class="table-responsive">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><b>Nama</b></th>
                                        <th><b>Alamat</b></th>
                                        <th><b>No Telpon</b></th>
                                        <th><b>Ruang</b></th>
                                        <th><b>Status</b></th>
                                        <th><b>Tanggal Masuk</b></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($karyawan as $k) : ?>
                                        <tr>
                                            <td><?= ++$nomer; ?></td>
                                            <td><?= $k["pd_nickname"]; ?></td>
                                            <td><?= $k["alamat"]; ?></td>
                                            <td><?= $k["no_telp"]; ?></td>
                                            <td><?= $k["userlevelid"]; ?></td>
                                            <td><?= $k["status"]; ?></td>
                                            <td><?= $k["tanggal_masuk_kerja"]; ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <div class="box-footer clearfix">
                <!-- <?= $links; ?> -->
            </div>
        </div>
    </div>
</div>