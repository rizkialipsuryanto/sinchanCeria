<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-form-title" style="background-image: url(<?= base_url('assets/Login_v15/'); ?>images/bg-01.jpg);">
                <span class="login100-form-title-1">
                    <?= $title; ?>
                </span>
            </div>


            <form class="login100-form validate-form" method="POST" Action="<?= base_url('auth/webinar') ?>">

                <?= $this->session->flashdata('message'); ?>

                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Email</span>

                    <input type="email" value="<?= set_value('email') ?>" autocomplete="off" class=" input100" id="email" name="email" placeholder="email">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Nama</span>


                    <input type="text" autocomplete="OFF" class="input100" id="nama" name="nama" value="<?= set_value('nama') ?>" placeholder="Nama">
                    <?= form_error('nama', '<small class="text-danger pl-3">', '</small>'); ?>


                    <span class="focus-input100"></span>
                </div>



                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Nomor Hp</span>


                    <input type="text" autocomplete="OFF" class="input100" id="nohp" name="nohp" value="<?= set_value('nohp') ?>" placeholder="No Hp">
                    <?= form_error('nohp', '<small class="text-danger pl-3">', '</small>'); ?>




                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Alamat</span>


                    <input type="text" autocomplete="OFF" class="input100" id="alamat" name="alamat" value="<?= set_value('alamat') ?>" placeholder="Alamat">
                    <?= form_error('alamat', '<small class="text-danger pl-3">', '</small>'); ?>




                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Instansi</span>


                    <input type="text" autocomplete="OFF" class="input100" id="instansi" name="instansi" value="<?= set_value('instansi') ?>" placeholder="Instansi">
                    <?= form_error('instansi', '<small class="text-danger pl-3">', '</small>'); ?>




                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Profesi</span>


                    <input type="text" autocomplete="OFF" class="input100" id="profesi" name="profesi" value="<?= set_value('profesi') ?>" placeholder="Profesi">
                    <?= form_error('profesi', '<small class="text-danger pl-3">', '</small>'); ?>




                    <span class="focus-input100"></span>
                </div>

                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">
                        Daftar Webinar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>