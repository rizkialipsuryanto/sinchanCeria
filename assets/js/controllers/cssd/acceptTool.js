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
    $('#reservationtime').daterangepicker({ timePicker: true, locale: { format: 'MM/DD/YYYY hh:mm A' }})

    $('.select2').select2()
    document.getElementById("cbpoli").disabled=true;
    document.getElementById("alat").disabled=true;
    document.getElementById("penanggungjawabinstrumen").disabled = true;
    let baseUrl =
        window.location.protocol +
        "//" +
        window.location.host +
        "/" +
        window.location.pathname.split("/")[1];
        
    // console.log("aaa");
    $('#cbjenisalat').change(function(){
        document.getElementById("cbpoli").disabled=false;

        // document.getElementById("cbjenisalat").disabled=true;
            var id=$(this).val();
            // alert(id);
            
            $('#cbpoli').change(function(){
            var poli=$(this).val();
            
            // document.getElementById("alat").disabled=false;
            // alert(poli);
            $.ajax({
                    url : baseUrl + "/Cssd/get_alat",
                    method : "POST",
                    data : {id: id, poli: poli},
                    async : false,
                    dataType : 'json',
                    success: function(data){
                        var html = '';
                        var i;
                        for(i=0; i<data.length; i++){
                            // html += '<option> -- Pilih Alat -- </option>';
                            html += '<option value='+data[i].alat_id+'>'+data[i].nama_alat+'</option>';
                        }
                        $('.alat').html(html);
                        // $('#alat').change(function(){
                        //     var nonsteril=$(this).val();
                        //     $('.nonsteril').html(html);
                        //     alert(nonsteril);
                        // })
                        $('.alattambahan').html(html);
                    }
                });
            
            if(poli=="40")
            {
                document.getElementById("penanggungjawabinstrumen").disabled = false;
            }
            else
            {
                document.getElementById("penanggungjawabinstrumen").disabled = true;
            }

            if(id=="")
            {
                document.getElementById("alat").disabled=true;
            }
            else
            {
                document.getElementById("alat").disabled=false;
            }
                
            });
        });

     

});
