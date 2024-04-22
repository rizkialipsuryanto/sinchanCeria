"use strict";

$(function () {
    $("#datemask").inputmask("dd-mm-yyyy", { placeholder: "dd-mm-yyyy" });
    $("[data-mask]").inputmask();

    $("#jammask").inputmask("HH-MM", { placeholder: "HH-MM" });
    $("[jam-mask]").inputmask();

    $("#datetimemask").inputmask("yyyy-mm-dd hh:mm", { placeholder: "yyyy-mm-dd hh:mm" });
    $("[data-mask]").inputmask();

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })


    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, locale: { format: 'MM/DD/YYYY hh:mm A' }})

    $('.select2').select2()

    $(".hapus-dailyrecord").on("click", function () {
        let id = $(this).data('id');

        $(".modal-body #modal_id").val(id);
    });

    $(".edit-dailyrecord").on("click", function () {
        let id = $(this).data('id');
        let user_input = $(this).data('user');
        let jam_mulai = $(this).data('jam_mulai');
        let jam_selesai = $(this).data('jam_selesai');
        let tanggal = $(this).data('tanggal');
        let id_tasks_detail = $(this).data('id_tasks_detail');
        let catatan = $(this).data('catatan');
        let jumlah = $(this).data('jumlah');
        let satuan = $(this).data('satuan');
        // let ststerilisasi = $(this).data('ststerilisasi');

        $(".modal-body #modal_id").val(id);
        $(".modal-body #user_input").val(user_input);
        $(".modal-body #jam_mulai").val(jam_mulai);
        $(".modal-body #jam_selesai").val(jam_selesai);
        $(".modal-body #tanggal").val(tanggal);
        $(".modal-body #tasks").val(id_tasks_detail);
        $(".modal-body #catatan").val(catatan);
        $(".modal-body #jumlah").val(jumlah);
        $(".modal-body #satuan").val(satuan);

        
    });

    $(".transaksi-konfirmasi").on("click", function () {
        let id = $(this).data('idnya');
        console.log(id);
        $(".modal-body #modal_id").val(id);
    });
});
