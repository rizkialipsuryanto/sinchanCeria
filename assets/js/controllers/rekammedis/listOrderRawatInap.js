"use strict";

function getBaseUrl() {


    let url =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];


    return url + "/";
}



function selectedRuang(noRuang, namRuang, bed) {
    $("#koderuang").val("");
    $("#koderuang").val(noRuang);
    $("#namaruang").val("");
    $("#namaruang").val(namRuang);
    $("#bed").val("");
    $("#bed").val(bed);
}

function printBedtoHtml(id, data) {
    $("#okok").append("<h1>ok</h1>");
}

function selectedDiagnosa(kode, nama) {
    $("#kodediagnosa").val("");
    $("#kodediagnosa").val(kode);
    $("#namadiagnosa").val("");
    $("#namadiagnosa").val(nama);
}



$(function () {

    let orDeradmission = $('#list_order_admission').DataTable({
        'scrollX': true,
        'columnDefs': [
            { width: 70, targets: 1 },
            { width: 250, targets: 3 },
            { width: 300, targets: 4 },
            { width: 200, targets: 6 },
            { width: 300, targets: 5 },
            { width: 100, targets: 7 }
        ],
        'fixedColumns': true
    });


    $("#datemask").inputmask("dd-mm-yyyy", { placeholder: "dd-mm-yyyy" });

    $("[data-mask]").inputmask();

    $(".btn-cari-diagnosa").on("click", function () {
        console.log("ok");
        event.preventDefault();
        let keyword = $("#table_search").val();
        let full_url = getBaseUrl() + "/api/ruanginap/cariDiagnosa/" + keyword;
        if (keyword) {
            console.log(keyword);
            $.ajax({
                url: full_url,
                method: "GET",
                dataType: "json",
                success: function (data) {
                    console.log(data);

                    // let status = data.metaData.code;
                    // if (status == 200) {
                        let listDiagnosa = data.diagnosa;
                        if (listDiagnosa) {
                            $("#tabel_diagnosa tbody").html("");
                            $.each(listDiagnosa, function (d, results) {
                                $("#tabel_diagnosa tbody").append(
                                    "<tr>" +
                                    '<td><button onclick="selectedDiagnosa(\'' +
                                    results.kode +
                                    '\',\'' +
                                    results.nama +
                                    '\')" data-dismiss="modal" class="btn btn-block btn-success btn-xs"type="button"> PILIH </button></td>' +
                                    "<td>" + results.kode + "</td>" +
                                    "<td>" + results.nama + "</td>" +
                                    "<td></td>" +
                                    "<td>-</td>" +
                                    "</tr>"
                                );
                            });
                        }
                    // } else {
                    //     Swal.fire(
                    //         data.metaData.code,
                    //         data.metaData.message,
                    //         'question'
                    //     );
                    // }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus);
                    console.log(jqXHR);
                    console.log("Failed :." + errorThrown);
                }
            });
        } else {
            Swal.fire(
                'Diagnosa Kosong?',
                'Masukkan diagnosa yang ada cari?',
                'question'
            );
        }
    });


    $(".konfirmasi-simpan").on("click", function () {

        let nomr = $(this).data("nomr");
        let nama = $(this).data("nama");
        let alamat = $(this).data("alamat");
        let idxorder = $(this).data("idxorder");
        let idxdaftar = $(this).data("idxdaftar");
        // Apakah Anda Akan Melakukan Transfer Pasien berikut ?
        //     NOMR : " + nomr + ", You won't be able to revert this!
        Swal.fire({
            title: 'Konfirmasi Transfer Pasien',
            html: "<h3><strong>" + nomr + "</strong></h3> " + nama + "<br> " + alamat + "<h3><strong>Apakah Anda Yakin?</strong></h3>",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yakin, Lanjutkan'
        }).then((result) => {
            if (result.value) {
                let urlNext = getBaseUrl() + "rekammedis/inpatientOrderProcess/" + idxorder + "/" + idxdaftar + " ";
                console.log(urlNext);
                window.location.href = urlNext;
                //window.location.href = getBaseUrl() + "rekammedis/inpatientOrderProcess/" + idxorder + "/" + idxdaftar + " ";
            }
        })
    });



    $(".search-diagnosa").on("click", function () {
        $(".modal-diagnosa").modal({
            show: "false"
        });

    });

    $("#namadiagnosa").autocomplete({
        source: baseUrl + "/api/diagnosa/search",
        select: function (event, ui) {
            $('[name="namadiagnosa"]').val(ui.item.label);
            $('[name="kodediagnosa"]').val(ui.item.description);
        }
    });

    $("#tx_nmdiagnosa").autocomplete({
        source: getBaseUrl() + "api/diagnosa/search",
        select: function (event, ui) {
            $('[name="tx_nmdiagnosa"]').val(ui.item.label);
            $('[name="txt_kddiagnosa"]').val(ui.item.description);
        }
    });

    $(".cari-kamar").on("click", function () {
        event.preventDefault();
        let full_url = getBaseUrl() + "api/ruanginap/getListRuang";
        console.log(full_url);
        $.ajax({
            url: full_url,
            method: "GET",
            dataType: "json",
            success: function (data) {
                let listRuangan = data.response.ruangan.data;
                if (listRuangan) {
                    $("#table_fakes1 tbody").html("");
                    $.each(listRuangan, function (d, results) {




                        let bedDetails = "";
                        for (let i = 0; i < results.bed.data.length; i++) {
                            bedDetails += '<button onclick="selectedRuang(\'' +
                                results.kodeRuang +
                                '\',\'' +
                                results.namaRuang +

                                '\',\'' +
                                results.bed.data[i].no_tt +


                                '\')" class="btn btn-success btn-xs" type="button" data-dismiss="modal" >' + results.bed.data[i].no_tt + '</button> &nbsp;';
                        }


                        $("#table_fakes1 tbody").append(
                            "<tr>" +
                            "<td>" + results.kodeRuang + "</td>" +
                            "<td>" + results.namaRuang + "</td>" +
                            '<td>' + bedDetails + '</td>' +
                            "</tr>"
                        );

                        // $("#table_fakes1 tbody").append(
                        //     "<tr>" +
                        //     "<td>" + results.kodeRuang + "</td>" +
                        //     "<td>" + results.namaRuang + "</td>" +
                        //     '<td><button onclick="selectedRuang(\'' +
                        //     results.kodeRuang +
                        //     '\',\'' +
                        //     results.namaRuang +
                        //     '\')"  data-dismiss="modal" class="btn btn-block btn-success btn-xs"type="button"> PILIH </button></td>' +
                        //     "</tr>"
                        // );


                    });


                    $(".modal-cari-kamar").modal({
                        show: "false"
                    });

                }
            }
        });


    });





});