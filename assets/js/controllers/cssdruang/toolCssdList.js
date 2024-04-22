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


    document.getElementById("nonsterildiv").style.visibility = "hidden";

    $('#cbjenisalat').change(function () {
        // document.getElementById("poli").disabled = true;

        var id = $(this).val();
        // alert(id);

        // console.log("aaa");
        if ((id == 3)) {
            document.getElementById("nonsterildiv").style.visibility = "visible";
        }
        else {
            document.getElementById("nonsterildiv").style.visibility = "hidden";
        }

    });
});
