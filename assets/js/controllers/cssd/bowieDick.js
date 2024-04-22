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

    $(".transaksi-detail").on("click", function () {
        let id = $(this).data('idnya');
        let sksterilisasi = $(this).data('sksterilisasi');
        let userid = $(this).data('userid');

        $(".modal-body #modal_id").val(id);
        $(".modal-body #statuskeberhasilansterilisasi").val(sksterilisasi);
        $(".modal-body #user").val(userid);

        // if(dtt==='T'){
        //     document.getElementById('form-nondtt').style.visibility = '';
        // }
        // if(dtt==='Y'){
        //     document.getElementById('form-nondtt').style.visibility = 'hidden';
        // }
    });

});
