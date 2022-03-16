"use strict";

$(function () {
  $.ajaxSetup({
    cache: false
  }); //get json records from general.json and display in there respective div for admin

  $.getJSON("/js/json/general_settings.json", function (obj) {
    $("#hopital").val(obj.hopital);
    $("#service").val(obj.service); // $("#matin_midi").val(obj.matin_midi);
    // $("#midi_soir").val(obj.midi_soir);
    // $("#soir_avant_coucher").val(obj.soir_avant_coucher);

    if (obj.analyse_auto == "on") $("#analyse_auto").prop('checked', true);
  }); //premier boutton de sauvegarde

  $('#save_01').click(function () {
    var hopital = $("#hopital").val();
    var service = $("#service").val();
    var analyse_auto;
    if ($("#analyse_auto").is(':checked')) analyse_auto = 'on';else analyse_auto = 'off'; // var matin_midi = $("#matin_midi").val();
    // var midi_soir = $("#midi_soir").val();
    // var soir_avant_coucher = $("#soir_avant_coucher").val();

    var settings = new Object();
    settings.hopital = hopital;
    settings.service = service;
    settings.analyse_auto = analyse_auto; // settings.matin_midi = matin_midi;
    // settings.midi_soir = midi_soir;
    // settings.soir_avant_coucher = soir_avant_coucher;

    $.ajax({
      type: "GET",
      dataType: 'html',
      async: false,
      url: '/js/php/save_settings_json.php',
      data: {
        data: JSON.stringify(settings)
      },
      success: function success(data) {
        alert("Sauvegarde effectuée !");
      },
      failure: function failure() {
        alert("Error!");
      }
    });
  });
  var eventsholded = []; //create array object to send into server
  //get json records from general.json and display in there respective div for admin

  $.getJSON("/js/json/general.json", function (obj) {
    $.each(obj, function (key, value) {
      $("#settings_list>tbody").append('<tr><td></td><td></td><td></td><td></td><td></td><td></td></tr>');
    });
    var i = -1;
    $.each(obj, function (key, value) {
      if (value.grade == "") {
        key++;
      }

      if (value.grade != "") $("#settings_list>tbody>tr:eq(" + ++i + ")> td:eq(0) ").html("<b>" + value.grade + (value.grade != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>"));
    });
    var i = -1;
    $.each(obj, function (key, value) {
      if (value.specialite == "") {
        key++;
      }

      if (value.specialite != "") $("#settings_list>tbody>tr:eq(" + ++i + ")> td:eq(1) ").html("<b>" + value.specialite + (value.specialite != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>"));
    });
    var i = -1;
    $.each(obj, function (key, value) {
      if (value.bilan == "") {
        key++;
      }

      if (value.bilan != "") $("#settings_list>tbody>tr:eq(" + ++i + ")> td:eq(2) ").html("<b>" + value.bilan + (value.bilan != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>"));
    });
    var i = -1;
    $.each(obj, function (key, value) {
      if (value.unite == "") {
        key++;
      }

      if (value.unite != "") $("#settings_list>tbody>tr:eq(" + ++i + ")> td:eq(3) ").html("<b>" + value.unite + (value.unite != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>"));
    });
    var i = -1;
    $.each(obj, function (key, value) {
      if (value.type_effet == "") {
        key++;
      }

      if (value.type_effet != "") $("#settings_list>tbody>tr:eq(" + ++i + ")> td:eq(4) ").html("<b>" + value.type_effet + (value.type_effet != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>"));
    });
    $.each(obj, function (key, value) {
      if (value.type_rdv == "") {
        key++;
      }

      if (value.type_rdv != "") $("#settings_list>tbody>tr:eq(" + ++i + ")> td:eq(5) ").html("<b>" + value.type_rdv + (value.type_rdv != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>"));
    });
    $("#settings_list>tbody>tr").each(function () {
      if ($(this).find("b").length == "0") $(this).remove();
    }); // $('#settings_list>tbody').append("<tr><td><b>"+value.grade+ (value.grade != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>" )+"</td><td><b>"+value.specialite + (value.specialite != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>" )+"</td><td><b>"+value.bilan+(value.bilan != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>" )+"</td><td><b>"+value.unite+(value.unite != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>" )+"</td><td><b>"+value.type_effet+(value.type_effet != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>" )+"</td></tr>");
    //}); 
  });
  $('#save_02').click(function () {
    if ($('tbody>tr').length > 0) $('#settings_list>tbody>tr').each(function (index) {
      var event = new Object();
      event.grade = $(this).children('td:eq(0)').find('b').text();
      event.specialite = $(this).children('td:eq(1)').find('b').text();
      event.bilan = $(this).children('td:eq(2)').find('b').text();
      event.unite = $(this).children('td:eq(3)').find('b').text();
      event.type_effet = $(this).children('td:eq(4)').find('b').text();
      event.type_rdv = $(this).children('td:eq(5)').find('b').text();
      eventsholded.push(event);
    });
    var event = new Object(); // ajouter l'objet a envoyer

    event.grade = $('#grade').val();
    event.specialite = $('#specialite').val();
    event.bilan = $('#bilan').val();
    event.unite = $('#unité').val();
    event.type_effet = $('#type_effet').val();
    event.type_rdv = $('#type_rdv').val();
    eventsholded.push(event); //l'ajouter dans le tableau

    $.ajax({
      type: "GET",
      dataType: 'html',
      async: false,
      url: '/js/php/save_json.php',
      data: {
        data: JSON.stringify(eventsholded)
      },
      success: function success(data) {
        $('#settings_list>tbody').append("<tr><td><b>" + $('#grade').val() + ($('#grade').val() != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>") + "</td><td><b>" + $('#specialite').val() + ($('#specialite').val() != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>") + "</td><td><b>" + $('#bilan').val() + ($('#bilan').val() != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>") + "</td><td><b>" + $('#unité').val() + ($('#unité').val() != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>") + "</td><td><b>" + $('#type_effet').val() + ($('#type_effet').val() != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>") + "</td><td><b>" + $('#type_rdv').val() + ($('#type_rdv').val() != "" ? "<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>" : "</b>") + "</td></tr>");
        $("#grade,#specialite,#bilan,#unité,#type_effet , #type_rdv").val("");
        eventsholded = [];
      },
      failure: function failure() {
        alert("Error!");
        eventsholded = [];
      }
    });
  });
  $('tbody').on('click', '.fa-times-circle', function () {
    $(this).parent().remove();
  });
});