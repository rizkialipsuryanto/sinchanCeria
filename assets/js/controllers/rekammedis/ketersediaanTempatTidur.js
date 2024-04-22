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


function getupdateBedUrl() {
    return baseUrl + "/rekammedis/updateRoom";
}

function updateBedProcess() {
    let promise = new Promise(function (resolve, reject) {
        let ajax = new XMLHttpRequest();
        ajax.onload = function () {
            console.log("respon : " + ajax.responseText);
            // resolve(JSON.parse(ajax.responseText));
            resolve("OK");
            reject(Error("Gagal mengambil data produk"));
        };
        let url = getupdateBedUrl();
        ajax.open("GET", url);
        ajax.send();
    });
    return promise;
}

$(function () {


    // RELOAD TIAP 60 DETIK ()
    setInterval(function () {
        updateBedProcess();
        console.log("update TT running...........");
        //location.reload();
    }, 10000); // SATUAN MILI SECOND

    $(".update-ketersediaan-kamar").on("click", function () {
        let promise = updateBedProcess();
        promise
            .then(function (value) {
                //console.log(value);
                location.reload();
            })
            .then(function (products) {
                //
            })
            .catch(function (error) {
                alert(error.message);
            })
            .finally(function () {
                //
            })
    });
});
