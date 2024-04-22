"use strict";

$(function () {
    $("#datemask").inputmask("dd-mm-yyyy", { placeholder: "dd-mm-yyyy" });
    $("[data-mask]").inputmask();

    $("#jammask").inputmask("HH-MM", { placeholder: "HH-MM" });
    $("[jam-mask]").inputmask();

    //Timepicker
    $('.timepicker').timepicker({
        showInputs: false
    })

    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, locale: { format: 'MM/DD/YYYY hh:mm A' } })

    $('.select2').select2()
    document.getElementById("kasi").disabled = true;

    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];

    $('#bidang').change(function(){
        var bidang_id=$(this).val();
        document.getElementById("kasi").disabled=false;
        $.ajax({
            url : baseUrl + "/Master/get_kasi",
            method : "POST",
            data : {bidang_id: bidang_id},
            async : false,
            dataType : 'json',
            success: function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].kasi_id+'>'+data[i].kasi+'</option>';
                }
                        $('.kasi').html(html);
            }
        });
    });

    $('#kasi').change(function(){
        var kasi_id=$(this).val();
        document.getElementById("profesi").disabled=false;
        $.ajax({
            url : baseUrl + "/Master/get_profesi",
            method : "POST",
            data : {kasi_id: kasi_id},
            async : false,
            dataType : 'json',
            success: function(data){
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html += '<option value='+data[i].id_profesi+'>'+data[i].nama_profesi+'</option>';
                }
                        $('.nama_profesi').html(html);
            }
        });
    });

});
