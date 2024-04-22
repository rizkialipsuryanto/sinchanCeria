<div class="row w-100">
    <div class="col-lg-4 mx-auto">

        <?= $this->session->flashdata('message'); ?>

        <div class="auth-form-light text-left p-5">
            <div class="brand-logo">
                <img src="<?= base_url('assets/'); ?>images/logo.svg">
            </div>
            <h4>New here?</h4>
            <h6 class="font-weight-light">Signing up is easy. It only takes a few steps</h6>
            <form class="pt-3" method="POST" action="<?= base_url('auth/registration/'); ?>">
                <div class="form-group">
                    <input type="text" autocomplete="OFF" class="form-control form-control-sm" id="firstname" name="firstname" value="<?= set_value('firstname') ?>" placeholder="First Name">
                    <?= form_error('firstname', '<small class="text-danger pl-3">', '</small>'); ?>

                </div>
                <div class="form-group">
                    <input type="text" autocomplete="OFF" class="form-control form-control-sm" id="lastname" name="lastname" value="<?= set_value('lastname') ?>" placeholder="Last Name">
                    <?= form_error('lastname', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <!-- <div class="form-group">
                    <select class="form-control input-sm select2" id="cbpoli" name="cbpoli">
                                            <option> -- Pilih Ruang -- </option>
                                            <?php if (!empty($poli)) : ?>
                                                <?php foreach ($poli as $pl) : ?>
                                                    <option value="<?= $pl['userlevelid']; ?>"><?= $pl['userlevelname']; ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                </div> -->
                <div class="form-group">
                    <input type="text" autocomplete="OFF" class="form-control form-control-sm" id="email" name="email" value="<?= set_value('email') ?>" placeholder="Email Address">
                    <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <input type="password" autocomplete="OFF" class="form-control form-control-sm" id="password1" name="password1" placeholder="Password">
                    <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <input type="password" autocomplete="OFF" class="form-control form-control-sm" id="password2" name="password2" placeholder="Repeat Password">

                </div>
                <div class="mb-4">
                    <div class="form-check">
                        <label class="form-check-label text-muted">
                            <input type="checkbox" class="form-check-input">
                            I agree to all Terms & Conditions
                        </label>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">
                        Register Account
                    </button>
                </div>
                <div class="text-center mt-4 font-weight-light">
                    Already have an account? <a href="<?= base_url("auth/"); ?>" class="text-primary">Login</a>
                </div>
            </form>
        </div>
    </div>
</div>