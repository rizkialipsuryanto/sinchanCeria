<?php
$this->session->unset_userdata('register_nomr');
$this->session->unset_userdata('register_nama');
?>
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
                            Pencarian :
                        </h3>

                        <div class="box-tools">
                            <form name="pencarianrawatjalan" action="<?= base_url('cssd/outTool'); ?>" method="POST">
                            <div class="col-xs-12 pull-right">
                                <div class="input-group input-group-sm">

                                    <div class="col-xs-12">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="<?= $tanggalcari; ?>" name="tanggalcari" placeholder="Masukan Tanggal Pencarian .. . . ." class="tanggal form-control pull-right " autocomplete="off">
                                        </div>


                                    </div>


                                <div class="input-group-btn">
                                    <input type="submit" name="caripembayaran" value="Cari Cepat" class="btn btn-warning">
                                </div>



                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <h3 class="box-title"><?= $title; ?>&nbsp;&nbsp;</h3>&nbsp;&nbsp;
                    <span class="label label-info">jumlah alat : <?php echo number_format($total_rows, 0, ",", ".") ?></span>&nbsp;&nbsp;

                </h3>
            </div>

            <div class="box-body">
                <?php if (empty($tasks)) : ?>
                    <div class="alert alert-danger" role="alert">
                        data belum dicari atau tidak ditemukan
                    </div>
                <?php else : ?>
                    <div class="box-bodyno-padding">
                        <div class="table-responsive">
                            <table style="white-space: nowrap;" class="table table-hover table-sm">
                                <thead>
                                    <tr>

                                        <th>#</th>
                                        <th><b>Instalasi</b></th>
                                        <th><b>Jabatan</b></th>
                                        <th><b>Nama</b></th>
                                        <th><b>Presentase Non Umum (%)</b></th>
                                        <th><b>Presentase Umum (%)</b></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tasks as $daftar) : ?>
                                        <tr>
                                            <td><?= ++$nomer; ?></td>
                                            <td><?= getPoli($daftar["ruang"], "userlevelname"); ?></td>
                                            <td><?= getProfesi($daftar["id_profesi"], "nama_profesi"); ?></td>
                                            <td><?= $daftar["nama"]; ?></td>
                                            <td align="right"><?= $daftar["prosentase_nonumum"]; ?></td>
                                            <td align="right"><?= $daftar["prosentase_umum"]; ?></td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endif; ?>

            </div>

            <div class="box-footer clearfix">
                <?= $links; ?>
            </div>
        </div>
    </div>
</div>