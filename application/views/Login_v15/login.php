<!-- <progress value = "65" max = "100"/> -->
<div class="limiter">

    <div class="container-login100">
        <div class="wrap-login100">
        <!-- <h2><marquee direction="left" scrollamount="5" align="center">MARHABAN YA RAMADHAN, KAMI SEGENAP KELUARGA BESAR IT MENGUCAPKAN SELAMAT MENUNAIKAN IBADAH PUASA BAGI YANG MENJALANKAN. MOHON MAAF LAHIR DAN BATHIN</marquee></h1> -->
            <div class="login100-form-title" style="background-size: cover;
         background-position: center;background-image: url(<?= base_url('assets/Login_v15/'); ?>images/bg-02.png);">
                <span class="login100-form-title-1">
                    Sistem Informasi Catatan Harian - CERIA
                </span>
                <span class="login100-form-title-1">
                    RSUD AJIBARANG
                </span>
            </div>


            <form class="login100-form validate-form"  method="POST" Action="<?= base_url('auth') ?>">

                <?= $this->session->flashdata('message'); ?>


                <div class="wrap-input100 validate-input m-b-26" data-validate="Username is required">
                    <span class="label-input100">Username</span>

                    <input type="text" value="<?= set_value('username') ?>" autocomplete="off" class=" input100" id="username" name="username" placeholder="username">
                    <?= form_error('username', '<small class="text-danger pl-3">', '</small>'); ?>


                    <span class="focus-input100"></span>
                </div>

                <div class="wrap-input100 validate-input m-b-18" data-validate="Password is required">
                    <span class="label-input100">Password</span>
                    <input type="password" class="input100" autocomplete="off" id="password" name="password" placeholder="Password">
                    <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>


                    <span class="focus-input100"></span>
                </div>

                <!-- <div class="flex-sb-m w-full p-b-30">


                    <div>
                        <a href="<?= base_url('auth/forgotPassword'); ?>" class="txt1">
                            Klik disini apabila Lupa Password
                        </a>
                    </div>
                    <div>
                        <a href="<?= base_url('auth/registration'); ?>" class="txt1">
                            Registrasi Akun Baru
                        </a>
                    </div>
                </div> -->

                <div class="container-login100-form-btn">
                    <button type="submit" class="login100-form-btn">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>