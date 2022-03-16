"use strict";

$(function () {
  //******************************^^*****^^**************************************// 
  // Hospitalisation : 													   //					   //
  // Affectation des champs pour la modification 								   //			       //
  //******************************^^*****^^**************************************// 
  $('.edit_hospitalisation').on('click', function () {
    // traitement pour modifier un bilan
    var myModal = $('#modal_detail_hospitalisation');
    var hospitalisation_id = $(this).attr('id'); // get bilan ID
    // now get the values from the table

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/hospitalisation/getHospitalisation/' + hospitalisation_id,
      method: 'POST',
      datatype: 'json',
      success: function success(data) {
        // and set them in the modal:
        $('#service', myModal).val(data[0].service);
        $('#numbiais', myModal).val(data[0].num_biais);
        $('#chambre', myModal).val(data[0].chambre);
        $('#lit', myModal).val(data[0].lit);
        $('#motif', myModal).val(data[0].motifs);
        $('#date_admission', myModal).val(data[0].date_admission);
        $('#date_sortie', myModal).val(data[0].date_sortie);
        $("#motif_sortie").val(data[0].motif_sortie).is(":selected"); // $("#service_transfert")
        //     .val(data[0].service_transfert)
        //     .is(":selected");

        $('.up_hospitalisation', myModal).attr('action', '/hospitalisation/' + hospitalisation_id + '/edit');
      },
      error: function error(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus + " " + jqXHR);
      }
    }); // and finally show the modal

    myModal.modal({
      show: true
    });
  });
  $('.edit_act_med').on('click', function () {
    // traitement pour modifier un bilan
    var myModal = $('#modal_detail_act');
    var act_id = $(this).attr('id'); // get bilan ID
    // now get the values from the table

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/acts/getAct/' + act_id,
      method: 'POST',
      datatype: 'json',
      success: function success(data) {
        // and set them in the modal:
        $('#cons_id', myModal).val(data[0].consultation_id);
        $('#actm', myModal).val(data[0].act_medicale_id);
        $('#patient_id', myModal).val(data[0].patient_id);
        $('#description', myModal).val(data[0].description);
        $('#date_act', myModal).val(data[0].date_act);
        $('.up_acts', myModal).attr('action', '/acts/' + act_id + '/edit');
      },
      error: function error(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus + " " + jqXHR);
      }
    }); // and finally show the modal

    myModal.modal({
      show: true
    });
  });
  $('.edit_impression').on('click', function () {
    // traitement pour modifier un rapport
    var myModal = $('#modal_detail_impression');
    var hospitalisation_id = $(this).attr('id'); // get bilan ID
    // now get the values from the table

    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(data) {
        // $('.up_impression', myModal).attr('action', '/hospitalisation/' + hospitalisation_id + '/print');
        $('.up_impression', myModal).attr('action', '/patient/hospitalisation/print-report');
      },
      error: function error(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus + " " + jqXHR);
      }
    }); // and finally show the modal

    myModal.modal({
      show: true
    });
  }); //Show other works input's 

  $("#motif_sortie").on('change', function () {
    if ($(this).val() == "autre") {
      $("#service_transfert").show();
    } else $("#service_transfert").hide();
  });
});