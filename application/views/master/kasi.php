<?php
$this->session->unset_userdata('register_nomr');
$this->session->unset_userdata('register_nama');
?>
<style>
    .d {


        white-space: nowrap;
    }
</style>
<form action="<?= base_url('Master/insertKasi'); ?>" method="post">
    <div class="row">
        <div class="col-md-12">
            <!-- Alat -->
            <div class="box box-success">

                <div class="box-body">
                    <input type="hidden" class="form-control" id="user_input" name="user_input" value="<?= $user['id']; ?>" placeholder="ID">
                    <div class="form-group">

                        <div class="col-sm-12">

                            <div class="row">

                                <label for="inputSkills" class="col-sm-2 control-label">Ruang</label>
                                <div class="col-xs-4">

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <select class="form-control input-sm select2" id="bidang" name="bidang">
                                            <option value=""> -- Bidang -- </option>
                                            <?php if (!empty($bidang)) : ?>
                                                <?php foreach ($bidang as $pl) : ?>
                                                    <option value="<?= $pl['bidang_id']; ?>"><?= $pl['bidang']; ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>

                                    </div>


                                </div>
                                <label for="inputSkills" class="col-sm-2 control-label">Kasi</label>
                                <div class="col-xs-4">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <input type="text" id="kasi" name="kasi" class="form-control input-sm" placeholder="Kasi">
                                    </div>
                                </div>

                            </div>
                            
                        </div>
                        </div>

                    </div>

                </div>
                <div class="col-md-3">

                </div>


            </div>
        </div>
    
    <div class="row no-print">
        <div class="col-xs-12">

            <input type='hidden' name='stop_daftar' id='stop_daftar' readonly />
            <button id="verifpacking" name="verifpacking" type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> SIMPAN
            </button>
        </div>
    </div>
    
</form>

<br><br><br>
<div class="row">


            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            Pencarian :
                        </h3>

                        <div class="box-tools">
                            <form name="pencarianrawatjalan" action="<?= base_url('master/kasi'); ?>" method="POST">
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
                    <!-- <span class="label label-info">jumlah alat : <?php echo number_format($total_rows, 0, ",", ".") ?></span>&nbsp;&nbsp; -->

                </h3>
            </div>

            <div class="box-body">
                <?php if (empty($kasilist)) : ?>
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
                                        <th><b>Bidang</b></th>
                                        <th><b>Kasi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($kasilist as $daftar) : ?>
                                        <tr>
                                            <td><?= ++$nomer; ?></td>
                                            <td><?= getBidang($daftar["bidang_id"], "bidang"); ?></td>
                                            <td><?= $daftar["kasi"]; ?></td>
                                            

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