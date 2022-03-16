$(function () {
	//******************************^^*****^^*****************************// 
	// Produit alimentaire et phytotherapie :
	// Ajouter des lignes prescriptions
	// Affichage de la page de confirmation
	// Envoi du formulaire au serveur HTTP , la méthode :POST
	//******************************^^*****^^**************************************// 
	$('#used_on').select2({
		ajax: {
			url: '/patient/get-pathologies',
			dataType: 'json',
			processResults: function (data) {
				// Transforms the top-level key of the response object from 'items' to 'results'
				return {
					results: data.items
				}
			}
		}
	});
	$("#modal_phyto").on('change', '.frequence', function () {
		if ($(this).val() == "Depuis :")
			$('.frequence_date').show();
		else $('.frequence_date').hide();
	});
	$("#add_produit").click(function () {
		//$(this).closest('tbody').prepend("<tr><td><input type='hidden' class='pr_hidden' name='produitalimentaire_id[]'><input type='text' class='pr_input' style='width: 200px;padding-top: 6px;'></td> <td width='120px'><input type='text' class='ar_input' style='width: 200px;padding-top: 6px;'></td> <td width='120px'> <select class='form form-control frequence' name='frequence[]' > <option>Occasionnellement</option> <option>Exceptionnellement</option> <option>Depuis :</option> </select> </td> <td><input type='date' class='form-control frequence_date'  name='frequence_date[]' style='display: none;' /></td></tr>");
	});

	var options = {
		url: function (phrase) {
			return "/patient/produit/" + phrase; // url to send into server
		},
		getValue: "produit_naturel_fr",
		template: { // permet d'afficher dans la liste un autre champs
			type: "description",
			fields: {
				description: "produits_arabe"
			}
		},
		ajaxSettings: { // d'ont touch and mmodify
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: "json",
			method: "POST",
			data: {
				dataType: "json"
			}
		},
		preparePostData: function (data) {
			data.phrase = $('.pr_input').val(); // returned data from server , json format
			return data;
		},
		list: {
			onSelectItemEvent: function () {
				var value = $('.pr_input').getSelectedItemData().id;
				$(".pr_hidden").val(value).trigger("change");
			}
		},
		// requestDelay: 10000 // delays for response serve
	};
	var options1 = {

		url: function (phrase) {
			return "/patient/produit_ar/" + phrase; // url to send into server
		},
		getValue: "produits_arabe",

		template: { // permet d'afficher dans la liste un autre champs
			type: "description",
			fields: {
				description: "produit_naturel_fr"
			}
		},
		ajaxSettings: { // d'ont touch and mmodify
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			dataType: "json",
			method: "POST",
			data: {
				dataType: "json"
			}
		},

		preparePostData: function (data) { // function before send data to server
			data.phrase = $('.pr_input').val(); // get val input into data.phrase
			return data;
		},
		list: {
			onSelectItemEvent: function () {
				var value = $('.ar_input').getSelectedItemData().id;
				$(".pr_hidden").val(value).trigger("change");
			}
		}
		// requestDelay: 10000 // delays for response serve
	};
	// Recherche produits phyotohérapeutique en français
	$('.pr_input').easyAutocomplete(options);
	$('.ar_input').easyAutocomplete(options1);

	$('#modal_phyto .easy-autocomplete').css('width', '100%');
});