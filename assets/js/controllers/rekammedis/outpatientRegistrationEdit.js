"use strict";

let baseUrl =
	window.location.protocol +
	"//" +
	window.location.host +
	"/" +
	window.location.pathname.split("/")[1];
$(function () {
	$(".btnCekKepesertaan").on("click", function () {
		var noKa = $("#nokabpjs").val();
		if (noKa) {
			let payload = {
				type: 2,
				noKartu: noKa
			};

			$.ajax({
				url: baseUrl + "/rekammedis/kepesertaan",
				method: "POST",
				data: payload,
				dataType: "json",
				success: function (data) {
					Swal.fire({
						type: data.type,
						title: data.message,
						html: data.html,
						footer:
							"<a href>Periksa Kembali Nomer Kartu BPJS yang di masukan</a>"
					});
				}
			});
		} else {
			Swal.fire({
				type: "error",
				title: "Nomer Kartu BPJS Belum Diisi",
				footer: "<a href>Periksa Kembali Nomer Kartu BPJS yang di masukan</a>"
			});
		}
	});

	$(".btnCekRujukan").on("click", function () {
		let noRujukan = $("#tx_no_rujukan_bpjs").val();
		if (noRujukan) {
			let faskes2;
			if ($("#faskes2").is(":checked")) {
				faskes2 = 1;
			} else {
				faskes2 = 0;
			}

			let rujukan = {
				faskes: faskes2,
				noRujukan: noRujukan
			};
			$.ajax({
				url: baseUrl + "/rekammedis/getRujukanByNoRujukan",
				method: "POST",
				data: rujukan,
				dataType: "json",
				success: function (data) {
					Swal.fire({
						type: data.type,
						title: data.title,
						html: data.html,
						footer: "<a href>RSUD AJIBARANG</a>"
					});
				}
			});
		} else {
			Swal.fire({
				type: "error",
				title: "Nomer Rujukan Belum Diisi",
				footer: "<a href>Periksa Kembali Nomer Kartu BPJS yang di masukan</a>"
			});
		}
	});
	//

	$(".hapus-pendaftaran").on("click", function () {
		let idx = $(this).data("idx");
		alert(idx);
	});

	$("input[type=radio][name=rbParentCarabayar]").on("click", function () {
		let payplan = this.value;
		if (payplan == 1) {
			$(".detail_jaminan_bpjs").hide();
		} else {
			$(".detail_jaminan_bpjs").show();
		}
	});

	$("#cb_poly").change(function () {
		let kodepoli = $(this).val();

		$.ajax({
			url: baseUrl + "/rekammedis/getDokterJaga",
			method: "POST",
			data: {
				kodepoli: kodepoli
			},
			dataType: "json",
			success: function (data) {
				$(".listdokter_jaga")
					.empty()
					.append(data);
			}
		});
	});

	$(".konfirmhapus").on("click", function () {
		let idx = $(this).data("idx");

		Swal.fire({
			title: "Apakah Kamu Yakin ?",
			text: "Proses ini akan membatalkan Pendaftaran Pasien",
			type: "warning",
			showCancelButton: true,
			confirmButtonColor: "#3085d6",
			cancelButtonColor: "#d33",
			confirmButtonText: "Yes, Batalkan Pendaftaran!"
		}).then(result => {
			// menghasilkan nilai true

			if (result.value) {
				let data = {
					idx: idx
				};
				$.ajax({
					type: "POST",
					url: baseUrl + "/rekammedis/cancelOutpatientRegistration",
					data: data,
					success: function (data, textStatus, jqXHR) {
						console.log(data);
						let obj = $.parseJSON(data);
						console.log(obj);
						// Swal.fire({
						// 	type: obj.type,
						// 	title: obj.code,
						// 	text: obj.message
						// });
						location.reload();
					},
					error: function (jqXHR, textStatus, errorThrown) {
						//
					}
				});
			}
		});
	});

	// $(".btn-ubah-data-pendaftaran").on("click", function () {
	// 	alert("eded");
	// });
});
