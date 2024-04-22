"use strict";

$(function () {
	let baseUrl =
		window.location.protocol +
		"//" +
		window.location.host +
		"/" +
		window.location.pathname.split("/")[1];

	let list_instrumen_cssd = $('#list_instrumen_cssd').DataTable({
		// 'scrollX': true
	});

	let list_distribusi_cssd = $('#list_distribusi_cssd').DataTable({
		// 'scrollX': true
	});
	// 'scrollX': true

    $('.select2').select2()

	$(".transaksi-distribusi").on("click", function () {
        let id = $(this).data('idnya');
        let instrumen = $(this).data('instrumen');
        let instrumen_name = $(this).data('instrumen_name');
        let jenis = $(this).data('jenis');
        let user = $(this).data('user');
        let sisa = $(this).data('sisa');

        if(sisa===0){
        	alert("Jumlah yang akan diorder tidak tersedia");
        	window.location.href = "cssdDistribusi";
            document.getElementById('jumlah').style.visibility = 'hidden';
        }
        else{
            document.getElementById('jumlah').style.visibility = '';
        }
        // alert(user);
        // let kondisi = $(this).data('kondisialat');
        $(".modal-body #modal_id").val(id);
        // $(".modal-body #modal_userkonfirmasi").val(user);
        $(".modal-body #modal_instrumen").val(instrumen);
        $(".modal-body #modal_instrumen_name").val(instrumen_name);
        $(".modal-body #modal_jenis").val(jenis);
        $(".modal-body #modal_user").val(user);
        // $(".modal-body #modal_kondisi").val(kondisi);
    });


});

