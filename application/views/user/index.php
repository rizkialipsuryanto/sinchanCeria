<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="box box-primary">
            <div class="box-body box-profile">
                <img class="profile-user-img img-responsive img-circle" src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="User profile picture">

                <h3 class="profile-username text-center"><?= $user['pd_nickname']; ?></h3>
                <p class="text-muted text-center"><?= $user['no_identitas']; ?></p>
                <p class="text-muted text-center"><?= $user['id_profesi']; ?></p>

                <ul class="list-group list-group-unbordered">
                    <li class="list-group-item">
                        <b>Tanggal Lahir</b> <a class="pull-right"><?= $user['tanggal_lahir']; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Alamat</b> <a class="pull-right"><?= $user['alamat']; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>No Telpon</b> <a class="pull-right"><?= $user['no_telp']; ?></a>
                    </li>
                    <!-- <li class="list-group-item">
                        <b>Ruang</b> <a class="pull-right"><?= getRuangan($user['userlevelid'],'userlevelname'); ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Status</b> <a class="pull-right"><?= getStatus($user['id_status_karyawan'],'nama_status_karyawan'); ?></a>
                    </li> -->
                    <li class="list-group-item">
                        <b>NIP</b> <a class="pull-right"><?= $user['nip']; ?></a>
                    </li>
                    <li class="list-group-item">
                        <b>Tanggal Masuk Kerja</b> <a class="pull-right"><?= $user['tanggal_masuk_kerja']; ?></a>
                    </li>
                </ul>

                <a href="#" class="btn btn-primary btn-block"><b>Follow</b></a>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- About Me Box -->
        

    </div>
</div>