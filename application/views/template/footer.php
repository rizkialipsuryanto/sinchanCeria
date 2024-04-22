</div>
<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © <?= date('Y'); ?> <a href="https://www.esensiana.com/" target="_blank">esensiana digital tech</a>. All rights reserved.</span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="mdi mdi-heart text-danger"></i></span>
    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->


</div>
<!-- container-scroller -->

<!-- plugins:js -->
<script src="<?= base_url('assets/'); ?>vendors/js/vendor.bundle.base.js"></script>
<script src="<?= base_url('assets/'); ?>vendors/js/vendor.bundle.addons.js"></script>
<!-- endinject -->
<!-- Plugin js for this page-->
<!-- End plugin js for this page-->
<!-- inject:js -->
<script src="<?= base_url('assets/'); ?>js/off-canvas.js"></script>
<script src="<?= base_url('assets/'); ?>js/misc.js"></script>
<!-- endinject -->
<!-- Custom js for this page-->
<script src="<?= base_url('assets/'); ?>js/dashboard.js"></script>
<!-- End custom js for this page-->


<script src="<?= base_url('vendor/bootstrap-datepicker/js/'); ?>bootstrap-datepicker.js"></script>
<!-- jQuery 3 -->
<script src="<?= base_url('assets/'); ?>AdminLTE/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= base_url('assets/'); ?>AdminLTE/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Select2 -->
<script src="<?= base_url('assets/'); ?>AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>


</body>

</html>

<script>
  


    function loadkota() {


        var hidden_prov = $('#hidden_prov').val();
        var hidden_kota = $('#hidden_kota').val();
        var hidden_kec = $('#hidden_kec').val();
        var hidden_kel = $('#hidden_kel').val();

        if (hidden_prov != '') {
            $.ajax({
                url: "<?php echo base_url('rekammedis/'); ?>fetch_kota",
                method: "POST",
                dataType: 'json',
                data: {
                    idprovinsi: hidden_prov
                },
                success: function(data) {
                    //$("#provinsi option[value=" + hidden_prov + "]").attr('selected', 'selected').trigger('change');
                    var html = '';
                    var i_prov;
                    html += '<select id="kabupaten" name="kabupaten" class="form-control form-control-sm"> <option value="">Pilih Kabupaten/Kota</option>';
                    if (data.length > 0) {
                        for (i_prov = 0; i_prov < data.length; i_prov++) {
                            if (hidden_kota == data[i_prov].idkota) {
                                var select_prov = "selected=Selected";
                            } else {
                                var select_prov = "";
                            }
                            html += '<option value = ' + data[i_prov].idkota + '  ' + select_prov + '  >' + data[i_prov].namakota + '</option>';
                        }
                    }
                    html += '</select>';
                    $('#kabupaten').html(html);

                }
            });
        }

        if (hidden_kota != '') {
            $("#kabupaten option[value=" + hidden_kota + "]").attr('selected', 'selected').trigger('change');
            $.ajax({
                url: "<?php echo base_url('rekammedis/'); ?>fetch_kecamatan",
                method: "POST",
                dataType: 'json',
                data: {
                    idKabupaten: hidden_kota
                },
                success: function(data) {

                    var html = '';
                    var i_kec;
                    html += '<select id="kecamatan" name="kecamatan" class="form-control form-control-sm"> <option value="">Pilih Kecamatan jquery</option>';
                    if (data.length > 0) {
                        for (i_kec = 0; i_kec < data.length; i_kec++) {
                            if (hidden_kec == data[i_kec].idkecamatan) {
                                var select_kec = "selected=Selected";
                            } else {
                                var select_kec = "";
                            }
                            html += '<option value = ' + data[i_kec].idkecamatan + '  ' + select_kec + '  >' + data[i_kec].namakecamatan + '</option>';
                        }
                    }
                    $('#kecamatan').html(html);
                }
            });
        }
        if (hidden_kel != '') {
            $.ajax({
                url: "<?php echo base_url('rekammedis/'); ?>fetch_kelurahan",
                method: "POST",
                dataType: 'json',
                data: {
                    idkecamatan: hidden_kec
                },
                success: function(data) {
                    //console.log(data);
                    var html = '';
                    var i_kel;
                    html += '<select id="kelurahan" name="kelurahan" class="form-control form-control-sm"> <option value="">Pilih Kelurahan jquery</option>';
                    if (data.length > 0) {
                        for (i_kel = 0; i_kel < data.length; i_kel++) {
                            if (hidden_kel == data[i_kel].idkelurahan) {
                                var select_kelu = "selected=Selected";
                            } else {
                                var select_kelu = "";
                            }

                            html += '<option value = ' + data[i_kel].idkelurahan + ' ' + select_kelu + '  >' + data[i_kel].namakelurahan + '</option>';
                        }
                    }
                    html += '</select>';

                    $('#kelurahan').html(html);
                }
            });
        }

    }
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });


    $(function() {

        $('.tanggal').datepicker({
            format: "dd-mm-yyyy"
        });

        $('[data-toggle="tooltip"]').tooltip();

        $('.print_kartu').on("click", function() {
            var nomr = this.id;
            $("#MyModalBody").html('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="<?php echo base_url('cetak/'); ?>labelidentitasPasien/' + nomr + '" allowfullscreen></iframe></div>');
        });


        $('.print_tandabukti').on("click", function() {
            var idx = this.id;
            $("#MyModalBody2").html('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="<?php echo base_url('cetak/'); ?>tandabuktipendaftaranrajal/' + idx + '" allowfullscreen></iframe></div>');
        });

        $('.print_cetak_sep ').on("click", function() {
            var idx = this.id;
            $("#MyModalBody_tampil_sep").html('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="<?php echo base_url('cetak/'); ?>cetakSEP/' + idx + '" allowfullscreen></iframe></div>');
        });



        $('.print_gelang_pasien').on("click", function() {
            var nomr = this.id;
            $("#MyModalBody_gelang_pasien").html('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="<?php echo base_url('cetak/'); ?>labelgelangPasien/' + nomr + '" allowfullscreen></iframe></div>');
        });


        $('.input-access').on('click', function() {
            const menuId = $(this).data('menu');
            const roleId = $(this).data('role');
            $.ajax({
                url: "<?= base_url('admin/changeaccess') ?>",
                type: "post",
                data: {
                    menuId: menuId,
                    roleId: roleId
                },
                success: function() {
                    document.location.href = "<?= base_url('admin/roleaccess/') ?>" + roleId;
                }
            });
        });

        $('input[type=radio][name=jeniskunjungan]').change(function() {
            var jeniskunjungan = $(this).val();
            if (jeniskunjungan == 1) {
                $('#nomr').attr('disabled', 'disabled').val('-otomatis-');
            } else {
                $('#nomr').removeAttr('disabled').val('');
            }
        });

        $('input[type=radio][name=carabayar]').change(function() {
            var carabayar = $(this).val();

            if (carabayar == 1) {
                $("#jaminan").slideUp();
                $("#div_kepesertaan_bpjs").slideUp();
            } else {
                $("#jaminan").slideDown();
                $("#div_kepesertaan_bpjs").slideDown();
            }

        });


      


    });

    $(document).ready(function() {
        $('#nomr').attr('disabled', 'disabled').val('-otomatis-');
        load_init()
        loadkota();


    });

</script>
