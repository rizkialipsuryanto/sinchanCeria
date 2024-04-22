<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-form-title" style="background-image: url(<?= base_url('assets/Login_v15/'); ?>images/bg-01.jpg);">
                <span class="login100-form-title-1">
                    <?= $title; ?>

                </span>
                <br>
                <h6 style="color:white;" class="font-weight-light">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</h6>


            </div>


            <form class="login100-form validate-form" method="POST" Action="<?= base_url('auth/changePassword') ?>">

                <?= $this->session->flashdata('message'); ?>


                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Password Baru</span>

                    <!-- <input type="email" value="<?= set_value('email') ?>" autocomplete="off" class=" input100" id="email" name="email" placeholder="email">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?> -->


                    <input type="password" autocomplete="off" class="input100" id="password1" name="password1" placeholder="Enter New Password ...">
                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>


                    <span class="focus-input100"></span>
                </div>



                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Ulangi</span>
                    <input type="password" autocomplete="off" class="input100" id="password2" name="password2" placeholder="Confirm  New Password ...">
                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>


                    <span class="focus-input100"></span>
                </div>



                <div class="flex-sb-m w-full p-b-30">
                </div>

                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>