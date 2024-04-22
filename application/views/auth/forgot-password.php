<div class="row w-100">
    <div class="col-lg-4 mx-auto">

        <?= $this->session->flashdata('message'); ?>


        <div class="auth-form-light text-left p-5">
            <div class="brand-logo">
                <img src="<?= base_url('assets/'); ?>images/logo.svg">
            </div>
            <h4>Forgot Your Password?</h4>
            <h6 class="font-weight-light">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</h6>
            <form class="pt-3" method="POST" Action="<?= base_url('auth/forgotPassword') ?>">
                <div class="form-group">
                    <input type="text" value="<?= set_value('email') ?>" autocomplete="off" class="form-control form-control-sm" id="email" name="email" placeholder="Enter Email Address...">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>

                <div class="mt-3">

                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                        Reset Password
                    </button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">

                </div>
                <div class="mb-2">

                </div>
                <div class="text-center mt-4 font-weight-light">
                    Already have an account? <a href="<?= base_url('auth/'); ?>" class="text-primary">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>