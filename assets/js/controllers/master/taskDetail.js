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

    $(".tasks-detail").on("click", function () {
        let id = $(this).data('idnya');
        let tasks = $(this).data('tasks');
        let tasksname = $(this).data('tasksname');
        let tasksdetail = $(this).data('tasksdetail');

        // alert(tasks);
        $(".modal-body #modal_id").val(id);
        $(".modal-body #modal_tasks").val(tasks);
        $(".modal-body #modal_tasksname").val(tasksname);
        $(".modal-body #modal_tasksdetail").val(tasksdetail);

    });
});
