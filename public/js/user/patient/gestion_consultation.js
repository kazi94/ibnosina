//******************************^^*****^^*****************************// 
// Consultation :
// Ajouter des lignes consultation
// Affichage de la page de confirmation
// Envoi du formulaire au serveur HTTP , la méthode :POST
// Button to delete row
//******************************^^*****^^**************************************//

// const SIGNES = ["Fièvre", "Frisson", "Sueurs", "Asthénie", "Anorexie", "Courbatures", "Myalgies", "Toux",
// 	"Expectorations", "Dyspnée", "Rhiorrhée", "Pharyngite", "Agueussie", "Anosmie", "Diarhées", "Douleur abdominale", "Nausée",
// 	"Vomissement", "Malaise", "Céphalées", "Contage", "prise d'AINS", "prise d'IEC", "prise d'ARA2", "ADO", "Corticoîdes", "Immunosuppresseurs"
// ]
var btnFinish = $('<input>').attr({
	type: 'submit',
	value: 'Valider'
}).addClass('btn btn-info');

$('#smartwizard').smartWizard({
	selected: 0,
	theme: 'dots',
	justified: true,
	autoAdjustHeight: false,
	transitionEffect: 'fade',
	showStepURLhash: false,
	lang: { // Language variables for button
		next: 'Suivant',
		previous: 'Précédent'
	},
	toolbarSettings: {
		toolbarPosition: 'bottom', // none, top, bottom, both
		toolbarButtonPosition: 'right', // left, right, center
		showNextButton: true, // show/hide a Next button
		showPreviousButton: true, // show/hide a Previous button
		toolbarExtraButtons: [btnFinish]
	}

});

// Details de la consultation
$(".detailConsultation").on('click', function (event) {
	$('#modal_detail_consultation table tbody').empty();
	const id = $(this).data('id');
	$.ajax({
		headers: {
			"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
		},
		url: "/api/patient/consultation/" + id,
		method: "get",
		datatype: "json",

		success: (data) => {

			const signes = mapSignes(data.consultations.signes);

			$('#modal_detail_consultation table tbody').append(
				`
					<tr>
						<td><b> Motif de la consultation</b></td>
						<td style="word-break: break-word;">${data.consultations.motif ?? "..."}</td>
					</tr>
					<tr>
						<td><b>Signes fonctionnels</b></td>
						<td style="word-break: break-word;">${signes ?? "..."}</td>
					</tr>
					<tr>
						<td><b> Début des symptômes</b></td>
						<td style="word-break: break-word;">${data.consultations.debut_symptome ?? "..."}</td>
					</tr>					
					<tr>
						<td><b> Examens physiques</b></td>
						<td style="word-break: break-word;">${data.consultations.examen ?? "..."}</td>
					</tr>
					<tr>
						<td><b> Certificat</b></td>
						<td style="word-break: break-word;">${data.consultations.certificat ?? "..."}</td>
					</tr>
					<tr>
						<td><b> Lettre d'orientation</b></td>
						<td style="word-break: break-word;">${data.consultations.orientation ?? "..."}</td>
					</tr>
					<tr>
						<td><b> Compte rendu</b></td>
						<td style="word-break: break-word;">${data.consultations.compte_rendu ?? "..."}</td>
					</tr>																				
				`
			);
		},
		error: function (jqXHR, textStatus) {
			alert("Request failed: " + textStatus + " " + jqXHR);
		},
	});
});
/*
 * Modal add consultation
 */
var isConsultationShown;
$('#modal_consultation').on('show.bs.modal', function (event) {
	// initSignes();
	// check if modal wasn't  open
	if (!isConsultationShown) {
		console.log('isConsultationShown :>> ', isConsultationShown);
		$.ajax({
			headers: {
				"X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
			},
			url: "/api/patient/" + patient.responseJSON.id + "/profile",
			method: "get",
			datatype: "json",

			success: (data) => {
				let patient = data["patient"];
				let pathologies = data["pathologies"];
				const pathologies_v1 = data["pathologies_v1"];
				let allergiess = data["allergies"];

				//Map elements to select2 data struture && chech matched elements
				var paths = setMapping(pathologies, patient.pathologies);
				var ants_fam = setMapping(pathologies_v1, patient.antecedents_familliaux);
				var allergies = setMapping(allergiess, patient.allergies);
				console.log('patient :>> ', patient);
				$("#modal_consultation .pathologies").select2({
					data: paths,
				});
				$("#modal_consultation .ants_fam").select2({
					data: ants_fam,
				});
				$("#modal_consultation .allergies").select2({
					data: allergies,
				});
				isConsultationShown = true;

			},
			error: function (jqXHR, textStatus) {
				alert("Request failed: " + textStatus + " " + jqXHR);
			},
		});
	}


	//


	// $("#modal_consultation").modal('show');
});

