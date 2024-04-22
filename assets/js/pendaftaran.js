"use strict";

let baseUrl =
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

function startjam() {
	let d = new Date();
	let curr_hour = d.getHours();
	let curr_min = d.getMinutes();
	let curr_sec = d.getSeconds();
	document.getElementById("start_daftar").value =
		curr_hour + ":" + curr_min + ":" + curr_sec;
}

function stopjam() {
	var d = new Date();
	var curr_hour = d.getHours();
	var curr_min = d.getMinutes();
	var curr_sec = d.getSeconds();
	document.getElementById("stop_daftar").value =
		curr_hour + ":" + curr_min + ":" + curr_sec;
}

function cekrujukanByNoka(x) {
	let baseUrl =
		window.location.protocol +
		"//" +
		window.location.host +
		"/" +
		window.location.pathname.split("/")[1];

	let payload = {
		faskes: 1,
		noka: x
	};

	$.ajax({
		url: baseUrl + "/rekammedis/getRujukanByNoka",
		method: "POST",
		data: payload,
		dataType: "json",
		success: function (data) {
			//let obj = JSON.parse(data);
			console.log(data);
			if (data.noKunjungan != null && data.code == 200) {
				$("#tx_no_rujukan_bpjs").val(data.noKunjungan);
				if (data.faskes2 == 1) {
					$("#faskes2").prop("checked", true);
				}
				else{
					// alert("Data Tidak Ditemukan");
				}
			} else {
				//
				// $("#faskes2").prop("checked", true);
				// alert("Data Tidak Ditemukan");
			}
		}
	});
}

function validacion(){
	var dependent = $('#detail_pasien_covid');
  	if (document.getElementById('cbpernahcovid').checked) {
      dependent.show();
	} else {
	    dependent.hide();
	}

  // alert(" Me gusta : " +x61 );
}

function refreshnested() {
	let baseUrl =
		window.location.protocol +
		"//" +
		window.location.host +
		"/" +
		window.location.pathname.split("/")[1];

	let hidden_prov = $("#hidden_prov").val();
	let hidden_kota = $("#hidden_kota").val();
	let hidden_kec = $("#hidden_kec").val();
	let hidden_kel = $("#hidden_kel").val();

	if (hidden_prov != "") {
		$.ajax({
			url: baseUrl + "/rekammedis/fetch_kota",
			method: "POST",
			dataType: "json",
			data: {
				idprovinsi: hidden_prov
			},
			success: function (data) {
				// console.log(data);
				// console.log(data[0].idkota);
				let html = "";
				let i_prov;
				let select_prov;
				html +=
					'<select id="cb_kabupaten" name="cb_kabupaten" class="form-control form-control-sm"> <option value="">Pilih Kabupaten/Kota</option>';
				if (data.length > 0) {
					for (i_prov = 0; i_prov < data.length; i_prov++) {
						if (hidden_kota == data[i_prov].idkota) {
							select_prov = "selected=Selected";
						} else {
							select_prov = "";
						}
						html +=
							"<option value = " +
							data[i_prov].idkota +
							"  " +
							select_prov +
							"  >" +
							data[i_prov].namakota +
							"</option>";
					}
				} else {
					alert("Kosong");
					html = "";
				}

				html += "</select>";

				$("#cb_kabupaten").html(html);
			}
		});
	}

	if (hidden_kota != "") {
		$.ajax({
			url: baseUrl + "/rekammedis/fetch_kecamatan",
			method: "POST",
			dataType: "json",
			data: {
				idKabupaten: hidden_kota
			},
			success: function (data) {
				//	console.log(data);
				let html = "";
				let i_kec;
				let select_kecama;
				html +=
					'<select id="cb_kecamatan" name="cb_kecamatan" class="form-control form-control-sm"> <option value="">Pilih Kecamatan jquery</option>';
				if (data.length > 0) {
					for (i_kec = 0; i_kec < data.length; i_kec++) {
						if (hidden_kec == data[i_kec].idkecamatan) {
							select_kecama = "selected=Selected";
						} else {
							select_kecama = "";
						}

						html +=
							"<option value = " +
							data[i_kec].idkecamatan +
							"  " +
							select_kecama +
							"  >" +
							data[i_kec].namakecamatan +
							"</option>";
					}
				} else {
					alert("Kosong");
					html = "";
				}
				html += "</select>";

				$("#cb_kecamatan").html(html);
			}
		});
	}

	if (hidden_kel != "") {
		$.ajax({
			url: baseUrl + "/rekammedis/fetch_kelurahan",
			method: "POST",
			dataType: "json",
			data: {
				idkecamatan: hidden_kec
			},
			success: function (data) {
				let html = "";
				let i_kel;
				let select_kelu;
				html +=
					'<select id="cb_kelurahan" name="cb_kelurahan" class="form-control form-control-sm"> <option value="">Pilih Kelurahan jquery</option>';
				if (data.length > 0) {
					for (i_kel = 0; i_kel < data.length; i_kel++) {
						if (hidden_kel == data[i_kel].idkelurahan) {
							select_kelu = "selected=Selected";
						} else {
							select_kelu = "";
						}

						html +=
							"<option value = " +
							data[i_kel].idkelurahan +
							" " +
							select_kelu +
							"  >" +
							data[i_kel].namakelurahan +
							"</option>";
					}
				} else {
					alert("Kosong");
					html = "";
				}
				html += "</select>";
				$("#cb_kelurahan").html(html);
			}
		});
	}
}

