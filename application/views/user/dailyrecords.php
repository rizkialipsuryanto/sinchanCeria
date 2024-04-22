<?php
$this->session->unset_userdata('register_nomr');
$this->session->unset_userdata('register_nama');
?>
<style>
    .d {


        white-space: nowrap;
    }
</style>
<form action="<?= base_url('User/insertdailyRecords'); ?>" method="post">
    <div class="row">
        <div class="col-md-12">
            <!-- Alat -->
            <div class="box box-success">

                <div class="box-body">

                    <div class="form-group">

                        
                        <div class="col-sm-12">
                                <div class="row">
                                    <input type="hidden" class="form-control" id="user_input" name="user_input" value="<?= $user['uid']; ?>" placeholder="ID">
                                    <label for="inputSkills" class="col-sm-2 control-label">Tanggal</label>
                                    <div class="col-xs-12">
                                        <?php echo validation_errors(); ?></p>
                                            <?php if ($this->session->flashdata('flash')) : ?>
                                            <?= $this->session->flashdata('flash'); ?>
                                            <?php endif; ?>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="<?= $tanggal; ?>" id="date" name="tanggal" placeholder="Masukan Tanggal" class="tanggal form-control pull-right " autocomplete="off">

                                        </div>
                                    </div>
                                </div>
                        </div>
                        <br>
                        <div class="col-sm-12">
                                <div class="row">
                                    <label for="inputSkills" class="col-sm-2 control-label">Kegiatan / Program</label>
                                    <div class="col-xs-12">

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-spinner"></i>
                                            </div>
                                            <select class="form-control input-sm" id="tupoksi" name="tupoksi">
                                                <option value=""> -- Tupoksi -- </option>
                                                <?php if (!empty($tupoksi)) : ?>
                                                    <?php foreach ($tupoksi as $pl) : ?>
                                                        <option value="<?= $pl['id']; ?>"> <?= $pl['tupoksi']; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>

                                        </div>


                                    </div>
                                </div>
                        </div>
                        <br>
                        <div class="col-sm-12">
                                <div class="row">
                                    <label for="inputSkills" class="col-sm-2 control-label">Satuan</label>
                                    <div class="col-xs-12">

                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-spinner"></i>
                                            </div>
                                            <select class="form-control input-sm" id="satuan" name="satuan">
                                                <option value=""> -- Satuan -- </option>
                                                <?php if (!empty($satuan)) : ?>
                                                    <?php foreach ($satuan as $pl) : ?>
                                                        <option value="<?= $pl['id']; ?>"> <?= $pl['satuan']; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                            </select>

                                        </div>


                                    </div>
                                </div>
                        </div>
                        <br>
                        <div class="col-sm-12">
                                <div class="row">
                                    <label for="inputSkills" class="col-sm-2 control-label">Jumlah</label>
                                    <div class="col-xs-12">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-spinner"></i>
                                            </div>
                                            <input type="text" id="jumlah" name="jumlah" 
                                            
                                                 class="form-control input-sm" placeholder="Jumlah" required>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <br>
                        
                        <br>
                        <div class="col-sm-12">
                                <div class="row">
                                    <label for="inputSkills" class="col-sm-2 control-label">Catatan Harian</label>
                                    
                                    <div class="col-xs-12">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-pencil"></i>
                                            </div>
                                                <input type="text" class="form-control pull-right input-sm" name="catatan_harian" required>
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
        <!-- <input name="startDate" id="startDate" class="date-picker" /> -->
    
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

                    <div class="box-body">
                        <div>
                            <form name="pencarianrawatjalan" action="<?= base_url('user/dailyRecords'); ?>" method="POST">
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
                                        <!-- <button class="btn btn-success"><a href="<?= base_url('user/dailyrecordsprint'); ?>">Cetak</a></button> -->
                                    </div>

                                    <div class="col-xs-12">
                                            
                                    </div>

                                    <!-- <div class="input-group-btn">
                                        <input type="submit" name="cetak" value="Cetak" class="btn btn-success">
                                    </div> -->

                                    <div class="input-group-btn">
                                        <a href="http://192.168.1.178/simrs2/cetak/catatanharian/lap_bulanan.php" class="laporan-register"><span class="label label-success">Cetak</span></a>
                                    </div>

                                </div>
                            </form>
                        </div>
            </div>

        </div>

</div>

