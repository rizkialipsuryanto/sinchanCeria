"use strict";

$(function () {
    $("#datemask").inputmask("dd-mm-yyyy", { placeholder: "dd-mm-yyyy" });
    $("[data-mask]").inputmask();

    $("#jammask").inputmask("HH-MM", { placeholder: "HH-MM" });
    $("[jam-mask]").inputmask();

    $("#datetimemask").inputmask("yyyy-mm-dd hh:mm", { placeholder: "yyyy-mm-dd hh:mm" });
    $("[data-mask]").inputmask();

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })


    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, locale: { format: 'MM/DD/YYYY hh:mm A' }})

    $('.select2').select2()

    $(".transaksi-alat").on("click", function () {
        let id = $(this).data('idnya');
        let kondisi = $(this).data('kondisialat');
        let dtt = $(this).data('dtt');
        let setpack = $(this).data('setpack');
        let dekontaminasi = $(this).data('dekontaminasi');
        let pengering = $(this).data('pengering');
        let ststerilisasi = $(this).data('ststerilisasi');
        let jmsterilisasi = $(this).data('jmsterilisasi');
        let jssterilisasi = $(this).data('jssterilisasi');
        let lamasterilisasi = $(this).data('lamasterilisasi');
        let ptgssterilisasi = $(this).data('ptgssterilisasi');
        let mesin = $(this).data('mesin');
        let mesinload = $(this).data('mesinload');
        let jmmesin = $(this).data('jmmesin');
        let jsmesin = $(this).data('jsmesin');
        let sksterilisasi = $(this).data('sksterilisasi');

        let tm_mesin = $(this).data('tm_mesin');

        let jm_mesin = $(this).data('jm_mesin');
        // alert(jm_mesin);
        // alert(jmmesin);
        let ts_mesin = $(this).data('ts_mesin');
        let js_mesin = $(this).data('js_mesin');
        let ts_steril = $(this).data('ts_steril');
        let js_steril = $(this).data('js_steril');
        let jkonfirmasi = $(this).data('jkonfirmasi');
        let tkonfirmasi = $(this).data('tkonfirmasi');

        $(".modal-body #modal_id").val(id);
        $(".modal-body #modal_kondisi").val(kondisi);
        $(".modal-body #modal_dtt").val(dtt);
        $(".modal-body #modal_idtracking").val(id);
        $(".modal-body #modal_kondisi").val(kondisi);
        $(".modal-body #petugaspacking").val(setpack);
        $(".modal-body #petugasdekontaminasi").val(dekontaminasi);
        $(".modal-body #petugaspengering").val(pengering);
        $(".modal-body #statussterilisasi").val(ststerilisasi);
        $(".modal-body #jam_masuk_steril").val(jmsterilisasi);
        $(".modal-body #jam_selesai_steril").val(jssterilisasi);
        $(".modal-body #lama_steril").val(lamasterilisasi);
        $(".modal-body #petugassterilisasi").val(ptgssterilisasi);
        $(".modal-body #mesin").val(mesin);
        $(".modal-body #mesinload").val(mesinload);
        $(".modal-body #jam_masuk_mesin").val(jmmesin);
        $(".modal-body #jam_selesai_mesin").val(jsmesin);
        $(".modal-body #statuskeberhasilansterilisasi").val(sksterilisasi);

        $(".modal-body #tm_mesin").val(tm_mesin);
        $(".modal-body #tm_mesinnya").val(tm_mesin);
        $(".modal-body #jm_mesin").val(jm_mesin);
        $(".modal-body #ts_mesin").val(ts_mesin);
        $(".modal-body #js_mesin").val(js_mesin);
        $(".modal-body #ts_steril").val(ts_steril);
        $(".modal-body #js_steril").val(js_steril);
        $(".modal-body #jkonfirmasi").val(jkonfirmasi);
        $(".modal-body #tkonfirmasi").val(tkonfirmasi);

        if(dtt==='T'){
            document.getElementById('form-nondtt').style.visibility = '';
        }
        if(dtt==='Y'){
            document.getElementById('form-nondtt').style.visibility = 'hidden';
        }

        // $('.modal-body #jam_masuk_mesin').change(function(){
        //     // document.getElementById("cbpoli").disabled=false;
        //     alert("tanggal");
        // });
        
    });

    $(".transaksi-alatkotor").on("click", function () {
        let id = $(this).data('idnya');
        let kondisi = $(this).data('kondisialat');
        $(".modal-body #modal_id").val(id);
        $(".modal-body #modal_kondisi").val(kondisi);

    });

    // $(".transaksi-alatbersih").on("click", function () {
    //     let id = $(this).data('idnya');
    //     let kondisi = $(this).data('kondisialat');
    //     $(".modal-body #modal_id").val(id);
    //     $(".modal-body #modal_kondisi").val(kondisi);
    // });

    $(".transaksi-detail").on("click", function () {
        let id = $(this).data('idnya');
        let kondisi = $(this).data('kondisialat');
        let dtt = $(this).data('dtt');
        let setpack = $(this).data('setpack');
        let dekontaminasi = $(this).data('dekontaminasi');
        let pengering = $(this).data('pengering');
        let ststerilisasi = $(this).data('ststerilisasi');
        let jmsterilisasi = $(this).data('jmsterilisasi');
        let jssterilisasi = $(this).data('jssterilisasi');
        let lamasterilisasi = $(this).data('lamasterilisasi');
        let ptgssterilisasi = $(this).data('ptgssterilisasi');
        let mesin = $(this).data('mesin');
        let mesinload = $(this).data('mesinload');
        let jmmesin = $(this).data('jmmesin');
        let jsmesin = $(this).data('jsmesin');
        let sksterilisasi = $(this).data('sksterilisasi');

        let tm_mesin = $(this).data('tm_mesin');

        let jm_mesin = $(this).data('jm_mesin');
        // alert(jm_mesin);
        // alert(sksterilisasi);
        let ts_mesin = $(this).data('ts_mesin');
        let js_mesin = $(this).data('js_mesin');
        let ts_steril = $(this).data('ts_steril');
        let js_steril = $(this).data('js_steril');
        let expdate = $(this).data('expdate');

        $(".modal-body #modal_id").val(id);
        $(".modal-body #modal_kondisi").val(kondisi);
        $(".modal-body #modal_dtt").val(dtt);
        $(".modal-body #modal_idtracking").val(id);
        $(".modal-body #modal_kondisi").val(kondisi);
        $(".modal-body #petugaspacking").val(setpack);
        $(".modal-body #petugasdekontaminasi").val(dekontaminasi);
        $(".modal-body #petugaspengering").val(pengering);
        $(".modal-body #statussterilisasi").val(ststerilisasi);
        $(".modal-body #jam_masuk_steril").val(jmsterilisasi);
        $(".modal-body #jam_selesai_steril").val(jssterilisasi);
        $(".modal-body #lama_steril").val(lamasterilisasi);
        $(".modal-body #petugassterilisasi").val(ptgssterilisasi);
        $(".modal-body #mesin").val(mesin);
        $(".modal-body #mesinload").val(mesinload);
        $(".modal-body #jam_masuk_mesin").val(jmmesin);
        $(".modal-body #jam_selesai_mesin").val(jsmesin);
        $(".modal-body #statuskeberhasilansterilisasi").val(sksterilisasi);

        $(".modal-body #tm_mesin").val(tm_mesin);
        $(".modal-body #jm_mesin").val(jm_mesin);
        $(".modal-body #ts_mesin").val(ts_mesin);
        $(".modal-body #js_mesin").val(js_mesin);
        $(".modal-body #ts_steril").val(ts_steril);
        $(".modal-body #js_steril").val(js_steril);
        $(".modal-body #expdate").val(expdate);

        if(dtt==='T'){
            document.getElementById('form-nondtt').style.visibility = '';
        }
        if(dtt==='Y'){
            document.getElementById('form-nondtt').style.visibility = 'hidden';
        }
    });

    $(".transaksi-konfirmasi").on("click", function () {
        let id = $(this).data('idnya');
        let user = $(this).data('user');
        let petugascssd = $(this).data('petugascssd');
        // let kondisi = $(this).data('kondisialat');
        $(".modal-body #modal_idkonfirmasi").val(id);
        $(".modal-body #modal_userkonfirmasi").val(user);
        $(".modal-body #modal_petugascssd").val(petugascssd);
        // $(".modal-body #modal_kondisi").val(kondisi);
    });

    $(".transaksi-tolak").on("click", function () {
        let id = $(this).data('idnya');
        let user = $(this).data('user');
        let petugascssd = $(this).data('petugascssd');
        // let kondisi = $(this).data('kondisialat');
        $(".modal-body #modal_idkonfirmasi").val(id);
        $(".modal-body #modal_userkonfirmasi").val(user);
        $(".modal-body #modal_petugascssd").val(petugascssd);
        // $(".modal-body #modal_kondisi").val(kondisi);
    });
});
