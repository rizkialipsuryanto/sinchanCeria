<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-form-title" style="background-image: url(<?= base_url('assets/Login_v15/'); ?>images/bg-01.jpg);">
                <span class="login100-form-title-1">
                    <?= $title; ?>
                </span>
            </div>


            <form class="login100-form validate-form" method="POST" Action="<?= base_url('auth/forgotPassword') ?>">

                <?= $this->session->flashdata('message'); ?>


                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Email</span>

                    <input type="email" value="<?= set_value('email') ?>" autocomplete="off" class=" input100" id="email" name="email" placeholder="email">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>


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
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>