<!-- <div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                <!-- <a href="http://192.168.1.178/simrs2/cetak/catatanharian/lap_bulanan.php?tanggal=<?php echo $tanggalcari; ?>&&userid=<?= $user['id']; ?>" target="_blank" class="laporan-register"><span class="label label-success">Cetak</span></a> -->
                <?php echo $tanggalcari; ?>
                    <h3 class="box-title"><?= $title; ?>&nbsp;&nbsp;</h3>&nbsp;&nbsp;
                    <!-- <span class="label label-info">jumlah alat : <?php echo number_format($total_rows, 0, ",", ".") ?></span>&nbsp;&nbsp; -->

                </h3>
            </div>

            <div class="box-body">
                <?php if (empty($daily)) : ?>
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
                                        <th><b>Action</b></th>
                                        <th><b>Tanggal</b></th>
                                        <th><b>Kegiatan / Program</b></th>
                                        <th><b>Catatan</b></th>
                                        <th><b>Jumlah</b></th>
                                        <th><b>Satuan</b></th>
                                        <th><b>Feedback</b></th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($daily as $daftar) : ?>
                                        <?php 
                                        if ($daftar["feedback"] == "") {
                                            $color = "style='background-color: orange;'";
                                        }else{
                                            $color = "style='background-color: white;'";
                                        } ?>
                                        <tr>
                                            <td <?= $color ?>><?= ++$nomer; ?></td>
                                            <?php if (($daftar["bulan"]) == date('m')){
                                                ?>
                                            <td <?= $color ?>>
                                                <a class="edit-dailyrecord" data-user ="<?= $user["id"]; ?>" data-id="<?= $daftar["idcatatan"]; ?>" data-tanggal="<?= $daftar["tanggal"]; ?>" data-id_tasks_detail="<?= $daftar["id_tasks_detail"]; ?>" data-catatan="<?= $daftar["catatan"]; ?>" data-jam_mulai="<?= $daftar["jam_mulai"]; ?>" data-jam_selesai="<?= $daftar["jam_selesai"]; ?>" data-jumlah="<?= $daftar["jumlah"]; ?>" data-satuan="<?= $daftar["satuan"]; ?>" data-toggle="modal" data-target="#submenumodaledit"><span class="label label-success"> Edit</span></a>

                                                <?php if ($daftar["feedback"] == '') {
                                                ?>
                                                    <a class="hapus-dailyrecord" data-id="<?= $daftar["idcatatan"]; ?>" data-toggle="modal" data-target="#submenumodal"><span class="label label-danger"> Hapus</span></a>
                                                <?php }else{
                                                    
                                                    } ?>
                                            </td>
                                            <?php } else{
                                             ?>
                                             <td>
                                                 
                                             </td>
                                            <?php } ?>
                                            <td <?= $color ?>><?= $daftar["tanggal"]; ?></td>
                                            <td <?= $color ?>><?= getTasksDetail($daftar["id_tasks_detail"], "tasks_detail"); ?></td>
                                            <td <?= $color ?>><?= $daftar["catatan"]; ?></td>
                                            <td <?= $color ?>><?= $daftar["jumlah"]; ?></td>
                                            <td <?= $color ?>><?= getSatuanSinchan($daftar["satuan"], "satuan"); ?></td>
                                            <td <?= $color ?>><?= $daftar["feedback"]; ?></td>

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
</div> -->

<div class="modal fade" id="submenumodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/deletedailyRecords'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="modal_id" name="modal_id" placeholder="Sub Menu url">
                    </div>
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-12 control-label">Apakah Data Akan DiHapus???</label>
                    </div>
                    
                </div>
                <div class="modal-footer">

                    <div class="pull-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Hapus</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="submenumodaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><b>Proses</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('user/updatedailyRecords'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="modal_id" name="modal_id" placeholder="Sub Menu url">
                        <input type="hidden" class="form-control" id="user_input" name="user_input" placeholder="Sub Menu url">
                    </div>
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label">Tanggal</label>
                           <div class="col-xs-8">
                            <div class="input-group date">
                                
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                    <input type="text" id="tanggal" name="tanggal" class="tanggal form-control pull-right " placeholder="Tanggal masuk" autocomplete="off">
                            </div>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label">Kegiatan / Program</label>
                           <div class="col-xs-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-spinner"></i>
                                </div>
                                <select class="form-control input-sm" id="tasks" name="tasks">
                                            <option value=""> -- Kegiatan -- </option>
                                            <?php if (!empty($kegiatan)) : ?>
                                                <?php foreach ($kegiatan as $pl) : ?>
                                                    <option value="<?= $pl['id']; ?>"><?= $pl['id']; ?>, <?= $pl['tasks_detail']; ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                            </div>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label">Jumlah</label>
                           <div class="col-xs-8">
                            <div class="input-group">
                                
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                    <input type="text" id="jumlah" name="jumlah" class="form-control pull-right " placeholder="Jumlah" autocomplete="off">
                            </div>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label">Satuan</label>
                           <div class="col-xs-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-spinner"></i>
                                </div>
                                <select class="form-control input-sm " id="satuan" name="satuan">
                                            <option value=""> -- Satuan -- </option>
                                            <?php if (!empty($satuan)) : ?>
                                                <?php foreach ($satuan as $pl) : ?>
                                                    <!-- <option value="<?= $pl['id']; ?>"><?= $pl['tasks_detail']; ?></option> -->
                                                    <option value="<?= $pl['id']; ?>" <?php if($dailyById[0]['mesin']== $pl['id']) echo 'selected="selected"'; ?>>
                                                        <?= $pl['satuan']; ?></option>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                </select>
                            </div>
                            </div>
                    </div>
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label">Catatan</label>
                           <div class="col-xs-8">
                            <div class="input-group date">
                                
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                    <input type="text" id="catatan" name="catatan" class="form-control pull-right " placeholder="Catatan" autocomplete="off">
                            </div>
                            </div>
                    </div>
                    <!-- <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label">Jam Mulai</label>
                           <div class="col-xs-8">
                            <div class="input-group date">
                                
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                    <input type="text" id="jam_mulai" name="jam_mulai" value="<?php

                                    // if ($cssdById[0]['jam_masuk']) {
                                    //     echo $cssdById[0]['jam_masuk'];
                                    // } else {
                                    //                                         // echo date('d-m-Y');
                                    // }
                                    ?>" class="form-control" placeholder="Jam Mulai" data-inputmask="'mask': ['99:99']" data-mask>
                            </div>
                            </div>
                    </div>
                    <br>
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label">Jam Selesai</label>
                           <div class="col-xs-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                    <input type="text" id="jam_selesai" name="jam_selesai" value="<?php

                                    // if ($cssdById[0]['js']) {
                                    //     echo $cssdById[0]['js'];
                                    // } else {
                                    //                                         // echo date('d-m-Y');
                                    // }
                                    ?>" class="form-control" placeholder="Jam Selesai" data-inputmask="'mask': ['99:99']" data-mask>
                            </div>
                            </div>
                    </div> -->
                    
                    </div>
                <br><br><br>
                <div class="modal-footer">

                    <div class="pull-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>