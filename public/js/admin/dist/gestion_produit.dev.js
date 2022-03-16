"use strict";

$(function () {
  // $.getJSON("/js/json/general.json",function(obj){//Ajouter les type d'effet à la liste
  // 	$.each(obj,function(key,value){
  // 		if (value.type_effet != "") 
  //         $('#type').append("<option value="+value.type_effet+">"+value.type_effet+"</option>");
  // 	}); 
  // 	});
  $("#interactions_plantes").DataTable({ // "ordering": false,
    // "scrollX": true,
    // "scrollY": "400px",
    // "scrollCollapse": true,
    // "paging": false,
  }); //historique prescriptions

  $('.addPlanteArBtn').on('click', function () {
    // function to add new filed dynamlicly without refresh
    produit_arabe = $('#produit_arabe').val(); // $(this).parent().parent().parent().prepend("<tr><td><input type='text' class='form-control' placeholder='placer votre produit en arabe' name='produits_arabe[]' value='" + produit_arabe + "' readonly></td><td><i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i></td></tr>");

    $("#arabe_words").append("\n\t\t\t\t<li class=\"mt-1\"> \n\t\t\t\t<input type = 'hidden' name = 'produits_arabe[]' value = \"".concat(produit_arabe, "\"> \n\t\t\t\t").concat(produit_arabe, "\n\t\t\t\t<i class = 'bg-maroon fa fa-1x fa-times-circle ml-2 p-1 deleteArabeWord' style ='color:red;cursor : pointer;'> </i> \n\t\t\t\t</li>\n\t\t\t"));
    $('#produit_arabe').val("");
  });
  $("ul").on('click', ".deleteArabeWord", function () {
    $(this).parent().remove();
  });
  $('.addMedBtn').on('click', function () {
    //ajouter intercations
    var médicament = $('.médicament_dci').val();
    var médicament_id = $('.medicament_dci_id').val();
    var type = $('#type option:selected').val();
    var effet = $('#effet').val();
    var indic = $('#indic').val();
    var ef_pharm = $('#ef_pharm').val();
    var reco = $('#reco').val();
    var niveau = $('#niveau option:selected').text();
    var niveau1 = $('#niveau option:selected').val();
    if (médicament != "") $('.produit_tab > tbody').append("\n\t\t\t\t<tr>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<input type='hidden' name='medicament_dci_id[]' value=\"".concat(médicament_id, "\">").concat(médicament, "\n\t\t\t\t\t</td>\n\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<input type='hidden' name='effet_interaction[]' value=\"").concat(effet, "\">").concat(effet, "\n\t\t\t\t\t</td>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<input type='hidden' name='type_effet[]' value=\"").concat(type, "\">").concat(type, "\n\t\t\t\t\t</td>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<input type='hidden' name='indication[]' value=\"").concat(indic, "\">").concat(indic, "\n\t\t\t\t\t</td>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<input type='hidden' name='effet_pharmaco[]' value=\"").concat(ef_pharm, "\">").concat(ef_pharm, "\n\t\t\t\t\t</td>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<input type='hidden' name='recommendation[]' value=\"").concat(reco, "\">").concat(reco, "\n\t\t\t\t\t</td>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<input type='hidden' name='niveau[]' value=\"").concat(niveau1, "\" >").concat(niveau, "\n\t\t\t\t\t</td>\n\t\t\t\t\t<td>\n\t\t\t\t\t\t<span class='glyphicon glyphicon-trash fa-2x' style='cursor:pointer;'></span>\n\t\t\t\t\t<td>\n\t\t\t\t</tr>"));
    else toastr.error("Veuillez entrer le médicament DCI SVP !"); // empty the inputs fileds

    $('.médicament_dci').val("");
    $('.medicament_dci_id').val(""); // $('#type :selected').val("");
    // $('#niveau:selected').val("");

    $('#effet').val("");
    $('#indic').val("");
    $('#ef_pharm').val("");
    $('#reco').val("");
  });
  $('table').on('click', '.glyphicon', function () {
    //function to remove field with fa close button
    $(this).parent().parent().remove();
  }); //Fonction de recherche de medicament dci

  $("#medic_input").on('keydown', function () {
    $(this).autocomplete({
      // selectionner l'element pour ajouter la liste des suggestion
      appendTo: $(this).parent(),
      source: function source(request, response) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/medicamentDci",
          dataType: "json",
          method: "POST",
          data: {
            phrase_dci: request.term // value on field input

          },
          success: function success(data, status, code) {
            response($.map(data.slice(0, 20), function (item) {
              // slice cut number of element to show
              return {
                label: item.sac_nom,
                // pour afficher dans la liste des suggestions
                sac_id: item.sac_code_sq_pk,
                value: item.sac_nom // value c la valeur à mettre dans l'input this

              };
            }));
          }
        });
      },
      // END SOURCE
      minLength: 2,
      select: function select(event, ui) {
        $(this).prev().val(ui.item.sac_id);
      },
      open: function open() {
        $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
      },
      close: function close() {
        $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
      }
    });
  });
});