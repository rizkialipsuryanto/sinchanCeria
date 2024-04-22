<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-form-title" style="background-image: url(<?= base_url('assets/Login_v15/'); ?>images/bg-01.jpg);">
                <span class="login100-form-title-1">
                    <?= $title; ?>
                </span>
            </div>


            <form class="login100-form validate-form" method="POST" Action="<?= base_url('auth/registration') ?>">

                <?= $this->session->flashdata('message'); ?>


                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">First Name</span>


                    <input type="text" autocomplete="OFF" class="input100" id="firstname" name="firstname" value="<?= set_value('firstname') ?>" placeholder="First Name">
                    <?= form_error('firstname', '<small class="text-danger pl-3">', '</small>'); ?>


                    <span class="focus-input100"></span>
                </div>



                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Last Name</span>


                    <input type="text" autocomplete="OFF" class="input100" id="lastname" name="lastname" value="<?= set_value('lastname') ?>" placeholder="Last Name">
                    <?= form_error('lastname', '<small class="text-danger pl-3">', '</small>'); ?>




                    <span class="focus-input100"></span>
                </div>


                <!-- <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Ruang</span>
                    <select class="form-control input-sm select2" id="cbpoli" name="cbpoli">
                                            <option> -- Pilih Ruang -- </option>
                                            <?php if (!empty($poli)) : ?>
                                                <?php foreach ($poli as $pl) : ?>
                                                    <option value="<?= $pl['userlevelid']; ?>"><?= $pl['userlevelname']; ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                </div> -->

                <div class="wrap-input100 validate-input m-b-26" data-validate="No Identitas is required">
                    <span class="label-input100">No Identitas</span>
                    <input type="text" autocomplete="OFF" class="input100" id="no_identitas" name="no_identitas" value="<?= set_value('no_identitas') ?>" placeholder="No Identitas">
                    <?= form_error('no_identitas', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>


                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Email</span>

                    <input type="email" value="<?= set_value('email') ?>" autocomplete="off" class=" input100" id="email" name="email" placeholder="email">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                    <span class="focus-input100"></span>
                </div>




                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Password</span>


                    <input type="password" autocomplete="OFF" class="input100" id="password1" name="password1" placeholder="Password">
                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>


                    <span class="focus-input100"></span>
                </div>


                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100"></span>

                    <input type="password" autocomplete="OFF" class="input100" id="password2" name="password2" placeholder="Ulangi Password">

                    <span class="focus-input100"></span>
                </div>



                <div class="flex-sb-m w-full p-b-30">


                    <div>
                        <a href="<?= base_url('auth/'); ?>" class="txt1">
                            Sudah Punya Akun?
                        </a>
                    </div>
                </div>

                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">
                        Register Account
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>