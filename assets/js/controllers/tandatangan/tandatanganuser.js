"use strict";

$(function () {
    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];

    $('#tandatangan').signature({ guideline: true });

    $('#hapus').click(function () {
        $('#tandatangan').signature('clear');
        $('#salinan').signature('clear');
        $('#json').val('');
    });

    $('#formatjson').click(function () {
        var pesan = $('#tandatangan').signature('toJSON');
        $('#json').val(pesan);
    });

});

