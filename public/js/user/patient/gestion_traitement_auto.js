$(
	function () {
		//******************************^^*****^^*****************************// 
		// Traitement :
		// Ajouter des lignes prescriptions
		// Affichage du modal modification traitement
		//******************************^^*****^^**************************************// 

		var linesTraitements = [];
		var $modalPrescriptionVille = $("#modalPrescriptionVille");
		/*
		 * update the state of trait or auto medic
		 */
		$(".updateTraitAuto").on('click', function () {
			let ligne_id = $(this).data('id');
			let type = $(this).data('type');
			let url = type == 'trait' ? '/patient/traitement_chronique/get-last-state/' + ligne_id : '/patient/automedication/get-last-state/' + ligne_id;
			let action = type == 'trait' ? '/patient/traitement_chronique/update-state/' + ligne_id : '/patient/automedication/update-state/' + ligne_id;
			$("#historyStates > tbody").empty();

			// Get Last State From Ajax Request
			let response = getLastState(url);

			// handle ajax request
			response.done(res => {
					let line = res['line'];
					let history = res['history'];

					$("#updateTraitAutoModal #state").html(line.etats == "En cours" ? "<span class='bg-red'>Arréter</span>" : "<span class='bg-blue'>Reprise</span>");
					$("#updateTraitAutoModal input[name='etats']").val(line.etats == "En cours" ? "Arréter" : "Reprise")
					$('#updateTraitAutoModal').modal('show');
					$('#updateTraitAutoModal form').attr('action', action);

					// show history states
					showHistoryStates(history);
				})
				.fail(err => {
					alert(err);
				});
		});

		/*
		 * show history states in table
		 */
		function showHistoryStates(h) {
			h.forEach(l => {
				$("#historyStates > tbody").append(`
					<tr>
						<td>${l.etats} ${l.date_etats}</td>
					</tr>
				`);
			})
		}

		/*
		 * Ajax request to get Ligne Prescription Object
		 */
		function getLastState(url) {
			return $.get(url)
		}

		/*
		 * open edit modal and update value of trait or auto medic
		 */
		$('.editPrescriptionVille').on('click', function () { //traitement pour modifier le médicament du traitement chronique
			var myModal = $('#modalUpdatePrescriptionVille');
			var ligneId = $(this).data('id');
			// var medicament = $(this).data('medicament');
			var typePrescription = $(this).data('type');
			var url = typePrescription == 'trait' ? '/getTraitement' : '/getAutomedication';

			//remplir le tableau historique de prise du médicament
			$.ajax({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				url: url,
				method: 'post',
				data: {
					ligne_id: ligneId,
				},
				datatype: 'json',
				success: function (ligne) {

					$("input[name='medecin_externe']", myModal).val(ligne.medecin_externe);
					$("input[name='dose']", myModal).val(ligne.dose);
					$("input[name='dose_matin']", myModal).val(ligne.dose_matin);
					$('#dose_matin', myModal).iCheck(ligne.dose_matin == "1" ? 'check' : 'uncheck');
					$("input[name='dose_midi']", myModal).val(ligne.dose_midi);
					$('#dose_midi', myModal).iCheck(ligne.dose_midi == "1" ? 'check' : 'uncheck');
					$("input[name='dose_soir']", myModal).val(ligne.dose_soir);
					$('#dose_soir', myModal).iCheck(ligne.dose_soir == "1" ? 'check' : 'uncheck');
					$("input[name='dose_avant_coucher']", myModal).val(ligne.dose_avant_coucher);
					$('#dose_avant_coucher', myModal).iCheck(ligne.dose_avant_coucher == "1" ? 'check' : 'uncheck');
					$("select[name='repas_matin']", myModal).val(ligne.repas_matin).is(':selected');
					$("select[name='repas_soir']", myModal).val(ligne.repas_soir).is(':selected');
					$("select[name='repas_midi']", myModal).val(ligne.repas_midi).is(':selected');
					$("input[name='date_etats']", myModal).val(ligne.date_etats);
					$('#state', myModal).html(ligne.etats).addClass(ligne.etats == "En cours" ? "bg-green" : "bg-red");
					$('#hopital', myModal).prop('checked', ligne.status_hopital == "1" ? true : false);

					action = typePrescription == 'trait' ? '/patient/traitement_chronique/' + ligne.id : '/patient/automedication/' + ligne.id;
					$('form', myModal).attr('action', action);
					/*---------------------------------------------------------*/

					// $('#example12>tbody', myModal).empty();
					// $.each(data['history'], function (i, value) {
					// 	if (value.status_hopital === '1') stat = 'V';
					// 	else stat = 'H';
					// 	if ((value.etats == "En cours") || (value.etats == "Reprise")) color = "success";
					// 	else color = "danger";

					// 	$('#example12>tbody', myModal).append("<tr>" +
					// 		"<td>" + ((!value.voie) ? "/" : value.voie) + "</td>" +
					// 		"<td>" + ((!value.dose_matin) ? "/" : value.dose_matin) + " " + ((!value.repas_matin) ? "" : value.repas_matin) + "</td>" +
					// 		"<td>" + ((!value.dose_midi) ? "/" : value.dose_midi) + " " + ((!value.repas_midi) ? "" : value.repas_midi) + "</td>" +
					// 		"<td>" + ((!value.dose_soir) ? "/" : value.dose_soir) + " " + ((!value.repas_soir) ? "" : value.repas_soir) + "</td>" +
					// 		"<td>" + ((!value.dose_avant_coucher) ? "/" : value.dose_avant_coucher) + "</td>" +
					// 		"<td>" + value.unite + "</td>" +
					// 		"<td>" + ((!value.medecin_externe) ? "/" : "Dr." + value.medecin_externe) + "</td>" +
					// 		"<td><span class='label label-" + color + "'> " + value.etats + "</span></td>" +
					// 		"<td>" + value.date_etats + "</td>" +
					// 		"<td>" + stat + "</td>" +
					// 		"</tr>");
					// });
				},
				error: function (jqXHR, textStatus) {
					alert("Request failed: " + textStatus + " " + jqXHR);
				}
			});

			//and finally show the modal
			myModal.modal({
				show: true
			});
		});

		function addLineTraitement(e) {
			e.preventDefault();
			if ($modalPrescriptionVille.find("input[name='med_sp_id']").val() != "") {
				let med_sp_id = $modalPrescriptionVille.find("input[name='med_sp_id']").val();
				let dose_matin = $modalPrescriptionVille.find("input[name='dose_matin']").val();
				let dose_midi = $modalPrescriptionVille.find("input[name='dose_midi']").val();
				let dose_soir = $modalPrescriptionVille.find("input[name='dose_soir']").val();
				let dose_av = $modalPrescriptionVille.find("input[name='dose_avant_coucher']").val();
				let status_hopital = $modalPrescriptionVille.find("input[name='status_hopital']").val();
				let unite = $modalPrescriptionVille.find("select[name='unite']").val();
				let voie = $modalPrescriptionVille.find("select[name='voie']").val();
				let dose = $modalPrescriptionVille.find("input[name='dose']").val();
				let date_etats = $modalPrescriptionVille.find("input[name='date_etats']").val();
				let medic = $modalPrescriptionVille.find("input[name='medicament_dci']").val();
				let line = {
					'med_sp_id': med_sp_id,
					'dose_matin': dose_matin,
					'dose_midi': dose_midi,
					'dose_soir': dose_soir,
					'dose_avant_coucher': dose_av,
					'unite': unite,
					'voie': voie,
					'dose': dose,
					'medic': medic,
					'date_etats': date_etats,
					'status_hopital': status_hopital,
				};
				// add form to lines
				let count = linesTraitements.push(line);

				// get textual format of Prescription
				let medicament = medicToText(line)

				// add to table
				appendToTable(medicament, count);
				resetForm1();

			} else {
				alert("Le médicament renseigné doit etre sélectionner de la liste des suggestions");
			}
			//reset form
			//$("form#addLineTraitement")[0].reset();

		}
		$("#addLineTraitement").on('submit', addLineTraitement);

		function resetForm1() {
			$("form#addLinePrescription input[name='medicament_dci']").val('');
			$("form#addLinePrescription input[name='date_etats']").val('');
			$("form#addLinePrescription input[name='dose_mat']").val('1');
			$("form#addLinePrescription input[name='dose_mid']").val('1');
			$("form#addLinePrescription input[name='dose_soi']").val('1');
			$("form#addLinePrescription input[name='dose_ac']").val('1');
			$("form#addLinePrescription input[name='nbr_jours']").val('1');
		}
		// store traitement to database
		/**
		 */
		function saveTraitement() {
			$("#saveTraitement").attr('disabled', 'disabled');
			let formData = new FormData();
			let patient_id = $("input[name='patient_id']").val();
			let medecin_externe = $modalPrescriptionVille.find("input[name='medecin_externe']").val();
			let url = $modalPrescriptionVille.find("form").attr("action");
			formData.append('patient_id', patient_id);
			formData.append('medecin_externe', medecin_externe);
			formData.append('med_sp_id', JSON.stringify(linesTraitements));
			$.ajax({
				type: "post",
				processData: false,
				contentType: false,
				url: url,
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				},
				data: formData,
				dataType: "json",
				success: function (response) {
					if (response !== "success")
						window.location.href = response;
					else
						window.location.reload();
				}
			});

		}
		$("#saveTraitement").on('click', saveTraitement);
		/*
		 * append line to medicament table
		 */
		function appendToTable(line, index = 1, ipMsg = null) {
			$("#tableTraitement > tbody").append(`
				<tr>
					<td>${line}</td>
					<td><i class='fa fa-times-circle' style='color:red;cursor : pointer;' data-index = '${index-1}'></i></td>
				</tr>
			`);
		}
		/*
		 * Transform line prescription to readable text
		 */
		function medicToText(line) {
			const toText = `
				${line.medic} ${line.voie}. ${line.dose} ${line.unite} le ${line.dose_matin != 0 ? 'matin' : ''} ${line.dose_midi != 0 ? 'midi' : ''}
				${line.dose_soir != 0 ? 'soir' : ''} ${line.dose_avant_coucher != '0' ? 'av-coucher' : ''}
			`;
			return toText;
		}

	});