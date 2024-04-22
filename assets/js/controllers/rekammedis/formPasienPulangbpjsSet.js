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

$(function () {
    $("#datemask").inputmask("yyyy-dd-mm", { placeholder: "yyyy-dd-mm" });
    $("[data-mask]").inputmask();

    $(".back-create-sep").on("click", function () {
        let type = $(this).data("type");
        let idx = $(this).data("idx");//"0002481534551";
        // alert(type);
        window.location.href = baseUrl + "/rekammedis/outpatientSepPageCreate/" + type + "/" + idx;
    });

    $('#cb_polikontrol').change(function(){
            var poli=$(this).val();
            let id;

            if (poli == 'HDL') {
                id = 'INT';
            }
            else{
                id = poli;
            }
            // alert(id);
            $.ajax({
                    url : baseUrl + "/rekammedis/get_dpjpSuratKontrol",
                    method : "POST",
                    data : {id: id},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){
                            // html += '<option> -- Pilih Alat -- </option>';
                            html += '<option value='+data[i].mapping_dokter_bpjs+'>'+data[i].nama+'</option>';
                        }
                        $('.cb_dokterdpjp').html(html);
                    }
                });
                
            });

    // $("#cb_dokterdpjp").autocomplete({
    //     source: function (req, res) {
    //         let poli = $("#cb_polikontrol").val();
    //         let setpoli;
    //         console.log(req);
    //         console.log(poli);
    //         if (poli == 'HDL') {
    //             setpoli = 'INT';
    //         }
    //         else{
    //             setpoli = poli;
    //         }
    //         $.ajax({
    //             url: baseUrl + "/rekammedis/searchDPJP/2/" + setpoli + "",
    //             type: "GET",
    //             minLength: 2,
    //             dataType: "json",
    //             data: {
    //                 search: req.term
    //             },
    //             success: function (data) {
    //                 res(data);
    //             }
    //         });
    //     },
    //     select: function (event, ui) {
    //         $('[name="namadpjplay"]').val(ui.item.label);
    //         $('[name="tx_kddpjplay"]').val(ui.item.description);

    //     }
    // });
});
