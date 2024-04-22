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
	
	$(".ubah-jumlah").on("click", function () {
        // alert("ubahjumlah");
        let id = $(this).data('idnya');
        let jumlah = $(this).data('jumlahnya');
        $(".modal-body #modal_id").val(id);
        $(".modal-body #modal_jumlah").val(jumlah);

    });

    $('.select2').select2()
    document.getElementById("cbpoli").disabled=true;
    document.getElementById("alat").disabled=true;
    document.getElementById("kondisi").disabled=true;
    document.getElementById("pengantar").disabled=true;
    document.getElementById("perawatjaga").disabled=true;
    document.getElementById("petugascssd").disabled=true;
    document.getElementById("satuan").disabled=true;
    document.getElementById("petugaspacking").disabled=true;
    document.getElementById("petugasdekontaminasi").disabled=true;
    document.getElementById("petugaspengering").disabled=true;
    document.getElementById("statussterilisasi").disabled=true;

    document.getElementById("jam_masuk_steril").disabled=true;
    document.getElementById("jam_selesai_steril").disabled=true;
    document.getElementById("lama_steril").disabled=true;
    document.getElementById("petugassterilisasi").disabled=true;
    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];

});
