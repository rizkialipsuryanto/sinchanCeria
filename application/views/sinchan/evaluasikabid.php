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

                </h3>

                <div class="box-tools">
                    <form name="pencarianrawatjalan" action="<?= base_url('sinchan/evaluasiKabid'); ?>" method="POST">
                        <div class="col-xs-10 pull-right">
                            <div class="input-group input-group-sm">


                                <!-- <select class="form-control form-control-sm pull-right" id="cari_profesi" name="cari_profesi">
                                    <option value=""> Profesi</option>
                                    <?php if (!empty($profesi)) : ?>
                                        <?php foreach ($profesi as $cb) : ?>
                                            <option value="<?= $cb['tasks']; ?>" <?= set_select('cari_profesi', $cb['tasks']); ?>><?= $cb['nama_profesi']; ?></option>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </select> -->


                                <div class="input-group-btn">

                                </div>
                                <div class="col-xs-12">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" value="<?= $tanggalcari; ?>" name="tanggalcari" placeholder="Masukan Tanggal Pencarian .. . . ." class="tanggal form-control pull-right " autocomplete="off">
                                        </div>


                                    </div>

                                <div class="input-group-btn">

                                </div>

                                <!-- <input type="text" value="<?= $keyword; ?>" name="keyword" placeholder="Cari Berdasarkan Nama Pegawai .. . . ." class="form-control pull-right input-sm" autocomplete="off" autofocus> -->

                                <div class="input-group-btn">
                                    <input type="submit" name="caripembayaran" value="Cari Cepat" class="btn btn-warning">
                                    <a class="btn btn-success" data-toggle="tooltip" data-placement="bottom" title="Klik Tombol ini apabila data tidak update!" href="<?= site_url('rekammedis/unlink/'); ?><?= $this->uri->segment('1'); ?>/<?= $this->uri->segment('2'); ?>" target="_self"> Refresh</a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

                <div class="box-body">

                </div>
                <div class="box-footer">
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
                                        <th><b>Nama</b></th>
                                        <th><b>Tanggal</b></th>
                                        <th><b>Tugas</b></th>
                                        <th><b>Catatan</b></th>
                                        <th><b>Jumlah</b></th>
                                        <th><b>Satuan</b></th>
                                        <th><b>Feedback</b></th>
                                        <!-- <th><b>Durasi</b></th> -->

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($daily as $daftar) : ?>
                                        <tr>
                                            <td><?= ++$nomer; ?></td>
                                            <?php if (($daftar["bulan"]) == date('m')){
                                                ?>
                                            <td>
                                                <?php if ($daftar["feedback"] != '') {
                                                 ?>
                                                    <a class="transaksi-konfirmasi" data-idnya="<?= $daftar["id"]; ?>"><span class="label label-success"><i class="fa fa-check"></i> Sudah Terverifikasi</span></a>
                                                <?php }else{ ?>
                                                    <a class="transaksi-konfirmasi" data-idnya="<?= $daftar["id"]; ?>" data-toggle="modal" data-target="#submenumodal"><span class="label label-danger"><i class="fa fa-check"></i> Belum Terverifikasi</span></a>
                                                <?php } ?>
                                                <!-- <a class="hapus-dailyrecord" data-id="<?= $daftar["id"]; ?>" data-toggle="modal" data-target="#submenumodal"><span class="label label-danger"> Tolak</span></a> -->
                                            </td>
                                            <?php } else{
                                             ?>
                                             <td>
                                                 
                                             </td>
                                            <?php } ?>
                                            <td><?= getDetailUserMaster($daftar["created_by"], "pd_nickname"); ?></td>
                                            <td><?= $daftar["tanggal"]; ?></td>
                                            <td><?= getTasksDetail($daftar["id_tasks_detail"], "tasks_detail"); ?></td>
                                            <td><?= $daftar["catatan"]; ?></td>
                                            <td><?= $daftar["jumlah"]; ?></td>
                                            <td><?= getSatuanSinchan($daftar["satuan"], "satuan"); ?></td>
                                            <td><?= $daftar["feedback"]; ?></td>
                                            <!-- <td><input type="text" name="feedback"><i class="fa fa-save"></i><a class="hapus-dailyrecord" data-id="<?= $daftar["id"]; ?>" data-toggle="modal" data-target="#submenumodal"><span class="label label-danger"> Simpan</span></a></td> -->
                                            <!-- <td><?= $daftar["durasi"]; ?></td> -->

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
                <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('sinchan/konfirmasievaluasi'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="modal_id" name="modal_id" placeholder="Sub Menu url">
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <label for="inputSkills" class="control-label">Feedback</label>
                            <input type="textarea" class="form-control" name="txt_feedback" id="txt_feedback" required>
                        </div>
                    </div>
                    
                    <br><br>
                    <div class="form-group">
                        <label for="inputSkills" class="col-sm-12 control-label">Apakah Data Yang Diinput Adalah Benar???</label>
                    </div>

                </div>
                <div class="modal-footer">

                    <div class="pull-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <!-- <a href="<?= base_url('cssd/cssdTransaction'); ?>"><span class="btn btn-primary">Proses</span></a> -->
                        <button type="submit" class="btn btn-primary">Konfirmasi</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>