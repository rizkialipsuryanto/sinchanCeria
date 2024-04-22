"use strict";

$(function () {

    var json = $('#signature');
    // alert('aaa');
    console.log(json);
    $('#salinan').signature({ disabled: true, guideline: true });
    $('#salinan').signature('draw', json);

});

