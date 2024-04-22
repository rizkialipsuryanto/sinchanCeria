"use strict";

let baseUrl =
	window.location.protocol +
	"//" +
	window.location.host +
	"/" +
	window.location.pathname.split("/")[1];



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
	newWindow.opener.location.reload();
	if (window.focus) newWindow.focus();
}

function popitup(url) {
    newwindow=window.open(url,'name','height=700,width=1200');
    if (window.focus) {newwindow.focus()}

      if (!newwindow.closed) {newwindow.focus()}
    return false;
}

function selectedNoSuratKontrol(noSuratKontrol, faskes) {

	let nosuratkontrol = noSuratKontrol;
	let f = faskes;
	$.ajax({
		url: baseUrl + "/api/vclaim/findDetailsSuratKontrol/" + nosuratkontrol + "",
		method: "GET",
		dataType: "json",
		success: function (data) {
			if (data.meta.metaData.code == 200) {
				console.log(data);
				$("#txtnoSurat").val(data.detail.noSuratKontrol);
				$("#tx_kddpjp").val(data.detail.kodeDokter);
				$("#namadpjp").val(data.detail.namaDokter);

			} else {
				Swal.fire({
					type: "error",
					title: data.meta.metaData.message,
					footer: "<a href>RSUD AJIBARANG</a>"
				});
			}
		},
		error: function (err) {
			console.log(err);
			Swal.fire({
				type: "error",
				title: "Gagal Mengambil Data, Silakan Coba Lagi",
				footer: "<a href>RSUD AJIBARANG</a>"
			});
		}
	});
}

function selectedNoSPRI(noSuratKontrol, faskes) {

	let nosuratkontrol = noSuratKontrol;
	let f = faskes;
	$.ajax({
		url: baseUrl + "/api/vclaim/findDetailsSuratKontrol/" + nosuratkontrol + "",
		method: "GET",
		dataType: "json",
		success: function (data) {
			if (data.meta.metaData.code == 200) {
				console.log(data);
				$("#txtnospri").val(data.detail.noSuratKontrol);
				$("#tx_kddpjp").val(data.detail.kodeDokter);
				$("#namadpjp").val(data.detail.namaDokter);

			} else {
				Swal.fire({
					type: "error",
					title: data.meta.metaData.message,
					footer: "<a href>RSUD AJIBARANG</a>"
				});
			}
		},
		error: function (err) {
			console.log(err);
			Swal.fire({
				type: "error",
				title: "Gagal Mengambil Data, Silakan Coba Lagi",
				footer: "<a href>RSUD AJIBARANG</a>"
			});
		}
	});
}


function selectedNoKunjungan(noKunjungan, faskes) {

	let Norujukan = noKunjungan;
	let f = faskes;
	$.ajax({
		url: baseUrl + "/api/rujukan/findDetails/" + Norujukan + "/" + f + "",
		method: "GET",
		dataType: "json",
		success: function (data) {
			if (data.meta.metaData.code == 200) {
				console.log(data);
				$("#txtnorujukan").val(data.detail.rujukan.noKunjungan);
				$("#txtnmpoli").val(data.detail.rujukan.poliRujukan.nama);
				$("#politujuan").val(data.detail.rujukan.poliRujukan.kode);

				// console.log(data.response.rujukan.tglKunjungan);
				// console.log(data.response.rujukan.tglKunjungan);
				console.log(data.detail.rujukan.provPerujuk.kode);
				console.log(data.detail.rujukan.provPerujuk.nama);
				$("#ppkRujukan").val(data.detail.rujukan.provPerujuk.kode);
				$("#txttglrujukan").val(data.detail.rujukan.tglKunjungan);

				$("#tx_nmdiagnosa").val(data.detail.rujukan.diagnosa.nama);
				$("#txt_kddiagnosa").val(data.detail.rujukan.diagnosa.kode);

			} else {
				Swal.fire({
					type: "error",
					title: data.meta.metaData.message,
					footer: "<a href>RSUD AJIBARANG</a>"
				});
			}
		},
		error: function (err) {
			console.log(err);
			Swal.fire({
				type: "error",
				title: "Gagal Mengambil Data, Silakan Coba Lagi",
				footer: "<a href>RSUD AJIBARANG</a>"
			});
		}
	});
}

