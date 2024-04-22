<div class="row w-100">
    <div class="col-lg-4 mx-auto">

        <?= $this->session->flashdata('message'); ?>

        <div class="auth-form-light text-left p-5">
            <div class="brand-logo">
                <img src="<?= base_url('assets/'); ?>images/logo.svg">
            </div>
            <h4>Change Your Password for </h4>
            <h6 class="font-weight-light">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</h6>
            <form class="pt-3" method="POST" action="<?= base_url('auth/changePassword') ?>">

                <div class="form-group">
                    <input type="password" autocomplete="off" class="form-control form-control-user" id="password1" name="password1" placeholder="Enter New Password ...">
                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <input type="password" autocomplete="off" class="form-control form-control-user" id="password2" name="password2" placeholder="Confirm  New Password ...">
                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary btn-user btn-block">
                        Change Password
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>