$('.edit_consultation').on('click', function () {
	// Declarations
	var myModal = $('#modal_edit_consultation');
	var cons_id = $(this).data('id');
	var consultation = getConsultation(cons_id);

	// Initialisations
	//initSignes();
	$('#modal_edit_consultation .signes').select2();
	$("#modal_edit_consultation .signes").val(null).trigger('change');

	// get Consultation

	consultation.done(res => {
		var cons = res['consultations'];
		var sign = res['signes'];
		var signes = setMappings(sign, cons.signes);
		$('#date', myModal).val(cons.date_consultation);
		$('#motif', myModal).val(cons.motif);
		$('#debut_symptome', myModal).val(cons.debut_symptome);
		$('#examen', myModal).val(cons.examen);
		$('#compte', myModal).val(cons.compte_rendu);
		$('#lettre', myModal).val(cons.orientation);
		$('#cert', myModal).val(cons.certificat);
		$("#modal_edit_consultation .signes").select2({
			data: signes,
			width: '100%'
		});
	}).fail(err => {
		toastr.error(err.responseText);
	});

	$('form', myModal).attr('action', '/patient/consultation/' + cons_id);

	// and finally show the modal
	myModal.modal({
		show: true
	});
});

function setMappings(g_signes, signes) {
	var obj = [];
	return $.map(g_signes, function (signe) {
		var selected = "";
		for (let index = 0; index < signes.length; index++) {
			if (signe.id == signes[index].id) {
				selected = true;
				break;
			}
		}
		return {
			"id": signe.id,
			"text": signe.name,
			"selected": selected
		};
	});
}

function getConsultation(id) {
	return $.getJSON(`/api/patient/consultation/${id}`);
}

/*
 * handle 'Ajouter un examen' button
 *
 */
$('.modale_bilane').on('click', function () {
	var cons_id = $(this).data('id');
	$("#modal_demande_examen #cons_id").val(cons_id);
});

function initSignes() {
	$('.signes').select2({
		width: '100%'
	});
}

/*
 * Download 'Lettre d'orientation' Report 
 */
function downloadLettre(lettre, date) {
	text = {
		head: [
			'Date : ' + date + '\n'
		],
		core: [{
				text: 'Lettre d\'orientation',
				style: 'header',
				alignment: 'center'
			},
			{
				style: 'core',
				text: lettre,
			},
		]
	};
	downloadDocument(text, 'Lettre-orientation-' + new Date().toISOString().slice(0, 10) + ".pdf");
}
/*
 * Download 'Certificat' Report 
 */
function downloadCertificat(certificat, date) {
	text = {
		head: [
			'Date : ' + date + '\n'
		],
		core: [{
				text: 'Certficat',
				style: 'header',
				alignment: 'center'
			},
			{
				style: 'core',
				text: certificat,
			},
		]
	};
	downloadDocument(text, 'Certificat-' + new Date().toISOString().slice(0, 10) + ".pdf");
}
/*
 * Download 'Consultation' Report 
 */
function donwloadConsultation(id = null) {
	let cons = $.getJSON(`/api/patient/consultation/${id}`)
	cons.done(resp => {
		const signes = mapSignes(resp.consultations.signes);
		text = {
			head: [
				'Date : ' + resp.consultations.date_consultation + '\n',
				'Num°: ' + resp.consultations.id + '\n',
			],
			core: [{
					text: 'Rapport Consultation',
					style: 'header',
					alignment: 'center'
				},
				{
					text: 'Motif',
					style: 'header'
				}, {
					style: 'core',
					text: resp.consultations.motif ? resp.consultations.motif : '...',
				},
				{
					text: 'Signes Fonctionnels',
					style: 'header'
				}, {
					style: 'core',
					text: signes.length != 0 ? signes : '...',
				},
				{
					text: 'Compte rendu',
					style: 'header'
				}, {
					style: 'core',
					text: resp.consultations.compte_rendu ? resp.consultations.compte_rendu : '...',
				},
				{
					text: 'Examen',
					style: 'header'
				}, {
					style: 'core',
					text: resp.consultations.examen ? resp.consultations.examen : '...',
				},
			]
		};
		downloadDocument(text, 'Consultation-' + new Date().toISOString().slice(0, 10) + ".pdf");

	}).fail(err => {
		alert(err.responseText);
	});


}

/*
 * Get name of signes
 * @param {Object[]} signes array of signes of the consultation
 * @returns {Object[]} names the names of signes.
 */
function mapSignes(signes) {
	if (signes.length != 0)
		return signes.map(e => e.name + ', ');
}