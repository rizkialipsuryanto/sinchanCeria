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
    if (window.focus) newWindow.focus();
}

$(function () {

    console.log(baseUrl);

});