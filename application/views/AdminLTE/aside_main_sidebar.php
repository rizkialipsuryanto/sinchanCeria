<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?= $user['pd_nickname']; ?> <?= $user['lastname']; ?></p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- sidebar menu: : style can be found in sidebar.less -->

        <!-- QUERY MENU -->

        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-user"></i>
                    <span>User</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url();?>user"><i class="fa fa-circle-o"></i> My profiles </a></li>
                    <li><a href="<?php echo base_url();?>user/edit"><i class="fa fa-circle-o"></i> Edit Profile </a></li>
                    <?php if ($this->session->userdata('username') == 'dr.nugroho') { ?>
                       <li><a href="<?php echo base_url();?>user/karyawan"><i class="fa fa-circle-o"></i> Direktur </a></li>
                    <?php } else { ?>

                        <?php } ?>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Master</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="<?php echo base_url();?>Master/tasks"><i class="fa fa-circle-o"></i> Profesi Utama </a></li>
                    <li><a href="<?php echo base_url();?>Master/tasksDetail"><i class="fa fa-circle-o"></i> Kegiatan / Program </a></li>
                </ul>
            </li>
            <li><a href="<?php echo base_url();?>user/dailyrecords"><i class="fa fa-credit-card"></i> <span>Catatan Harian</span></a></li>
            <?php if ($user['is_manajemen'] == 1 || $user['is_karu']) {?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-book"></i>
                    <span>Evaluasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <?php if ($user['id_jabatan_intern_sub'] != '') {?>
                        <li><a href="<?php echo base_url();?>sinchan/evaluasiKasi"><i class="fa fa-check-square-o"></i> <span>Kepala Seksi</span></a></li>
                    <?php } else if ($user['id_jabatan_intern'] == 1){?>
                    <li><a href="<?php echo base_url();?>sinchan/evaluasiDirektur"><i class="fa fa-check-square-o"></i> <span>Direktur</span></a></li>
                    <!-- <li><a href="<?php echo base_url();?>sinchan/evaluasiKabid"><i class="fa fa-check-square-o"></i> <span>Kepala Bidang</span></a></li>
                    <li><a href="<?php echo base_url();?>sinchan/evaluasiKaru"><i class="fa fa-check-square-o"></i> <span>Kepala Ruang</span></a></li> -->
                    <?php } else if ($user['id_jabatan_intern'] != ''){?>
                    <li><a href="<?php echo base_url();?>sinchan/evaluasiKabid"><i class="fa fa-check-square-o"></i> <span>Kepala Bidang</span></a></li>
                    <?php } else if ($user['is_karu'] == 1){?>
                    <li><a href="<?php echo base_url();?>sinchan/evaluasiKaru"><i class="fa fa-check-square-o"></i> <span>Kepala Ruang</span></a></li>
                    <?php }?>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>