"use strict";

const baseUrl =
	window.location.protocol +
	"//" +
	window.location.host +
	"/" +
	window.location.pathname.split("/")[1];

function PopupCenter(url, title, w, h) {
	// Fixes dual-screen position                         Most browsers      Firefox
	var dualScreenLeft =
		window.screenLeft != undefined ? window.screenLeft : window.screenX;
	var dualScreenTop =
		window.screenTop != undefined ? window.screenTop : window.screenY;

	var width = window.innerWidth
		? window.innerWidth
		: document.documentElement.clientWidth
			? document.documentElement.clientWidth
			: screen.width;
	var height = window.innerHeight
		? window.innerHeight
		: document.documentElement.clientHeight
			? document.documentElement.clientHeight
			: screen.height;

	var systemZoom = width / window.screen.availWidth;
	var left = (width - w) / 2 / systemZoom + dualScreenLeft;
	var top = (height - h) / 2 / systemZoom + dualScreenTop;
	var newWindow = window.open(
		url,
		title,
		"scrollbars=yes, width=" +
		w / systemZoom +
		", height=" +
		h / systemZoom +
		", top=" +
		top +
		", left=" +
		left
	);

	// Puts focus on the newWindow
	if (window.focus) newWindow.focus();
}

$(function () {

	$(".tanggal").datepicker({
		format: "dd-mm-yyyy"
	});



	$(".transfer-pendaftaran-online").on("click", function () {
		let data = {
			idx: $(this).data("idx"),
			pasienbaru: $(this).data("pasienbaru"),
			nomr: $(this).data("nomr")
		};

		let idx = $(this).data("idx");
		let type = 5;
		window.location =
			baseUrl +
			"/rekammedis/pendaftaranpasienrawatjalan?RGMrOXNGZHl0OGdEZ0lJTCt6RVFtQT09=" +
			type +
			"&cllkbm55RnNzRUQxSWd4V2QxTFFIUT09=" +
			idx;
		//console.log(data);
	});

	$(".tampil-tanda-bukti-pendaftaran-online").on("click", function () {
		let idxpendaftaranonline = $(this).data("idxpendaftaranonline");
		PopupCenter(
			"http://192.168.1.27/regon/cetak/bukti_pendaftaran_online2.php?id_pendaftaran_online=" +
			idxpendaftaranonline +
			"",
			"xtf",
			"900",
			"500"
		);
	});
});
