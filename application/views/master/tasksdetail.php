<?php
$this->session->unset_userdata('register_nomr');
$this->session->unset_userdata('register_nama');
?>
<style>
    .d {


        white-space: nowrap;
    }
</style>
<form action="<?= base_url('Master/insertTasksDetail'); ?>" method="post">
    <div class="row">
        <div class="col-md-12">
            <!-- Alat -->
            <div class="box box-success">

                <div class="box-body">
                    <input type="hidden" class="form-control" id="user_input" name="user_input" value="<?= $user['id']; ?>" placeholder="ID">
                    <div class="form-group">

                        <div class="col-sm-12">

                            <div class="row">

                                <label for="inputSkills" class="col-sm-2 control-label">Jabatan</label>
                                <div class="col-xs-12">

                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <select class="form-control input-sm" id="tasks" name="tasks">
                                            <option value=""> -- Jabatan -- </option>
                                            <?php if (!empty($tasks)) : ?>
                                                <?php foreach ($tasks as $pl) : ?>
                                                    <option value="<?= $pl['id']; ?>"><?= getProfesinya($pl['tasks'], "nama_profesi"); ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>

                                    </div>

                                </div>
                            </div>
                            
                        </div>

                        <div class="col-sm-12">

                            <div class="row">
                                <label for="inputSkills" class="col-sm-2 control-label">Kegiatan</label>
                                <div class="col-xs-12">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-spinner"></i>
                                        </div>
                                        <input type="text" id="tasks_detail" name="tasks_detail" class="form-control input-sm" placeholder="kegiatan">
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
                            <form name="pencarianrawatjalan" action="<?= base_url('Master/tasksDetail'); ?>" method="POST">
                            <div class="col-xs-12 pull-right">
                                <div class="input-group input-group-sm">

                                    <!-- <div class="col-xs-12">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="<?= $tanggalcari; ?>" name="tanggalcari" placeholder="Masukan Tanggal Pencarian .. . . ." class="tanggal form-control pull-right " autocomplete="off">
                                        </div>


                                    </div> -->
                                <select class="form-control form-control-sm pull-right" id="cari_task" name="cari_task">
                                    <option value="">-- Jabatan --</option>
                                    <?php if (!empty($tasks)) : ?>
                                        <?php foreach ($tasks as $cb) : ?>
                                            <option value="<?= $cb['id']; ?>" <?= set_select('cari_tasks', $cb['id']); ?>><?= getProfesinya($cb["tasks"], "nama_profesi"); ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select>

                                <div class="input-group-btn">

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
                                        <th><b>Jabatan</b></th>
                                        <th><b>Kegiatan</b></th>
                                        

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($tasksdetail as $daftar) : ?>
                                        <tr>
                                            <td><?= ++$nomer; ?></td>
                                            <td><?= getProfesinya($daftar["tasks"], "nama_profesi"); ?></td>
                                            <td>
                                                <a class="tasks-detail" data-idnya="<?= $daftar["id"]; ?>" data-tasks="<?= $daftar["id_tasks"]; ?>" data-tasksname="<?= $daftar["tasks"]; ?>" data-tasksdetail="<?= $daftar["tasks_detail"]; ?>" 
                                                  data-toggle="modal" data-target="#submenumodal"><?= $daftar["tasks_detail"]; ?></a>
                                          </td>
                                            

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

<div class="modal fade" id="submenumodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel"><b>Proses</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('Master/updateTasksDetail'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="modal_id" name="modal_id" placeholder="Sub Menu url">
                    </div>
                    
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label">Tasks</label>
                           <div class="col-xs-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-spinner"></i>
                                </div>
                                <input type="text" id="modal_tasksname" name="modal_tasksname" class="form-control pull-right " autocomplete="off" readonly>
                                
                            </div>
                            </div>
                    </div>
                    <br><br>
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-4 control-label">Detail</label>
                           <div class="col-xs-8">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-spinner"></i>
                                </div>
                                <input type="text" id="modal_tasksdetail" name="modal_tasksdetail" class="form-control pull-right " autocomplete="off">
                            </div>
                            </div>
                    </div>
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