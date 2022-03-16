// $(
// 	function () {

//******************************^^*****^^*****************************// 
// Prescription :
// Ajouter des lignes prescriptions
// Aide à la saise médicament dci ou médicament spécialité
// Affichage de la page de confirmation
// Envoi du formulaire au serveur HTTP , la méthode :POST
// Button to delete row
//******************************^^*****^^**************************************// 

toastr.options = {
	"positionClass": "toast-bottom-center",
	"hideDuration": "300",
	"timeOut": "2000",
	"escapeHtml ": true
};
var $options = "<option>BILLE(S)</option> <option>BOUFFEE(S)</option> <option>CACHET(S)</option> <option>GELULE(S)</option> <option>CAPSULE(S) MOLLE(S)</option> <option>CATAPLASME(S)</option> <option>CHAMP(S) MEDICAMENTEUX</option> <option>CIGARETTE(S)</option> <option>COMPRESSE(S)</option> <option>COMPRIME(S)</option> <option>DISPOSITIF(S) INTRAUTERIN(S)</option> <option>DISPOSITIF(S) TRANSDERMIQUE(S)</option> <option>DOSE(S)</option> <option>EMPLATRE(S)</option> <option>EPONGE(S)</option> <option>GAZE(S)</option> <option>GOMME(S)</option> <option>GRANULE(S)</option> <option>IMPLANT(S)</option> <option>INSERT(S)</option> <option>LYOPHILISAT(S)</option> <option>OVULE(S)</option> <option>PASTILLE(S)</option> <option>PATE(S)</option> <option>PILULE(S)</option> <option>SUPPOSITOIRE(S)</option> <option>TAMPON(S)</option> <option>TIMBRE(S)</option> <option>CUILLERE(S) A CAFE</option> <option>CUILLERE(S) A SOUPE</option> <option>CUILLERE(S) A DESSERT</option> <option>CUILLERE(S) MESURE</option> <option>GOUTTE(S)</option> <option>GOBELET(S)</option> <option>PULVERISATION(S)</option> <option>MESURE(S)</option> <option>PANSEMENT(S) ADHESIF(S)</option> <option>MECHE(S)</option> <option>SYSTEME DE DIFFUSION VAGINAL</option> <option>DISPOSITIF(S)</option> <option>RECIPIENT(S) UNIDOSE(S)</option> <option>BATON(S)</option> <option>FILM(S) ORODISPERSIBLE(S)</option> <option>DOSE(S) KG</option> <option>MATRICE(S)</option> <option>APPLICATION(S)</option>";
var lines = [];
var $modalPrescSelector = $('#modal_prescription');
var $row = "";
var g_idx = "";
// Listen on checbox events
function handleCheckboxEvent() {
	var input = $(this).parent().prev().val();
	$(this).parent().prev().val(1 - input);
};
$('#modal_prescription ,#modalPrescriptionVille, #prescription_box').on('ifToggled', 'input', handleCheckboxEvent);

