 <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
     <span class="mdi mdi-menu"></span>
 </button>


 </div>
 </nav>


 <!-- partial -->
 <div class="container-fluid page-body-wrapper">


     <!-- partial:partials/_sidebar.html -->
     <nav class="sidebar sidebar-offcanvas" id="sidebar">
         <ul class="nav">



             <li class="nav-item nav-profile">
                 <a href="#" class="nav-link">
                     <div class="nav-profile-image">
                         <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" alt="profile">
                         <span class="login-status online"></span>

                     </div>
                     <div class="nav-profile-text d-flex flex-column">
                         <span class="font-weight-bold mb-2"><?= $user['firstname']; ?></span>
                         <span class="text-secondary text-small"><?= $user['lastname']; ?></span>
                     </div>
                     <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
                 </a>
             </li>





             <li class="nav-item">
                 <a class="nav-link" href="<?= base_url('auth/'); ?>">
                     <span class="menu-title">Dashboard</span>
                     <i class="mdi mdi-home menu-icon"></i>
                 </a>
             </li>




             <!-- QUERY MENU -->
             <?php
                $role_id = $this->session->userdata('role_id');
                $queryMenu = "SELECT `user_menu`.`id`,`caption` 
                    FROM `user_menu` JOIN `user_access_menu` 
                    ON `user_menu`.`id` = `user_access_menu`.`menu_id` 
                    WHERE `user_access_menu`.`role_id` =  $role_id
                    ORDER BY `user_access_menu`.`menu_id` ASC  ";

                $menu = $this->db->query($queryMenu)->result_array();
                ?>
             <?php foreach ($menu as $m) :  ?>


                 <li class="nav-item">
                     <a class="nav-link" data-toggle="collapse" href="#<?= $m['id']; ?>" aria-expanded="false" aria-controls="<?= $m['id']; ?>">
                         <span class="menu-title"><?= $m['caption']; ?></span>
                         <i class="menu-arrow"></i>
                         <i class="mdi mdi-medical-bag menu-icon"></i>
                     </a>
                     <div class="collapse" id="<?= $m['id']; ?>">
                         <?php
                            $querysubMenu = "   SELECT *
                                                FROM  `user_sub_menu` JOIN `user_menu`
                                                ON  `user_sub_menu`.`menu_id` = `user_menu`.`id`
                                                WHERE  `user_sub_menu`.`menu_id` = {$m['id']}
                                                AND `user_sub_menu`.`is_active` = 1";

                            $submenu = $this->db->query($querysubMenu)->result_array();
                            ?>
                         <ul class="nav flex-column sub-menu">
                             <?php foreach ($submenu as $sm) :  ?>


                                 <li class="nav-item"> <a class="nav-link" href="<?= base_url(trim($sm['url'])); ?>"> <?= $sm['title']; ?> </a></li>

                             <?php endforeach ?>
                         </ul>
                     </div>
                 </li>


             <?php endforeach; ?>


             <li class="nav-item sidebar-actions">
                 <span class="nav-link">
                     <div class="border-bottom">

                     </div>

                     <a class="btn btn-block btn-lg btn-gradient-primary mt-4" href="<?= base_url('auth/'); ?>"> + Add a project </a>

                 </span>
             </li>
         </ul>
     </nav>



     <!-- partial -->
     <div class="main-panel">
         <div class="content-wrapper">