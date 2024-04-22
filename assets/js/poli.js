"use strict";

$(function() {
	$(".add_cart").on("click", function() {
		let idx = $(this).data("idx");
		let idtmno = $(this).data("idtmno");
		let keterangan = $(this).data("keterangan");

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		let data = {
			idx: idx,
			idtmno: idtmno,
			keterangan: keterangan
		};

		$.ajax({
			url: baseUrl + "/poli/tambahcart",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".hapus_cart").on("click", function() {
		let idx = $(this).data("idx");
		let idtmno = $(this).data("idtmno");
		let idxbayar = $(this).data("idxbayar");

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/poli/hapuscart",
			method: "POST",
			data: {
				idxbayar: idxbayar,
				idtmno: idtmno
			},
			success: function(data, textStatus, jqXHR) {
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".simpanBilling").on("click", function() {
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
			url: baseUrl + "/poli/simpanCartToBilling",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				//
				let obj = $.parseJSON(data);
				console.log(obj);

				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("AJAX call failed.");
			}
		});
	});

	$(".hapus_pelayanan_tmno").on("click", function() {
		let idx = $(this).data("idx");
		let idtmno = $(this).data("idtmno");
		let id = $(this).data("id");

		let data = {
			idx: idx,
			idtmno: idtmno,
			id: id
		};

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/poli/hapus_y_tindakan_diagnosa_tindakan",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".tampilRiwayatPemeriksaan").on("click", function() {
		let idx = $(this).data("idx");
		let nomr = $(this).data("nomr");

		let data = {
			idx: idx,
			nomr: nomr
		};

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			type: "POST",
			url: baseUrl + "/poli/riwayatPelayanan",
			data: data,
			success: function(data, textStatus, jqXHR) {
				$("#riwayatPemerikasaan").html(data);
			},
			error: function(jqXHR, textStatus, errorThrown) {}
		});
	});

	$(".add_cart_tind_keperawatan").on("click", function() {
		let idx = $(this).data("idx");
		let idtmo = $(this).data("idtmno");
		let keterangan = $(this).data("keterangan");

		let data = {
			idx: idx,
			idtmo: idtmo,
			keterangan: keterangan
		};

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		console.log(data);
		$.ajax({
			url: baseUrl + "/poli/tambahcarttindkeperawatanpoli",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				//console.log(data);
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".simpanBillingTindakanKeperawatanPoli").on("click", function() {
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

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		//console.log(data);
		$.ajax({
			url: baseUrl + "/poli/simpanCartToBillingTindakanKeperawatan",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				let obj = $.parseJSON(data);
				console.log(obj);

				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("AJAX call failed.");
			}
		});
	});

	$(".add_cart_orderlab").on("click", function() {
		var idx = $(this).data("idx");
		var idtmno = $(this).data("idtmno");
		var keterangan = $(this).data("keterangan");

		let data = {
			idx: idx,
			idtmno: idtmno,
			keterangan: keterangan
		};

		//console.log(data);

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/poli/tambahcartlab",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				//console.log(data);
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".hapus_pelayanan_tmno_keperawatan").on("click", function() {
		let idx = $(this).data("idx");
		let idtmno = $(this).data("idtmno");
		let id = $(this).data("id");

		let data = {
			idx: idx,
			idtmno: idtmno,
			id: id
		};

		console.log(data);

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/poli/hapus_y_tindakan_keperawatan",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".simpanBillingPelayananLaborat").on("click", function() {
		var nomr = $(this).data("nomr");
		var shift = $(this).data("shift");
		var nip = $(this).data("nip");
		var idxdaftar = $(this).data("idxdaftar");
		var tanggal = $(this).data("tanggal");
		var lunas = $(this).data("lunas");
		var jambayar = $(this).data("jambayar");
		var ip = $(this).data("ip");
		var kdcarabayar = $(this).data("kdcarabayar");
		var poli = $(this).data("poli");
		var aps = $(this).data("aps");
		var unit = $(this).data("unit");

		var data = {
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
			url: baseUrl + "/poli/simpanCartPelayananLaborat",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				var obj = $.parseJSON(data);
				console.log(obj);

				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("AJAX call failed.");
			}
		});
	});

	$(".hapus_pelayanan_laboratorium").on("click", function() {
		let idx = $(this).data("idx");
		let idtmno = $(this).data("idtmno");
		let id = $(this).data("id");

		let data = {
			idx: idx,
			idtmno: idtmno,
			id: id
		};

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/poli/hapus_y_tindakan_laboratorium",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});
	$(".hapus_pelayanan_radiologi").on("click", function() {
		let idx = $(this).data("idx");
		let idtmno = $(this).data("idtmno");
		let id = $(this).data("id");

		let data = {
			idx: idx,
			idtmno: idtmno,
			id: id
		};

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/poli/hapus_y_tindakan_radiologi",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".add_cart_orderrad").on("click", function() {
		var idx = $(this).data("idx");
		var idtmno = $(this).data("idtmno");
		var keterangan = $(this).data("keterangan");

		let data = {
			idx: idx,
			idtmno: idtmno,
			keterangan: keterangan
		};

		console.log(data);

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/poli/tambahcartrad",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				//console.log(data);
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});

	$(".simpanBillingPelayananRadiologi").on("click", function() {
		var nomr = $(this).data("nomr");
		var shift = $(this).data("shift");
		var nip = $(this).data("nip");
		var idxdaftar = $(this).data("idxdaftar");
		var tanggal = $(this).data("tanggal");
		var lunas = $(this).data("lunas");
		var jambayar = $(this).data("jambayar");
		var ip = $(this).data("ip");
		var kdcarabayar = $(this).data("kdcarabayar");
		var poli = $(this).data("poli");
		var aps = $(this).data("aps");
		var unit = $(this).data("unit");

		var data = {
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

		console.log(data);

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			url: baseUrl + "/poli/simpanCartPelayananRadiologi",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				var obj = $.parseJSON(data);
				console.log(obj);

				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("AJAX call failed.");
			}
		});
	});

	$(".catat_mulai").on("click", function() {
		let idx = $(this).data("idx");
		let data = {
			idx: idx
		};

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		$.ajax({
			type: "POST",
			url: baseUrl + "/poli/masukpoli",
			data: data,
			success: function(data, textStatus, jqXHR) {
				let obj = $.parseJSON(data);
				console.log(obj);
				$(".catat_mulai").hide();
				$("#waktumulai").html(
					'<div id="waktumulai"  name="waktumulai"><label class = "text-danger"><strong>' +
						obj +
						"</strong></label></div>"
				);
			},
			error: function(jqXHR, textStatus, errorThrown) {}
		});
	});

	$(".catat_selesai").on("click", function() {
		let idx = $(this).data("idx");
		let data = {
			idx: idx
		};

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];
		$.ajax({
			type: "POST",
			url: baseUrl + "/poli/keluarpoli",
			data: data,
			success: function(data, textStatus, jqXHR) {
				let obj = $.parseJSON(data);
				//console.log(obj);
				$(".catat_selesai").hide();
				$("#waktuselesai").html(
					'<div id="waktuselesai"  name="waktuselesai"><label class = "text-danger"><strong>' +
						obj +
						"</strong></label></div>"
				);
			},
			error: function(jqXHR, textStatus, errorThrown) {}
		});
	});
});
