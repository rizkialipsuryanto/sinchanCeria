"use strict";

var baseUrl =
	window.location.protocol +
	"//" +
	window.location.host +
	"/" +
	window.location.pathname.split("/")[1];


var foreignUrl = "http://192.168.1.178/simrs2/";




function PopupCenter(url, title, w, h) {

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

	$(".input-access-status-bayar-kasir").change(function (event) {


		let id = $(this).val();
		let idx = $(this).data("idx");
		let idbilldetailtarif = $(this).data("idbilldetailtarif");
		let data = {
			id: id,
			idx: idx,
			detailtarif: idbilldetailtarif
		};


		$.ajax({
			type: "POST",
			url: baseUrl + "/api/kasir/ubahStatusPembayaran",
			data: data,
			success: function (data, textStatus, jqXHR) {

				console.log(data);
				// document.location.href = window.location;
				//console.log("dad");
				//console.log(data);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				//console.log(textStatus);
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});



		// alert("ok");
		// let id = $(this).val();
		// const idx = $(this).data("idx");

		// let data = {
		// 	id: id,
		// 	idx: idx
		// };

		// let baseUrl =
		// 	window.location.protocol +
		// 	"//" +
		// 	window.location.host +
		// 	"/" +
		// 	window.location.pathname.split("/")[1];

		// console.log(data);
		// $.ajax({
		// 	type: "POST",
		// 	url: baseUrl + "/kasir/ubahstatusbayarkasir",
		// 	data: data,
		// 	success: function (data, textStatus, jqXHR) {
		// 		document.location.href = window.location;
		// 		//console.log("dad");
		// 		//console.log(data);
		// 	},
		// 	error: function (jqXHR, textStatus, errorThrown) {
		// 		//console.log(textStatus);
		// 		console.log(jqXHR);
		// 		console.log("SEP LOKAl AJAX call failed.");
		// 	}
		// });


		event.preventDefault();
	});





	$(".flag-tagihan-kasir").on("click", function () {
		let tagihan = $(this).data("tagihan");
		let flag = $(this).data("flag");
		let idxdaftar = $(this).data("idxdaftar");
		let nomr = $(this).data("nomr");
		let jenislayanan = $(this).data("jenislayanan");
		let data = {
			idxdaftar: idxdaftar,
			nomr: nomr,
			flag: flag,
			jenislayanan: jenislayanan,
			tagihan: tagihan
		};
		//console.log(data);

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			type: "POST",
			url: baseUrl + "/kasir/lunasbayar",
			data: data,
			success: function (data, textStatus, jqXHR) {
				// console.log(data);
				document.location.href = window.location;
			},
			error: function (jqXHR, textStatus, errorThrown) {
				//console.log(textStatus);
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".hapus_pelayanan_tmno").on("click", function () {
		let idx = $(this).data("idx");
		let idtmno = $(this).data("idtmno");
		let id = $(this).data("id");

		let data = {
			idx: idx,
			idtmno: idtmno,
			id: id
		};

		// console.log(data);
		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/kasir/hapus_y_tindakan_diagnosa_tindakan",
			method: "POST",
			data: data,
			success: function (data, textStatus, jqXHR) {
				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".add_cart").on("click", function (event) {
		//
		Swal.fire({
			title: 'Konfirmasi',
			text: "Apakah Anda Yakin Akan menambah data ini?",
			type: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya,',
			cancelButtonText: 'Tidak'
		}).then((result) => {
			if (result.value) {
				let idx = $(this).data("idx");
				let idpemeriksaanmedis = $(this).data("idpemeriksaanmedis");
				let keterangan = $(this).data("keterangan");

				if (keterangan === undefined || keterangan == null) {
					keterangan = "catatan";
				}

				let data = {
					idx: idx,
					idpemeriksaanmedis: idpemeriksaanmedis,
					keterangan: keterangan
				};


				console.log(data);

				$.ajax({
					url: baseUrl + "/api/kasir/tambahcart",
					method: "POST",
					data: data,
					success: function (data, textStatus, jqXHR) {
						location.reload();
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(jqXHR);
						console.log("SEP LOKAl AJAX call failed.");
					}
				});
			}
		})

		event.preventDefault();
	});

	$(".print_rincian_layanan_rawat_jalan_kasir").on("click", function () {

		//

		let id = $(this).data("iddetailtarif");
		let user = $(this).data("user");

		if (id) {
			PopupCenter(
				// baseUrl + "/cetak/tandabuktipendaftaranrajal/" + idx + "",
				foreignUrl + "cetak/nota_tindakan_kasir.php?id_bill_detail_tarif=" + id + "&user=" + user,
				"xtf",
				"1200",
				"700"
			);
		}

	});

	//
	$(".hapus_cart").on("click", function () {

		Swal.fire({
			title: 'Konfirmasi : Silakan Baca dengan Teliti',
			text: "Apakah Anda Yakin Akan menghapus data ini?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Ya, Saya yakin dan akan mempertanggungjawabkan apapun akibatnya!',
			cancelButtonText: 'Saya Tidak Jadi Menghapus data'
		}).then((result) => {
			if (result.value) {

				let data = {
					idx: $(this).data("idx"),
					iddetailtindakan: $(this).data("iddetailtindakan"),
					idxbayar: $(this).data("idxbayar")
				};

				// console.log(data);

				$.ajax({
					url: baseUrl + "/api/kasir/hapuscart",
					method: "POST",
					data: data,
					success: function (data, textStatus, jqXHR) {
						location.reload();
					},
					error: function (jqXHR, textStatus, errorThrown) {
						console.log(jqXHR);
						Swal.fire(
							'Failed',
							'Proses data gagal',
							'error'
						);
					}
				});
			}
		})

	});

	$(".simpanBilling").on("click", function () {
		let nomr = $(this).data("nomr");
		let shift = $(this).data("shift");
		let nip = $(this).data("nip");
		let idxdaftar = $(this).data("idxdaftar");
		let tanggal = $(this).data("tanggal");
		let lunas = $(this).data("lunas");
		let jambayar = $(this).data("jambayar");
		let ip = $(this).data("ip");
		let kdcarabayar = $(this).data("kdcarabayar");
		let poli = $(this).data("poli");
		let aps = $(this).data("aps");
		let unit = $(this).data("unit");

		let data = {
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
		};

		//console.log(data);

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/kasir/simpanCartToBilling",
			method: "POST",
			data: data,
			success: function (data, textStatus, jqXHR) {
				//
				let obj = $.parseJSON(data);
				console.log(obj);

				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("AJAX call failed.");
			}
		});
	});

	$(".hapus_marking_pembayaran").on("click", function () {
		//data-tagihan="' . $tagihan . '" data-idxdaftar="' . $idxdaftar . '" data-nomr="' . $nomr . '" data-jenislayanan="2" data-flag="' . $flag . '"

		let tagihan = $(this).data("tagihan");
		let idxdaftar = $(this).data("idxdaftar");
		let nomr = $(this).data("nomr");
		let jenislayanan = $(this).data("jenislayanan");
		let flag = $(this).data("flag");

		let data = {
			tagihan: tagihan,
			idxdaftar: idxdaftar,
			nomr: nomr,
			jenislayanan: jenislayanan,
			flag: flag
		};

		//console.log(data);

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/kasir/hapusmarkingPayment",
			method: "POST",
			data: data,
			success: function (data, textStatus, jqXHR) {
				location.reload();
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});
});
