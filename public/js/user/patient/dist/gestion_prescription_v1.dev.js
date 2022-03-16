"use strict";

$(function () {
  //******************************^^*****^^*****************************// 
  // Prescription :
  // Ajouter des lignes prescriptions
  // Aide à la saise médicament dci ou médicament spécialité
  // Affichage de la page de confirmation
  // Envoi du formulaire au serveur HTTP , la méthode :POST
  // Button to delete row
  //******************************^^*****^^**************************************// 
  $options = "<option>BILLE(S)</option> <option>BOUFFEE(S)</option> <option>CACHET(S)</option> <option>GELULE(S)</option> <option>CAPSULE(S) MOLLE(S)</option> <option>CATAPLASME(S)</option> <option>CHAMP(S) MEDICAMENTEUX</option> <option>CIGARETTE(S)</option> <option>COMPRESSE(S)</option> <option>COMPRIME(S)</option> <option>DISPOSITIF(S) INTRAUTERIN(S)</option> <option>DISPOSITIF(S) TRANSDERMIQUE(S)</option> <option>DOSE(S)</option> <option>EMPLATRE(S)</option> <option>EPONGE(S)</option> <option>GAZE(S)</option> <option>GOMME(S)</option> <option>GRANULE(S)</option> <option>IMPLANT(S)</option> <option>INSERT(S)</option> <option>LYOPHILISAT(S)</option> <option>OVULE(S)</option> <option>PASTILLE(S)</option> <option>PATE(S)</option> <option>PILULE(S)</option> <option>SUPPOSITOIRE(S)</option> <option>TAMPON(S)</option> <option>TIMBRE(S)</option> <option>CUILLERE(S) A CAFE</option> <option>CUILLERE(S) A SOUPE</option> <option>CUILLERE(S) A DESSERT</option> <option>CUILLERE(S) MESURE</option> <option>GOUTTE(S)</option> <option>GOBELET(S)</option> <option>PULVERISATION(S)</option> <option>MESURE(S)</option> <option>PANSEMENT(S) ADHESIF(S)</option> <option>MECHE(S)</option> <option>SYSTEME DE DIFFUSION VAGINAL</option> <option>DISPOSITIF(S)</option> <option>RECIPIENT(S) UNIDOSE(S)</option> <option>BATON(S)</option> <option>FILM(S) ORODISPERSIBLE(S)</option> <option>DOSE(S) KG</option> <option>MATRICE(S)</option> <option>APPLICATION(S)</option>";
  $('#tablePrescription > tbody').on('ifUnchecked', 'input', function (event) {
    $(this).parent().prev('input').val('0');
  });
  $('#tablePrescription > tbody').on('ifChecked', 'input', function (event) {
    $(this).parent().prev('input').val('1');
  });
  /*Recherche médicament*/

  $("tbody").on('keydown', "input[name='medicament_dci']", function () {
    $(this).autocomplete({
      appendTo: $(this).parent(),
      // selectionner l'element pour ajouter la liste des suggestion
      source: function source(request, response) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/medicament",
          method: "POST",
          data: {
            phrase: request.term // value on field input

          },
          success: function success(data, status, code) {
            response($.map(data.slice(0, 30), function (item) {
              // slice cut number of element to show
              dosage = "";

              if (item.status == "médicament") {
                //pour afficher le status du medicament sp en couleur
                style = "style='color:red;'";
              } else {
                // status : substance active
                //dosage = item.dosage+""+item.unite;
                style = "style='color: green;'";
              }

              status = "<i " + style + ">" + item.status + "</i>";
              return {
                label: item.medicament + " " + status,
                // pour afficher dans la liste des suggestions
                //sac_id: item.sac_code_sq_pk,
                //dosage: item.dosage,
                //unite:  item.unite, 
                unite: item.unite,
                voies: item.voies,
                sp_id: item.sp_id,
                value: item.medicament // value c la valeur à mettre dans l'input this

              };
            }));
          }
        });
      },
      // END SOURCE
      minLength: 2,
      select: function select(event, ui) {
        var unit = $(this).closest('tr').find("td >select[name='unites[]']");
        var voie = $(this).closest('tr').find("td > select[name='voie[]']");
        var input_sp_id = $(this).closest('tr').find("input[name='med_sp_id[]']");
        $(input_sp_id).val(""); // var input_dci = $(this).closest('tr').find("input[name='medicament_dci']");

        if (typeof ui.item.sp_id != 'undefined' || ui.item.sp_id != null) {
          // si le médicament selectionner est une spécialité
          get_unite_voie(ui.item.unite, ui.item.voies, unit, voie);
          $(this).prev().val(ui.item.sp_id);
        }
      },
      open: function open() {
        $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
      },
      close: function close() {
        $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
      }
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
      //cette method permet de gérer l'affichage de la liste des suggestions
      var bg = "";

      if (item.alg == 1) {
        bg = "style = 'background-color:green; color:white;'";
        $(this).addClass('type');
      }

      return $("<li></li>").data("item.autocomplete", item) //récupérer les donnée de l'autocomplete
      //.attr( "data-value", item.id )
      .append("<a " + bg + ">" + item.label + "</a>") //ajouter à la liste de suggestions
      .appendTo(ul);
    };
  });
  /*Retourner l'unite et la voie d'administration de la specialite/Dci*/

  function get_unite_voie(unite_data, voie_data, unit, voie) {
    $(unit).empty();
    $(voie).empty();

    if (unite_data.length == 0) {
      //Si le médicament ne contient aucune voie d'administration, on ajoute la liste des voies
      $(unit).append($options);
    } else $.each(unite_data, function (i, value) {
      //ajouter les unites coresspondant à la spécialité sélectionner
      $(unit).append("<option value=" + value.unite_nom + ">" + value.unite_nom + "</option>");
    });

    $.each(voie_data, function (i, value) {
      //ajouter les voie coresspondant à la spécialité sélectionner
      $(voie).append("<option value=" + value.cdf_nom + ">" + value.cdf_nom + "</option>");
    });
  }

  $("#tablePrescription>tbody").on('click', '#add_prescription', function () {
    $(this).closest('tbody').append("<tr> <td colspan='2'> <input type='hidden' name='med_sp_id[]' /> <input type='text' class='form form-control' autocomplete='off' placeholder='Médicament DCI ou médicament commerciale' name='medicament_dci' data-toggle='tooltip' data-placement='bottom'  data-original-title='' > </td><td width='80px' ><select class='form form-control' name='voie[]' ></select></td>	<td width='80px'><input type='text' class='form form-control' name='dose[]' value='0'></td> <td> <input type='hidden' name='dose_matin[]' value='0'> <input type='checkbox' class='form-control flat-green' name='' onclick='this.previousSibling.value=1-this.previousSibling.value'  /></td> <td> <input type='hidden' name='dose_midi[]' value='0'> <input type='checkbox' class='form-control flat-green' name='' onclick='this.previousSibling.value=1-this.previousSibling.value'   /></td> <td> <input type='hidden' name='dose_soir[]' value='0'> <input type='checkbox' class='form-control flat-green' name=''  onclick='this.previousSibling.value=1-this.previousSibling.value'  /></td> <td> <input type='hidden' name='dose_av[]' value='0'> <input type='checkbox' class='form-control flat-green' name=''   onclick='this.previousSibling.value=1-this.previousSibling.value'   /></td> <td width='97px'> <select class='form form-control' name='unites[]'> </select> </td> <td> <input type='text' class='form-control' name='nbr_jours[]' value='0'> </td> <td width='97px'> <select id='type_j' name='type_j[]' class='form-control'> <option>jours</option> <option>semaines</option> <option>mois</option> </select> </td>	 <td style='text-align:center;'> <button type='button' class='btn btn-info btn-flat' id='add_prescription'>+</button> </td> </tr>");
    $(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer;' onclick=\"$(this).closest('tr').remove();\"></i>");
    $('input[type="checkbox"].flat-green').iCheck({
      checkboxClass: 'icheckbox_flat-green'
    });
  });
  $('.modal_act').on('click', function () {
    var myModal = $('#modal_act');
    var cons_id = $(this).data('id');
    $(".modal-body #cons_id").val(cons_id);
    $('form', myModal).attr('action', '/patient/acte/store'); // and finally show the modal

    myModal.modal({
      show: true
    });
  });
  $("#tablePrescription2>tbody").on('click', '#add_prescription2', function () {
    $(this).closest('tbody').append("<tr> <td colspan='2'> <input type='hidden' name='med_sp_id[]' /> <input type='text' class='form form-control' autocomplete='off' placeholder='Médicament DCI ou médicament commerciale' name='medicament_dci' data-toggle='tooltip' data-placement='bottom'  data-original-title='' > </td><td width='80px' ><select class='form form-control' name='voie[]' ></select></td>	<td width='80px'><input type='text' class='form form-control' name='dose[]' value=''></td> <td><input type='checkbox' class='form-control flat-green' name='dose_matin[]'  checked /></td> <td><input type='checkbox' class='form-control flat-green' name='dose_midi[]'   checked /></td> <td><input type='checkbox' class='form-control flat-green' name='dose_soir[]'   checked /></td> <td><input type='checkbox' class='form-control flat-green' name='dose_av[]'     checked /></td> <td width='97px'> <select class='form form-control' name='unites[]'> </select> </td> <td> <input type='text' class='form-control' name='nbr_jours[]' value=''> </td> <td width='97px'> <select id='type_j' name='type_j[]' class='form-control'> <option>jours</option> <option>semaines</option> <option>mois</option> </select> </td>	 <td style='text-align:center;'> <button type='button' class='btn btn-info btn-flat' id='add_prescription'>+</button> </td> </tr>");
    $(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer; '></i>");
    $('input[type="checkbox"].flat-green').iCheck({
      checkboxClass: 'icheckbox_flat-green'
    });
  });
  /*Cloner la prescription*/

  $('.cloner').on('click', function () {
    var $prescription_id = $(this).data('id');
    $.get({
      url: "/patient/prescription/" + $prescription_id,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function success(data) {
        var lignes = data[0];
        var ips = data[1];

        for (var i = 0; i < lignes.length; i++) {
          $dose = lignes[i][0].dose;
          $matin = lignes[i][0].dose_matin != null ? "checked" : "";
          $midi = lignes[i][0].dose_midi != null ? "checked" : "";
          $soir = lignes[i][0].dose_soir != null ? "checked" : "";
          $av = lignes[i][0].dose_avant_coucher != null ? "checked" : "";
          $ipMsg = ips[i].ip;
          $("#tablePrescription>tbody").prepend("<tr data-toggle=\'tooltip\' data-placement='top'  title='" + $ipMsg + "' >" + "<td colspan='2'><input type='hidden' name='last_presc_id' value=" + $prescription_id + " />" + "<input type='hidden' name='med_sp_id[]' value=" + lignes[i][0].med_sp_id + " />" + lignes[i][1] + "</td>" + "<td width='80px' >" + "<input type='hidden' name='voie[]' value=" + lignes[i][0].voie + " />" + lignes[i][0].voie + "</td>" + "<td width='80px'> <input type='text' class='form form-control' name='dose[]' value='" + $dose + "'></td>" + "<td><input type='checkbox' class='form-control flat-green' name='dose_matin[]'  " + $matin + " /></td>" + "<td><input type='checkbox' class='form-control flat-green' name='dose_midi[]'   " + $midi + " /></td>" + "<td><input type='checkbox' class='form-control flat-green' name='dose_soir[]'   " + $soir + " /></td>" + "<td><input type='checkbox' class='form-control flat-green' name='dose_av[]'     " + $av + " /></td>" + "<td width='97px'>" + "<select class='form form-control' name='unites[]' >" + "<option selected>" + lignes[i][0].unite + "</option>" + "</select>" + "</td>" + "<td> <input type='text' class='form-control' name='nbr_jours[]' value=" + lignes[i][0].nbr_jours + "> </td>" + "<td> <select name='type_j[]' class='form-control'> <option selected>jours</option> <option>semaines</option> <option>mois</option> </select> </td>" + "<td style='text-align:center;'><i class='fa fa-times-circle' style='color:red;cursor : pointer;' onclick='$(this).closest(\"tr\").remove();'></i></td>" + "</tr>");
          $('input[type="checkbox"].flat-green').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          }); // $('[data-toggle="tooltip"]').tooltip()
        }

        $("#modal_prescription").modal({
          show: true
        });
      }
    });
  });
  /*Supprimer la ligne*/

  $("a.deleteRowPrescription").click(function (event) {
    var _this = this;

    if (confirm('voulez vous supprimer cette ligne ?')) {
      var url = $(this).data('url');
      event.preventDefault();
      $.ajax({
        url: url,
        type: 'POST',
        method: 'DELETE',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }).done(function (response) {
        if (response.response == 'success') {
          $(_this).closest('tr').remove();
          $(_this).closest('tr').next('tr').remove();
          toastr.success(response.msg);
        } else toastr.error(response);
      });
    }
  });
});