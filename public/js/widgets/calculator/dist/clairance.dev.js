"use strict";

$(function () {
  $("form").on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      data: $(this).serialize(),
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
      },
      url: "/clairance",
      success: function success(data) {
        var age;
        if (data.age <= 21) age = "moins de 21 ans";else if (data.age <= 65) age = "moins de 65 ans";else age = "plus de 65 ans";
        $('#response').empty();
        $('#response').html("\n                    <div class=\"alert alert-success\">\n                        <h3><b> Valeurs normales</b></h3>\n                        <h3>Clairance de la cr\xE9atinine * : <b>".concat(toMax3Decimals(data.result), "</b></h3>\n                        <p>Estimation de la fonction r\xE9nale selon <b>").concat(data.method.nom, "</b></p>\n                    </div>\n                    <p class=\"clairance\">Le calcul a \xE9t\xE9 fait selon la formule de <b><a\n                                href=\"").concat(data.method.url, "\" class=\"smoothScroll\">").concat(data.method.nom, "</a></b> car\n                        le patient a <b>").concat(age, "</b></p>\n                    <p class=\"clairance d-none\">Elle est <b>normalis\xE9</b> pour la surface corporelle moyenne\n                        d'un adulte (<b>1,73 m<sup>2</sup></b>)</p>\n\n                    <div class=\"well centre\">\n                        <p class=\"centre\">Pour info <b>Clairance selon <a href=\"#\"\n                                    class=\"smoothScroll\"><abbr\n                                        title=\"Modification of Diet in Renal Disease\">MDRD</abbr></a></b>\n                            : <b class=\"vert\">").concat(toMax3Decimals(data.mdrd), "</b> </p>\n                    </div>\n                "));
      }
    });
  });

  function toMax3Decimals(x) {
    return +x.toFixed(3);
  }
});