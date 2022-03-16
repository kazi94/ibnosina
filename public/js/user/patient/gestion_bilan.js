//******************************^^*****^^**************************************// 
// Analyse biologique : 													   //
// Ajouter des lignes bilans 												   //
// faire une demande dexamens 												   //
// Affichage dynamique des élements et des unité via AJAX 					   //
// Affectation des champs pour la modification 								   //
// fonction d'affichage des fichiers médias 								   //
// Suppression d'une ligne 													   //
// Ajout auto des dates d'analyse et du nom du laboratoire 				       //
//******************************^^*****^^**************************************// 
jQuery(function () {


	/*
	 * Listen to change of type bilan
	 * 
	 */
	let selected = [];
	$("#modal_demande_examen").on('change', 'select#type_bilan', function () {
		//if ($('#modal_demande_examen #bilan').contents().length == 0) {
		const bilan = $(this).val();
		const patient_id = $("input[name='patient_id']").val();
		if (bilan != "")
			$.ajax({
				type: "get",
				url: "/admin/element/get-elements/" + bilan,
				success: function (response) {
					var $rows = '';
					if (selected.indexOf(bilan) == -1) {
						selected.push(bilan);
						addElementsToTable(response);

					}
				}
			});
		//}
	});

	/*
	 *
	 *
	 */
	function addElementsToTable(response) {
		response.forEach((element, key) => {
			let cel = "";
			if (key % 2 == 0) {
				let cel0 = `
								<td>
								<input type='hidden' name='elements_id[]' value='${element.id}'>
								<input type='hidden' name='checkedElements[]' value='0'>
								<input type='checkbox' class="flat-red" '/>
								${element.element}
								</td>
								`;
				if (key < response.length - 1) {

					cel = `
										<td>
											<input type='hidden' name='elements_id[]' value='${response[ key + 1].id}'>
											<input type='hidden' name='checkedElements[]' value='0'>
											<input type='checkbox' class="flat-red" '/>
											${response[ key + 1].element}
										</td>
										`;
				}
				$rows = `
									<tr>
										${cel0}
										${cel}							
									</tr>
										`;
				$("#elements tbody").append($rows);
				$('input[type="checkbox"].flat-red').iCheck({
					checkboxClass: 'icheckbox_flat-red'
				});
			}
		});
	}

	/*
	 * handler when click to 'remplir' btn
	 * get the elements of the requested exam to do
	 * display the elements to fields values input if bio
	 * or display input file to upload radio img
	 */
	$(".remplir").on('click', function () {
		const $id = $(this).data('id');
		$('#modal_biologique form').attr('action', "/patient/bilan/" + $id);
		$("#bilansTable > tbody").empty();
		$("#bilanDiv").show();
		$("#radioDiv").hide();
		$.ajax({
			type: "get",
			url: "/patient/element/get-demande/" + $id,
			success: function (response) {
				var $rows;
				$('#modal_biologique form input[name="type"]').val(response[0].type);
				if (response[0].type == 'bilan') {

					response.forEach(element => {
						$rows += `
							<tr >
								<td style = 'border-top : 0px;' class="text-center">
									<input type='hidden' name='lignes_id[]' value='${element.id}'>
									${element.element.element}
								</td>
								<td style='border-top : 0px;' ><input type='number' step='0.0000001' name='valeurs[]' autocomplete="off"  style='width:50%' /> <b>${element.element.unite ?? ''}</b></td>
							</tr>
						`;
					});
					$("#bilansTable > tbody").append($rows);
				} else if (response[0].type == 'radio') {
					$("#bilanDiv, #radioDiv").toggle();
				}
			}
		});
	});

	// Listen on checbox events
	function handleBilanCheckEvent() {
		var input = $(this).parent().prev().val();
		$(this).parent().prev().val(1 - input);
	};

	$("#bilansTable ").on('ifToggled', 'input', handleBilanCheckEvent);
	$("#modal_demande_examen ").on('ifToggled', 'input', handleBilanCheckEvent);


	/*
	 * Handle edit button on openning modal
	 *
	 */
	$('.edit_bilan').on('click', function () {
		const $id = $(this).data('id');
		const $el = $(this).data('el');
		$.get('/patient/element/get-element/' + $id)
			.done(res => {
				$("#modal_update_biologique input[name='valeur']").val(res.valeur);
				$("#modal_update_biologique input[name='laboratoire']").val(res.laboratoire);
				$("#modal_update_biologique input[name='commentaire']").val(res.commentaire);
				$('#modal_update_biologique form').attr('action', "/patient/bilan/element/" + $id);
				$('#modal_update_biologique #el').html($el);
			})

	});


	/*
	 * open radio image
	 */
	$('.open_image').on('click', function () {
		var url = "/storage" + $(this).data('url');
		var comment = $(this).data('comment');
		$("#modal_imgs .modal-body img").attr('src', url);
		$("#modal_imgs .modal-body img").attr('alt', comment);
		$("#modal_imgs .modal-body img").attr('title', comment);
	});


	/*
	 * select examen type
	 */
	$("#modal_demande_examen").on('change', '#examens_type', function () {
		const type = $(this).val();

		if (type) {
			$.get('/admin/prescription-type/prescription-examen/' + type)
				.done(res => {
					addElementsToTable(res)
				})
				.fail(exception => {
					toastr.error(exception.responseText);
				});
		}
	});

});