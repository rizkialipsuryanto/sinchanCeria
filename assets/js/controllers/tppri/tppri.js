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



$(function () {

    let orDeradmission = $('#list_sep').DataTable({
        'scrollX': true,
        'columnDefs': [
            { width: 80, targets: 1 },
            { width: 120, targets: 2 }
        ],
        'fixedColumns': true
    });


});