/*Recherche médicament*/
$("#modal_prescription, #modalPrescriptionVille , #prescription_box").on('keydown', "input[name='medicament_dci']", function () {
	$(this).autocomplete({
		// appendTo: $(this).parent(), // selectionner l'element pour ajouter la liste des suggestion
		source: function (request, response) {
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: "/medicament",
				method: "POST",
				data: {
					phrase: request.term // value on field input
				},
				success: function (data, status, code) {
					response($.map(data.slice(0, 30), function (item) { // slice cut number of element to show
						dosage = "";
						if (item.status == "médicament") { //pour afficher le status du medicament sp en couleur
							style = "style='color:red;'";
						} else { // status : substance active
							//dosage = item.dosage+""+item.unite;
							style = "style='color: green;'";
						}
						status = "<i " + style + ">" + item.status + "</i>";

						return {
							label: item.medicament + " " + status, // pour afficher dans la liste des suggestions
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
		}, // END SOURCE
		minLength: 2,
		select: function (event, ui) {
			var unit = $("#modal_prescription,#modalPrescriptionVille, #prescription_box").find("select[name='unite']");
			var voie = $("#modal_prescription,#modalPrescriptionVille, #prescription_box").find("select[name='voie']");
			var input_sp_id = $("#modal_prescription,#modalPrescriptionVille, #prescription_box").find("input[name='med_sp_id']");
			$(input_sp_id).val("");
			// var input_dci = $(this).closest('tr').find("input[name='medicament_dci']");
			if (typeof ui.item.sp_id != 'undefined' || ui.item.sp_id != null) { // si le médicament selectionner est une spécialité
				get_unite_voie(ui.item.unite, ui.item.voies, unit, voie);
				$(this).prev().val(ui.item.sp_id);
			}

		},
		open: function () {
			$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
		},
		close: function () {
			$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
		}
	}).data("ui-autocomplete")._renderItem = function (ul, item) { //cette method permet de gérer l'affichage de la liste des suggestions
		var bg = "";
		if (item.alg == 1) {
			editPrescription
			bg = "style = 'background-color:green; color:white;'";
			$(this).addClass('type');
		}
		return $("<li></li>")
			.data("item.autocomplete", item) //récupérer les donnée de l'autocomplete
			//.attr( "data-value", item.id )
			.append("<a " + bg + ">" + item.label + "</a>") //ajouter à la liste de suggestions
			.appendTo(ul);
	};
});

/*Retourner l'unite et la voie d'administration de la specialite/Dci*/
function get_unite_voie(unite_data, voie_data, unit, voie) {
	$(unit).empty();
	$(voie).empty();
	if (unite_data.length == 0) { //Si le médicament ne contient aucune voie d'administration, on ajoute la liste des voies
		$(unit).append($options);
	} else
		$.each(unite_data, function (i, value) { //ajouter les unites coresspondant à la spécialité sélectionner
			$(unit).append("<option value=" + value.unite_nom + ">" + value.unite_nom + "</option>");
		});

	$.each(voie_data, function (i, value) { //ajouter les voie coresspondant à la spécialité sélectionner
		$(voie).append("<option value=" + value.cdf_nom + ">" + value.cdf_nom + "</option>");
	});
}

// Supprimer le médicament du tableau 
$('#tablePrescription > tbody').on('click', '.del_line', function (e) {
	e.stopPropagation(); // pour en cas 2 boutton dasn la meme ligne

	const $row = $(this).closest('tr');
	const index = $row.index();
	$row.remove();
	if ($(".up_line_btn").is(":visible")) {
		$(".up_line_btn").hide();
	}
	if ($(".add_line_btn").is(':hidden')) {
		$(".add_line_btn").show();
	}

	// supprimer le médicament du tablea lines
	lines.splice(index, 1);
});

$('#tableTraitement > tbody ').on('click', '.fa-times-circle', function () {
	const $row = $(this).closest('tr');
	const index = $row.index();
	$row.remove();

	// supprimer le médicament du tablea lines
	lines.splice(index, 1);
});

// Modifier le médicament du tableau 
$('#tablePrescription > tbody,#tableTraitement > tbody ').on('click', '.up_line', function () {
	let idx = $(this).index();

	// get the line from the index
	let up_line = lines[idx];
	//
	$modalPrescSelector.find("input[name='med_sp_id']").val(up_line.med_sp_id);
	$modalPrescSelector.find("select[name='type_j']").val(up_line.type_j);
	$modalPrescSelector.find("input[name='nbr_jours']").val(up_line.nbr_jours);

	$(".d_matin").iCheck(up_line.dose_matin == 0 ? 'uncheck' : 'check');
	$modalPrescSelector.find("input[name='dose_matin']").val(up_line.dose_matin);
	$modalPrescSelector.find("input[name='dose_mat']").val(up_line.dose_mat);

	$(".d_midi").iCheck(up_line.dose_midi == 0 ? 'uncheck' : 'check');
	$modalPrescSelector.find("input[name='dose_midi']").val(up_line.dose_midi);
	$modalPrescSelector.find("input[name='dose_mid']").val(up_line.dose_mid);

	$(".d_soir").iCheck(up_line.dose_soir == 0 ? 'uncheck' : 'check');
	$modalPrescSelector.find("input[name='dose_soir']").val(up_line.dose_soir);
	$modalPrescSelector.find("input[name='dose_soi']").val(up_line.dose_soi);

	$modalPrescSelector.find("input[name='dose_ac']").val(up_line.dose_ac);
	$(".d_av").iCheck(up_line.dose_avant_coucher == 0 ? 'uncheck' : 'check');
	$modalPrescSelector.find("input[name='dose_avant_coucher']").val(up_line.dose_avant_coucher);
	$modalPrescSelector.find("select[name='unite']").append(`<option value=${up_line.unite} > ${ up_line.unite }</option>`).is(":selected");
	$modalPrescSelector.find("select[name='voie']").append(`<option value=${up_line.voie} > ${ up_line.voie }</option>`).is(":selected");
	$modalPrescSelector.find("input[name='line_id']").val(up_line.id);
	$modalPrescSelector.find("input[name='medicament_dci']").val(up_line.medicament_dci).prop('readonly', true);


	if ($(".up_line_btn").is(":hidden")) {
		$(".up_line_btn").show();
	}
	if ($(".add_line_btn").is(':visible')) {
		$(".add_line_btn").hide();
	}
	$row = $(this);
	g_idx = idx;

});
// ajouter la line prescription au tableau lines
function upLinePrescription(e) {
	e.preventDefault();
	const form = $("form#addLinePrescription").serializeArray();
	const line = objectifyForm(form);
	const index = $row.index();
	//
	lines.splice(g_idx, 1);
	$row.remove();
	//
	$(".up_line_btn").toggle();
	$(".add_line_btn").toggle();

	// add form to lines
	let count = lines.push(line);

	// get textual format of Prescription
	let medicament = medicToText(line)

	// add to table
	appendToTable(medicament, count);
	resetForm();

	//reset form
	//$("form#addLinePrescription")[0].reset();
	$modalPrescSelector.find("input[name='medicament_dci']").attr("readonly", false);
}
$(".up_line_btn").on('click', upLinePrescription);


// ajouter la line prescription au tableau lines
function addLinePrescription(e) {
	e.preventDefault();
	if ($("form#addLinePrescription input[name='med_sp_id']").val() != "") {
		const form = $("form#addLinePrescription").serializeArray();
		const line = objectifyForm(form);

		// add form to lines
		let count = lines.push(line);

		// get textual format of Prescription
		let medicament = medicToText(line)

		// add to table
		appendToTable(medicament, count, null);
		// uncheckAll();
		//reset form
		// $("form#addLinePrescription")[0].reset();
		resetForm();

	} else {
		alert("Le médicament renseigné doit etre sélectionner de la liste des suggestions");
	}

}

function resetForm() {
	$("form#addLinePrescription input[name='medicament_dci']").val('');
	$("form#addLinePrescription input[name='dose_mat']").val('1');
	$("form#addLinePrescription input[name='dose_mid']").val('1');
	$("form#addLinePrescription input[name='dose_soi']").val('1');
	$("form#addLinePrescription input[name='dose_ac']").val('1');
	$("form#addLinePrescription input[name='nbr_jours']").val('1');
}
// $('form#addLinePrescription').on('reset', function (e) {
// 	var form = $("form#addLinePrescription");
// 	setTimeout(function () {
// 		form.find('input.icheck-input').each(function (index, element) {
// 			$(element).icheck('updated', function (node) {});
// 		});

// 	});
// });
$("form#addLinePrescription").on('submit', addLinePrescription);

/**
 * Uncheck all
 */
// function uncheckAll() {
// 	$(".d_matin").iCheck('uncheck');
// 	$(".d_midi").iCheck('uncheck');
// 	$(".d_soir").iCheck('uncheck');
// 	$(".d_av").iCheck('uncheck');
// }

// store prescription to database
function savePrescription() {
	if (lines.length == 0) {
		alert("Veuillez ajouter un médicament")
	} else {

		var formData = new FormData();
		const url = $modalPrescSelector.find("input[name='url']").val() !== "" ? $modalPrescSelector.find("input[name='url']").val() : "/patient/prescription";
		$("#savePrescription").attr('disabled', 'disabled');
		const dataToAppend = [{
				key: 'patient_id',
				value: $("input[name='patient_id']").val()
			},
			{
				key: 'date_prescription',
				value: $modalPrescSelector.find("input[name='date_prescription']").val()
			},
			{
				key: 'cons_id',
				value: $modalPrescSelector.find("input[name='cons_id']").val()
			},

			{
				key: 'med_sp_id',
				value: JSON.stringify(lines)
			},
			{
				key: '_method',
				value: $modalPrescSelector.find("input[name='method']").val() == "PUT" ? 'PATCH' : 'POST'
			},
		];

		dataToAppend.map((keyvalue) => {
			formData.append(keyvalue.key, keyvalue.value);
		})

		$.ajax({
			type: 'POST',
			url: url,
			processData: false,
			contentType: false,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			data: formData,
			dataType: "json",
			success: function (response) {
				window.location.reload();
			},
			error(exception, type, code) {
				toastr.error(exception.responseText);
			}
		});
	}
}

$("#savePrescription").on('click', savePrescription);

$("#prescrBtn").on('click', function () {
	$("#tablePrescription>tbody").empty();
});

$('.modal_act').on('click', function () {
	var myModal = $('#modal_act');
	var cons_id = $(this).data('id');
	$(".modal-body #cons_id").val(cons_id);
	$('form', myModal).attr('action', '/patient/acte/store');
	// and finally show the modal
	myModal.modal({
		show: true
	});
});

/*Dubliquer la prescription*/
$('.cloner').on('click', function () {
	$("#tablePrescription>tbody").empty();
	var $prescription_id = $(this).data('id');

	$.get({
		url: "/patient/prescription/" + $prescription_id,
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		success: function (data) {
			lines = [];
			var lignes_presc = data.lignes; // lignes de prescription
			var lignes_ips = data.intervention.lignes_i_p; // les intervention du médecin sur les lignes
			for (var i = 0; i < lignes_presc.length; i++) {
				var j = i;
				const ipMsg = lignes_ips[i].ip;
				const medicament = medicToText(lignes_presc[i])
				appendToTable(medicament, j + 1, ipMsg);
				lines.push(lignes_presc[i]);
			}

			$("#modal_prescription").modal({
				show: true
			});
		}
	});
});

/*
 * append line to medicament table
 */
function appendToTable(line, index = 1, ipMsg = null) {
	// let up_line = "";
	// if (ipMsg)
	up_line = `
				class = "up_line"
				style = 'cursor : pointer;'
				data - index = '${index - 1}'
				`;
	$("#tablePrescription > tbody").append(`<tr title = "Cliquer pour modifier le médicament"${up_line} ><td> ${line} </td> <td> <i class = 'fa fa-times-circle fa-1x del_line' style = 'color:red;cursor : pointer;' data-index = '${index-1}' ></i></td></tr>`);
}
/*
 * Transform line prescription to readable text
 */
function medicToText(line) {
	const toText = `<b> ${line.medicament_dci} </b> ${line.voie}. 
				${line.dose_matin != 0 ? line.dose_mat + " <b>" + line.unite.toLowerCase() + '</b> le <b class="text-info">Matin</b>, ' : ''}
				${line.dose_midi != 0 ? line.dose_mid + ' à <b class="text-green">Midi</b>, ' : ''}
				${line.dose_soir != 0 ? line.dose_soi + ' le <b class="text-orange">Soir</b>, ' : ''}
				${line.dose_avant_coucher != 0 ? line.dose_ac + ' <b class="text-red">Avant-coucher</b>.' : ''}
				Pendant: <b> ${line.nbr_jours} </b> ${line.type_j}
				`;
	return toText;
}

/*Supprimer la ligne Prescription*/
// $("a.deleteRowPrescription").on('click', function (event) {
// 	if (confirm('voulez vous supprimer cette ligne ?')) {
// 		let url = $(this).data('url');
// 		event.preventDefault();
// 		$.ajax({
// 			url: url,
// 			type: 'POST',
// 			method: 'DELETE',
// 			headers: {
// 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// 			},
// 		}).done((response) => {
// 			if (response.response == 'success') {
// 				$(this).closest('tr').remove();
// 				$(this).closest('tr').next('tr').remove();
// 				toastr.success(response.msg);
// 			} else toastr.error(response);
// 		});
// 	}
// });

/*
 * edit prescription on open modal
 */
$(".editPrescription").on('click', function () {
	const id = $(this).data('id');
	$.get(`/patient/prescription/${id}/edit`)
		.done(res => {
			lines = res.lignes;
			const date_prescription = res.date_prescription;
			const url = `/patient/prescription/${id}`;
			$modalPrescSelector.find("input[name='date_prescription']").val(date_prescription);
			$modalPrescSelector.find("input[name='url']").val(url);
			$modalPrescSelector.find("input[name='method']").val('PUT');
			lines.forEach((line, index) => {
				// get textual format of Prescription
				let medicament = medicToText(line)

				// add to table
				appendToTable(medicament, ++index, 1);
			});
		});
});


$("#modal_prescription").on('hide.bs.modal', function () {
	$modalPrescSelector.find("input[name='url']").val("");
	$modalPrescSelector.find("input[name='method']").val("");
	$modalPrescSelector.find("tbody").empty();
	if ($(".up_line_btn").is(":visible")) {
		$(".up_line_btn").hide();
	}
	if ($(".add_line_btn").is(':hidden')) {
		$(".add_line_btn").show();
	}
	lines = [];
});

function objectifyForm(formArray) {
	//serialize data function
	var returnArray = {};
	for (var i = 0; i < formArray.length; i++) {
		returnArray[formArray[i]['name']] = formArray[i]['value'];
	}
	return returnArray;
}

$("#modal_prescription, #prescription_box").on('change', '#prescriptions_type', function () {
	const type = $(this).val();

	if (type) {
		$.get('/admin/prescription-type/prescription-service/' + type)
			.done(res => {
				res.forEach((val, key) => {
					// add form to lines
					let count = lines.push(val);

					// get textual format of Prescription
					let medicament = medicToText(val)

					// add to table
					appendToTable(medicament, count, null);
				});
			})
			.fail(exception => {
				toastr.error(exception.responseText);
			});
	}
});
/*
 * Détails de l'hospitalisation 
 */
$(".detailPrescription").on('click', function (event) {
	$('#modal_detail_prescription ol').empty();
	const id = $(this).data('id');
	$.ajax({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
		},
		url: "/api/patient/prescription/" + id + "/lines",
		method: "get",
		datatype: "json",

		success: (data) => {
			var lines = data;
			lines.forEach(line => {

				$('#modal_detail_prescription ol').append(
					`
					<li class='mb-3'>
						${medicToText(line)}
					</li>
					
					`
				);
			});
		},
		error: function (jqXHR, textStatus) {
			alert("Request failed: " + textStatus + " " + jqXHR);
		},
	});
});
// });