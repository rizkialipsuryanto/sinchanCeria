"use strict";

$(function() {
	$(".add_cart").on("click", function() {
		let idx = $(this).data("idx");
		let idtmno = $(this).data("idtmno");
		let keterangan = $(this).data("keterangan");

		let baseUrl =
			window.location.protocol +
			"//" +
			window.location.host +
			"/" +
			window.location.pathname.split("/")[1];

		let data = {
			idx: idx,
			idtmno: idtmno,
			keterangan: keterangan
		};

		$.ajax({
			url: baseUrl + "/kasir/tambahcart",
			method: "POST",
			data: data,
			success: function(data, textStatus, jqXHR) {
				location.reload();
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR);
				console.log("SEP LOKAl AJAX call failed.");
			}
		});
	});
});
