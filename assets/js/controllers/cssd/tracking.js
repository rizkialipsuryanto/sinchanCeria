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

    $('.select2').select2()
    // document.getElementById("cbpoli").disabled=true;
    // document.getElementById("alat").disabled=true;
    // document.getElementById("kondisi").disabled=true;
    // document.getElementById("pengantar").disabled=true;
    // document.getElementById("perawatjaga").disabled=true;
    // document.getElementById("petugascssd").disabled=true;

    // document.getElementById("petugaspacking").disabled=true;
    // document.getElementById("petugasdekontaminasi").disabled=true;
    // document.getElementById("petugaspengering").disabled=true;
    // document.getElementById("statussterilisasi").disabled=true;

    // document.getElementById("jam_masuk_steril").disabled=true;
    // document.getElementById("jam_selesai_steril").disabled=true;
    // document.getElementById("lama_steril").disabled=true;
    // document.getElementById("petugassterilisasi").disabled=true;
    // document.getElementById("petugas_yg_menyerahkan").disabled=true;
    // document.getElementById("pengambil").disabled=true;
    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];

    $(".btn-cetak-konfirmasi-cssd").on("click", function () {
        let bulan = $("#bulan").val();
        if (!bulan) {
            Swal.fire({
                type: "error",
                title: "Bulan Belum Di Pilih",
                footer: "<a href>RSUD AJIBARANG</a>"
            });
        } else {
            PopupCenter(
                baseUrl + "/cetak/LaporanKonfirmasi/" + bulan,
                "xtf",
                "1250",
                "750"
            );
        }

    });
});
