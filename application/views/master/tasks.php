<?php
$this->session->unset_userdata('register_nomr');
$this->session->unset_userdata('register_nama');
?>
<style>
    .d {


        white-space: nowrap;
    }
</style>
<form action="<?= base_url('Master/insertTasks'); ?>" method="post">
    <div class="row">
        <div class="col-md-12">
            <!-- Alat -->
            <div class="box box-success">

                <div class="box-body">
                    <input type="hidden" class="form-control" id="user_input" name="user_input" value="<?= $user['id']; ?>" placeholder="ID">
                    <div class="form-group">

                        <div class="col-sm-12">

                            <div class="row">

                            <label for="inputSkills" class="col-sm-2 control-label">Bagian / Bidang</label>
                                <div class="col-xs-12">

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <select class="form-control input-sm" id="bidang" name="bidang">
                                            <option value=""> -- Bidang -- </option>
                                            <?php if (!empty($bidang)) : ?>
                                                <?php foreach ($bidang as $pl) : ?>
                                                    <option value="<?= $pl['bidang_id']; ?>"><?= $pl['bidang']; ?></option>
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
                                <label for="inputSkills" class="col-sm-2 control-label">Subbag / Seksi</label>
                                <div class="col-xs-12">

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        
                                        <select id="kasi" name="kasi" class="kasi form-control input-sm" required> 
                                            <option> -- Pilih Instalasi -- </option>
                                        </select>

                                    </div>


                                </div>
                                
                                
                            </div>
                        </div>

                        <div class="col-sm-12">

                            <div class="row">
                                <label for="inputSkills" class="col-sm-2 control-label">Jabatan</label>
                                <div class="col-xs-12">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <!-- <input type="text" id="tasks" name="tasks" class="form-control input-sm" placeholder="Tasks"> -->
                                       <!--  <select id="profesi" name="profesi" class="profesi form-control input-sm select2" required> 
                                            <option> -- Pilih Profesi -- </option>
                                        </select> -->

                                        <select class="form-control input-sm" id="profesi" name="profesi">
                                            <option value=""> -- Profesi -- </option>
                                            <?php if (!empty($profesi)) : ?>
                                                <?php foreach ($profesi as $pl) : ?>
                                                    <option value="<?= $pl['id_profesi']; ?>"><?= $pl['nama_profesi']; ?></option>
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
                                <label for="inputSkills" class="col-sm-2 control-label">Ruang</label>
                                <div class="col-xs-12">

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <select class="form-control input-sm" id="ruang" name="ruang">
                                            <option value=""> -- Ruang -- </option>
                                            <?php if (!empty($ruang)) : ?>
                                                <?php foreach ($ruang as $pl) : ?>
                                                    <option value="<?= $pl['userlevelid']; ?>"><?= $pl['userlevelname']; ?></option>
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
                                <label for="inputSkills" class="col-sm-2 control-label">Karu/Koordinator</label>
                                <div class="col-xs-12">

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <select class="form-control input-sm" id="karukoordinator" name="karukoordinator">
                                            <option value=""> -- Karu / Koordinator -- </option>
                                            <?php if (!empty($karukoordinator)) : ?>
                                                <?php foreach ($karukoordinator as $pl) : ?>
                                                    <option value="<?= $pl['uid']; ?>"><?= $pl['nama_emp']; ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>

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
                            <form name="pencarianrawatjalan" action="<?= base_url('Master/tasks'); ?>" method="POST">
                            <div class="col-xs-12 pull-right">
                                <div class="input-group input-group-sm">

                                    <div class="col-xs-12">
                                        <select class="form-control form-control-sm pull-right" id="cari_ruang" name="cari_ruang">
                                    <option value="">-- Ruang --</option>
                                    <?php if (!empty($ruang)) : ?>
                                        <?php foreach ($ruang as $cb) : ?>
                                            <option value="<?= $cb['userlevelid']; ?>" <?= set_select('cari_ruang', $cb['userlevelid']); ?>><?= $cb['userlevelname']; ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>


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
                                        <th>Status</th>
                                        <th><b>Ruang</b></th>
                                        <th><b>Profesi</b></th>
                                        <th><b>Bidang</b></th>
                                        <th><b>Kasi</b></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tasks as $daftar) : ?>
                                        <tr>
                                            <td><?= ++$nomer; ?></td>
                                            <td class="center">
                                                <a href="<?= base_url('master/konfirmasiNonActiv'); ?>/<?= $daftar["id"];?>"><span class="label label-success"><i class="fa fa-close "></i> Aktif</span></a>
                                            </td>
                                            <td><?= getPoli($daftar["ruang"], "userlevelname"); ?></td>
                                            <td><?= getProfesinya($daftar["tasks"], "nama_profesi"); ?></td>
                                            <td><?= getBidang($daftar["bidang_id"], "bidang"); ?>
                                            <td><?= getKasi($daftar["kasi_id"], "kasi"); ?>
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

<!-- ini jika ditolak -->
<div class="modal fade" id="submenumodaltolak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('master/konfirmasiNonActiv'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="modal_idkonfirmasi" name="modal_idkonfirmasi" placeholder="Sub Menu url">
                        <input type="hidden" class="form-control" id="modal_userkonfirmasi" name="modal_userkonfirmasi" placeholder="Sub Menu url">
                        <input type="hidden" class="form-control" id="modal_petugascssd" name="modal_petugascssd" placeholder="Sub Menu url">
                    </div>

                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-12 control-label">Apakah Data Tersebut Akan Di Non Aktifkan???</label>
                    </div>

                </div>
                <div class="modal-footer">

                    <div class="pull-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>