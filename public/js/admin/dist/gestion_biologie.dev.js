"use strict";

var i = 0;

function addVariante() {
  var min = $('#min').val();
  var max = $('#max').val();
  var unite = $('#unite option:selected').val();
  var sexe = $('#sexe option:selected').val();
  $('table > tbody').append("\n        <tr>\n            <td>\n                <input type='hidden' name='variantes[".concat(i, "][min]' value=\"").concat(min, "\">").concat(min, "\n            </td>\n            <td>\n                <input type='hidden' name='variantes[").concat(i, "][max]' value=\"").concat(max, "\">").concat(max, "\n            </td>\n            <td>\n                <input type='hidden' name='variantes[").concat(i, "][unite]' value=\"").concat(unite, "\">").concat(unite, "\n            </td>\n            <td>\n                <input type='hidden' name='variantes[").concat(i, "][sexe]' value=\"").concat(sexe, "\">").concat(sexe, "\n            </td>\n            <td>\n                <span class='glyphicon glyphicon-trash fa-2x' style='cursor:pointer;'></span>\n            </td>\n        </tr>"));
  i++;
  $('#min').val("");
  $('#max').val("");
}

$('table').on('click', '.glyphicon', function () {
  //function to remove field with fa close button
  $(this).parent().parent().remove();
});