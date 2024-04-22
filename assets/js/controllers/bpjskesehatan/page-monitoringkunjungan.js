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
            { width: 70, targets: 1 },
            { width: 150, targets: 3 },
            { width: 150, targets: 4 },
            { width: 150, targets: 5 },
            { width: 300, targets: 5 },
            { width: 100, targets: 7 }
        ],
        'fixedColumns': true
    });


});