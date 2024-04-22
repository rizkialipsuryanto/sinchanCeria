<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? $title : 'SIMRS'; ?> | <?= isset($subtitle) ? $subtitle : 'RSUD AJIBARANG'; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url('assets/AdminLTE/'); ?>favicon.ico" />

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <!-- <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/jqvmap/jqvmap.min.css"> -->
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/summernote/summernote-bs4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/pace-progress/themes/black/pace-theme-flat-top.css">

    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/datatables-responsive/css/responsive.bootstrap4.min.css">


    <!-- Select2 -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">


    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('assets/simrs-theme/'); ?>plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">



    <!-- Fake Notification  -->
    <link href="<?= base_url('assets/simrs-theme/'); ?>dist/css/notifications/fake-notification-min.css" rel="stylesheet">


    <?php if ($css_arr_head != '') : ?>
        <?php foreach ($css_arr_head as $css) : ?>
            <link rel="stylesheet" href="<?= base_url('assets/css/') . $css; ?>">
        <?php endforeach; ?>
    <?php endif; ?>


    <script src="<?= base_url('assets/simrs-theme/'); ?>pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = false;

        var pusher = new Pusher('7f5cdf6976d8673b4e56', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-channel');
        console.log("jalan 1");
        channel.bind('my-event', function(data) {
            console.log("jalan 2");
            $(document).Toasts('create', {
                class: 'bg-danger',
                title: 'Pengumuman',
                subtitle: 'Penerimaan Jasa Pelayanan',
                image: '<?= base_url('assets/images/') ?>logout_image.jpg',
                body: 'Penandatanganan Jasa Pelayanan sudah boleh dilakukan mulai .....'
            })
        });
        console.log("jalan 3");
    </script>


    <script src="<?= base_url('assets/simrs-theme/'); ?>jquery.min.js"></script>
    <script>
        var BASEURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname.split("/")[1];
        $(document).ready(function() {
            $('.ajax').click(function(e) {
                e.preventDefault();
                $.get($(this).attr('href'), function(Res) {
                    $('#content').html(Res);
                });
            })
        })
    </script>

</head>

<body class="layout-boxed text-sm hold-transition sidebar-mini pace-danger accent-primary">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-primary navbar-dark">
            <?php echo $_navbar; ?>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-primary elevation-4">
            <?php echo $_main_sidebar; ?>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <?php /*echo $_breadcrumbs; */ ?>
                    <!-- Content Header (Page header) -->
                    <div class="content-header">
                        <div class="container-fluid">
                            <div class="row mb-2">
                                <div class="col-sm-6">
                                    <h1 class="m-0 text-dark"><?= $subtitle; ?></h1>
                                </div><!-- /.col -->
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="<?= site_url() ?>">Home</a></li>
                                        <li class="breadcrumb-item active"><?= $subtitle; ?></li>
                                    </ol>
                                </div><!-- /.col -->
                            </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                    </div>
                    <!-- /.content-header -->

                    <!-- Main content -->
                    <!-- disini -->

                    <?php if ($this->session->flashdata('external_message_push')) : ?>
                        <?php $message = $this->session->flashdata('external_message_push'); ?>
                        <?php switch ($message["metaData"]["code"]) {
                            case 200:
                                echo '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-check"></i> Status</h5>
                                    ' . $message["metaData"]["message"] . '
                                    </div>
                                </div>
                            </div>';
                                break;
                            case 201:
                                echo '
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Status</h5>
                                    ' . $message["metaData"]["message"] . '
                                    </div>
                                </div>
                            </div>';
                                break;
                            default:
                                echo '
                        <div class="row">
                            <div class="col-md-12">
                                <div class="alert alert-warning alert-dismissible">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                    <h5><i class="icon fas fa-ban"></i> Status</h5>
                                ' . $message["metaData"]["message"] . '
                                </div>
                            </div>
                        </div>';
                        } ?>
                    <?php endif; ?>
                    <div id="content">
                        <?php echo $_content_wrapper; ?>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <?php echo $_main_footer; ?>
        </footer>

        <!-- Control Sidebar -->
        <aside class=" control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->




    <!-- jQuery -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <!-- <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
    <!-- jQuery Knob Chart -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/moment/moment.min.js"></script>
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>dist/js/adminlte.js"></script>
    <!-- <script src="<?= base_url('assets/simrs-theme/'); ?>dist/js/adminlte.min.js"></script> -->
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <!-- <script src="<?= base_url('assets/simrs-theme/'); ?>dist/js/pages/dashboard.js"></script> -->
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>dist/js/demo.js"></script>
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/pace-progress/pace.min.js"></script>



    <!-- InputMask -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/moment/moment.min.js"></script>
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/inputmask/jquery.inputmask.min.js"></script>

    <!-- jquery-validation -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/jquery-validation/additional-methods.min.js"></script>


    <!-- DataTables -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>




    <!-- Select2 -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/select2/js/select2.full.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>


    <!-- <script src="<?= base_url('assets/simrs-theme/'); ?>dist/js/pages/dashboard3.js"></script> -->

    <!-- SweetAlert2 -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/sweetalert2/sweetalert2.min.js"></script>

    <!-- Bootstrap Switch -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>


    <!-- Fake Notif -->
    <script src="<?= base_url('assets/simrs-theme/'); ?>dist/js/notifications/jquery.fake-notification.min.js"></script>

    <?php if ($js_arr_foot) : ?>
        <?php foreach ($js_arr_foot as $js) : ?>
            <script type="text/javascript" src="<?php echo base_url('assets/js/') . $js;  ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>



    <div id="notification-1" class="notification">
        <div class="notification-block">
            <div class="notification-img">
                <!-- Your image or icon -->
                <i class="fa fa-address-book" aria-hidden="true"></i>
                <!-- / Your image or icon -->
            </div>
            <div class="notification-text-block">
                <div class="notification-title text-danger">
                    Pengumuman Baru
                </div>
                <div class="notification-text"></div>
            </div>
        </div>
    </div>

</body>

</html>

<?php if ($js_to_load != '') : ?>
    <script type="text/javascript" src="<?= base_url('assets/js/') ?><?= $js_to_load; ?>"></script>
<?php endif; ?>

<script>
    function goBack() {
        console.log("jalan");
        window.history.back();

    }

    function getdate() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        if (h < 10) {
            h = "0" + h;
        }
        if (m < 10) {
            m = "0" + m;
        }
        if (s < 10) {
            s = "0" + s;
        }

        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        var myDays = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu'];
        var date = new Date();
        var day = date.getDate();
        var month = date.getMonth();
        var thisDay = date.getDay(),
            thisDay = myDays[thisDay];
        var yy = date.getYear();
        var year = (yy < 1000) ? yy + 1900 : yy;

        var tgl = ("Hari : " + thisDay + ', ' + day + ' ' + months[month] + ' ' + year);
        var jam = (h + ":" + m + ":" + s + " wib");
        $("#timer").html(tgl + ' ' + jam);
        //console.log(tgl + ' ' + jam);
        setTimeout(function() {
            getdate()
        }, 1000);
    }


    $(function() {


        $('#notification-1').Notification({
            // Notification varibles
            Varible1: ["Tanda tangan jaspel bisa dilakukan mulai hari ini diruang rapat", "Hari ini jaspel akan di transfer", "Jangan Lupa Pake Masker", "Senyum, Sapa dan Salaman..", ""],
            Content: '[Varible1]' + "<br /><br />" + ' #RSUDAJIBARANG</b>.',
            // Timer
            Show: ['random', 8, 15],
            Close: 5,
            Time: [0, 23],
            // Notification style 
            LocationTop: [false, '5%'],
            LocationBottom: [true, '10%'],
            LocationRight: [false, '10%'],
            LocationLeft: [true, '10px'],
            Background: 'white',
            BorderRadius: 5,
            BorderWidth: 1,
            BorderColor: 'blue',
            TextColor: 'black',
            IconColor: 'blue',
            // Notification Animated   
            AnimationEffectOpen: 'zoomInDown',
            AnimationEffectClose: 'bounceOutLeft',
            // Number of notifications
            Number: 50,
            // Notification link
            Link: [false, 'http://simrs.rsudajibarang/', '_self']

        });


        getdate();
        $('.actLogout').on('click', function() {
            Swal.fire({
                title: 'Yakin ingin Logout?',
                text: "Sistem Akan Melakukan SignOut",
                // icon: 'warning',
                showCancelButton: true,
                imageUrl: '<?= base_url('assets/images/') ?>logout_image.jpg',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'iyaa dong',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.replace(BASEURL + "/auth/logout");
                }
            })
        });


    });
