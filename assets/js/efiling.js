"use strict";

$(function () {
	let baseUrl =
		window.location.protocol +
		"//" +
		window.location.host +
		"/" +
		window.location.pathname.split("/")[1];

	$(".cetakGelang").on("click", function () {
		let id = $(this).data("id");

		if (id) {
			window.location.href =
				baseUrl + "/efiling/konfirmasiEfiling/2/" + id + "";
		}
	});

	$(".refresh-data").on("click", function () {

		let path = $(this).data("path");
		let segment = $(this).data("segment");
		//
		$.ajax({
			url: baseUrl + "/efiling/hapuscache/" + path + "/" + segment + "",
			method: "GET",
			dataType: "json",
			success: function (data) {
				console.log("sukses");
				console.log(data);
			}, error: function () {
				alert('error!');
			}
		});

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
				baseUrl + "/efiling/outPatientRegistrationEdit/" + id + "";
		}
	});
});
