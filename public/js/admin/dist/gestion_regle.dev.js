"use strict";

$(function () {
  var options = {
    url: function url(phrase) {
      return "/admin/element/" + phrase; // url to send into server
    },
    getValue: "element",
    ajaxSettings: {
      // d'ont touch and mmodify
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      dataType: "json",
      method: "POST",
      data: {
        dataType: "json"
      }
    },
    preparePostData: function preparePostData(data) {
      data.phrase = $("input[name='element']").val(); // returned data from server , json format

      return data;
    },
    list: {
      onSelectItemEvent: function onSelectItemEvent() {
        var min = $("input[name='element']").getSelectedItemData().variantes[0].min;
        var max = $("input[name='element']").getSelectedItemData().variantes[0].max;
        var unite = $("input[name='element']").getSelectedItemData().variantes[0].unite;
        $("input[name='inf']").val(max);
        $("input[name='sup']").val(min);
        $(".unite").text(unite);
      }
    } // requestDelay: 10000 // delays for response serve

  };
  $("input[name='element']").easyAutocomplete(options);
  $('form').on('click', '#addMed', function () {
    // function to add new filed dynamlicly without refresh
    $("<div class='col-sm-4 col-sm-offset-0 float-left med_dci' > <label for='Médicament'>Médicament (DCI) liée :</label> <input type='hidden' name='medicament_dci_id[]'> <input type='text' class='form-control' name='medicament_dci' autocomplete='off'></div> <div class='col-sm-1'> <label for=''> </label> <input type='button' class='btn btn-info' id='addMed' style='margin-top: 25px;' value='+' /></div>").insertAfter($(this).parent());
    $(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer; margin-top:30px;'></i>");
  });
  $('form').on('click', '.fa.fa-times-circle', function () {
    $(this).parent().prev().remove();
    $(this).parent().remove();
  }); // fonction qui permet de stocker la regle de type PATIENT !

  $("#bout_01").click(function (e) {
    e.preventDefault();
    var form = $("#form_01"); // get data form

    $.ajax({
      url: "/admin/regle",
      method: 'POST',
      data: form.serialize(),
      // send data form to server
      datatype: 'json',
      success: function success(data, status) {
        //status = 'success'
        if (status == "success") {
          if (data != "") {
            $.each(data, function (i, value) {
              for (i = 0; i < value.length; i++) {
                //because each attribut has more than one error message
                alert(value[i]);
              }
            });
          } else alert("Ajout effetué avec succée !");
        }
      },
      error: function error(data, result, status) {
        // status = code d'erreur
        var errors = $.parseJSON(data.responseText); // because the reponse is a 'String' format , //responseText is when erros has been set

        $.each(errors.errors, function (key, value) {
          for (i = 0; i < value.length; i++) {
            //because each attribut has more than one error message
            alert(value[i]);
          }
        });
      },
      complete: function complete(result, status) {
        //status = 'success'
        if (window.console && window.console.log) {
          // check if console is availlable
          console.log(result + status);
        }
      }
    });
  }); // Fonction qui permet de stocker la regle de type MMTE !

  $("#bout_02").click(function (e) {
    e.preventDefault();
    var form = $("#form_02"); // get data form

    $.ajax({
      url: "/admin/regle",
      method: 'POST',
      data: form.serialize(),
      // send data form to server
      datatype: 'json',
      success: function success(data, status) {
        //status = 'success'
        if (status == "success") {
          if (data != "") {
            $.each(data, function (i, value) {
              for (i = 0; i < value.length; i++) {
                //because each attribut has more than one error message
                alert(value[i]);
              }
            });
          } else alert("Ajout effetué avec succée !");
        }
      },
      error: function error(data, result, status) {
        // status = code d'erreur
        var errors = $.parseJSON(data.responseText); // because the reponse is a 'String' format , //responseText is when erros has been set

        $.each(errors.errors, function (key, value) {
          for (i = 0; i < value.length; i++) {
            //because each attribut has more than one error message
            alert(value[i]);
          }
        });
      },
      complete: function complete(result, status) {
        //status = 'success'
        if (window.console && window.console.log) {
          // check if console is availlable
          console.log(result + status);
        }
      }
    });
  });
  $('#regle').change(function () {
    //fonction pour alterner entre les deux type de règles
    if ($(this).val() == "mmte") {
      $('.mmte').toggle();
      $('.element').toggle();
    } else {
      $('.element').toggle();
      $('.mmte').toggle();
    }
  }); //Fonction de recherche de medicament dci

  $("form").on('keydown', "input[name='medicament_dci']", function () {
    $(this).autocomplete({
      appendTo: $(this).parent(),
      // selectionner l'element pour ajouter la liste des suggestion
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
            response($.map(data.slice(0, 10), function (item) {
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
    }).data("ui-autocomplete")._renderItem = function (ul, item) {
      //cette method permet de gérer l'affichage de la liste des suggestions
      var bg = "";
      if (item.label.indexOf("NSFP") != -1) bg = "style = 'background-color:red;' ";
      return $("<li></li>").data("item.autocomplete", item) //récupérer les donnée de l'autocomplete
      //.attr( "data-value", item.id )
      .append("<a " + bg + ">" + item.label + "</a>") //ajouter à la liste de suggestions
      .appendTo(ul);
    };
  }); //fonction de recherche des classes pharmacotherapeutique

  $("form").on('keydown', ".classe", function () {
    $(this).autocomplete({
      appendTo: $(this).parent(),
      // selectionner l'element pour ajouter la liste des suggestion
      source: function source(request, response) {
        $.ajax({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          url: "/classeMedicament",
          dataType: "json",
          method: "POST",
          data: {
            phrase_classe: request.term // value on field input

          },
          success: function success(data, status, code) {
            response($.map(data.slice(0, 10), function (item) {
              // slice cut number of element to show
              return {
                label: item.cph_nom,
                // pour afficher dans la liste des suggestions
                classe_id: item.cph_code_pk,
                value: item.cph_nom // value c la valeur à mettre dans l'input this

              };
            }));
          }
        });
      },
      // END SOURCE
      minLength: 2,
      select: function select(event, ui) {
        $(this).prev().val(ui.item.classe_id);
      }
    });
  });
  $('.fa-edit').click(function () {
    var regle_id = $(this).data('id');
    $.ajax({
      //Récupérer l'enregistrement via l'id
      url: '/admin/regle/' + regle_id + '/edits',
      method: 'GET',
      datatype: 'json',
      success: function success(data, status) {
        $("#regle").val(data[0].regle);
        $("#element").val(data[0].element);
        $(".unite").val(data[0].unite);
        $("#inf").val(data[0].inf);
        $("#sup").val(data[0].sup); // $.each(data,function(i , value){ // Un ou plusieurs médicaments
        // });

        $("#modal_modifier_regle").modal({
          show: true
        });
      },
      error: function error(Jqxhr, status, result) {
        if (Jqxhr) {
          alert("Attention : " + status + "!");
        }
      }
    });
  });
  $(".regle_footer").on('change', ':input', function () {
    var active = this.checked ? "1" : "0";
    var regle_id = $(this).closest('td').data("id");
    event.preventDefault();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "/admin/regle/" + regle_id + "/edits",
      method: 'GET',
      data: {
        active: active
      },
      // send data form to server
      datatype: 'json',
      success: function success(data, status) {//status = 'success'
      },
      error: function error(data, result, status) {
        // status = code d'erreur
        alert(status);
      }
    });
  }); //Fonction de recherche de classe médicament			
});