"use strict";

$(function () {
    $("#datemask").inputmask("dd-mm-yyyy", { placeholder: "dd-mm-yyyy" });
    $("[data-mask]").inputmask();

    $("#jammask").inputmask("HH-MM", { placeholder: "HH-MM" });
    $("[jam-mask]").inputmask();

    //Timepicker
    $('.timepicker').timepicker({
        showInputs: false
    })

    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, locale: { format: 'MM/DD/YYYY hh:mm A' } })

    $('.select2').select2()
    document.getElementById("poli").disabled = true;
    document.getElementById("alat").disabled = true;
    document.getElementById("cbset").disabled = true;
    // if(poli=="40")
    //         {
    //             document.getElementById("penanggungjawabinstrumen").disabled = false;
    //         }
    //         else
    //         {
    //             document.getElementById("penanggungjawabinstrumen").disabled = true;
    //         }
    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];

    // console.log("aaa");
    $('#cbjenisalat').change(function () {
        document.getElementById("poli").disabled = true;
        var id = $(this).val();
        alert(id);

        // $('#cbpoli').change(function(){
        // var poli=$(this).val();
        var poli = document.getElementById("cbpoli").value;
        // alert(poli);
        // console.log(poli);
        $.ajax({
            url: baseUrl + "/CssdRuang/get_alat",
            method: "POST",
            data: { id: id, poli: poli },
            async: false,
            dataType: 'json',
            success: function (data) {
                var html = '';
                var i;
                // html += '<option> -- Pilih Alat -- </option>';
                for (i = 0; i < data.length; i++) {
                    // html += '<option> -- Pilih Alat -- </option>';
                    html += '<option value=' + data[i].alat_id + '>' + data[i].nama_alat + '</option>';
                }
                $('.alat').html(html);

            }
        });

        if (id == "") {
            document.getElementById("alat").disabled = true;
        }
        else {
            document.getElementById("alat").disabled = false;
        }

    });

    $('#satuan').change(function () {

        var id = $(this).val();
        // alert(id);
        if ((id == "") || (id == 2)) {
            document.getElementById("cbset").disabled = true;
        }
        else {
            document.getElementById("cbset").disabled = false;
        }

    });

    $('#cbjenisalattambahan').change(function () {
        document.getElementById("poli").disabled = true;
        var id = $(this).val();
        // alert(id);

        // $('#cbpoli').change(function(){
        // var poli=$(this).val();
        var poli = document.getElementById("cbpoli").value;
        // alert(poli);
        // console.log(poli);
        $.ajax({
            url: baseUrl + "/CssdRuang/get_alat",
            method: "POST",
            data: { id: id, poli: poli },
            async: false,
            dataType: 'json',
            success: function (data) {
                var html = '';
                var i;
                // html += '<option> -- Pilih Alat -- </option>';
                for (i = 0; i < data.length; i++) {
                    // html += '<option> -- Pilih Alat -- </option>';
                    html += '<option value=' + data[i].alat_id + '>' + data[i].nama_alat + '</option>';
                }
                $('.alattambahan').html(html);

            }
        });

        if (id == "") {
            document.getElementById("alattambahan").disabled = true;
        }
        else {
            document.getElementById("alattambahan").disabled = false;
        }

    });

    $('#cbjenisalata').change(function () {

        var id = $(this).val();
        alert(id);

        console.log("aaa");
        // if ((id == "") || (id == 2)) {
        //     document.getElementById("cbset").disabled = true;
        // }
        // else {
        //     document.getElementById("cbset").disabled = false;
        // }

    });
});