$(function () {


	$(".sep-toggle").on("click", function () {
		$(".form-sep-advanced").toggle();
	});

	$(".tanda-tangan").on("click", function () {
		//
		let idadmission = $(this).data('idadmission');
		let jenispelayanan = $(this).data('jenispelayanan');
		let nomr = $(this).data('nomr');
		$(".modal-body #modal_idadmission").val(idadmission);
		$(".modal-body #modal_jenispelayanan").val(jenispelayanan);
		$(".modal-body #modal_nomr").val(nomr);
		//console.log(idadmission);
	});

	$(".tanda-tangan-elektronik").on("click", function () {
		//
		let idadmission = $(this).data('idadmission');
		let jenispelayanan = $(this).data('jenispelayanan');
		let nomr = $(this).data('nomr');
		$(".modal-body #modal_idadmission").val(idadmission);
		$(".modal-body #modal_jenispelayanan").val(jenispelayanan);
		$(".modal-body #modal_nomr").val(nomr);
		//console.log(idadmission);
	});

	$(".reg-toggle-button").on("click", function () {

		let idx = $(this).data("idx");

		PopupCenter(
			baseUrl + "/cetak/tandabuktipendaftaranrajal/" + idx + "",
			"xtf",
			"1200",
			"700"
		);
	});

	$(".delete-sep-electronic").on("click", function () {
		let nosep = $(this).data("nosep");
		let user = "RSUD AJIBARANG";
		if (nosep) {
			window.open(baseUrl + "/rekammedis/deleteSepElektronik/" + nosep + "", "_blank ");
		}
	});

	$(".sep-create").on("click", function () {
		let idx = $(this).data("idx");
		let type = $(this).data("type");
		if (idx) {


			// window.location.href = baseUrl + "/rekammedis/SepCreate/" + type + "/" + idx + "";
			// window.location.href = baseUrl + "/rekammedis/outpatientSepPageCreate/" + type + "/" + idx + "";
			window.open(baseUrl + "/rekammedis/outpatientSepPageCreate/" + type + "/" + idx + "", "_blank ");


		}
	});

	$(".sep-igd-create").on("click", function () {
		let idx = $(this).data("idx");
		let type = $(this).data("type");
		if (idx) {


			// window.location.href = baseUrl + "/rekammedis/emergencyPatientSepPageCreate/" + type + "/" + idx + "";
			window.open(baseUrl + "/rekammedis/emergencyPatientSepPageCreate/" + type + "/" + idx + "", "_blank ");

		}
	});

	$(".pengajuan-sep").on("click", function () {
		let jenislayanan = $(this).data("jenislayanan");
		let idx = $(this).data("idx");
		PopupCenter(
			baseUrl + "/rekammedis/pengajuanSEP/" + jenislayanan + "/" + idx + " ",
			"xtf",
			"1250",
			"900"
		);
	});
	$(".pengajuan-sep-ranap").on("click", function () {
		let jenislayanan = $(this).data("jenislayanan");
		let idx = $(this).data("idx");
		PopupCenter(
			baseUrl + "/rekammedis/pengajuanSEP/" + jenislayanan + "/" + idx + " ",
			"xtf",
			"1250",
			"900"
		);
	});

	$(".print-label").on("click", function () {
		let nomr = $(this).data("nomr");
		PopupCenter(
			baseUrl + "/cetak/labelidentitasPasien/" + nomr + "",
			"xtf",
			"900",
			"500"
		);
	});
	$(".print-gelang").on("click", function () {
		let nomr = $(this).data("nomr");
		PopupCenter(
			baseUrl + "/cetak/labelgelangPasien/" + nomr + "",
			"xtf",
			"900",
			"500"
		);
	});

	$(".print-sep").on("click", function () {
		let idx = $(this).data("idx");
		let sep = $(this).data("sep");

		PopupCenter(
			baseUrl + "/cetak/cetakSEP/2/" + sep + "/" + idx + "",
			"xtf",
			"1200",
			"700"
		);
	});

	//
	$(".printout-sep-electronic").on("click", function () {
		let idx = $(this).data("idx");
		let jenislayanan = $(this).data("jenislayanan");
		let nomr = $(this).data("nomr");

		// public function SepDetailprintOut($idadmission, $jenispelayanan, $nomr)

		/*PopupCenter(
			baseUrl + "/cetak/SepDetailprintOut/" + idx + "/" + jenislayanan + "/" + nomr + "",
			"xtf",
			"1200",
			"700"
		);*/
		
		// popitup
		let urls = baseUrl + "/cetak/SepDetailprintOut/" + idx + "/" + jenislayanan + "/" + nomr;
		popitup(urls);
		
		let popup = window.open(baseUrl + "/cetak/SepDetailprintOut/" + idx + "/" + jenislayanan + "/" + nomr,"popup");
		popup.location.reload(true)
		
	});

	$(".printout-sep-electronicnew").on("click", function () {
		let idx = $(this).data("idx");
		let jenislayanan = $(this).data("jenislayanan");
		let nomr = $(this).data("nomr");

		// public function SepDetailprintOut($idadmission, $jenispelayanan, $nomr)

		/*PopupCenter(
			baseUrl + "/cetak/SepDetailprintOut/" + idx + "/" + jenislayanan + "/" + nomr + "",
			"xtf",
			"1200",
			"700"
		);*/
		
		// popitup
		let urls = baseUrl + "/cetak/SepDetailprintOutDouble/" + idx + "/" + jenislayanan + "/" + nomr;
		popitup(urls);
		
		let popup = window.open(baseUrl + "/cetak/SepDetailprintOutDouble/" + idx + "/" + jenislayanan + "/" + nomr,"popup");
		popup.location.reload(true)
		
	});

	$(".print-sep-electronic").on("click", function () {
		let idx = $(this).data("idx");
		let sep = $(this).data("sep");

		PopupCenter(
			baseUrl + "/cetak/cetakSEPBaru/2/" + sep + "/" + idx + "",
			"xtf",
			"1200",
			"700"
		);
	});

	$(".print-sep-rawat-inap").on("click", function () {
		let nomr = $(this).data("nomr");
		let jenispelayanan = $(this).data("jenispelayanan");
		let idadmission = $(this).data("idadmission");

		PopupCenter(
			baseUrl + "/cetak/SepDetailprintOut/" + idadmission + "/" + jenispelayanan + "/" + nomr + "",
			"xtf",
			"1200",
			"700"
		);
	});


	// 

	$(".pembuatan-sep-rawat-inap").on("click", function () {

		Swal.fire({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!'
		}).then((result) => {
			if (result.value) {
				Swal.fire(
					'Deleted!',
					'Your file has been deleted.',
					'success'
				)
			}
		})

	});

	$("#btnCekSuratKontrol").on("click", function () {
			let txtnoSurat = $("#txtnoSurat").val();
			if (txtnoSurat) {
				
				// console.log(txtnoSurat);
	
				let suratkontrol = {
					txtnoSurat: txtnoSurat
				};
				$.ajax({
					url: baseUrl + "/rekammedis/getSuratKontrol",
					method: "POST",
					data: suratkontrol,
					dataType: "json",
					success: function (data) {
						if (data.code == 200) {
						// console.log(data);
						// alert(data.response);
						// alert(data.kodeDokter);
						// console.log(data.response.rujukan.noKunjungan);
							$("#tx_kddpjp").val(data.kodeDokter);
							$("#namadpjp").val(data.namaDokter);
						}
						//if (data.value) {
							
						//}
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

	$("#btnCekSPRI").on("click", function () {
			let txtnospri = $("#txtnospri").val();
			if (txtnospri) {
				
				// console.log(txtnospri);
	
				let suratkontrol = {
					txtnospri: txtnospri
				};
				$.ajax({
					url: baseUrl + "/rekammedis/getSPRI",
					method: "POST",
					data: suratkontrol,
					dataType: "json",
					success: function (data) {
						if (data.code == 200) {
							$("#tx_kddpjp").val(data.kodeDokter);
							$("#namadpjp").val(data.namaDokter);
						}
						//if (data.value) {
							
						//}
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


	$("#txtnmdiagnosa").autocomplete({
		source: baseUrl + "/rekammedis/searchdiagnosa",
		select: function (event, ui) {
			//console.log(ui);
			$('[name="txtnmdiagnosa"]').val(ui.item.label);
			$('[name="txtkddiagnosa"]').val(ui.item.description);
		}
	});


	$("#tx_nmdiagnosa").autocomplete({
		source: baseUrl + "/api/diagnosa/search",
		select: function (event, ui) {
			$('[name="tx_nmdiagnosa"]').val(ui.item.label);
			$('[name="txt_kddiagnosa"]').val(ui.item.description);
		}
	});


	$("#tx_nmdpjp").autocomplete({

		// let jenislayanan = jnsPelayanan
		source: function (req, res) {
			$.ajax({
				url: baseUrl + "/api/dokter/search/1/",
				type: "GET",
				minLength: 2,
				dataType: "json",
				data: {
					search: req.term
				},
				success: function (data) {
					// console.log(data);
					res(data);
				}
			});
		},
		select: function (event, ui) {
			$('[name="tx_nmdpjp"]').val(ui.item.label);
			$('[name="tx_kddpjp"]').val(ui.item.description);
		}
	});

	$("#tx_nmdpjpinap").autocomplete({

		// let jenislayanan = jnsPelayanan
		source: function (req, res) {
			$.ajax({
				url: baseUrl + "/api/dokter/search/1/",
				type: "GET",
				minLength: 2,
				dataType: "json",
				data: {
					search: req.term
				},
				success: function (data) {
					// console.log(data);
					res(data);
				}
			});
		},
		select: function (event, ui) {
			$('[name="tx_nmdpjpinap"]').val(ui.item.label);
			$('[name="tx_kddpjpnap"]').val(ui.item.description);
		}
	});

	$("#txtnmpoli").autocomplete({
		source: baseUrl + "/rekammedis/searchpoli",
		select: function (event, ui) {
			//console.log(ui);
			$('[name="txtnmpoli"]').val(ui.item.label);
			$('[name="txtkdpoli"]').val(ui.item.description);
			$('[name="politujuan"]').val(ui.item.description);
		}
	});

	$("#txtnmdpjp").autocomplete({
		source: function (req, res) {
			let poli = $("#txtkdpoli").val();
			//console.log(req);
			$.ajax({
				url: baseUrl + "/rekammedis/searchDPJP/2/" + poli + "",
				type: "GET",
				minLength: 2,
				dataType: "json",
				data: {
					search: req.term
				},
				success: function (data) {
					//console.log(data);
					res(data);
				}
			});
		},
		select: function (event, ui) {
			$('[name="txtnmdpjp"]').val(ui.item.label);
			$('[name="txtkddpjp"]').val(ui.item.description);
		}
	});


	//

	$(".pilih-sep").on("click", function () {
		let nosep = $(this).data("nosep");
		$("#txtnorujukan").val(nosep);
	});
	$("#namadpjp").autocomplete({
		source: function (req, res) {
			let poli = $("#politujuan").val();
			console.log(req);
			console.log(poli);
			$.ajax({
				url: baseUrl + "/rekammedis/searchDPJP/2/" + poli + "",
				type: "GET",
				minLength: 2,
				dataType: "json",
				data: {
					search: req.term
				},
				success: function (data) {
					res(data);
				}
			});
		},
		select: function (event, ui) {
			$('[name="tx_nmdpjplay"]').val(ui.item.label);
			$('[name="tx_kddpjplay"]').val(ui.item.description);

		}
	});

	$("#namadpjplay").autocomplete({
		source: function (req, res) {
			let poli = $("#politujuan").val();
			let setpoli;
			console.log(req);
			console.log(poli);
			if (poli == 'HDL') {
				setpoli = 'INT';
			}
			else{
				setpoli = poli;
			}
			$.ajax({
				url: baseUrl + "/rekammedis/searchDPJP/2/" + setpoli + "",
				type: "GET",
				minLength: 2,
				dataType: "json",
				data: {
					search: req.term
				},
				success: function (data) {
					res(data);
				}
			});
		},
		select: function (event, ui) {
			$('[name="namadpjplay"]').val(ui.item.label);
			$('[name="tx_kddpjplay"]').val(ui.item.description);

		}
	});

	$("#namadpjp1").autocomplete({
		source: function (req, res) {
			let poli = $("#politujuan").val();
			console.log(req);
			console.log(poli);
			$.ajax({
				url: baseUrl + "/rekammedis/searchDPJP/1/UGD",
				type: "GET",
				minLength: 2,
				dataType: "json",
				data: {
					search: req.term
				},
				success: function (data) {
					res(data);
				}
			});
		},
		select: function (event, ui) {
			$('[name="namadpjp1"]').val(ui.item.label);
			$('[name="tx_kddpjp1"]').val(ui.item.description);

		}
	});

	$(".cek-rujukan-faskes").on("click", function () {
		let noRujukan = $("#tx_susulannorujukan_bpjs").val();
		let type = $("#cb_asalrujukan").val();
		if (noRujukan) {
			let rujukan = {
				faskes: type,
				noRujukan: noRujukan
			};
			$.ajax({
				url: baseUrl + "/rekammedis/getRujukanByNorujukanBPJS",
				method: "POST",
				data: rujukan,
				dataType: "json",
				success: function (data) {
					if (data.metaData.code == 200) {
						Swal.fire({
							type: "success",
							title:
								data.response.rujukan.noKunjungan +
								"<br/>" +
								data.response.rujukan.peserta.nama +
								"<br/>" +
								data.response.rujukan.peserta.noKartu +
								"<br/>" +
								data.response.rujukan.provPerujuk.nama +
								"<br/> Poli tujuan : " +
								data.response.rujukan.poliRujukan.nama,
							footer: "<a href>RSUD AJIBARANG</a>"
						});
					} else {
						Swal.fire({
							type: "error",
							title: data.metaData.message,
							footer: "<a href>RSUD AJIBARANG</a>"
						});
					}
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
	$(".cek-kepesertaan-bpjs").on("click", function () {
		let noKa = $("#tx_susulannokepesertaan_bpjs").val();
		let type = $("#cb_asalrujukan").val();
		if (noKa) {
			let payload = {
				type: type,
				noKartu: noKa
			};

			//console.log(payload);

			$.ajax({
				url: baseUrl + "/rekammedis/cariNomerRujukanByNoka",
				method: "POST",
				data: payload,
				dataType: "json",
				success: function (data) {
					//console.log(data);

					if (data.metaData.code == 200) {
						let htmldata = "<h2>" + data.response.rujukan.noKunjungan + "</h2>";
						htmldata +=
							"<h2>Poli tujuan : " +
							data.response.rujukan.poliRujukan.nama +
							"</h2>";
						htmldata +=
							"<h6>" +
							data.response.rujukan.diagnosa.kode +
							"  - " +
							data.response.rujukan.diagnosa.nama +
							"</h6>";
						htmldata +=
							"<h2>" + data.response.rujukan.provPerujuk.nama + " </h2>";
						htmldata += "<h2>" + data.response.rujukan.tglKunjungan + " </h2>";

						Swal.fire({
							type: "success",
							title: data.metaData.message,
							html: htmldata,
							footer: "<a href>RSUD AJIBARANG</a>"
						});
						$("#tx_susulannorujukan_bpjs").val(
							data.response.rujukan.noKunjungan
						);
					} else {
						Swal.fire({
							type: "error",
							title: data.metaData.message,
							footer: "<a href>RSUD AJIBARANG</a>"
						});
					}
				}
			});
		} else {
			Swal.fire({
				type: "error",
				title: "Nomer Kartu Belum Diisi",
				footer: "<a href>Periksa Kembali Nomer Kartu BPJS yang di masukan</a>"
			});
		}
	});

	$(".form-pulangkan-pasien-bpjs").on("click", function () {
		let idx = $(this).data("idx");
		let noKa = $(this).data("noka");//"0002481534551";
		// alert(idx);
		// alert(noKa);
		window.location.href = baseUrl + "/rekammedis/formPasienPulangbpjs/" + idx + "/" + noKa + "";

	});

	$(".form-suratkontrol-pasien-bpjs").on("click", function () {
		let idx = $(this).data("idx");
		let noKa = $(this).data("noka");//"0002481534551";
		// alert(idx);
		// alert(noKa);
		window.location.href = baseUrl + "/rekammedis/formPasienSuratKontrolbpjs/" + idx + "/" + noKa + "";

	});

	$(".form-spri-pasien-bpjs").on("click", function () {
		let idx = $(this).data("idx");
		let noKa = $(this).data("noka");//"0002481534551";
		let nomr = $(this).data("nomr");//"0002481534551";
		// alert(idx);
		// alert(noKa);
		// alert(nomr);
		window.location.href = baseUrl + "/rekammedis/formPasienSpribpjs/" + idx + "/" + noKa + "/" + nomr + "";

	});

	$(".btn_back_konfirmasi_pendaftaran").on("click", function () {

		let idx = $(this).data("idx");
		let type = $(this).data("type");
		window.location.href = baseUrl + "/rekammedis/konfirmasipendaftaran/" + type + "/" + idx + "";

	});

	$(".btnListRujukan").on("click", function () {
		let noKa = $("#tx_susulannokepesertaan_bpjs").val();

		if (noKa) {
			let payload = {
				noKartu: noKa
			};
			$.ajax({
				url: baseUrl + "/rekammedis/lisRujukanBPJS",
				method: "POST",
				data: payload,
				dataType: "json",
				success: function (data) {
					console.log(data);
					alert(data);
					$("#table_fakes1 tbody").html("");
					$("#table_fakes2 tbody").html("");
					$("#table_last_rujukan_pcare tbody").html("");
					$("#table_last_rujukan_rs tbody").html("");

					let message = "";
					if (data.pcare.response) {
						$("#table_fakes1 tbody").html("");
						let response = data.pcare.response.rujukan;

						$.each(response, function (d, results) {
							$("#table_fakes1 tbody").append(
								"<tr>" +
								'<td><button type="button" onclick="selectedNoKunjungan(\'' +
								results.noKunjungan +
								'\')" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								results.noKunjungan +
								"</button></td>" +
								"<td>" +
								results.peserta.nama +
								"  (" +
								results.peserta.noKartu +
								")</td>" +
								"<td>" +
								results.diagnosa.nama +
								"</td>" +
								"<td>" +
								results.pelayanan.nama +
								"</td>" +
								"<td>" +
								results.poliRujukan.nama +
								"</td>" +
								"<td>" +
								results.provPerujuk.nama +
								"</td>" +
								"<td>" +
								results.tglKunjungan +
								"</td>" +
								"</tr>"
							);
						});
					} else {
						$("#message-faskes-1").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#"  data-dismiss="alert" ></a><strong>' +
							data.pcareMeta.metaData.message +
							"</strong></div>";
						$("#message-faskes-1").append(message);
					}

					if (data.rs.response) {
						$("#table_fakes2 tbody").html("");
						let response = data.rs.response.rujukan;
						$.each(response, function (d, results) {
							$("#table_fakes2 tbody").append(
								"<tr>" +
								// "<td>" +
								// results.noKunjungan +
								// "</td>" +

								'<td><button type="button" onclick="selectedNoKunjungan(\'' +
								results.noKunjungan +
								'\')" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								results.noKunjungan +
								"</button></td>" +
								"<td>" +
								results.peserta.nama +
								"  (" +
								results.peserta.noKartu +
								")</td>" +
								"<td>" +
								results.diagnosa.nama +
								"</td>" +
								"<td>" +
								results.pelayanan.nama +
								"</td>" +
								"<td>" +
								results.poliRujukan.nama +
								"</td>" +
								"<td>" +
								results.provPerujuk.nama +
								"</td>" +
								"<td>" +
								results.tglKunjungan +
								"</td>" +
								"</tr>"
							);
						});
					} else {
						$("#message-faskes-2").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#"  data-dismiss="alert" ></a><strong>' +
							data.rs.metaData.message +
							"</strong></div>";
						$("#message-faskes-2").append(message);
					}

					if (data.peserta.response) {
						$("#dialog_lblnama").text(data.peserta.response.peserta.nama);
						$("#dialog_lblnoka").text(
							data.peserta.response.peserta.noKartu +
							"(" +
							data.peserta.response.peserta.mr.noMR +
							")"
						);

						$("#status-peserta").html("");
						let statuscode = data.peserta.response.peserta.statusPeserta.kode;
						//console.log("status " + statuscode);
						let mark = " alert alert-warning alert-dismissible";
						if (statuscode == "0") {
							mark = " alert alert-success alert-dismissible";
						} else {
							mark = " alert alert-danger alert-dismissible";
						}
						message =
							'<div class="' +
							mark +
							'"><a href="#"  data-dismiss="alert" ></a><strong> Status Kepesertaan BPJS : ' +
							data.peserta.response.peserta.statusPeserta.keterangan +
							"</strong></div>";
						$("#status-peserta").append(message);
					} else {
						$("#message-peserta").html("");
						message =
							'<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' +
							data.peserta.metaData.message +
							"</strong></div>";
						$("#message-peserta").append(message);
					}

					if (data.lastpcare.response) {
						$("#table_last_rujukan_pcare tbody").html("");
						if (data.lastpcare.metaData.code == 200) {
							let response = data.lastpcare.response.rujukan;
							$("#table_last_rujukan_pcare tbody").append(
								"<tr>" +
								// "<td>" +
								// response.noKunjungan +
								// "</td>" +

								'<td><button type="button" onclick="selectedNoKunjungan(\'' +
								response.noKunjungan +
								'\')" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								response.noKunjungan +
								"</button></td>" +
								"<td>" +
								response.peserta.nama +
								"  (" +
								response.peserta.noKartu +
								")</td>" +
								"<td>" +
								response.diagnosa.nama +
								"</td>" +
								"<td>" +
								response.pelayanan.nama +
								"</td>" +
								"<td>" +
								response.poliRujukan.nama +
								"</td>" +
								"<td>" +
								response.provPerujuk.nama +
								"</td>" +
								"<td>" +
								response.tglKunjungan +
								"</td>" +
								"</tr>"
							);
						}
					} else {
						$("#message_table_last_rujukan_pcare").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' +
							data.lastpcare.metaData.message +
							"</strong></div>";
						$("#message_table_last_rujukan_pcare").append(message);
					}

					if (data.lastrs.response) {
						$("#table_last_rujukan_rs tbody").html("");
						if (data.lastrs.metaData.code == 200) {
							let response = data.lastrs.response.rujukan;

							$("#table_last_rujukan_rs tbody").append(
								"<tr>" +
								// "<td>" +
								// response.noKunjungan +
								// "</td>" +

								'<td><button type="button" onclick="selectedNoKunjungan(\'' +
								response.noKunjungan +
								'\')" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								response.noKunjungan +
								"</button></td>" +
								"<td>" +
								response.peserta.nama +
								"  (" +
								response.peserta.noKartu +
								")</td>" +
								"<td>" +
								response.diagnosa.nama +
								"</td>" +
								"<td>" +
								response.pelayanan.nama +
								"</td>" +
								"<td>" +
								response.poliRujukan.nama +
								"</td>" +
								"<td>" +
								response.provPerujuk.nama +
								"</td>" +
								"<td>" +
								response.tglKunjungan +
								"</td>" +
								"</tr>"
							);
						}
					} else {
						$("#message_table_last_rujukan_rs").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' +
							data.lastrs.metaData.message +
							"</strong></div>";
						$("#message_table_last_rujukan_rs").append(message);
					}

					$("#modal-default").modal({
						show: "false"
					});
				}
			});
		} else {
			Swal.fire({
				type: "error",
				title: "Nomer KArtu Belum Diisi",
				footer: "<a href>Periksa Kembali Nomer Kartu BPJS yang di masukan</a>"
			});
		}
	});




	$(".btnListRujukanFaskesByNoka").on("click", function () {

		let noKa = $("#noka").val();

		if (noKa) {
			let payload = {
				noKartu: noKa
			};
			$.ajax({
				url: baseUrl + "/rekammedis/lisRujukanBPJS",
				method: "POST",
				data: payload,
				dataType: "json",
				success: function (data) {
					//console.log(data);
					$("#table_fakes1 tbody").html("");
					$("#table_fakes2 tbody").html("");
					$("#table_last_rujukan_pcare tbody").html("");
					$("#table_last_rujukan_rs tbody").html("");

					let message = "";
					if (data.pcare) {
						$("#table_fakes1 tbody").html("");
						let response = data.pcare.rujukan;

						$.each(response, function (d, results) {
							$("#table_fakes1 tbody").append(
								"<tr>" +
								'<td><button type="button" onclick="selectedNoKunjungan(\'' +
								results.noKunjungan +
								'\',1)" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								results.noKunjungan +
								"</button></td>" +
								"<td>" +
								results.peserta.nama +
								"  (" +
								results.peserta.noKartu +
								")</td>" +
								"<td>" +
								results.diagnosa.nama +
								"</td>" +
								"<td>" +
								results.pelayanan.nama +
								"</td>" +
								"<td>" +
								results.poliRujukan.nama +
								"</td>" +
								"<td>" +
								results.provPerujuk.nama +
								"</td>" +
								"<td>" +
								results.tglKunjungan +
								"</td>" +
								"</tr>"
							);
						});
					} else {
						$("#message-faskes-1").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#"  data-dismiss="alert" ></a><strong>' +
							data.pcareMeta.metaData.message +
							"</strong></div>";
						$("#message-faskes-1").append(message);
					}

					if (data.rs) {
						$("#table_fakes2 tbody").html("");
						let response = data.rs.rujukan;
						$.each(response, function (d, results) {
							$("#table_fakes2 tbody").append(
								"<tr>" +
								// "<td>" +
								// results.noKunjungan +
								// "</td>" +

								'<td><button type="button" onclick="selectedNoKunjungan(\'' +
								results.noKunjungan +
								'\',2)" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								results.noKunjungan +
								"</button></td>" +
								"<td>" +
								results.peserta.nama +
								"  (" +
								results.peserta.noKartu +
								")</td>" +
								"<td>" +
								results.diagnosa.nama +
								"</td>" +
								"<td>" +
								results.pelayanan.nama +
								"</td>" +
								"<td>" +
								results.poliRujukan.nama +
								"</td>" +
								"<td>" +
								results.provPerujuk.nama +
								"</td>" +
								"<td>" +
								results.tglKunjungan +
								"</td>" +
								"</tr>"
							);
						});
					} else {
						$("#message-faskes-2").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#"  data-dismiss="alert" ></a><strong>' +
							data.rsMeta.metaData.message +
							"</strong></div>";
						$("#message-faskes-2").append(message);
					}

					if (data.peserta) {
						$("#dialog_lblnama").text(data.peserta.peserta.nama);
						$("#dialog_lblnoka").text(
							data.peserta.peserta.noKartu +
							"(" +
							data.peserta.peserta.mr.noMR +
							")"
						);

						$("#status-peserta").html("");
						let statuscode = data.peserta.peserta.statusPeserta.kode;
						//console.log("status " + statuscode);
						let mark = " alert alert-warning alert-dismissible";
						if (statuscode == "0") {
							mark = " alert alert-success alert-dismissible";
						} else {
							mark = " alert alert-danger alert-dismissible";
						}
						message =
							'<div class="' +
							mark +
							'"><a href="#"  data-dismiss="alert" ></a><strong> Status Kepesertaan BPJS : ' +
							data.peserta.peserta.statusPeserta.keterangan +
							"</strong></div>";
						$("#status-peserta").append(message);
					} else {
						$("#message-peserta").html("");
						message =
							'<div class="alert alert-success alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' +
							data.pesertaMeta.metaData.message +
							"</strong></div>";
						$("#message-peserta").append(message);
					}

					if (data.lastpcare) {
						$("#table_last_rujukan_pcare tbody").html("");
						if (data.lastpcareMeta.metaData.code == 200) {
							let response = data.lastpcare.rujukan;
							$("#table_last_rujukan_pcare tbody").append(
								"<tr>" +
								// "<td>" +
								// response.noKunjungan +
								// "</td>" +

								'<td><button type="button" onclick="selectedNoKunjungan(\'' +
								response.noKunjungan +
								'\',1)" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								response.noKunjungan +
								"</button></td>" +
								"<td>" +
								response.peserta.nama +
								"  (" +
								response.peserta.noKartu +
								")</td>" +
								"<td>" +
								response.diagnosa.nama +
								"</td>" +
								"<td>" +
								response.pelayanan.nama +
								"</td>" +
								"<td>" +
								response.poliRujukan.nama +
								"</td>" +
								"<td>" +
								response.provPerujuk.nama +
								"</td>" +
								"<td>" +
								response.tglKunjungan +
								"</td>" +
								"</tr>"
							);
						}
					} else {
						$("#message_table_last_rujukan_pcare").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' +
							data.lastpcareMeta.metaData.message +
							"</strong></div>";
						$("#message_table_last_rujukan_pcare").append(message);
					}

					if (data.lastrs) {
						$("#table_last_rujukan_rs tbody").html("");
						if (data.lastrsMeta.metaData.code == 200) {
							let response = data.lastrs.rujukan;

							$("#table_last_rujukan_rs tbody").append(
								"<tr>" +
								// "<td>" +
								// response.noKunjungan +
								// "</td>" +

								'<td><button type="button" onclick="selectedNoKunjungan(\'' +
								response.noKunjungan +
								'\',2)" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								response.noKunjungan +
								"</button></td>" +
								"<td>" +
								response.peserta.nama +
								"  (" +
								response.peserta.noKartu +
								")</td>" +
								"<td>" +
								response.diagnosa.nama +
								"</td>" +
								"<td>" +
								response.pelayanan.nama +
								"</td>" +
								"<td>" +
								response.poliRujukan.nama +
								"</td>" +
								"<td>" +
								response.provPerujuk.nama +
								"</td>" +
								"<td>" +
								response.tglKunjungan +
								"</td>" +
								"</tr>"
							);
						}
					} else {
						$("#message_table_last_rujukan_rs").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong>' +
							data.lastrsMeta.metaData.message +
							"</strong></div>";
						$("#message_table_last_rujukan_rs").append(message);
					}

					$("#modal-default").modal({
						show: "false"
					});
				}
			});
		} else {
			Swal.fire({
				type: "error",
				title: "Nomer KArtu Belum Diisi",
				footer: "<a href>Periksa Kembali Nomer Kartu BPJS yang di masukan</a>"
			});
		}
	});

	$(".btnListSuratKontrolFaskesByNoka").on("click", function () {

		let noKa = $("#noka").val();

		if (noKa) {
			let payload = {
				noKartu: noKa
			};
			$.ajax({
				url: baseUrl + "/rekammedis/lisSuratKontrolBPJS",
				method: "POST",
				data: payload,
				dataType: "json",
				success: function (data) {
					// console.log(data);
					$("#table_fakes1 tbody").html("");

					let message = "";
					if (data.suratkontrol) {
						$("#table_fakes1 tbody").html("");
						let response = data.suratkontrol.list;

						$.each(response, function (d, results) {
							$("#table_fakes1 tbody").append(
								"<tr>" +
								'<td><button type="button" onclick="selectedNoSuratKontrol(\'' +
								results.noSuratKontrol +
								'\',1)" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								results.noSuratKontrol +
								"</button></td>" +
								"<td>" +
								results.nama +
								"</td>" +
								"<td>" +
								results.namaJnsKontrol +
								"</td>" +
								"<td>" +
								results.tglRencanaKontrol +
								"</td>" +
								"<td>" +
								results.noSepAsalKontrol +
								"</td>" +
								"<td>" +
								results.namaPoliTujuan +
								"</td>" +
								"<td>" +
								results.kodeDokter +
								"</td>" +
								"<td>" +
								results.namaDokter +
								"</td>" +
								
								"</tr>"
							);
						});
					} else {
						$("#message-faskes-1").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#"  data-dismiss="alert" ></a><strong>' +
							data.suratkontrolaMeta.metaData.message +
							"</strong></div>";
						$("#message-faskes-1").append(message);
					}

					$("#modal-default-suratkontrol").modal({
						show: "false"
					});
				}
			});
		} else {
			Swal.fire({
				type: "error",
				title: "Nomer KArtu Belum Diisi",
				footer: "<a href>Periksa Kembali Nomer Kartu BPJS yang di masukan</a>"
			});
		}
	});
	
	$(".btnListSPRIFaskesByNoka").on("click", function () {

		let noKa = $("#noka").val();

		if (noKa) {
			let payload = {
				noKartu: noKa
			};
			$.ajax({
				url: baseUrl + "/rekammedis/lisSuratKontrolBPJS",
				method: "POST",
				data: payload,
				dataType: "json",
				success: function (data) {
					// console.log(data);
					$("#table_fakes1 tbody").html("");

					let message = "";
					if (data.suratkontrol) {
						$("#table_fakes1 tbody").html("");
						let response = data.suratkontrol.list;

						$.each(response, function (d, results) {
							$("#table_fakes1 tbody").append(
								"<tr>" +
								'<td><button type="button" onclick="selectedNoSPRI(\'' +
								results.noSuratKontrol +
								'\',1)" class="btn btn-block btn-success btn-xs"   data-dismiss="modal">' +
								results.noSuratKontrol +
								"</button></td>" +
								"<td>" +
								results.nama +
								"</td>" +
								"<td>" +
								results.namaJnsKontrol +
								"</td>" +
								"<td>" +
								results.tglRencanaKontrol +
								"</td>" +
								"<td>" +
								results.noSepAsalKontrol +
								"</td>" +
								"<td>" +
								results.namaPoliTujuan +
								"</td>" +
								"<td>" +
								results.kodeDokter +
								"</td>" +
								"<td>" +
								results.namaDokter +
								"</td>" +
								
								"</tr>"
							);
						});
					} else {
						$("#message-faskes-1").html("");
						message =
							'<div class="alert alert-danger alert-dismissible"><a href="#"  data-dismiss="alert" ></a><strong>' +
							data.suratkontrolaMeta.metaData.message +
							"</strong></div>";
						$("#message-faskes-1").append(message);
					}

					$("#modal-default-suratkontrol").modal({
						show: "false"
					});
				}
			});
		} else {
			Swal.fire({
				type: "error",
				title: "Nomer KArtu Belum Diisi",
				footer: "<a href>Periksa Kembali Nomer Kartu BPJS yang di masukan</a>"
			});
		}
	});

    $('#cb_tujuankunj').change(function () {
        var id = $(this).val();
        // alert(id);
        if (id == "1") {
            document.getElementById('kontrol').style.display = "none";
            document.getElementById('procedure').style.display = "block";
        }
        else if (id == "2") {
        	document.getElementById('kontrol').style.display = "block";
            document.getElementById('procedure').style.display = "none";
        }
        else {
            document.getElementById('kontrol').style.display = "block";
            document.getElementById('procedure').style.display = "none";
        }

    });

    $('#cb_naikkelas').change(function () {
        var id = $(this).val();
        // alert(id);
        if (id != "") {
            document.getElementById('pembiayaan').style.display = "block";
        }
        else {
            document.getElementById('pembiayaan').style.display = "none";
        }

    });


    $('#cb_statuspoli').change(function () {
        var id = $(this).val();
        // alert(id);
        if (id == "TIDAK") {
            document.getElementById('kontrol').style.display = "block";
            document.getElementById('procedure').style.display = "none";
            document.getElementById('tujuankunj').style.display = "none";
        }
        else {
            document.getElementById('kontrol').style.display = "block";
            document.getElementById('procedure').style.display = "none";
            document.getElementById('tujuankunj').style.display = "block";
        }

    });

    $(".set-nobpjs").on("click", function () {
        let id = $(this).data('idnya');
        let user = $(this).data('user');
        let petugascssd = $(this).data('petugascssd');
        // let kondisi = $(this).data('kondisialat');
        $(".modal-body #modal_idkonfirmasi").val(id);
        $(".modal-body #modal_userkonfirmasi").val(user);
        $(".modal-body #modal_petugascssd").val(petugascssd);
        // $(".modal-body #modal_kondisi").val(kondisi);
    });

});






