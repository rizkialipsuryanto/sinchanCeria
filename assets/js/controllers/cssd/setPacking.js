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

    $('.select2').select2()
    document.getElementById("cbpoli").disabled=true;
    document.getElementById("alat").disabled=true;
    document.getElementById("kondisi").disabled=true;
    document.getElementById("pengantar").disabled=true;
    document.getElementById("perawatjaga").disabled=true;
    document.getElementById("petugascssd").disabled=true;
    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];
        
    // console.log("aaa");
    // $('#cbjenisalat').change(function(){
    //     document.getElementById("cbpoli").disabled=false;
    //         var id=$(this).val();
    //         var alat_id = $("#alat_id").text();
    //         // alert(id);
            
    //         $('#cbpoli').change(function(){
    //         var poli=$(this).val();
    //         // alert(poli);
    //         $.ajax({
    //                 url : baseUrl + "/cssd/get_alat",
    //                 method : "POST",
    //                 data : {id: id, poli: poli},
    //                 async : false,
    //                 dataType : 'json',
    //                 success: function(data){
    //                     var html = '';
    //                     var i;
    //                     for(i=0; i<data.length; i++){
    //                         if (data[i].alat_id==alat_id) {
    //                             $selected = 'selected="selected"';
    //                         }
    //                         else {
    //                             $selected = '';
    //                         }  
    //                         html += '<option> -- Pilih Alat -- </option>';
    //                         html += '<option value='+data[i].alat_id+' '.$selected.+'>'+data[i].nama_alat+'</option>';
    //                     }
    //                     $('.alat').html(html);
                         
    //                 }
    //             });
            
    //         if(id=="")
    //         {
    //             document.getElementById("alat").disabled=true;
    //         }
    //         else
    //         {
    //             document.getElementById("alat").disabled=false;
    //         }
                
    //         });
    //     });
});
