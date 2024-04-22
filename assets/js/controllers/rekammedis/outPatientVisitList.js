"use strict";

$(function () {
    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];

    $(".outPatientConfirmationRegistration").on("click", function () {
        let id = $(this).data("id");

        if (id) {
            window.location.href =
                baseUrl + "/rekammedis/konfirmasipendaftaran/2/" + id + "";
        }
    });

    $(".pilian-menu-rawat-jalan").click(function (e) {
        let idx = $(this).data("idx");
        e.preventDefault();
        var mymodal = $("#modal-menuOptionsForOutpatientRegistration");
        mymodal.find(".modal-body").text("hello");
        mymodal.modal("show");
    });

    $(".edit-outpatient-registration").on("click", function () {
        let id = $(this).data("id");

        if (id) {
            window.location.href =
                baseUrl + "/rekammedis/outPatientRegistrationEdit/" + id + "";
        }
    });
});
