"use strict";

// $(function () {
//******************************^^*****^^*****************************//
// Patient :
// retourner les inforamtions sur le patient et l'afficher sur le modal  à modifier
//******************************^^*****^^**************************************//
$("#villeId").on('change', function () {
  $.ajax('/api/utils/dairas/' + $(this).val()).done(function (res) {
    var dairas;
    res.forEach(function (daira) {
      dairas += "<option value=" + daira.id + ">" + daira.name + "</option>";
    });
    $("#communeId").empty().append(dairas);
  });
});
$("#btn-add-act").on("click", function () {
  var newStateVal = $("#new-act").val(); // Set the value, creating a new option if necessary

  if ($("#acts").has('option:contains(' + newStateVal + ')').length) {
    $("#acts").val(newStateVal).trigger("change");
  } else {
    // Create the DOM option that is pre-selected by default
    var form = new FormData();
    form.append('act', newStateVal);
    $.ajax('/api/operation/' + newStateVal).done(function (id) {
      var newState = new Option(newStateVal, id, true, true);
      $("#acts").append(newState).trigger('change');
    }); // Append it to the select
  }
});
$('.modal').on("hidden.bs.modal", function (e) {
  if ($('.modal:visible').length) {
    $('body').addClass('modal-open');
  }
});
$(".up_patient").on('click', function () {
  var patient_id = $(this).attr("data");
  var token = $("input[name='_token']").val(); // var progressElem = $(".ldBar");

  if ($("#modal_modifier #nom").val() == "") {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: "/api/patient/" + patient_id + "/profile",
      method: "get",
      datatype: "json",
      success: function success(data) {
        var patient = data["patient"];
        var pathologies = data["pathologies"];
        var pathologies_v1 = data["pathologies_v1"];
        var allergiess = data["allergies"]; //Map elements to select2 data struture && chech matched elements

        var paths = setMapping(pathologies, patient.pathologies);
        var ants_fam = setMapping(pathologies_v1, patient.antecedents_familliaux);
        var allergies = setMapping(allergiess, patient.allergies);
        $("#modal_modifier .pathologies").select2({
          data: paths
        });
        $("#modal_modifier .ants_fam").select2({
          data: ants_fam
        });
        $("#modal_modifier .allergies").select2({
          data: allergies
        });
        $("#num_securite_sociale").val(patient.num_securite_sociale);
        $("#nom").val(patient.nom);
        $("#code_nationale").val(patient.code_national);
        $("#prenom").val(patient.prenom);
        $("#date_naissance1").val(patient.naissance);
        $("#sexe").val(patient.sexe).is(":selected");
        $("#adresse").val(patient.adresse);
        $("#poids").val(patient.poids); // $("#ville").val(patient.ville);
        // $("#commune").val(patient.commune);

        $("#taille").val(patient.taille);
        if (patient.lastPoids != undefined) $("#poids").val(patient.lastPoids.poids);
        $("#owned_by > option").each(function () {
          if (patient.owned_by == $(this).val()) {
            $(this).attr("selected", "selected");
          }
        });
        $("#situation_familliale").val(patient.situation_familliale).is(":selected");

        if (patient.situation_famillial == "Marié(e)" || patient.situation_famillial == "Divorcé") {
          $("#nbre").val(patient.nbre_enfants);
          $("#nbre_enfants").show();
        }

        if (patient.travaille == "Retraité" || patient.travaille == "Universitaire") {
          $("#travaille").val(patient.travaille).is(":selected"); // $("#travaille1").val(patient.travaille1);
        } else {
          $("#travaille").val(patient.travaille).is(":selected");
          $("#travaille1").val(patient.travaille1);
          $("#autre").show();
        }

        if (patient.tabagiste == "on") {
          $("#tabac").prop("checked", true);
          $("#tabac1").val(patient.tabagiste_depuis);
          $("#tabac_stop").val(patient.tabagiste_arreter_depuis);
          $("#cigarettes").val(patient.cigarettes);
          $(".tabac").show();
        }

        if (patient.alcoolique == "on") {
          $("#alcool").prop("checked", true);
          $("#alcool1").val(patient.alcoolique_depuis);
          $(".alcool").show();
        }

        if (patient.drogue == "on") {
          $("#drogue").prop("checked", true);
          $("#drogue1").val(patient.drogue_depuis);
          $("#type_dr").val(patient.details);
          $(".drogue").show();
        }

        $("#num_tel_1").val(patient.num_tel_1);

        if (patient.p_tierce != null) {
          $("#p_tierce").val(patient.p_tierce);
          $("#p_tierce_div").show();
        }

        $("#num_tel_2").val(patient.num_tel_2);
        $("#num_dossier").val(patient.num_dossier);
        $("#photo").attr("src", "/avatar/" + patient.photo);
        $("#modal_modifier").modal('show');
      },
      error: function error(jqXHR, textStatus) {
        console.log("Request failed: " + textStatus + " " + jqXHR);
      }
    });
  } else $("#modal_modifier").modal('show');
});

function setMapping(mapArray, patient) {
  return $.map(mapArray, function (obj) {
    obj.text = obj.pathologie || obj.allergie; // replace pathologie with your text
    //Parcours des mapArray du patient

    for (var index = 0; index < patient.length; index++) {
      var pathologie_p = patient[index];

      if (pathologie_p.id == obj.id) {
        obj.selected = true;
        break;
      }
    }

    return obj;
  });
} //Show number of children input's when the situation is married


$("#situation_familliale").change(function () {
  if ($(this).val() == "Marié(e)" || $(this).val() == "Divorcé") {
    $("#nbre_enfants").show();
  } else $("#nbre_enfants").hide();
});
$("#sexe").on("change", function () {
  if ($(this).val() == "F") {
    $("#etat").show();
    $("#letat").show();
  } else {
    $("#etat").hide();
    $("#letat").hide();
  }
});
$("#travaille").change(function () {
  if ($(this).val() == "autre") {
    $("#autre").show();
  } else {
    $("#autre").hide();
    $("#autre").find("input").val("");
  }

  $("#travaille1").val($(this).val());
});
$("#tabac").change(function () {
  if ($(this).is(":checked")) {
    $(".tabac").show();
  } else {
    $("#tabac1").val("");
    $("#tabac_stop").val("");
    $("#paquets").val("");
    $(".tabac").hide();
  }
});
$("#alcool").change(function () {
  if ($(this).is(":checked")) {
    $(".alcool").show();
  } else {
    $("#alcool1").val("");
    $(".alcool").hide();
  }
});
$("#drogue").change(function () {
  if ($(this).is(":checked")) {
    $(".drogue").show();
  } else {
    $("#drogue1").val("");
    $(".drogue").hide();
  }
});
$("form").on("change", "select[name='etat']", function () {
  if ($(this).val() == "grossesse") {
    $("#grossesse").show();
  } else {
    $("#grossesse").hide();
  }
});
$("form").on("change", "#date_naissance1", function () {
  var valeur = parseInt($("#date_naissance1").val());
  var d = new Date();
  var strDate = d.getFullYear();

  if (strDate - valeur <= 18) {
    $("#p_tierce_div").show();
  } else $("#p_tierce_div").hide();
}); // });