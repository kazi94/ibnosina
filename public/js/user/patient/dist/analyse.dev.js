"use strict";

$(function () {
  //******************************^^*****^^*****************************// 
  // Intervention pharmaceutique :
  // Afficher les alertes analyse pharmaceutique.
  // Afficher le tableau d'interventipn pharmaceutique
  //******************************^^*****^^**************************************// 
  var levels = [{
    'key': 1,
    'value': 'Problème majeure'
  }, {
    'key': 2,
    'value': 'Problème modéré'
  }, {
    'key': 3,
    'value': 'Problème mineur'
  }];

  function createLevels() {
    var options = "<option value=''></option>";
    levels.forEach(function (level) {
      options += "<option value='".concat(level.key, "'>").concat(level.value, "</option>");
    });
    return options;
  }

  var options = createLevels();
  /**
   * 
   * Lunch the processus of pharmaceutical analysis
   */

  $('#analyseBtn').on('click', function () {
    // Lancement du traitement Analyse Pharmaceutique , et affichage des alertes
    var myModal = $('#modal_analyse_pharm');
    $('.analyse_table > tbody').empty();
    $('.analyse_table_interne > tbody').empty();
    var bar1 = new ldBar("#myItem1");
    var progressElem = $(".ldBar");
    var patient_id = $(this).data('id');
    var presc_id = $(this).data('risque');
    var dataToStore;
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/patient/' + patient_id + '&' + presc_id + '/analysePharmaceutique',
      method: 'get',
      datatype: 'html',
      xhr: function xhr() {
        var xhr = new window.XMLHttpRequest(); // 	// Upload progress
        // 	xhr.upload.addEventListener("progress", function (evt) {
        // 	// if (evt.lengthComputable) {
        // 		// bar1.set(60);
        // 	var percentComplete = evt.loaded / evt.total;
        // 	//Do something with upload progress
        // 	console.log(percentComplete);
        // 	// }
        // 	}, false);
        // 	// Download progress

        xhr.addEventListener("progress", function (evt) {
          if (evt.lengthComputable) {
            // bar1.set(60);
            var percentComplete = evt.loaded / evt.total * 100; // Do something with download progress

            bar1.set(percentComplete);
            console.log(percentComplete);
          }
        }, true);
        return xhr;
      },
      beforeSend: function beforeSend() {
        progressElem.show();
        bar1.set(100);
      },
      complete: function complete() {
        progressElem.hide();
        bar1.set(50);
      },
      success: function success(data) {
        dataToStore = data[0];
        $("input[name='presc_id']", myModal).val(data.presc_id);
        $.each(data[0], function (i, value) {
          problemes_select = "<select class='form-control select2 select2-hidden-accessible' style='width: 100%;' multiple='multiple'data-placeholder='Problèmes'  tabindex='-1' aria-hidden='true' name='problemes[" + value.medicament + "][]'> <option>Non conformité aux référentiel ou Contre indication</option> <option>Indication non traitée</option> <option>Sous dosage</option> <option>Surdosage</option> <option>Médicament non indiqué</option> <option>Interaction : A prendre en compte</option> <option>Interaction : Précaution d’emploi</option> <option>Interaction : Association déconseillée</option> <option>Interaction : Association contre-indiquée</option> <option>Interaction : Publiée (= hors GTIAM de l’A FSSAPS )  </option> <option>Voie et/ou administration inappropiée</option> <option>traitement non reçu</option> <option>Monitorage à suivre</option></select>";
          $reds = value.alertes.redondance;
          $iams = value.alertes.interaction;
          $pes = value.alertes.Precaution_emploi;
          $sur = value.alertes.Surdosage;
          $ial = value.alertes.interaction_alimentaire;
          $cia = value.alertes.contre_indication;
          $red_tmp = "";
          $iam_tmp = "";
          $phrase = "";
          $iam_phrase = "";
          $red_phrase = "";

          if ($reds != "") {
            $.each($reds, function (j, red) {
              $red_tmp += red.nom_sac_redondant;
            });
            $red_phrase = "<b>Redondance</b> : " + $red_tmp;
          }

          if ($iams != "") {
            $.each($iams, function (j, iam) {
              $iam_tmp += iam.item_sac_2;
            });
            $iam_phrase = '<b>Interaction :</b> ' + $iam_tmp;
          }

          if ($iam_phrase != "" || $red_phrase != "") {
            $phrase = $iam_phrase + ($iam_phrase != "" ? '<br/>' : '') + $red_phrase;
          }

          if ($reds != "" || $iams != "" || $pes != "" || $sur != "" || $ial != null || $cia != "") $back = "class='bg-red'"; // background color red
          else $back = "";
          $('.analyse_table > tbody').append("\n\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<select class=\"form-control\" name=\"prob_lvl[]\">\n\t\t\t\t\t\t\t\t\t".concat(options, "\n\t\t\t\t\t\t\t\t</select>\n\t\t\t\t\t\t\t</td>\n\t\t\t\t\t\t\t<td  ").concat($back, " style='white-space: nowrap; text-overflow:ellipsis; overflow: hidden; max-width:250px;' title='").concat(value.dci, "'> \n\t\t\t\t\t\t\t\t<input type='hidden' value='").concat(value.dci, "' name='med_sp[]'/>\n\t\t\t\t\t\t\t\t<input type='hidden' value='").concat(value.medicament, "' name='med_sp_id[]'/>\n\t\t\t\t\t\t\t\t<input type='hidden' value='").concat(encodeURI($phrase), "' name='med_sp_1[]'/>  \n\t\t\t\t\t\t\t\t<a href='https://medicaments.hic-sante.com/medicaments/").concat(value.medicament, "' target='_blank' class='text-bold'\n\t\t\t\t\t\t\t\t").concat($back ? "style='color:white'" : "style='color:black'", "\n\t\t\t\t\t\t\t\t>").concat(value.dci, "</a>\n\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t\t<td class='text-center'>\n\t\t\t\t\t\t\t\t").concat($back ? "<a href='#detail-alerte' class='alerte_btn' data-id='".concat(value.medicament, "'> <i class=\"fa fa-plus-circle fa-2x\"></i></a>") : '', " \n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t\t<td>").concat(problemes_select, "</td> \n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<input type='text' class='form-control' name='comment_prob[]' placeholder='commentraire '/>\n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<select class='form-control' name='ip[]'>\n\t\t\t\t\t\t\t\t\t<option></option> \n\t\t\t\t\t\t\t\t\t<option>Ajout (prescription nouvelle)</option> \n\t\t\t\t\t\t\t\t\t<option>Arr\xE9t</option> <option>Substitution/\xE9change</option> \n\t\t\t\t\t\t\t\t\t<option>Choix de la voie d'adminitration</option> \n\t\t\t\t\t\t\t\t\t<option>Suivie th\xE9rapeutique</option> \n\t\t\t\t\t\t\t\t\t<option>Optimisation des modalit\xE9s d'administration</option>\n\t\t\t\t\t\t\t\t\t<option>Adapatation posologique</option> \n\t\t\t\t\t\t\t\t</select>\n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t\t<td>\n\t\t\t\t\t\t\t\t<input type='text' class='form-control' name='comment_ip[]' placeholder='commentraire '/>\n\t\t\t\t\t\t\t</td> \n\t\t\t\t\t\t</tr"));
          $('.select2').select2(); // pour afficher select2
        });
        var user_id = $("input[name='user_id']").val();
        $.ajax({
          type: "POST",
          url: '/js/php/save_alerte_json.php',
          async: false,
          data: {
            data: JSON.stringify(dataToStore),
            user_id: user_id
          }
        }); // stockage du resultat dans un fichier
        //and finally show the modal

        myModal.modal({
          show: true
        });
      },
      error: function error(jqXHR, textStatus) {
        alert("Erreur Serveur: " + textStatus + " " + jqXHR);
      }
    });
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/patient/' + patient_id + '&' + presc_id + '/pre_analyse_interne',
      method: 'get',
      datatype: 'html',
      success: function success(data) {
        if (data.array_id.length == 0) {} else {
          for (var $x = 0; $x < data.array_id.length; $x++) {
            $('.analyse_table_interne > tbody').append("<tr>" + "<td> " + data.si[$x] + "</td>" + //"<td><button type='button' class='btn btn-primary alerte_btn' data-id='"+1+"'> Détails </button></td>"+ 
            "<td> " + data.alors[$x] + "</td>" + "<td> " + data.commentaire[$x] + "</td>" + "</tr");
          }
        }
      }
    });
  });
  /**
   * 
   * Lunch the processus of Thérapeutical analysis
   */

  $('.BTNANALYSE').on('click', function () {
    // afficher les details de l'Analyse thérapeutique 
    var myModal2 = $('#modal_analyse_therap');
    $('#div_body').empty();
    var patient_id = $(this).data('id');
    var presc_id = $(this).data('risque');
    $.ajax({
      //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
      url: '/patient/' + patient_id + '&' + presc_id + '/details_education',
      method: 'get',
      datatype: 'html',
      success: function success(data) {
        if (data.si.length == 0) {} else {
          $('#div_body').append("<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#si' aria-expanded='true' aria-controls='si'>" + "Si :" + "</a>" + "</h4>" + "</div>" + "<div id='si' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.si + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#titre' aria-expanded='true' aria-controls='titre'>" + "Titre :" + "</a>" + "</h4>" + "</div>" + "<div id='titre' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.titre + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#maladie' aria-expanded='true' aria-controls='maladie'>" + "Maladie :" + "</a>" + "</h4>" + "</div>" + "<div id='maladie' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.maladie + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#effet' aria-expanded='true' aria-controls='effet'>" + "Effet :" + "</a>" + "</h4>" + "</div>" + "<div id='effet' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.effet + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#voyage' aria-expanded='true' aria-controls='voyage'>" + "Voyage :" + "</a>" + "</h4>" + "</div>" + "<div id='voyage' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.voyage + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#act' aria-expanded='true' aria-controls='act'>" + "Act :" + "</a>" + "</h4>" + "</div>" + "<div id='act' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.act + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#utilisation' aria-expanded='true' aria-controls='utilisation'>" + "Utilisation :" + "</a>" + "</h4>" + "</div>" + "<div id='utilisation' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.utilisation + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#effet_indiserable' aria-expanded='true' aria-controls='effet_indiserable'>" + "Effet indésirable :" + "</a>" + "</h4>" + "</div>" + "<div id='effet_indiserable' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.effet_indiserable + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#regime' aria-expanded='true' aria-controls='regime'>" + "Regime allimentaire :" + "</a>" + "</h4>" + "</div>" + "<div id='regime' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body'>" + data.regime + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#url' aria-expanded='true' aria-controls='url'>" + "URL :" + "</a>" + "</h4>" + "</div>" + "<div id='url' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body' id='urlBody'> " + "</div>" + "</div>" + "</div>" + "<div class='panel panel-default'>" + "<div class='panel-heading' role='tab' id='headingTwo'>" + "<h4 class='panel-title'>" + "<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#pdff' aria-expanded='true' aria-controls='pdff'>" + "PDF :" + "</a>" + "</h4>" + "</div>" + "<div id='pdff' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>" + "<div class='panel-body' id='pdfBody'>" + "</div>" + "</div>" + "</div>" + "</div>");

          if (data.url != "") {
            $('#urlBody').append("<a href='" + data.url + "' target='_blank'>" + "Aller sur le site" + "</a>");
          } else {
            $('#urlBody').append("Aucun site enregistré");
          }

          if (data.pdf != null) {
            $('#pdfBody').append(data.pdf + "<a href='https://ibno-sina.com/pdfs/" + data.pdf + "' target='_blank'>" + "  Ouvrir");
          } else {
            $('#pdfBody').append("Aucun pdf enregistré");
          }
        } //$('#div_body').empty(); 
        //$('#modal_analyse_therap').modal({show : true}); 


        myModal2.modal({
          show: true
        }); // console.log(myModal2.show); 
      },
      error: function error(jqXHR, textStatus) {
        alert("Erreur Serveur: " + textStatus + " " + jqXHR);
      }
    });
  });
  /**
   * Show the details of analysis of the selected medicament
   */

  $('.analyse_table > tbody').on('click', '.alerte_btn', function () {
    var myModal = $('#modal_alertes');
    var sp_id = $(this).data('id');
    var alert = "<i class='glyphicon glyphicon-alert p44' style='color: red; '></i>";
    $('#modal_alertes table > tbody').empty(); //Vider tout les tableaux du modal détails alerte					

    $('#modal_alertes').find('.p44').remove(); //Vider tout les tableaux du modal détails alerte					

    $('.alrt_med').html("");
    var user_id = $("input[name='user_id']").val();
    $.ajax({
      url: "/js/json/alerte" + user_id + ".json",
      cache: false,
      success: function success(obj) {
        $("#alertes_accordion").empty();
        $.each(obj, function (key, value) {
          $row = "";

          if (value.medicament === sp_id) {
            $('.alrt_med').html("Médicament : " + value.dci + "");
            $.each(value.alertes.redondance, function (i, val) {
              //$('.i11').append(alert);
              $item_sac_2 = val.nom_sac_redondant;
              $row += "<tr>" + "<td><b>Médicament Redondant :</b> </td>" + "<td>" + $item_sac_2 + " </td>" + "</tr>"; //$("#redondance_table").append($row);
            });

            if ($row) {
              $row = "\n\t\t\t\t\t\t\t\t<div div class = \"panel box box-danger\" >\n\t\t\t\t\t\t\t\t<div class=\"alert-danger box-header\">\n\t\t\t\t\t\t\t\t\t<h4 class=\"box-title text-bold\">\n\t\t\t\t\t\t\t\t\t<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#redondance\" style=\"color: white\" class=\"collapsed\" aria-expanded=\"false\">\n\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-exclamation-circle\"></i> Redondance M\xE9dicaments\n\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t\t</h4>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div id=\"redondance\" class=\"panel-collapse collapse\" aria-expanded=\"false\" style=\"height: 0px;\">\n\t\t\t\t\t\t\t\t\t<div class=\"box-body\">\n\t\t\t\t\t\t\t\t\t\t<table class=\"table table-condensed table-striped table-bordered\">\n\t\t\t\t\t\t\t\t\t\t\t<tbody>".concat($row, "</tbody>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t");
              $("#alertes_accordion").append($row);
            }

            $row = "";
            $.each(value.alertes.contre_indication, function (i, val) {
              if (typeof val.hypersensibilité != "undefined") {
                $hyp = val.hypersensibilité;
                $row += "<tr>" + "<td><b>TERRAIN HYPERSENSIBILITE :</b></td>" + "<td>" + $hyp + " </td>" + "</tr>";
              }

              if (typeof val.pathologie != "undefined") {
                $path = val.pathologie;
                $row += "<tr>" + "<td><b>TERRAIN PATHOLOGIQUE :</b></td>" + "<td>" + $path + " </td>" + "</tr>";
              } // if ($row != "") {
              // 	$('.i1').append(alert);
              // 	$('#patient_ci_table > tbody').append($row);
              // }

            });

            if ($row) {
              $row = "\n\t\t\t\t\t\t\t\t<div div class = \"panel box box-danger\" >\n\t\t\t\t\t\t\t\t<div class=\"alert-danger box-header\">\n\t\t\t\t\t\t\t\t\t<h4 class=\"box-title\">\n\t\t\t\t\t\t\t\t\t<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#pat_ci\" style=\"color: white\" class=\"collapsed\" aria-expanded=\"false\">\n\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-exclamation-circle\"></i> Patient : Contre indication\n\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t\t</h4>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div id=\"pat_ci\" class=\"panel-collapse collapse\" aria-expanded=\"false\" style=\"height: 0px;\">\n\t\t\t\t\t\t\t\t\t<div class=\"box-body\">\n\t\t\t\t\t\t\t\t\t\t<table class=\"table table-condensed table-striped table-bordered\">\n\t\t\t\t\t\t\t\t\t\t\t<thead>\n\t\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t\t<th>Type de terrain </th>\n\t\t\t\t\t\t\t\t\t\t\t\t\t<td>Terrain patient</td>\n\t\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t</thead>\n\t\t\t\t\t\t\t\t\t\t\t<tbody>".concat($row, "</tbody>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t");
              $("#alertes_accordion").append($row);
            }

            $row = "";
            $.each(value.alertes.interaction, function (i, val) {
              if (value.alertes.interaction.length > 0) {
                if (val instanceof Array) $.each(val, function (j, element) {
                  $item_sac_int = element.item_sac_2;
                  $fiche_int = element.fiche_interaction;
                  $mecanisme = element.mecanisme;
                  $niveau = element.niveau_inter;
                  storeTableInteraction($item_sac_int, $fiche_int, $mecanisme, $niveau, alert, j);
                });else {
                  $item_sac_int = val.item_sac_2;
                  $fiche_int = val.fiche_interaction;
                  $mecanisme = val.mecanisme;
                  $niveau = val.niveau_inter;
                  storeTableInteraction($item_sac_int, $fiche_int, $mecanisme, $niveau, alert, "m" + i);
                }
              }
            });
            $row = ""; //$.each(value.alertes.Surdosage , function(i,val){

            if (Object.keys(value.alertes.Surdosage).length > 0) {
              $('.i4').append(alert);
              $profile = value.alertes.Surdosage.profile;
              $row += "<tr><td><b>Dose journalière prescrite :</b></td><td>" + value.alertes.Surdosage.dosePatient + " " + value.alertes.Surdosage.unitePatient + "</td></tr><tr>" + "<tr><td><b>Posologie maximale </b></td><td></td></tr><tr>" + "<td><b>Profile patient  : </b></td>" + "<td>" + $profile + " </td>" + "</tr><tr>" + "<td><b>Dose  : </b></td>" + "<td>" + value.alertes.Surdosage.dose + " " + value.alertes.Surdosage.unite + " </td>" + "</tr><tr>" + "<td><b>Fréquence maximale  : </b></td>" + "<td>" + (value.alertes.Surdosage.uniteFreqMax != "ADAPTER" ? value.alertes.Surdosage.freqMax + " " + value.alertes.Surdosage.uniteFreqMax : "ADAPTER") + "</td>" + "</tr><tr>" + "<td><b>Durée maximale :</b> </td>" + "<td>" + (value.alertes.Surdosage.durée != null ? value.alertes.Surdosage.durée : "ADAPTER SELON RAPPORT BENEFICE/RISQUE") + "</td>" + "</tr>"; //$('#posologie_ci_table > tbody').append($row);
            }

            if ($row) {
              $row = "\n\t\t\t\t\t\t\t\t<div div class = \"panel box box-danger\" >\n\t\t\t\t\t\t\t\t<div class=\"alert-danger box-header\">\n\t\t\t\t\t\t\t\t\t<h4 class=\"box-title\">\n\t\t\t\t\t\t\t\t\t<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#po_ci\" style=\"color: white\" class=\"collapsed\" aria-expanded=\"false\">\n\t\t\t\t\t\t\t\t\t<i class=\"fa fa-exclamation-circle\"></i>\t\n\t\t\t\t\t\t\t\t\tPosologie: Contre indication\n\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t\t</h4>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div id=\"po_ci\" class=\"panel-collapse collapse\" aria-expanded=\"false\" style=\"height: 0px;\">\n\t\t\t\t\t\t\t\t\t<div class=\"box-body\">\n\t\t\t\t\t\t\t\t\t\t<table class=\"table table-condensed table-striped table-bordered\">\n\t\t\t\t\t\t\t\t\t\t\t<tbody>".concat($row, "</tbody>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t");
              $("#alertes_accordion").append($row);
            }

            $row = ""; //});

            if (value.alertes.interaction_alimentaire != null) {
              $.each(value.alertes.interaction_alimentaire, function (i, val) {
                if (val != null) {
                  $produit = val.aliment;
                  $type_effet = val.type_effet;
                  $effet = val.effet;
                  $indic = val.indication;
                  $effet_pharmaco = val.effet_pharmaco;
                  $recommendation = val.recommendation;
                  $niveau_phyto = val.niveau;
                  $row += "\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td> <strong>Produit Alimentaire</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>".concat($produit, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Type d'int\xE9raction</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($type_effet, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Effet de l'int\xE9raction</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($effet, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Indication</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($indic, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Recommendation</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($recommendation, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\n\t\t\t\t\t\t\t\t\t\t\t<tr>\n\t\t\t\t\t\t\t\t\t\t\t\t<td><strong>Effet Pharmacologique Document\xE9</strong></td>\n\t\t\t\t\t\t\t\t\t\t\t\t<td>").concat($effet_pharmaco, "</td>\n\t\t\t\t\t\t\t\t\t\t\t</tr>\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\t\n\t\t\t\t\t\t\t\t\t\t"); // $row = "<tr>" +
                  // 	"<td>" + $produit + " </td>" +
                  // 	"<td>" + $type_effet + " </td>" +
                  // 	"<td>" + $effet + " </td>" +
                  // 	"<td>" + $indic + " </td>" +
                  // 	"<td>" + $recommendation + " </td>" +
                  // 	"<td>" + $effet_pharmaco + " </td>" +
                  // 	"</tr>";

                  if ($niveau_phyto === 1) {
                    // $('.i3').append(alert);
                    // $('#produit_ci_table > tbody').append($row);
                    title = "Contre Indication";
                  }

                  if ($niveau_phyto === 2) {
                    // $('.i7').append(alert);
                    // $('#produit_ad_table > tbody').append($row);
                    title = "Association déconseillée";
                  }

                  if ($niveau_phyto === 3) {
                    // $('.i10').append(alert);
                    // $('#produit_pe_table > tbody').append($row);
                    title = "Précaution d'emploi";
                  }
                }
              });
            }

            if ($row) {
              $row = "\n\t\t\t\t\t\t\t\t<div div class = \"panel box box-danger\" >\n\t\t\t\t\t\t\t\t<div class=\"alert-danger box-header\">\n\t\t\t\t\t\t\t\t\t<h4 class=\"box-title\">\n\t\t\t\t\t\t\t\t\t<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#int_alim\" style=\"color: white\" class=\"collapsed\" aria-expanded=\"false\">\n\t\t\t\t\t\t\t\t\t\t<i class=\"fa fa-exclamation-circle\"></i> Interaction Alimentaire: ".concat(title, "\n\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t\t</h4>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div id=\"int_alim\" class=\"panel-collapse collapse\" aria-expanded=\"false\" style=\"height: 0px;\">\n\t\t\t\t\t\t\t\t\t<div class=\"box-body\">\n\t\t\t\t\t\t\t\t\t\t<table class=\"table table-condensed table-striped table-bordered\">\n\t\t\t\t\t\t\t\t\t\t\t<tbody>").concat($row, "</tbody>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t");
              $("#alertes_accordion").append($row);
            }

            $row = "";
            $.each(value.alertes.Precaution_emploi, function (i, val) {
              if (typeof val.hypersensibilité != "undefined") {
                $hyp = val.hypersensibilité;
                $row += "<tr>" + "<td><b>TERRAIN HYPERSENSIBILITE :</b>   </td>" + "<td>" + $hyp + " </td>" + "</tr>";
              }

              if (typeof val.pathologie != "undefined") {
                $path = val.pathologie;
                $row += "<tr>" + "<td><b>TERRAIN PATHOLOGIQUE : </b></td>" + "<td>" + $path + " </td>" + "</tr>";
              } // if ($row != "") {
              // 	$('.i8').append(alert);
              // 	$('#patient_pe_table > tbody').append($row);
              //}

            });

            if ($row) {
              $row = "\n\t\t\t\t\t\t\t\t<div div class = \"panel box box-danger\" >\n\t\t\t\t\t\t\t\t<div class=\"alert-danger box-header\">\n\t\t\t\t\t\t\t\t\t<h4 class=\"box-title\">\n\t\t\t\t\t\t\t\t\t<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#po_ci\" style=\"color: white\" class=\"collapsed\" aria-expanded=\"false\">\n\t\t\t\t\t\t\t\t\t\t <i class=\"fa fa-exclamation-circle\"></i> Patient: Pr\xE9caution d'emploi \n\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t\t</h4>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div id=\"po_ci\" class=\"panel-collapse collapse\" aria-expanded=\"false\" style=\"height: 0px;\">\n\t\t\t\t\t\t\t\t\t<div class=\"box-body\">\n\t\t\t\t\t\t\t\t\t\t<table class=\"table table-condensed table-striped table-bordered\">\n\n\t\t\t\t\t\t\t\t\t\t\t<tbody>".concat($row, "</tbody>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t");
              $("#alertes_accordion").append($row);
            }

            $row = "";
            $.each(value.alertes.Association_deconseillé, function (i, val) {
              if (typeof val.hypersensibilité != "undefined") {
                $hyp = val.hypersensibilité;
                $row += "<tr>" + "<td><b>TERRAIN HYPERSENSIBILITE :</b></td>" + "<td>" + $hyp + " </td>" + "</tr>";
              }

              if (typeof val.pathologie != "undefined") {
                $path = val.pathologie;
                $row += "<tr>" + "<td><b>TERRAIN PATHOLOGIQUE :</b> </td>" + "<td>" + $path + " </td>" + "</tr>";
              } // if ($row != "") {
              // 	$('.i1').append(alert);
              // 	$('#patient_ad_table > tbody').append($row);
              // }

            });

            if ($row) {
              $row = "\n\t\t\t\t\t\t\t\t<div div class = \"panel box box-danger\" >\n\t\t\t\t\t\t\t\t<div class=\"alert-danger box-header\">\n\t\t\t\t\t\t\t\t\t<h4 class=\"box-title\">\n\t\t\t\t\t\t\t\t\t<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#pat_ad\" style=\"color: white\" class=\"collapsed\" aria-expanded=\"false\">\n\t\t\t\t\t\t\t\t\t\t <i class=\"fa fa-exclamation-circle\"></i> Patient: Association(s) D\xE9conseill\xE9e(s)\n\t\t\t\t\t\t\t\t\t</a>\n\t\t\t\t\t\t\t\t\t</h4>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t<div id=\"pat_ad\" class=\"panel-collapse collapse\" aria-expanded=\"false\" style=\"height: 0px;\">\n\t\t\t\t\t\t\t\t\t<div class=\"box-body\">\n\t\t\t\t\t\t\t\t\t\t<table class=\"table table-condensed table-striped table-bordered\">\n\t\t\t\t\t\t\t\t\t\t\t<tbody>".concat($row, "</tbody>\n\t\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t</div>\n\t\t\t\t\t\t\t\t");
              $("#alertes_accordion").append($row);
            }

            $row = "";
            return false;
          }
        });
      }
    });
    myModal.modal({
      show: true
    });
  });
  /**
   * Handle the accept checkbox
   * Modal : Avis sur l'IP
   */

  function onCheckIntervention() {
    var state = $(this)[0].checked;

    if (state) {
      var checkedCount = $('.execute_table > tbody  .checked ').length;
      var rowCount = $('.execute_table > tbody > tr').length;
      if (checkedCount + 1 == rowCount) $('.refus').prop('disabled', true);
    } else {
      $('.refus').prop('disabled', false);
    }
  }

  ;
  $('.execute_table > tbody').on('ifToggled', 'input', onCheckIntervention);
  /**
   * Handle the execute button on Avis sur l'IP Table
   * Populate and open the execute modal
   */

  $('.execute').on('click', function () {
    // Lancement de l'execution de devenir de l'IP
    var myModal = $('#modal_executer');
    var intervention_id = $(this).data('id');
    $('.execute_table > tbody').empty();
    $('.pri').empty();
    $('.sec').empty();
    $('.det').empty();
    $('.sef').empty();
    $('form', myModal).attr('action', '/analyse/' + intervention_id);
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/analyse/' + intervention_id + '/edit',
      method: 'get',
      datatype: 'json',
      success: function success(data) {
        var back = "";
        if (data['ip'].first_prob) $('.pri').append("<h5><i class='fa fa-exclamation-circle'></i> <u>Probl\xE8me Majeur :</u></h5><h5> ".concat(data['ip'].first_prob, "</h5>")).show();
        if (data['ip'].second_prob) $('.sec').append("<h5><i class='fa fa-exclamation-triangle'></i> <u>Probl\xE8me Mod\xE9r\xE9 :</u></h5><h5> ".concat(data['ip'].second_prob, "</h5>")).show();
        if (data['ip'].third_prob) $('.sef').append("<h5><i class='fa fa-exclamation'></i> <u>Probl\xE8me Mineur :</u></h5><h5> ".concat(data['ip'].third_prob, "</h5>")).show();
        if (data['ip'].global_comment) $('.det').append("<h5><i class='fa fa-pencil'></i>  <u>Rapport :</u></h5><h5> ".concat(data['ip'].global_comment, "</h5>")).show();
        $.each(data['lignes'], function (i, value) {
          // set the color of background in fct of the lvl of problem
          back = value.prob_lvl == '1' ? 'alert-danger' : value.prob_lvl == '2' ? 'alert-warning' : value.prob_lvl == '3' ? 'alert-success' : '';
          $('.execute_table > tbody').append( //Ajout des interventions Pharmacien au tableau
          "<tr>" + "<td class=" + back + ">" + value.med_sp + "</td>" + "<td>" + (value.med_sp_1 != null ? decodeURI(value.med_sp_1) : "/") + "</td>" + //Decode Uri , permet de formater le text dans un format HTML
          "<td>" + (value.problemes != null ? value.problemes : "/") + "</td>" + // "<td>" + value.comment_prob                                        + "</td>"+
          "<td>" + (value.ip != null ? value.ip : "/") + "</td>" + "<td>" + (value.comment_ip != null ? value.comment_ip : "RAS") + "</td>" + "<td class='text-center'><input type='checkbox' class='form-control flat-green' name='accept[]' checked /></td>" + "</tr");
          $('input[type="checkbox"].flat-green').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          }); //Affecter le fonction icheck aux input ajoutés.
        }); //and finally show the modal

        myModal.modal({
          show: true
        });
      },
      error: function error(jqXHR, textStatus) {
        alert("Erreur Serveur: " + textStatus + " " + jqXHR);
      }
    });
  });

  function storeTableInteraction($item_sac_int, $fiche_int, $mecanisme, $niveau, alert2, i) {
    $row = "<tr>" + "<td><b>Médicament en interaction : </b></td>" + "<td>" + $item_sac_int + " </td>" + // "<td><button class='btn btn-primary' data-toggle='collapse'  href='#"+i+"'> Fiche détails</button> </td>"+
    "</tr><tr>" + "<td><b>Mécanisme d'interaction : </b></td>" + "<td>" + $mecanisme + " </td>" + // "<td><button class='btn btn-primary' data-toggle='collapse'  href='#"+i+"'> Fiche détails</button> </td>"+
    "</tr>" + "<tr><td colspan = '2'> " + $fiche_int + "</td></tr>"; // "<tr> <td colspan='3' style='padding: 0 !important;'> <div  id=" + i + " class='accordian-body collapse' >" + $fiche_int +
    // "</div></td></tr><tr><td colspan='3' class='bg-aqua'></td></tr>";

    switch ($niveau) {
      case '1':
        // $('.i2').append(alert2);
        // $('#med_interaction_ci_table > tbody').append($row);
        title = "Contre Indication";
        break;

      case '2':
        // $('.i6').append(alert2);
        // $('#med_interaction_ad_table > tbody').append($row);
        title = "Association déconseillée";
        break;

      case '3':
        // $('.i9').append(alert2);
        // $('#med_interaction_pe_table > tbody').append($row);
        title = "Précaution d'emploi";
        break;

      case '4':
        // $('.i6').append(alert2);
        // $('#med_interaction_ad_table > tbody').append($row);
        title = "Association déconseillée";
        break;

      case '11':
        // $('.i2').append(alert2); 
        //$('#med_interaction_ci_div ').html(decodeURI($fiche_int));
        break;

      default:
        break;
    }

    $row = "\n\t\t\t<div div class = \"panel box box-danger\" >\n\t\t\t<div class=\"alert-danger box-header\">\n\t\t\t\t<h4 class=\"box-title\">\n\t\t\t\t<a data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#int_".concat(i, "\" style=\"color: white\" class=\"collapsed\" aria-expanded=\"false\">\n\t\t\t\t\t<i class=\"fa fa-exclamation-circle\"></i> Interaction(s) m\xE9dicamenteuse(s) : ").concat(title, "\n\t\t\t\t</a>\n\t\t\t\t</h4>\n\t\t\t</div>\n\t\t\t<div id=\"int_").concat(i, "\" class=\"panel-collapse collapse\" aria-expanded=\"false\" style=\"height: 0px;\">\n\t\t\t\t<div class=\"box-body\">\n\t\t\t\t\t<table class=\"table table-condensed table-striped table-bordered\">\n\n\t\t\t\t\t\t<tbody>").concat($row, "</tbody>\n\t\t\t\t</div>\n\t\t\t</div>\n\t\t\t</div>\n\t\t\t");
    $("#alertes_accordion").append($row);
  }
  /**
   * Download report of intervention on submit
   */


  function downloadIntervention() {
    if (confirm('Voulez vous une copie du rapport de l\'intervention pharmaceutique?')) {
      var report = $("#modal_analyse_pharm textarea[name='global_comment']").val();
      lunchDownloadIntervention(report);
    }
  }

  $("#modal_analyse_pharm #formInterventions").on('submit', downloadIntervention);

  function lunchDownloadIntervention(report) {
    text = {
      head: ['Date : ' + new Date().toISOString().slice(0, 10) + '\n'],
      core: [{
        text: 'Rapport Intervention Pharmaceutique',
        style: 'header',
        alignment: 'center'
      }, {
        style: 'core',
        text: report
      }]
    };
    downloadDocument(text, 'Intervention-pharmaceutique-' + new Date().toISOString().slice(0, 10) + ".pdf");
  }
});