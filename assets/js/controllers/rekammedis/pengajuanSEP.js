"use strict";
const baseUrl =
	window.location.protocol +
	"//" +
	window.location.host +
	"/" +
	window.location.pathname.split("/")[1];
$(function() {
	// $(".pengajuan-sep").on("click", function() {
	// 	alert("pengajuan Sep");
	// });
	// $(".approval-sep").on("click", function() {
	// 	alert("pengajuan Sep");
	// });

	$("#datemask").inputmask("dd-mm-yyyy", { placeholder: "dd-mm-yyyy" });

	$("[data-mask]").inputmask();
});