</script>
<!-- Start of LiveChat (www.livechatinc.com) code -->
<script>
    window.__lc = window.__lc || {};
    window.__lc.license = 12355524;;
    (function(n, t, c) {
        function i(n) {
            return e._h ? e._h.apply(null, n) : e._q.push(n)
        }
        var e = {
            _q: [],
            _h: null,
            _v: "2.0",
            on: function() {
                i(["on", c.call(arguments)])
            },
            once: function() {
                i(["once", c.call(arguments)])
            },
            off: function() {
                i(["off", c.call(arguments)])
            },
            get: function() {
                if (!e._h) throw new Error("[LiveChatWidget] You can't use getters before load.");
                return i(["get", c.call(arguments)])
            },
            call: function() {
                i(["call", c.call(arguments)])
            },
            init: function() {
                var n = t.createElement("script");
                n.async = !0, n.type = "text/javascript", n.src = "https://cdn.livechatinc.com/tracking.js", t.head.appendChild(n)
            }
        };
        !n.__lc.asyncInit && e.init(), n.LiveChatWidget = n.LiveChatWidget || e
    }(window, document, [].slice))
</script>
<noscript><a href="https://www.livechatinc.com/chat-with/12355524/" rel="nofollow">Chat with us</a>, powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a></noscript>
<!-- End of LiveChat code -->