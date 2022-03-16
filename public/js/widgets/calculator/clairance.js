$(function () {
    $("form").on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            data: $(this).serialize(),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/clairance",
            success: function (data) {
                var age;
                if (data.age <= 21) age = "moins de 21 ans";
                else if (data.age <= 65) age = "moins de 65 ans";
                else age = "plus de 65 ans";

                $('#response').empty();
                $('#response').html(`
                    <div class="alert alert-success">
                        <h3><b> Valeurs normales</b></h3>
                        <h3>Clairance de la créatinine * : <b>${toMax3Decimals(data.result)}</b></h3>
                        <p>Estimation de la fonction rénale selon <b>${data.method.nom}</b></p>
                    </div>
                    <p class="clairance">Le calcul a été fait selon la formule de <b><a
                                href="${data.method.url}" class="smoothScroll">${data.method.nom}</a></b> car
                        le patient a <b>${age}</b></p>
                    <p class="clairance d-none">Elle est <b>normalisé</b> pour la surface corporelle moyenne
                        d\'un adulte (<b>1,73 m<sup>2</sup></b>)</p>

                    <div class="well centre">
                        <p class="centre">Pour info <b>Clairance selon <a href="#"
                                    class="smoothScroll"><abbr
                                        title="Modification of Diet in Renal Disease">MDRD</abbr></a></b>
                            : <b class="vert">${toMax3Decimals(data.mdrd)}</b> </p>
                    </div>
                `);


            }
        });
    });

    function toMax3Decimals(x) {
        return +x.toFixed(3)
    }
});