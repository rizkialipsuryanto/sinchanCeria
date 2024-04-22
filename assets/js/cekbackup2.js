$(function() {


    $('.tanggal').datepicker({
      format: "dd-mm-yyyy"
    });

    $('.custom-file-input').on('change', function() {
      let fileName = $(this).val().split('\\').pop();
      $(this).next('.custom-file-label').addClass("selected").html(fileName);
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



    $(".flag-tagihan-kasir").on("click", function() {
      var tagihan = $(this).data("tagihan");
      var flag = $(this).data("flag");
      var idxdaftar = $(this).data("idxdaftar");
      var nomr = $(this).data("nomr");
      var jenislayanan = $(this).data("jenislayanan");
      var data = {
        idxdaftar: idxdaftar,
        nomr: nomr,
        flag: flag,
        jenislayanan: jenislayanan,
        tagihan: tagihan
      };
      //console.log(data);
      $.ajax({
        type: "POST",
        url: '<?= base_url('kasir/lunasbayar') ?>',
        data: data,
        success: function(data, textStatus, jqXHR) {
          // console.log(data);
          document.location.href = window.location;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          //console.log(textStatus);
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });
    });




    $('.catat_mulai').on("click", function() {

      let idx = $(this).data('idx');
      let data = {
        idx: idx
      };

      $.ajax({
        type: "POST",
        url: '<?= base_url('poli/masukpoli') ?>',
        data: data,
        success: function(data, textStatus, jqXHR) {
          let obj = $.parseJSON(data);
          console.log(obj);
          $(".catat_mulai").hide();
          $("#waktumulai").html('<div id="waktumulai"  name="waktumulai"><label class = "text-danger"><strong>' + obj + '</strong></label></div>');

        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
      });

    });
    $('.catat_selesai').on("click", function() {

      let idx = $(this).data('idx');
      let data = {
        idx: idx
      };

      $.ajax({
        type: "POST",
        url: '<?= base_url('poli/keluarpoli') ?>',
        data: data,
        success: function(data, textStatus, jqXHR) {
          let obj = $.parseJSON(data);
          //console.log(obj);
          $(".catat_selesai").hide();
          $("#waktuselesai").html('<div id="waktuselesai"  name="waktuselesai"><label class = "text-danger"><strong>' + obj + '</strong></label></div>');

        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
      });

    });

    $('.input-access-status-bayar-kasir').change(function() {
      //console.log("radio clicked!");
      var id = $(this).val();
      const idx = $(this).data('idx');

      var data = {
        id: id,
        idx: idx
      };

      console.log(data);
      $.ajax({
        type: "POST",
        url: '<?= base_url('kasir/ubahstatusbayarkasir') ?>',
        data: data,
        success: function(data, textStatus, jqXHR) {

          document.location.href = window.location;
        },
        error: function(jqXHR, textStatus, errorThrown) {
          //console.log(textStatus);
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });
    });



    $(".add_cart").on("click", function() {


      var idx = $(this).data("idx");
      var idtmno = $(this).data("idtmno");
      var keterangan = $(this).data("keterangan");

      let data = {
        idx: idx,
        idtmno: idtmno,
        keterangan: keterangan
      };

      console.log(data);
      $.ajax({
        url: "<?= base_url('kasir/tambahcart'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });
    });


    $(".add_cart_orderrad").on("click", function() {

      var idx = $(this).data("idx");
      var idtmno = $(this).data("idtmno");
      var keterangan = $(this).data("keterangan");

      let data = {
        idx: idx,
        idtmno: idtmno,
        keterangan: keterangan
      }


      console.log(data);

      $.ajax({
        url: "<?= base_url('kasir/tambahcartrad'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {
          //console.log(data);
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });



    });


    
    $(".add_cart_orderlab").on("click", function() {


      var idx = $(this).data("idx");
      var idtmno = $(this).data("idtmno");
      var keterangan = $(this).data("keterangan");

      let data = {
        idx: idx,
        idtmno: idtmno,
        keterangan: keterangan
      }


      //console.log(data);


      $.ajax({
        url: "<?= base_url('kasir/tambahcartlab'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {
          //console.log(data);
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });


    });


    $(".add_cart_tmo").on("click", function() {
      let idx = $(this).data("idx");
      let idtmo = $(this).data("idtmo");
      let keterangan = $(this).data("keterangan");

      let data = {
        idx: idx,
        idtmo: idtmo,
        keterangan: keterangan
      }

      $.ajax({
        url: "<?= base_url('kasir/tambahcarttmno'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {
          //console.log(data);
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });


    });

    $(".add_cart_tind_keperawatan").on("click", function() {
      let idx = $(this).data("idx");
      let idtmo = $(this).data("idtmno");
      let keterangan = $(this).data("keterangan");

      let data = {
        idx: idx,
        idtmo: idtmo,
        keterangan: keterangan
      }
      console.log(data);
      $.ajax({
        url: "<?= base_url('kasir/tambahcarttindkeperawatanpoli'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {
          //console.log(data);
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });


    });


    // $(".tampil_tarif").on("click", function() {

    //   var kodepoli = $(this).data("kd");

    //   $(".halaman_list_tarif").load("<?= base_url('tarif/tarifdetailpoliklinik/3/') ?>");
    // });




    $(".hapus_cart").on("click", function() {
      var idx = $(this).data("idx");
      var idtmno = $(this).data("idtmno");
      var idxbayar = $(this).data("idxbayar");

      $.ajax({
        url: "<?= base_url('kasir/hapuscart'); ?>",
        method: "POST",
        data: {
          idxbayar: idxbayar,
          idtmno: idtmno
        },
        success: function(data, textStatus, jqXHR) {
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });

    });



    $(".hapus_marking_pembayaran").on("click", function() {

      //data-tagihan="' . $tagihan . '" data-idxdaftar="' . $idxdaftar . '" data-nomr="' . $nomr . '" data-jenislayanan="2" data-flag="' . $flag . '"

      var tagihan = $(this).data("tagihan");
      var idxdaftar = $(this).data("idxdaftar");
      var nomr = $(this).data("nomr");
      var jenislayanan = $(this).data("jenislayanan");
      var flag = $(this).data("flag");



      data = {
        tagihan: tagihan,
        idxdaftar: idxdaftar,
        nomr: nomr,
        jenislayanan: jenislayanan,
        flag: flag
      };


      //console.log(data);

      $.ajax({
        url: "<?= base_url('kasir/hapusmarkingPayment'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });

    });

    $(".hapus_pelayanan_tmno").on("click", function() {
      var idx = $(this).data("idx");
      var idtmno = $(this).data("idtmno");
      var id = $(this).data("id");

      var data = {
        idx: idx,
        idtmno: idtmno,
        id: id
      };

      // console.log(data);

      $.ajax({
        url: "<?= base_url('kasir/hapus_y_tindakan_diagnosa_tindakan'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {
          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('SEP LOKAl AJAX call failed.');
        }
      });

    });

    $(".simpanBillingTMNO").on("click", function() {

      var nomr = $(this).data("nomr");
      var shift = $(this).data("shift");
      var nip = $(this).data("nip");
      var idxdaftar = $(this).data("idxdaftar");
      var tanggal = $(this).data("tanggal");
      var lunas = $(this).data("lunas");
      var jambayar = $(this).data("jambayar");
      var ip = $(this).data("ip");
      var kdcarabayar = $(this).data("kdcarabayar");
      var poli = $(this).data("poli");
      var aps = $(this).data("aps");
      var unit = $(this).data("unit");


      var data = {
        nomr: nomr,
        shift: shift,
        nip: nip,
        idxdaftar: idxdaftar,
        tanggal: tanggal,
        lunas: lunas,
        jambayar: jambayar,
        ip: ip,
        kdcarabayar: kdcarabayar,
        poli: poli,
        aps: aps,
        unit: unit
      }


      //console.log(data);


      $.ajax({
        url: "<?= base_url('kasir/simpanCartToBillingTmo'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {

          //
          var obj = $.parseJSON(data);
          console.log(obj);

          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('AJAX call failed.');
        }
      });
    });

    $(".simpanBilling").on("click", function() {


      var nomr = $(this).data("nomr");
      var shift = $(this).data("shift");
      var nip = $(this).data("nip");
      var idxdaftar = $(this).data("idxdaftar");
      var tanggal = $(this).data("tanggal");
      var lunas = $(this).data("lunas");
      var jambayar = $(this).data("jambayar");
      var ip = $(this).data("ip");
      var kdcarabayar = $(this).data("kdcarabayar");
      var poli = $(this).data("poli");
      var aps = $(this).data("aps");
      var unit = $(this).data("unit");


      var data = {
        nomr: nomr,
        shift: shift,
        nip: nip,
        idxdaftar: idxdaftar,
        tanggal: tanggal,
        lunas: lunas,
        jambayar: jambayar,
        ip: ip,
        kdcarabayar: kdcarabayar,
        poli: poli,
        aps: aps,
        unit: unit
      }


      //console.log(data);

      $.ajax({
        url: "<?= base_url('kasir/simpanCartToBilling'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {

          //
          var obj = $.parseJSON(data);
          console.log(obj);

          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('AJAX call failed.');
        }
      });

    });

    $(".statuspulangpoli").on("change", function() {
      let value = $(this).val();
      // alert(value);
      if (value == 2) {
        console.log("RUJUK RAWAT INAP");
        $('#div_cb_kamarinap').show();
      } else {
        $('#div_cb_kamarinap').hide();
      }

      // if (value == 5) {

      // }else{

      // }




      //  else if (value == 5) {
      //   console.log("RUJUK POLI LAIN");
      // } else if (value == 12) {
      //   console.log("RUJUK KE VK");
      // } else if (value == 4) {
      //   console.log("RUJUK KE OP");
      // } else if (value == 13) {
      //   console.log("RUJUK KE IGD");
      // }

      //$('#cb_kamarinap').hide();
    });

    $('#cb_poli_konsul').on('change', function() {
      //let value = $(this).val();

      var data = {
        value: $(this).val()
      }


      $.ajax({
        type: "POST",
        url: '<?= base_url('poli/caridokterjaga') ?>',
        data: data,
        success: function(data, textStatus, jqXHR) {
          $("#dokter_konsul").html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
      });
    });


    $('.koreksi_konsul').on('change', function() {
      // let value = $(this).val();
      // alert(value);

      if (this.checked) {
        console.log("cek");
        $('#poli_konsul').show();
      } else {
        console.log("un cek");
        $('#poli_konsul').hide();
      }
    });



    $(".simpanBillingTindakanKeperawatanPoli").on("click", function() {
      var nomr = $(this).data("nomr");
      var shift = $(this).data("shift");
      var nip = $(this).data("nip");
      var idxdaftar = $(this).data("idxdaftar");
      var tanggal = $(this).data("tanggal");
      var lunas = $(this).data("lunas");
      var jambayar = $(this).data("jambayar");
      var ip = $(this).data("ip");
      var kdcarabayar = $(this).data("kdcarabayar");
      var poli = $(this).data("poli");
      var aps = $(this).data("aps");
      var unit = $(this).data("unit");


      var data = {
        nomr: nomr,
        shift: shift,
        nip: nip,
        idxdaftar: idxdaftar,
        tanggal: tanggal,
        lunas: lunas,
        jambayar: jambayar,
        ip: ip,
        kdcarabayar: kdcarabayar,
        poli: poli,
        aps: aps,
        unit: unit
      }

      //console.log(data);
      $.ajax({
        url: "<?= base_url('kasir/simpanCartToBillingTindakanKeperawatan'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {

          var obj = $.parseJSON(data);
          console.log(obj);

          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('AJAX call failed.');
        }
      });
    });





    $(".tampilRiwayatPemeriksaan").on("click", function() {
      let idx = $(this).data('idx');
      let nomr = $(this).data('nomr');

      let data = {
        idx: idx,
        nomr: nomr
      };

      //alert(idx);
      // console.log(data);
      $.ajax({
        type: "POST",
        url: '<?= base_url('poli/riwayatPelayanan') ?>',
        data: data,
        success: function(data, textStatus, jqXHR) {
          // let obj = $.parseJSON(data);
          // console.log(obj);
          // // $(".catat_mulai").hide();
          $("#riwayatPemerikasaan").html(data);
        },
        error: function(jqXHR, textStatus, errorThrown) {

        }
      });

    });





    $(".simpanBillingPelayananRadiologi").on("click", function() {
      var nomr = $(this).data("nomr");
      var shift = $(this).data("shift");
      var nip = $(this).data("nip");
      var idxdaftar = $(this).data("idxdaftar");
      var tanggal = $(this).data("tanggal");
      var lunas = $(this).data("lunas");
      var jambayar = $(this).data("jambayar");
      var ip = $(this).data("ip");
      var kdcarabayar = $(this).data("kdcarabayar");
      var poli = $(this).data("poli");
      var aps = $(this).data("aps");
      var unit = $(this).data("unit");


      var data = {
        nomr: nomr,
        shift: shift,
        nip: nip,
        idxdaftar: idxdaftar,
        tanggal: tanggal,
        lunas: lunas,
        jambayar: jambayar,
        ip: ip,
        kdcarabayar: kdcarabayar,
        poli: poli,
        aps: aps,
        unit: unit
      }

      console.log(data);
      $.ajax({
        url: "<?= base_url('kasir/simpanCartPelayananRadiologi'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {

          var obj = $.parseJSON(data);
          console.log(obj);

          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('AJAX call failed.');
        }
      });
    });



    $(".simpanBillingPelayananLaborat").on("click", function() {
      var nomr = $(this).data("nomr");
      var shift = $(this).data("shift");
      var nip = $(this).data("nip");
      var idxdaftar = $(this).data("idxdaftar");
      var tanggal = $(this).data("tanggal");
      var lunas = $(this).data("lunas");
      var jambayar = $(this).data("jambayar");
      var ip = $(this).data("ip");
      var kdcarabayar = $(this).data("kdcarabayar");
      var poli = $(this).data("poli");
      var aps = $(this).data("aps");
      var unit = $(this).data("unit");


      var data = {
        nomr: nomr,
        shift: shift,
        nip: nip,
        idxdaftar: idxdaftar,
        tanggal: tanggal,
        lunas: lunas,
        jambayar: jambayar,
        ip: ip,
        kdcarabayar: kdcarabayar,
        poli: poli,
        aps: aps,
        unit: unit
      }

      console.log(data);
      $.ajax({
        url: "<?= base_url('kasir/simpanCartPelayananLaborat'); ?>",
        method: "POST",
        data: data,
        success: function(data, textStatus, jqXHR) {

          var obj = $.parseJSON(data);
          console.log(obj);

          location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          console.log(jqXHR);
          console.log('AJAX call failed.');
        }
      });





    });



    $('.print_cetak_spri').on("click", function() {

      var idxdaftar = $(this).data("idxdaftar");
      var nomr = $(this).data("nomr");
      var nospri = $(this).data("nospri");
      $("#MyModalBody_tampil_sep").html('<div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="<?php echo base_url('cetak/'); ?>cetakSPRI/' + idxdaftar + '/' + nomr + '/' + nospri + '" allowfullscreen></iframe></div>');
    });

    $(document).ajaxStart(function() {
      Pace.restart()
    })
  });



  $(document).ready(function() {

    $('#poli_konsul').hide();
    $('#div_cb_kamarinap').hide();


  });