function hitungUmur(tglLahir) {
	let tgl_lahir = tglLahir;
	if (tgl_lahir) {
		//console.log(tgl_lahir);
		$.ajax({
			type: "POST",
			url: baseUrl + "/rekammedis/hitungUmur",
			data: {
				tglLahir: tgl_lahir
			},
			success: function (data, textStatus, jqXHR) {
				let obj = $.parseJSON(data);
				console.log(obj);
				$("#umur").val(obj);
			},
			error: function (jqXHR, textStatus, errorThrown) {
				//
			}
		});
	} else {
		$("#umur").val("0 tahun 0 bulan 0 hari ");
	}
}

function changeFormatDate(date_param) {
	let d = new Date(date_param);
	let dd = d.getDate();
	let mm = d.getMonth() + 1;
	let yy = d.getFullYear();
	return dd + "/" + mm + "/" + yy;
}

function getPatientDetail() {
	let nomr = $("#nomr").val();

	if (nomr) {
		$.ajax({
			type: "POST",
			url: baseUrl + "/rekammedis/caripasien",
			data: {
				nomr: nomr
			},
			success: function (data, textStatus, jqXHR) {
				let obj = $.parseJSON(data);
				console.log(obj);

				if (obj.status === true) {
					$("#hidden_prov").val(obj.data.KDPROVINSI);
					$("#hidden_kota").val(obj.data.KOTA);
					$("#hidden_kec").val(obj.data.KDKECAMATAN);
					$("#hidden_kel").val(obj.data.KELURAHAN);
					$("#cbProvinsi").val(obj.data.KDPROVINSI);
					refreshnested();

					$("#tx_nama").val(obj.data.NAMA);
					$("#cb_alias").val(obj.data.TITLE);
					$("#noktp").val(obj.data.NOKTP);
					$("#nokabpjs").val(obj.data.NO_KARTU);
					$("#ttl").val(obj.data.TEMPAT);

					let _tanggal = changeFormatDate(obj.data.TGLLAHIR);
					console.log(_tanggal);

					$("#tgllahir").val(_tanggal);
					hitungUmur(_tanggal);
					$("#alamatktp").val(obj.data.ALAMAT);
					$("#alamatktplama").val(obj.data.ALAMAT_KTP);

					$("#tx_namaayah").val(obj.data.nama_ayah);
					$("#tx_namaibu").val(obj.data.nama_ibu);


					if (obj.data.nama_suami == null) {
						$("#tx_namasuami").val('-');
					} else {
						$("#tx_namasuami").val(obj.data.nama_suami);
					}
					$("#tx_namaistri").val(obj.data.nama_istri);
					$("#tx_notelepon").val(obj.data.NOTELP);
					$("#cb_pekerjaan").val(obj.data.PEKERJAAN);
					$("#cb_etnis").val(obj.data.KD_ETNIS);
					$("#cb_bahasaharian").val(obj.data.KD_BHS_HARIAN);

					$("#cb_hubungan").val(obj.data.PENANGGUNGJAWAB_HUBUNGAN);
					$("#tx_namapenanggungjawab").val(obj.data.PENANGGUNGJAWAB_NAMA);
					$("#tx_notel_penanggungjawab").val(obj.data.PENANGGUNGJAWAB_PHONE);
					$("#tx_alamatpenanggungjawab").val(obj.data.PENANGGUNGJAWAB_ALAMAT);

					$(
						"input[name='rb_Jeniskelamin'][value='" +
						obj.data.JENISKELAMIN +
						"']"
					).prop("checked", true);
					$("input[name='rb_Agama'][value='" + obj.data.AGAMA + "']").prop(
						"checked",
						true
					);
					$(
						"input[name='rb_Pendidikanterakhir'][value='" +
						obj.data.PENDIDIKAN +
						"']"
					).prop("checked", true);
					$(
						"input[name='rb_statuspernikahan'][value='" + obj.data.STATUS + "']"
					).prop("checked", true);
					$(
						"input[name='rbjenispasienbpjs'][value='" +
						obj.data.JNS_PASIEN +
						"']"
					).prop("checked", true);
				} else {
					Swal.fire({
						type: "warning",
						title: "Oops...",
						text: "Data Nomer Rekam medis Pasien Tidak DItemukan",
						footer: "<a href>silakan masukan nomer rekam medis yang benar</a>"
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				//
			}
		});
	} else {
		Swal.fire({
			type: "warning",
			title: "Oops...",
			text: "Nomer Rekam Medis Masih Kosong",
			footer: "<a href>silakan masukan nomer rekam medis yang benar</a>"
		});
	}
}

function selectedNoKunjungan(noKunjungan) {
	$("#tx_no_rujukan_bpjs").val(noKunjungan);
}


$(function () {

	let baseUrl =
		window.location.protocol +
		"//" +
		window.location.host +
		"/" +
		window.location.pathname.split("/")[1];

		console.log("gtt : ",baseUrl);

	startjam();

	console.log("function is running");

		$('.select2').select2()

	$(document).ready(function () {

        $('#cb_bayi').change(function () {
            let idbayi = $("#cb_bayi").val();
            if (idbayi != "") {

                $.ajax({
                    url: baseUrl + "/Rekammedis/get_detailBayi",
                    method: "POST",
                    data: { idbayi: idbayi },
                    async: true,
                    dataType: 'json',
                    success: function (data) {

                    	let tglconvert = data[0].tanggal_lahir;
                    	let tahun = tglconvert.substring(0, 4);
                    	let bulan = tglconvert.substring(5, 7);
                    	let tanggal = tglconvert.substring(8, 10);
                    	let convert = tanggal+'/'+bulan+'/'+tahun;

                    	// alert(convert);
                    	$("#tx_nama").val(data[0].nama_lengkap_bayi);
                    	$("#tgllahir").val(convert);
                    	$("#alamatktp").val(data[0].alamat_ayah);
                    	$("#tx_namaayah").val(data[0].nama_ayah);
                    	$("#tx_namaibu").val(data[0].nama_ibu);
                    	$("#tx_notelepon").val(data[0].telp);
                    	$("#cb_alias").val(data[0].title);
                    	// $("#cb_poly").val(data[0].ruang_lahir);
                    	// $("#idpoli").val(data[0].ruang_lahir);
                    }
                });
            } else {
                $("#tx_nama").val("");
                $("#tgllahir").val("");
                $("#alamatktp").val("");
                $("#tx_namaayah").val("");
                $("#tx_namaibu").val("");
                $("#tx_notelepon").val("");
                // $("#cb_poly").val("-");
            }
        })
    });

	$(document).ready(function() {

        $.validator.setDefaults({
            submitHandler: function(form, event) {
                event.preventDefault();
                alert("Form successful submitted!");
                console.log($(form).find('input[name="nomr"]').val());

            }
        });


        $('#quickForm').validate({

            rules: {
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    minlength: 5
                },
                terms: {
                    required: true
                },
            },
            messages: {
                email: {
                    required: "Please enter a email address",
                    email: "Please enter a vaild email address"
                },
                password: {
                    required: "Please provide a password",
                    minlength: "Your password must be at least 5 characters long"
                },
                terms: "Please accept our terms"
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });


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
	
		$("#rbShift_1").prop("checked", true);
	
		$("#datemask").inputmask("dd-mm-yyyy", { placeholder: "dd-mm-yyyy" });
	
		$("[data-mask]").inputmask();
	
		$(".newPatientRegistration").on("click", function () {
			window.location.href = baseUrl + "/rekammedis/pendaftaranpasienrawatjalan";
		});
	
		$("#nomr").blur(function () {
			getPatientDetail();
		});
	
		$("#nomr").keydown(function (event) {
			if (event.keyCode == 13) {
				getPatientDetail();
				return false;
			}
		});
	
		$("#tgllahir").change(function () {
			let tgl_lahir = $("#tgllahir").val();
	
			if (tgl_lahir) {
				//console.log(tgl_lahir);
				$.ajax({
					type: "POST",
					url: baseUrl + "/rekammedis/hitungUmur",
					data: {
						tglLahir: tgl_lahir
					},
					success: function (data, textStatus, jqXHR) {
						let obj = $.parseJSON(data);
						$("#umur").val(obj);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						//
					}
				});
			} else {
				$("#umur").val("0 tahun 0 bulan 0 hari ");
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

			$.ajax({
                    url: baseUrl + "/rekammedis/get_kdAntrian",
                    method: "POST",
                    data: { kodepoli: kodepoli },
                    async: true,
                    dataType: 'json',
                    success: function (data) {
                    	$("#kdAntrian").val(data[0].kd_antrian);
                    	// console.log(data);
                    }
                });
		});

		// menampilkan perusahaan

		$("#cb_carabayar").change(function () {
			let carabayar = $(this).val();
	
			// alert(carabayar);
			if (carabayar == 14) {
				$(".detail_perusahaan").show();
			}
			else{
				$(".detail_perusahaan").hide();
			}
		});
	
		$("input[type=radio][name=rbParentCarabayar]").on("click", function () {
			let payplan = this.value;
			if (payplan == 1) {
				$(".detail_jaminan_bpjs").hide();
			} else {
				$(".detail_jaminan_bpjs").show();
			}
		});
	
		$(".rbflagstatusPasienDaftar").on("click", function () {
			let status = $(this).val();
			$("#nomr").val("");
			if (status == 1) {
				$("#nomr").prop("disabled", true);
				//complete();
			} else {
				$("#nomr").prop("disabled", false);
				//incomplete();
			}
	
			startjam();
		});
	
	
		$(".link-pendaftaran-online").on("click", function () {
			window.location.href = baseUrl + "/rekammedis/pendaftaranonline";
		});
		$("#btnCekKepesertaan").on("click", function () {
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
						//let obj = JSON.parse(data);
						console.log(data);
	
						cekrujukanByNoka(noKa);
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
	
		$("#btnCekRujukan").on("click", function () {
			let noRujukan = $("#tx_no_rujukan_bpjs").val();
			if (noRujukan) {
				let faskes2;
				if ($("#faskes2").is(":checked")) {
					faskes2 = 1;
				} else {
					faskes2 = 0;
				}
				// console.log(faskes2);
				// console.log(noRujukan);
	
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
						// if (data.metaData.code == 200) {
						// console.log(data);
						// console.log(data.rujukan.noKunjungan);
						// }
						//if (data.value) {
						$("#nokabpjs").val(data.value);
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
	
	
	
		$(".btnTampildataRekamMedis").on("click", function () {
			getPatientDetail();
		});
	
		$(".btnListRujukan").on("click", function () {
			let noKa = $("#nokabpjs").val();
	
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
	
		$("#cbProvinsi").on("change", function () {
			let idprovinsi = $("#cbProvinsi").val();
			var idKota = $("#hidden_kota").val();
	
			if (idprovinsi != "") {
				//alert(idprovinsi);
				$.ajax({
					url: baseUrl + "/rekammedis/fetch_kota",
					method: "POST",
					dataType: "json",
					data: {
						idprovinsi: idprovinsi
					},
					success: function (data) {
						//console.log(data);
						let html = "";
						let i_prov;
						let select_prov;
						html +=
							'<select id="cb_kabupaten" name="cb_kabupaten" class="form-control form-control-sm"> <option value="">Pilih Kabupaten/Kota</option>';
						if (data.length > 0) {
							for (i_prov = 0; i_prov < data.length; i_prov++) {
								if (idKota == data[i_prov].idkota) {
									select_prov = "selected=Selected";
								} else {
									select_prov = "";
								}
								html +=
									"<option value = " +
									data[i_prov].idkota +
									"  " +
									select_prov +
									"  >" +
									data[i_prov].namakota +
									"</option>";
							}
						} else {
							alert("Kosong");
							html = "";
						}
	
						html += "</select>";
	
						$("#cb_kabupaten").html(html);
					}
				});
			} else {
				alert("Provinsi belum dipilih");
			}
		});
	
		$("#cb_kabupaten").on("change", function () {
			let idKabupaten = $("#cb_kabupaten").val();
			let kdKecam = $("#hidden_kec").val();
	
			if (idKabupaten != "") {
				$.ajax({
					url: baseUrl + "/rekammedis/fetch_kecamatan",
					method: "POST",
					dataType: "json",
					data: {
						idKabupaten: idKabupaten
					},
					success: function (data) {
						//console.logconsole.log(data);
						let html = "";
						let i_kec;
						html +=
							'<select id="cb_kecamatan" name="cb_kecamatan" class="form-control form-control-sm"> <option value="">Pilih Kecamatan jquery</option>';
						if (data.length > 0) {
							for (i_kec = 0; i_kec < data.length; i_kec++) {
								// if (kdKecam == data[i].idkecamatan) {
								//     let select_kecama = "selected=Selected";
								// } else {
								//     let select_kecama = "";
								// }
								html +=
									"<option value = " +
									data[i_kec].idkecamatan +
									"   >" +
									data[i_kec].namakecamatan +
									"</option>";
							}
						} else {
							alert("Kosong");
							html = "";
						}
						html += "</select>";
	
						$("#cb_kecamatan").html(html);
					}
				});
			} else {
				alert("Kabupaten belum dipilih");
			}
		});
	
		$("#cb_kecamatan").on("change", function () {
			let idkecamatan = $("#cb_kecamatan").val();
			let idhidden_kel = $("#hidden_kel").val();
	
			if (idkecamatan != "") {
				$.ajax({
					url: baseUrl + "/rekammedis/fetch_kelurahan",
					method: "POST",
					dataType: "json",
					data: {
						idkecamatan: idkecamatan
					},
					success: function (data) {
						let html = "";
						let i_kel;
						let select_kelu;
						html +=
							'<select id="cb_kelurahan" name="cb_kelurahan" class="form-control form-control-sm"> <option value="">Pilih Kelurahan jquery</option>';
						if (data.length > 0) {
							// console.log(data);
							for (i_kel = 0; i_kel < data.length; i_kel++) {
								if (idhidden_kel == data[i_kel].idkelurahan) {
									select_kelu = "selected=Selected";
								} else {
									select_kelu = "";
								}
	
								html +=
									"<option value = " +
									data[i_kel].idkelurahan +
									" " +
									select_kelu +
									"  >" +
									data[i_kel].namakelurahan +
									"</option>";
							}
						} else {
							alert("Kosong");
							html = "";
						}
						html += "</select>";
						$("#cb_kelurahan").html(html);
					}
				});
			} else {
				alert("Kecamatan belum dipilih");
			}
		});
	
	
	
	
});
