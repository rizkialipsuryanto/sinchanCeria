      <!-- Brand Logo -->
      <!-- <a href="<?= site_url('welcome'); ?>" class="ajax brand-link  navbar-primary text-sm">
          <img src="<?= base_url('assets/simrs-theme/'); ?>dist/img/digitalesensiana.png" alt="RSUDAJB" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">SIMRS RSUD AJIBARANG</span>
      </a> -->


      <a href="index3.html" class="brand-link">
          <img src="<?= base_url('assets/simrs-theme/'); ?>dist/img/digitalesensiana.png" alt="RSUDAJB" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">simRs AJB</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar ">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" onerror="this.onerror=null; this.src='<?= base_url('assets/img/profile/default.png') ?>'" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="<?= site_url(); ?>" class="ajax d-block"><span class="font-weight-bold"><?= $user['firstname']; ?> <?= $user['lastname']; ?></span></a>
              </div>
          </div>

          <!-- SidebarSearch Form -->
          <div class="form-inline">
              <div class="input-group" data-widget="sidebar-search">
                  <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                  <div class="input-group-append">
                      <button class="btn btn-sidebar">
                          <i class="fas fa-search fa-fw"></i>
                      </button>
                  </div>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">

              <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-legacy" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-item menu-open">
                      <a href="<?= site_url('welcome'); ?>" class="ajax nav-link active">
                          <i class="nav-icon fas fa-tachometer-alt"></i>
                          <p>
                              Dashboard
                              <i class="right fas fa-angle-left"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="<?php echo base_url();?>anjungan"" class=" ajax nav-link active">
                                  <i class="far fa-circle nav-icon"></i>
                                  <p>SEP Mandiri</p>
                              </a>
                          </li>

                      </ul>
                  </li>
                  <?php
                    $role_id = $this->session->userdata('role_id');
                    $queryMenu = "SELECT `user_menu`.`id`,`caption` ,`icon`
                    FROM `user_menu` JOIN `user_access_menu` 
                    ON `user_menu`.`id` = `user_access_menu`.`menu_id` 
                    WHERE `user_access_menu`.`role_id` =  $role_id
                    ORDER BY `user_access_menu`.`menu_id` ASC  ";

                    $menu = $this->db->query($queryMenu)->result_array();
                    ?>
                  <?php foreach ($menu as $m) :  ?>
                      <li class="nav-item">
                          <a href="#" class="nav-link">
                              <i class="nav-icon <?= $m['icon']; ?>"></i>
                              <p>
                                  <?= $m['caption']; ?>
                                  <i class="fas fa-angle-left right"></i>
                              </p>
                          </a>
                          <ul class="nav nav-treeview ">

                              <?php
                                $querysubMenu = "   SELECT `user_sub_menu`.`title`,`user_sub_menu`.`icon`,`user_sub_menu`.`url`, `user_sub_menu`.`hot_reload`
                                                FROM  `user_sub_menu` JOIN `user_menu`
                                                ON  `user_sub_menu`.`menu_id` = `user_menu`.`id`
                                                WHERE  `user_sub_menu`.`menu_id` = {$m['id']}
                                                AND `user_sub_menu`.`is_active` = 1";

                                $submenu = $this->db->query($querysubMenu)->result_array();
                                ?>
                              <?php foreach ($submenu as $sm) :  ?>

                                  <li class="nav-item">
                                      <a href="<?= base_url(trim($sm['url'])); ?>" class="<?php if ($sm['hot_reload'] == 1) : ?><?php echo " ajax "; ?><?php endif; ?> nav-link">
                                          <i class="far fa-circle nav-icon"></i>
                                          <p><?= $sm['title']; ?></p>
                                      </a>
                                  </li>
                              <?php endforeach ?>


                          </ul>
                      </li>


                  <?php endforeach; ?>



                  <li class="nav-header">SignOut</li>
                  <li class="nav-item">
                      <a href="javascript:void(0)" class="nav-link actLogout">
                          <i class="nav-icon far fa-calendar-alt"></i>
                          <!-- <p>Petunjuk Penggunaan<span class="badge badge-info right">2</span> -->
                          <p>Logout<span class="badge badge-info right">new</span>
                          </p>
                      </a>
                  </li>




              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->