<div class="row w-100">
    <div class="col-lg-4 mx-auto">

        <?= $this->session->flashdata('message'); ?>


        <div class="auth-form-light text-left p-5">
            <div class="brand-logo">
                <img src="<?= base_url('assets/'); ?>images/logosimrs2.png">
            </div>
            <h4>Hello, ini adalah modul simrs<br> versi pengembangan (Uji coba)</h4>
            <h6 class="font-weight-light">Hanya yang mempunyai hak akses yang berhak mengakses.</h6>
            <form class="pt-3" method="POST" Action="<?= base_url('auth') ?>">
                <div class="form-group">
                    <input type="email" value="<?= set_value('email') ?>" autocomplete="off" class="form-control form-control-lg" id="email" name="email" placeholder="Username">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control form-control-lg" autocomplete="off" id="password" name="password" placeholder="Password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="mt-3">

                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                        Login
                    </button>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <label class="form-check-label text-muted">
                            <input type="checkbox" class="form-check-input">
                            Keep me signed in
                        </label>
                    </div>
                    <a href="<?= base_url('auth/forgotPassword'); ?>" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="mb-2">

                </div>
                <div class="text-center mt-4 font-weight-light">
                    Don't have an account? <a href="<?= base_url('auth/registration'); ?>" class="text-primary">Create</a>
                </div>
            </form>
        </div>
    </div>
</div>