<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Sinchan Ceria - RSUD AJIBARANG | <?= $title; ?></title>

  <link rel="icon" type="image/png" href="<?= base_url('assets/AdminLTE/'); ?>favicon2.ico" />

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>dist/css/skins/_all-skins.min.css">


  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

  <!-- Morris chart -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

  <!-- <link href="<?= base_url('vendor/bootstrap-datepicker/css/'); ?>bootstrap-datepicker3.css" rel="stylesheet">-->

  <!-- Pace style -->
  <link rel="stylesheet" href="<?= base_url('assets/AdminLTE/'); ?>/plugins/pace/pace.min.css">



  <?php if ($css_arr_head) : ?>
    <?php foreach ($css_arr_head as $css) : ?>
      <link rel="stylesheet" href="<?= base_url('assets/css/') . $css; ?>">
    <?php endforeach; ?>
  <?php endif; ?>


  <style>
    .pace {
      -webkit-pointer-events: none;
      pointer-events: none;

      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    .pace.pace-inactive .pace-progress {
      display: none;
    }

    .pace .pace-progress {
      position: fixed;
      z-index: 2000;
      top: 0;
      right: 0;
      height: 5rem;
      width: 5rem;

      -webkit-transform: translate3d(0, 0, 0) !important;
      -ms-transform: translate3d(0, 0, 0) !important;
      transform: translate3d(0, 0, 0) !important;
    }

    .pace .pace-progress:after {
      display: block;
      position: absolute;
      top: 0;
      right: .5rem;
      content: attr(data-progress-text);
      font-family: "Helvetica Neue", sans-serif;
      font-weight: 100;
      font-size: 5rem;
      line-height: 1;
      text-align: right;
      color: rgba(0, 0, 0, 0.19999999999999996);
    }
  </style>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="<?= base_url('assets/fonts/'); ?>font-css.css">
</head>