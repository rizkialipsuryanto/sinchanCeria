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
                <h3 class="box-title">Pencarian :</h3>
                <br>
                <form name="pencarianrawatjalan" action="<?= base_url('master/dataUser'); ?>" method="POST">
                    <div class="col-xs-12 pull-right">
                        <div class="input-group input-group-sm">
                            <input type="text" value="<?= $keyword; ?>" name="keyword" placeholder="Cari" class="form-control pull-right input-sm" autocomplete="off" autofocus>
                            <div class="input-group-btn">
                                <input type="submit" name="cariuser" value="cariuser" class="btn btn-warning">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <h3 class="box-title"><?= $title; ?>&nbsp;&nbsp;</h3>&nbsp;&nbsp;
                    <span class="label label-info">jumlah : <?php echo number_format($total_rows, 0, ",", ".") ?></span>&nbsp;&nbsp;

                </h3>
            </div>

            <div class="box-body">
                <?php if (empty($data)) : ?>
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
                                            <th></th>
                                            <th><b>Nama Depan</b></th>
                                            <th><b>Nama Belakang</b></th>
                                            <th><b>Email</b></th>
                                            <th><b>Role</b></th>
                                            <th><b>Status</b></th>
                                            <th><b>NIK</b></th>
                                            <th><b>Nomor Telphon</b></th>
                                            <th><b>Alamat</b></th>
                                            <th><b>Ruang</b></th>
                                            <th><b>Pegawai Id</b></th>
                                            <th><b>Tasks</b></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data as $d) : ?>
                                            <tr>
                                                <td><?= ++$nomer; ?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <!-- <button type="button" class="btn btn-info btn-xs">Pasien Baru</button> -->
                                                        <button type="button" class="btn btn-info dropdown-toggle btn-xs" data-toggle="dropdown">
                                                            <span class="caret"></span>
                                                            <span class="sr-only">Toggle Dropdown</span>
                                                        </button>
                                                        <ul class="dropdown-menu" role="menu">
                                                            <li><a href="<?= base_url('master/editUser/').$d["id"]; ?>">Edit</a></li>
                                                            <li><a href="<?= base_url('master/').$d["id"]; ?>">Delete</a></li>
                                                            <li><a href="<?= base_url('master/resetPassword/').$d["id"]; ?>">Reset Password</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td><?= $d["firstname"]; ?></td>
                                                <td><?= $d["lastname"] ?></td>
                                                <td><?= $d["email"]; ?></td>
                                                <td><?= getRole($d["role_id"],"role"); ?></td>
                                                <td><?= $d["is_active"]; ?></td>                                            
                                                <td><?= $d["nik"]; ?></td>
                                                <td><?= $d["nohp"]; ?></td>
                                                <td><?= $d["alamat"]; ?></td>
                                                <td><?= getPoli($d["ruang"], "userlevelname"); ?></td>
                                                <td><?= $d["pd_nickname"]; ?></td>
                                                <td><?= getTasks($d["tasks"], "tasks"); ?></td>

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