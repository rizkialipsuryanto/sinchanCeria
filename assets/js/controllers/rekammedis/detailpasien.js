"use strict";

$(function () {
    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];


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
                        '<select id="cb_kecamatan" name="cb_kecamatan" class="form-control form-control-sm"> <option value="">Pilih Kecamatan</option>';
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
                        '<select id="cb_kelurahan" name="cb_kelurahan" class="form-control form-control-sm"> <option value="">Pilih Kelurahan</option>';
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

  

	$(".cetakgelang").on("click", function () {

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




});