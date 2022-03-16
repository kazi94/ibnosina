$(function () {
    //******************************^^*****^^**************************************// 
    // Hospitalisation : 													   //					   //
    // Affectation des champs pour la modification 								   //			       //
    //******************************^^*****^^**************************************// 

    $('.edit_hospitalisation').on('click', function () { // traitement pour modifier un bilan
        var myModal = $('#modal_edit_hospitalisation');
        var hospitalisation_id = $(this).data('id'); // get bilan ID
        // now get the values from the table
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/hospitalisation/getHospitalisation/' + hospitalisation_id,
            method: 'POST',
            datatype: 'json',
            success: (data) => {

                // and set them in the modal:
                $('#service', myModal).val(data[0].service);
                $('#numbiais', myModal).val(data[0].num_biais);
                $('#chambre', myModal).val(data[0].chambre);
                $('#lit', myModal).val(data[0].lit);
                $('#motif', myModal).val(data[0].motifs);
                $('#date_admission', myModal).val(data[0].date_admission);
                $('#date_sortie', myModal).val(data[0].date_sortie);
                $("#motif_sortie")
                    .val(data[0].motif_sortie)
                    .is(":selected");
                $("#owned_by")
                    .val(data[0].owned_by)
                    .is(":selected");
                // $("#service_transfert")
                //     .val(data[0].service_transfert)
                //     .is(":selected");
                $('.up_hospitalisation', myModal).attr('action', '/hospitalisation/' + hospitalisation_id + '/edit');

            },
            error: function (jqXHR, textStatus) {

                console.log("Request failed: " + textStatus + " " + jqXHR);
            }
        });

        // and finally show the modal
        myModal.modal({
            show: true
        });
    });

    $('.edit_act_med').on('click', function () { // traitement pour modifier un bilan
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
            success: (data) => {

                // and set them in the modal:
                $('#cons_id', myModal).val(data[0].consultation_id);
                $('#actm', myModal).val(data[0].act_medicale_id);
                $('#patient_id', myModal).val(data[0].patient_id);
                $('#description', myModal).val(data[0].description);
                $('#date_act', myModal).val(data[0].date_act);
                $('.up_acts', myModal).attr('action', '/acts/' + act_id + '/edit');

            },
            error: function (jqXHR, textStatus) {

                console.log("Request failed: " + textStatus + " " + jqXHR);
            }
        });



        // and finally show the modal
        myModal.modal({
            show: true
        });
    });



    $('.edit_impression').on('click', function () { // traitement pour modifier un rapport
        var myModal = $('#modal_detail_impression');
        var hospitalisation_id = $(this).attr('id'); // get bilan ID
        // now get the values from the table
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {

                // $('.up_impression', myModal).attr('action', '/hospitalisation/' + hospitalisation_id + '/print');
                $('.up_impression', myModal).attr('action', '/patient/hospitalisation/print-report');
            },
            error: function (jqXHR, textStatus) {

                console.log("Request failed: " + textStatus + " " + jqXHR);
            }
        });



        // and finally show the modal
        myModal.modal({
            show: true
        });
    });

    //Show other works input's 
    $("#motif_sortie1").on('change', function () {
        if ($(this).val() == "autre") {
            $("#service_transfert1").show();
        } else $("#service_transfert1").hide();
    });
    $("#motif_sortie").on('change', function () {
        if ($(this).val() == "autre") {
            $("#service_transfert").show();
        } else $("#service_transfert").hide();
    });


    /*
     * Imprimer la demande d'hospitalisation
     */
    $("#modal_hospitalisation form").on('submit', function () {
        if (confirm("Voulez vous une copie de la demande d'hospitalisation ?")) {
            // get data from formulaire
            const service = $("#modal_hospitalisation select[name='service'] option:selected").val();
            console.log(patient);
            dd = {
                footer: {
                    columns: [{
                            width: '50%',
                            text: 'DATE, LE :',
                            style: 'core',

                        },
                        {
                            width: '50%',
                            text: 'VISA DU PRATICIEN',
                            style: 'core',

                        }
                    ], // end column

                },
                content: [{
                        image: 'data:image/png;base64,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',
                        fit: [80, 80],
                        alignment: 'center'
                    },

                    {
                        text: 'Centre Hospitalo-universitaire De Tlemcen\n Direction des activites medicales et paramedicales\n Sous direction de la gestion administrative du malade\n',
                        style: 'header1',
                        alignment: 'center'
                    }, {
                        text: 'DEMANDE D\'HOSPITALISATION',
                        style: 'h1',
                        alignment: 'center'
                    }, {
                        columns: [{
                                width: '50%',
                                text: 'Service :' + service + ' ',
                                style: 'core',

                            },
                            {
                                width: '50%',
                                text: 'Spécialité : ..............................................................',
                                style: 'core',

                            }
                        ], // end column
                    }, {
                        text: 'NOM ET GRADE DU PRATICIEN',
                        style: 'core',
                    }, {
                        text: 'AYANT ACCORDER L\'HOSPITALISATION',
                        style: 'core',
                    }, {
                        canvas: [{
                            type: 'line',
                            x1: 0,
                            y1: 20,
                            x2: 560,
                            y2: 20,
                            lineWidth: 0.8
                        }]
                    }, {
                        text: 'PATIENT',
                        style: 'header',
                        alignment: 'center'
                    }, {
                        columns: [{
                                width: '50%',

                                text: [
                                    'Nom : ' + patient.responseJSON.nom + ' \n',
                                    'Prénom : ' + patient.responseJSON.prenom + ' \n',
                                    'Age :  ' + patient.responseJSON.age + ' ans \n',
                                    'Heure d\'hospitalisation : ........................ \n',
                                ],
                                style: 'core',
                            },
                            {
                                width: '50%',
                                text: [
                                    'Nom de la salle : .....................................\n',
                                    'N°du Lit : .....................................\n',
                                    'Chef d\'unité : .................................. \n',
                                ],
                                style: 'core',
                            }
                        ], // end column
                    }, {
                        canvas: [{
                            type: 'line',
                            x1: 0,
                            y1: 20,
                            x2: 560,
                            y2: 20,
                            lineWidth: 0.8
                        }]
                    }, {
                        text: 'MALADE ORIENTE OU ADRESSE PAR',
                        style: 'header',
                        alignment: 'center'
                    }, {
                        text: 'Nom Prénom Grade....................................................................................',
                        style: 'core',
                    }, {
                        text: 'Etablissement....................................................................................',
                        style: 'core',
                    }, {
                        canvas: [{
                            type: 'line',
                            x1: 0,
                            y1: 20,
                            x2: 560,
                            y2: 20,
                            lineWidth: 0.8,

                        }]
                    }, {
                        text: 'GARDE MALADE',
                        style: 'header',
                        alignment: 'center'
                    }, {
                        text: 'Nom et Prénom du garde malade....................................................................................',
                        style: 'core',
                    }, {
                        text: 'Type d\identité présentée....................................................................................',
                        style: 'core',
                    }, {
                        text: 'Délivré le....................................................................................',
                        style: 'core',
                    },
                ],
                styles: {
                    header1: {
                        fontSize: 16,
                        bold: true,
                        margin: [0, 2, 0, 10]
                    },
                    header: {
                        fontSize: 14,
                        bold: true,
                        lineHeight: 1,
                        decoration: 'underline',
                        margin: [0, 2, 0, 10]
                    },
                    h1: {
                        fontSize: 20,
                        bold: true,
                        lineHeight: 3,
                    },
                    core: {
                        lineHeight: 1.5,
                        margin: [0, 0, 0, 3]
                    }
                },
                defaultStyle: {
                    columnGap: 20
                },
                pageMargins: [15, 10, 15, 40],

            };
            download(dd, 'demande-hospitalisation' + new Date().toISOString().slice(0, 10) + ".pdf");
        }
    });

    /*
     * Détails de l'hospitalisation 
     */
    $(".detailHospitalisation").on('click', function (event) {
        $('#modal_detail_hospitalisation table tbody').empty();
        const id = $(this).data('id');
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/api/patient/hospitalisation/" + id,
            method: "get",
            datatype: "json",

            success: (data) => {
                var motif_sortie = "...";
                if (data.motif_sortie == 'autre')
                    motif_sortie = `<span class='label label-success text-sm'> Vers service ${data.service_transfert}</span>`;
                else if (data.motif_sortie == 'hopital')
                    motif_sortie = "<span class='label label-danger text-sm'>Sortie du CHU</span>";
                else if (data.motif_sortie == 'décés')
                    motif_sortie = "<span class='label label-danger text-sm'>Décédé</span>";


                $('#modal_detail_hospitalisation table tbody').append(
                    `
					<tr>
						<td><b> Hopital</b></td>
						<td>${data.hopital ?? "..."}</td>
					</tr>
					<tr>
						<td><b>Service</b></td>
						<td>${data.service ?? "..."}</td>
					</tr>
					<tr>
						<td><b>Numéro de biais</b></td>
						<td>${data.num_biais ?? "..."}</td>
					</tr>					
					<tr>
						<td><b>Chambre</b></td>
						<td>${data.chambre ?? "..."}</td>
					</tr>
					<tr>
						<td><b>Lit</b></td>
						<td>${data.lit ?? "..."}</td>
					</tr>
					<tr>
						<td><b>Motif d'hospitalisation</b></td>
						<td style="word-break: break-word;">${data.motifs ?? "..."}</td>
					</tr>
					<tr>
						<td><b> Date d'admission</b></td>
						<td>${data.date_admission ?? "..."}</td>
                    </tr>
                    <tr>
                        <td><b>Date de sortie</b></td>
                        <td>${data.date_sortie ?? "..."}</td>
                    </tr>	
                                        <tr>
                        <td><b>Motif de sortie</b></td>
                        <td>${motif_sortie}</td>
                    </tr>                    																				
				`
                );
            },
            error: function (jqXHR, textStatus) {
                alert("Request failed: " + textStatus + " " + jqXHR);
            },
        });
    });
});