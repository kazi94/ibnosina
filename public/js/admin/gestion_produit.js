	$(function () {

		// $.getJSON("/js/json/general.json",function(obj){//Ajouter les type d'effet à la liste
		// 	console.log(obj);
		// 	$.each(obj,function(key,value){
		// 		if (value.type_effet != "") 
		//         $('#type').append("<option value="+value.type_effet+">"+value.type_effet+"</option>");
		// 	}); 
		// 	});

		$("#interactions_plantes").DataTable({
			// "ordering": false,
			// "scrollX": true,
			// "scrollY": "400px",
			// "scrollCollapse": true,
			// "paging": false,

		}); //historique prescriptions

		$('.addPlanteArBtn').on('click', function () { // function to add new filed dynamlicly without refresh

			produit_arabe = $('#produit_arabe').val();

			// $(this).parent().parent().parent().prepend("<tr><td><input type='text' class='form-control' placeholder='placer votre produit en arabe' name='produits_arabe[]' value='" + produit_arabe + "' readonly></td><td><i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i></td></tr>");
			$("#arabe_words").append(`
				<li class="mt-1"> 
				<input type = 'hidden' name = 'produits_arabe[]' value = "${ produit_arabe }"> 
				${produit_arabe}
				<i class = 'bg-maroon fa fa-1x fa-times-circle ml-2 p-1 deleteArabeWord' style ='color:red;cursor : pointer;'> </i> 
				</li>
			`);
			$('#produit_arabe').val("");

		});

		$("ul").on('click', ".deleteArabeWord", function () {
			$(this).parent().remove();
		});

		$('.addMedBtn').on('click', function () { //ajouter intercations

			var médicament = $('.médicament_dci').val();
			var médicament_id = $('.medicament_dci_id').val();
			var type = $('#type option:selected').val();
			var effet = $('#effet').val();
			var indic = $('#indic').val();
			var ef_pharm = $('#ef_pharm').val();
			var reco = $('#reco').val();
			var niveau = $('#niveau option:selected').text();
			var niveau1 = $('#niveau option:selected').val();
			if (médicament != "")
				$('.produit_tab > tbody').append(`
				<tr>
					<td>
						<input type='hidden' name='medicament_dci_id[]' value="${médicament_id}">${médicament}
					</td>

					<td>
						<input type='hidden' name='effet_interaction[]' value="${effet}">${effet}
					</td>
					<td>
						<input type='hidden' name='type_effet[]' value="${type}">${type}
					</td>
					<td>
						<input type='hidden' name='indication[]' value="${indic}">${indic}
					</td>
					<td>
						<input type='hidden' name='effet_pharmaco[]' value="${ef_pharm}">${ef_pharm}
					</td>
					<td>
						<input type='hidden' name='recommendation[]' value="${reco}">${reco}
					</td>
					<td>
						<input type='hidden' name='niveau[]' value="${niveau1}" >${niveau}
					</td>
					<td>
						<span class='glyphicon glyphicon-trash fa-2x' style='cursor:pointer;'></span>
					<td>
				</tr>`);
			else
				toastr.error("Veuillez entrer le médicament DCI SVP !");

			// empty the inputs fileds
			$('.médicament_dci').val("");
			$('.medicament_dci_id').val("");
			// $('#type :selected').val("");
			// $('#niveau:selected').val("");
			$('#effet').val("");
			$('#indic').val("");
			$('#ef_pharm').val("");
			$('#reco').val("");
		});

		$('table').on('click', '.glyphicon', function () { //function to remove field with fa close button
			$(this).parent().parent().remove();
		});

		//Fonction de recherche de medicament dci
		$("#medic_input").on('keydown', function () {
			$(this).autocomplete({
				// selectionner l'element pour ajouter la liste des suggestion
				appendTo: $(this).parent(),
				source: function (request, response) {
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
						success: function (data, status, code) {
							response($.map(data.slice(0, 20), function (item) { // slice cut number of element to show
								return {
									label: item.sac_nom, // pour afficher dans la liste des suggestions
									sac_id: item.sac_code_sq_pk,
									value: item.sac_nom // value c la valeur à mettre dans l'input this
								};
							}));
						}
					});
				}, // END SOURCE
				minLength: 2,
				select: function (event, ui) {
					$(this).prev().val(ui.item.sac_id);
				},
				open: function () {
					$(this).removeClass("ui-corner-all").addClass("ui-corner-top");
				},
				close: function () {
					$(this).removeClass("ui-corner-top").addClass("ui-corner-all");
				}
			});
		});

	});