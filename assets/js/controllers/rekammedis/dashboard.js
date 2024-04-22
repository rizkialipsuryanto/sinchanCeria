
$(function () {
	let baseUrl =
		window.location.protocol +
		"//" +
		window.location.host +
		"/" +
		window.location.pathname.split("/")[1];

	$(".link-new-outpatient-registration").on("click", function () {
		window.location.href = baseUrl + "/rekammedis/pendaftaranpasienrawatjalan";
	});


	let list_corona = $('#list_corona').DataTable({
	});


	let list_corona_indonesia = $('#list_corona_sebaran_indonesia').DataTable({
		// 'scrollX': true
	});
	// 'scrollX': true


});

// $(document).ready(function () { }); //

