"use strict";

$(function () {


    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];



    let sig = $('#tandatangan').signature(
        {
            syncField: '#json',
            thickness: '3',
            syncFormat: 'JPEG',

            guideline: false
        }
    );

    // let sig = $('#signature-pad').signature(
    //     {
    //         syncField: '#json',
    //         thickness: '3',
    //         syncFormat: 'JPEG',

    //         guideline: false
    //     }
    // );

    $('#hapus').click(function () {
        $('#tandatangan').signature('clear');
        $('#salinan').signature('clear');
        $('#json').val('');
    });



    $('#simpan').click(function () {
        var json = $('#json').val();
        var idsep = $('#idsep').val();
        $.ajax({
            type: "POST",
            url: "../simpansignature",
            data: $("#f_post").serialize(),
            success: function (data) {
                alert("Berhasil disimpan");
                $("#idsep").val();
                $("#json").val('');
                $('#tandatangan').signature('clear');
                window.location.href = baseUrl + "/eklaim/coding/";
            },
        });
        return false;
    });



});

