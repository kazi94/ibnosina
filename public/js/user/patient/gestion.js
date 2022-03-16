$(".envoyer").click(function () {
	var message = $("input[name='message']").val();
	var patient_id = $(this).data('id');
	var user_id = $(this).data('user');
	var user_name = $(this).data('name');

	$.ajax({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		method: "POST",
		url: "/patient/message",
		data: {
			message: message,
			patient_id: patient_id,
			user_id: user_id
		},
		datatype: 'html',
		success: function (data) {
			var msg_id = data;
			var d = new Date();
			var month = d.getMonth() + 1;
			var day = d.getDate();
			var weekday = ["Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi"];
			var output = weekday[d.getDay()] + " " + (day < 10 ? '0' : '') + day + " " + (month < 10 ? '0' : '') + month + " " + d.getFullYear() + " " + d.getHours() + ":" + d.getMinutes();
			$('.direct-chat-messages').prepend("<div class='direct-chat-msg right'> <div class='direct-chat-info clearfix'>" +
				"<span class='direct-chat-name pull-right'>" + user_name +
				"</span> <span class='direct-chat-timestamp pull-left'>" + output +
				"</span> </div> <img class='direct-chat-img' src='/images/user.jpg' alt='Message User Image'><div class='direct-chat-text'>" + message +
				"<i class='fa fa-times-circle' style='color:red;cursor : pointer; ' data-id=" + msg_id + "></i>" +
				"</div></div>");
		},
		failure: function (error) {
			console.log(error);
		}
	});
});


// $("input[name='q1']").autocomplete({
// 	source: availableTags
//  });

$('#messageBox').on('click', '.fa-times-circle', function () {

	var msg_id = $(this).data('id'); //get msg id

	$.ajax({ //remove message from database
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		},
		method: "DELETE",
		url: "/patient/message/" + msg_id,
		data: {
			msg_id: msg_id
		},
		datatype: 'html',
		success: (data) => {
			if (data == '1') $(this).closest('div.direct-chat-msg').remove(); //remove message from chat box
		},
		failure: function (error) {
			console.log(error);
		}
	});
});















// new Date().getDate()          // Get the day as a number (1-31)
// new Date().getDay()           // Get the weekday as a number (0-6)
// new Date().getFullYear()      // Get the four digit year (yyyy)
// new Date().getHours()         // Get the hour (0-23)
// new Date().getMilliseconds()  // Get the milliseconds (0-999)
// new Date().getMinutes()       // Get the minutes (0-59)
// new Date().getMonth()         // Get the month (0-11)
// new Date().getSeconds()       // Get the seconds (0-59)
// new Date().getTime()          // Get the time (milliseconds since January 1, 1970)
// $(function(){


// 	//******************************^^*****^^*****************************// 
// 	// Traitement :
// 	// Ajouter des lignes prescriptions
// 	// Affichage du modal modification traitement
// 	//******************************^^*****^^**************************************// 
// 	$("#tableAddMedicamenttrait>tbody").on('click','#add_traitement',function(){

// 			$(this).closest('tbody').append("<tr> <td width='250px'> <input type='text' class='form form-control' placeholder='Médicament comerciale'> </td> <td width='250px'> <input type='text' class='form form-control'  placeholder='équivalent DCI' name='medicament_dci_id[]'> </td> <td width='80px'><input type='text' class='form form-control' name='dose_matin[]'></td> <td width='97px'> <select class='form form-control' name='repas_matin[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_midi[]'> </td> <td width='97px'> <select class='form form-control' name='repas_midi[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_soir[]'> </td> <td width='97px'> <select class='form form-control' name='repas_soir[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_avant_coucher[]'> </td> <td width='97px'> <select class='form form-control' name='unite[]'> <option>unité</option> <option>comprimé</option> </select> </td> <td><input type='hidden' name='status_hopital[]' value='0'><input type='checkbox' onclick='this.previousSibling.value=1-this.previousSibling.value'</td> <td> <input type='date' class='form-control' name='date_etats[]'> </td><td> <button type='button' class='btn btn-info btn-flat' id='add_traitement'>+</button> </td></tr>");
// 			$(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>");
// 	});

// 	 $('.edit_traitement').on('click', function() {
// 	     var myModal = $('#modal_update_traitement');
// 	     var ligne_id = $(this).attr('id');  //get bilan ID


// 	      //now get the values from the table
// 	    	 var medicament_dci_id = $(this).closest('tr').find('th:eq(0)').attr('value');
// 	    	 var dose_matin = $(this).closest('tr').find('td:eq(0)').attr('value');
// 	    	 var repas_matin = $(this).closest('tr').find('td:eq(0)').attr('value1');
// 	    	 var dose_midis = $(this).closest('tr').find('td:eq(1)').attr('value');
// 	    	 var repas_midis = $(this).closest('tr').find('td:eq(1)').attr('value1');
// 	    	 var dose_soir = $(this).closest('tr').find('td:eq(2)').attr('value');
// 	    	 var repas_soir = $(this).closest('tr').find('td:eq(2)').attr('value1');
// 	    	 var dose_avant_coucher = $(this).closest('tr').find('td:eq(3)').attr('value');
// 	    	 var unite = $(this).closest('tr').find('td:eq(4)').attr('value');
// 	    	 var medecin_externe = $(this).closest('tr').find('td:eq(5)').attr('value');
// 	    	 var status = $(this).closest('tr').find('td:eq(6)').attr('value');
// 	    	 var date_etats = $(this).closest('tr').find('td:eq(7)').attr('value');
// 	    	 var hopital = $(this).closest('tr').find('td:eq(8)').attr('value');

// 	      //and set them in the modal:
// 	     $('h4' ,myModal).html("Modifier médicament : "+medicament_dci_id);
// 	     $('h2' ,myModal).html("Historique du médicament :"+medicament_dci_id);
// 	     $('#medecin_externe',myModal).val(medecin_externe);
// 	     $('#medicament_dci_id',myModal).val(medicament_dci_id);
// 	     $('#dose_matin',myModal).val(dose_matin);
// 	     $('#dose_midis',myModal).val(dose_midis);
// 	     $('#dose_soir',myModal).val(dose_soir);
// 	     $('#dose_avant_coucher',myModal).val(dose_avant_coucher);
// 	     $('#unite',myModal).val(unite).is(':selected'); 
// 	     $('#repas_matin',myModal).val(repas_matin).is(':selected'); 
// 	     $('#repas_soir',myModal).val(repas_soir).is(':selected'); 
// 	     $('#repas_midis',myModal).val(repas_midis).is(':selected'); 
// 		 if(hopital == "1") $('#hopital',myModal).prop('checked', true); else $('#hopital',myModal).prop('checked', false);   
//      	$('#date_etats',myModal).val(date_etats);
// 		if (status == "Arrété" )
//      		$("#status").append("<option value='Reprise'>Reprise</option>");
//      		else
//      			$("#status").append("<option value='Arrété'>Arrété</option>");

// 	     $('.up_traitement',myModal).attr('action' ,'/patient/traitement_chronique/'+ligne_id);  

// 	     //remplir le tableau sur l'historique de prise du médicament
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			data : {medicament_dci_id : medicament_dci_id },
// 			datatype : 'json',
// 			success : function (data) {
// 				var stat;
// 				$('#example12>tbody',myModal).empty();
// 				 $.each(data ,function(i,value) {
// 				 	if (data[i].status_hopital === '1') { stat = 'V'} else stat = 'H'
// 					$('#example12>tbody',myModal).append("<tr><td>" + data[i].dose_matin + " " + data[i].repas_matin + "</td><td>" + data[i].dose_midi + " " + data[i].repas_midi + "</td><td>"+data[i].dose_soir + " "+data[i].repas_soir + "</td><td>" + data[i].dose_avant_coucher + "</td><td>" + data[i].unite + "</td><td>Dr." + data[i].medecin_externe + "</td><td> "+data[i].etats + " </td><td>"+data[i].date_etats + " </td><td>"+stat+"</td></tr>");
// 				});
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});

// 	      //and finally show the modal
// 	     myModal.modal({ show: true });
// 	 });
// 	     	$('#tableAddMedicamenttrait>tbody').on('click','.fa-times-circle',function(){
// 		$(this).closest('tr').remove(); });

// 	 //**************************************************************************************************************************//

// 	//******************************^^*****^^*****************************// 
// 	// Automedication / prescription ponctuelle  :
// 	// Ajouter des lignes automedications
// 	// Set fields to update modal's
// 	//******************************^^*****^^**************************************// 
// 	$("#tableAddMedicamentauto>tbody").on('click','#add_auto',function(){
// 			$(this).closest('tbody').append("<tr> <td width='250px'> <input type='text' class='form form-control' placeholder='Médicament comerciale'> </td> <td width='250px'> <input type='text' class='form form-control'  placeholder='équivalent DCI' name='medicament_dci_id[]'> </td> <td width='80px'><input type='text' class='form form-control' name='dose_matin[]'></td> <td width='97px'> <select class='form form-control' name='repas_matin[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_midi[]'> </td> <td width='97px'> <select class='form form-control' name='repas_midi[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_soir[]'> </td> <td width='97px'> <select class='form form-control' name='repas_soir[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_avant_coucher[]'> </td> <td width='97px'> <select class='form form-control' name='unite[]'> <option>unité</option> <option>comprimé</option> </select> </td> <td><input type='hidden' name='status_hopital[]' value='0'><input type='checkbox' onclick='this.previousSibling.value=1-this.previousSibling.value'</td> <td> <input type='date' class='form-control' name='date_etats[]'> </td><td> <button type='button' class='btn btn-info btn-flat' id='add_ضعفخ'>+</button> </td></tr>");
// 			$(this).remove();
// 	});
// 	 $('.edit_auto').on('click', function() {
// 	     var myModal = $('#modal_update_auto');
// 	     var ligne_id = $(this).attr('id');  //get bilan ID


// 	      //now get the values from the table
// 	    	 var medicament_dci_id = $(this).closest('tr').find('th:eq(0)').attr('value');
// 	    	 var dose_matin = $(this).closest('tr').find('td:eq(0)').attr('value');
// 	    	 var repas_matin = $(this).closest('tr').find('td:eq(0)').attr('value1');
// 	    	 var dose_midis = $(this).closest('tr').find('td:eq(1)').attr('value');
// 	    	 var repas_midis = $(this).closest('tr').find('td:eq(1)').attr('value1');
// 	    	 var dose_soir = $(this).closest('tr').find('td:eq(2)').attr('value');
// 	    	 var repas_soir = $(this).closest('tr').find('td:eq(2)').attr('value1');
// 	    	 var dose_avant_coucher = $(this).closest('tr').find('td:eq(3)').attr('value');
// 	    	 var unite = $(this).closest('tr').find('td:eq(4)').attr('value');
// 	    	 var medecin_externe = $(this).closest('tr').find('td:eq(5)').attr('value');
// 	    	 var status = $(this).closest('tr').find('td:eq(6)').attr('value');
// 	    	 var date_etats = $(this).closest('tr').find('td:eq(7)').attr('value');
// 	    	 var hopital = $(this).closest('tr').find('td:eq(8)').attr('value');

// 	      //and set them in the modal:
// 	     $('h4' ,myModal).html("Modifier médicament : "+medicament_dci_id);
// 	     $('h2' ,myModal).html("Historique du médicament :"+medicament_dci_id);
// 	     $('#medecin_externe',myModal).val(medecin_externe);
// 	     $('#medicament_dci_id',myModal).val(medicament_dci_id);
// 	     $('#dose_matin',myModal).val(dose_matin);
// 	     $('#dose_midis',myModal).val(dose_midis);
// 	     $('#dose_soir',myModal).val(dose_soir);
// 	     $('#dose_avant_coucher',myModal).val(dose_avant_coucher);
// 	     $('#unite',myModal).val(unite).is(':selected'); 
// 	     $('#repas_matin',myModal).val(repas_matin).is(':selected'); 
// 	     $('#repas_soir',myModal).val(repas_soir).is(':selected'); 
// 	     $('#repas_midis',myModal).val(repas_midis).is(':selected'); 
// 		 if(hopital == "1") $('#hopital1',myModal).prop('checked', true); else $('#hopital1',myModal).prop('checked', false);   
//      	$('#date_etats',myModal).val(date_etats);
// 				if (status == "Arrété" )
//      		$("#status",myModal).append("<option value='Reprise'>Reprise</option>");
//      		else
//      			$("#status",myModal).append("<option value='Arrété'>Arrété</option>");

// 	     $('.up_auto',myModal).attr('action' ,'/patient/automedication/'+ligne_id);  

// 	     $.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			data : {medicament_dci_id_auto : medicament_dci_id},
// 			datatype : 'json',
// 			success : function (data) {
// 				var stat;
// 				$('#example112>tbody',myModal).empty();
// 				 $.each(data ,function(i,value) {
// 				 	if (data[i].status_hopital === '1') { stat = 'V'} else stat = 'H'
// 					$('#example112>tbody',myModal).append("<tr><td>" + data[i].dose_matin + " " + data[i].repas_matin + "</td><td>" + data[i].dose_midi + " " + data[i].repas_midi + "</td><td>"+data[i].dose_soir + " "+data[i].repas_soir + "</td><td>" + data[i].dose_avant_coucher + "</td><td>" + data[i].unite + "</td><td>Dr." + data[i].medecin_externe + "</td><td> "+data[i].etats + " </td><td>"+data[i].date_etats + " </td><td>"+stat+"</td></tr>");
// 				});
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 	      //and finally show the modal
// 	     myModal.modal({ show: true });
// 	 });

// 	 //**************************************************************************************************************************//

// 	//******************************^^*****^^*****************************// 
// 	// Analyse biologique :
// 	// Ajouter des lignes bilans
// 	// Affectation des champs pour la modification
// 	//fonction d'affichage des fichiers médias
// 	//******************************^^*****^^**************************************// 
// 	$("#add_bilan").click(function(){
// 		for(i =0 ; i< $("#rd").val() ;i++) {
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			data : {someData : '1' },
// 			datatype : 'json',
// 			success : function (data) {
// 				var option = "<option></option>";
// 				$.each(data ,function(key , value){
// 					option+="<option value="+data[key].bilan+">"+data[key].bilan+"</option>"
// 				});
// 			$("#bilans>tbody").prepend("<tr> <td> <select class='form form-control bilan' name='typeBilans[]'>"+option+"</td> <td> <select class='form form-control element' name='typeElements[]'></td> <td><input type='text' class='form form-control' name='valeurs[]'></td> <td style='font-weight: bolder;'> <select class='form form-control unite' name='unites[]'> </select> </td> <td><input type='date' class='date_analyses form form-control' name='date_analyses[]' /></td> <td><input type='text' class='form form-control lab' placeholder='laboratoire' name='laboratoires[]'/></td> <td><input type='text' class='form form-control' placeholder='Commentaire' name='commentaires[]'/></td> <td><input type='file' class='form-control' name='fichiers[]' id='fichier'  accept='.jpg, .jpeg, .png, .mp3, .mp4 ,.flv'></td><td><i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i></td> </tr>");					
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});

// 		}
// 		});
// 	$('tbody').on('change','.bilan',function(){
// 		var bilan = $(this).val(); //récupérer le bilan selectionné
// 		if ($(this).val() == "")  {
// 			$(this).parent().next().children('select').empty();
// 			return true;
// 		}
// 			$(this).parent().next().children('select').empty();
// 		var option ="<option></option>";
// 		function callback(response) {
// 				 $.each(response ,function(i,value) {
// 					option+="<option value=" + response[i].element + ">" + response[i].element + "</option>";
// 				});
//   //use return_first variable here
// }
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			'async': false,
// 			data : {bilan : bilan },
// 			datatype : 'json',
// 			success : function (data) {
// 				callback(data);
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 		$(this).parent().next().children('select').append(option);
// 	});
// 	$('tbody').on('change','.element',function(){
// 		var element = $(this).val(); //récupérer le bilan selectionné
// 		if ($(this).val() == "")  {
// 			$(this).parent().next().next().children('select').empty();
// 			return true;
// 		}
// 		$(this).parent().next().next().children('select').empty();
// 		var option ="";
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/getElement',
// 			method :'POST',
// 			'async': false,
// 			data : {element : element },
// 			datatype : 'json',
// 			success : function (data) {
// 				 $.each(data ,function(i,value) {
// 					option+="<option value=" + data[i].id + ">" + data[i].unite + "</option>";
// 				});
// 			},
// 			error:function (jqXHR, textStatus) {
// 				alert( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 		$(this).parent().next().next().children('select').append(option);
// 	});	
// 			//function to edit biological analysis row and show in the modal
// 	$('.edit_bilan').on('click', function() {
// 	    var myModal = $('#modal_detail_analyse');
// 	    var bilan_id = $(this).attr('id'); // get bilan ID

// 	    // now get the values from the table
// 	   	 var bilan = $(this).closest('tr').find('th:eq(0)').attr('value');
// 	   	 var element = $(this).closest('tr').find('th:eq(1)').attr('value');
// 	   	 var valeur = $(this).closest('tr').find('td:eq(0)').attr('value');
// 	   	 var date_analyse = $(this).closest('tr').find('td:eq(4)').attr('value');
// 	   	 var laboratoire = $(this).closest('tr').find('td:eq(6)').attr('value');
// 	   	 var commentaire = $(this).closest('tr').find('td:eq(7)').attr('value');

// 	    // and set them in the modal:
// 	    $('#bilan' ,myModal).val(bilan).is(':selected');
// 	    $('#element',myModal).val(element).is(':selected');
// 	    $('#valeur',myModal).val(valeur);
// 	    $('#date_analyse',myModal).val(date_analyse);
// 	    $('#laboratoire',myModal).val(laboratoire);
// 	    $('#commentaire',myModal).val(commentaire);    
// 	    $('.up_bilan',myModal).attr('action' ,'/patient/bilan/'+bilan_id);    

// 	    // and finally show the modal
// 	    myModal.modal({ show: true });
//     });

//     //Function to show modal media
//     $('.media').click(function(){
//     	var id = $(this).parent().attr('value');
//     	 console.log(id);
//     	$("#modal_media img").attr('src','/images/'+id+'.jpg');
//     	var myModal = $("#modal_media");	
//     	myModal.modal({ show: true });
//     });

//     $("#labo_gen").keyup(function(){
//     	var valeur = $("#labo_gen").val();
//     	console.log(valeur);

//     	$('.lab').val(valeur);

//     });

//     	$('#bilans').on('click','.fa-times-circle',function(){
// 		$(this).closest('tr').remove();
// 	});
// 	//**************************************************************************************************************************//

// 	//******************************^^*****^^*****************************// 
// 	// Produit alimentaire et phytotherapie :
// 	// Ajouter des lignes prescriptions
// 	// Affichage de la page de confirmation
// 	// Envoi du formulaire au serveur HTTP , la méthode :POST
// 	//******************************^^*****^^**************************************// 
// 	$("tbody").on('change','.frequence',function(){
// 			if($(this).val() == "Depuis :")
// 				$(this).parent().next().children('input').show();
// 		else $(" this.frequence_date").hide();
// 	});
// 	$("#add_produit").click(function(){
// 		$(this).closest('tbody').prepend("<tr><td><input type='hidden' class='pr_hidden' name='produitalimentaire_id[]'><input type='text' class='pr_input' style='width: 200px;padding-top: 6px;'></td> <td width='120px'><input type='text' class='ar_input' style='width: 200px;padding-top: 6px;'></td> <td width='120px'> <select class='form form-control frequence' name='frequence[]' > <option>Occasionnellement</option> <option>Exceptionnellement</option> <option>Depuis :</option> </select> </td> <td><input type='date' class='form-control frequence_date'  name='frequence_date[]' style='display: none;' /></td></tr>");
// 			});

// 	// console.log($(this).val());
// 	var options = {
// 			  url: function(phrase) {
// 			    return "/patient/produit/"+ phrase; // url to send into server
// 			  },
// 			  getValue: "produit_naturel_fr",
// 			  ajaxSettings: { // d'ont touch and mmodify
// 				  	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 				    dataType: "json",
// 				    method: "POST",
// 				    data: {
// 				      dataType: "json"
// 				    }
// 			  },
// 			  preparePostData: function(data) {
// 			    data.phrase = $('.pr_input').val(); // returned data from server , json format
// 			    return data;
// 			  },
// 			  list : {
// 			  	onSelectItemEvent : function () {
// 			  		var value = $('.pr_input').getSelectedItemData().id;
// 			  		$(".pr_hidden").val(value).trigger("change");
// 			  	}
// 			  }
// 			  // requestDelay: 10000 // delays for response serve
// 			};
// 	$('.pr_input').easyAutocomplete(options);

// 	$('#modal_phyto').on('blur','.pr_input',function(){
// 		var valeur = $ (this).val();
// 		console.log(valeur);
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/patient/produit/'+valeur,
// 			method :'POST',
// 			// data : {phrase : valeur },
// 			datatype : 'json',
// 			success : function (data) {
// 					if (data.length == "0") {
// 						$(this.element).val("Erreur !!!!").css('border-color','red');
// 						$(this.element).val(""); 
// 					}
// 			},
// 			error:function (jqXHR, textStatus) {
// 				 $('.pr_input').val("");
// 				console.log( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		});
// 	});
// 	//**************************************************************************************************************************//

// 	//******************************^^*****^^*****************************// 
// 	// Prescription :
// 	// Ajouter des lignes prescriptions
// 	// Affichage de la page de confirmation
// 	// Envoi du formulaire au serveur HTTP , la méthode :POST
// 	// Button to delete row
// 	//******************************^^*****^^**************************************// 
// 	$("#tablePrescription>tbody").on('click','#add_prescription',function(){
// 		$(this).closest('tbody').append("<tr> <td width='250px'> <input type='text' class='form form-control' placeholder='Médicament comerciale'> </td> <td width='250px'> <input type='text' class='form form-control'  placeholder='équivalent DCI' name='medicament_dci_id[]'> </td> <td width='80px'><select class='form form-control' name='voie[]'><option>IM</option><option>IV</option></select></td> <td width='80px'><input type='text' class='form form-control' name='dose_matin[]' value='0'></td> <td width='97px'> <select class='form form-control' name='repas_matin[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_midi[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='repas_midi[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_soir[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='repas_soir[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_avant_coucher[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='unite[]'> <option>gellule</option> <option>comprimé</option> </select> </td> <td> <input type='text' class='form-control' name='nbr_jours[]' value='0'> </td> <td> <button type='button' class='btn btn-info btn-flat' id='add_prescription'>+</button> </td> </tr>");
// 		 $(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>");
// 	});	
// 	// Affichage de la page de confirmation	
// 	$(".confirmer").click(function(){
// 		//test if display table is show , submit form so
// 		 if ($('#modal_display').is(':visible')) {
// 			$('#target').submit();
// 			event.preventDefault();
// 		 } 
// 		 else {
// 				var medicament_dci = []; var voie = []; var dose_matin = []; var repas_matin = []; var dose_midi = []; var repas_midi = []; var dose_soir = []; var repas_soir = []; var dose_avant_coucher = []; var unite = []; var jours = [];
// 				$('#tablePrescription > tbody > tr').each(function(){
// 					medicament_dci.push($(this).find('td:eq(1) > input').val());
// 					voie.push($(this).find('td:eq(2) > select option:selected').val())
// 					dose_matin.push($(this).find('td:eq(3) > input').val());
// 					repas_matin.push($(this).find('td:eq(4) > select option:selected').val());
// 					dose_midi.push($(this).find('td:eq(5) > input').val());
// 					repas_midi.push($(this).find('td:eq(6) > select option:selected').val());
// 					dose_soir.push($(this).find('td:eq(7) > input').val());
// 					repas_soir.push($(this).find('td:eq(8) > select option:selected').val());
// 					dose_avant_coucher.push($(this).find('td:eq(9) > input').val());
// 					unite.push($(this).find('td:eq(10) > select option:selected').val());
// 					jours.push($(this).find('td:eq(11) > input').val());
// 				});
// 					 console.log(repas_matin);
// 				//affect inputs  to table
// 				for (var i = 0; i < medicament_dci.length; i++) 

// 					$(".display > tbody").append("<tr>"+
// 													"<td>"+medicament_dci[i]+"</td>"+
// 													"<td>"+voie[i]+"</td>"+
// 													"<td>"+dose_matin[i]+" "+repas_matin[i]+"</td>"+
// 													"<td>"+dose_midi[i]+" "+repas_midi[i]+"</td>"+
// 													"<td>"+dose_soir[i]+" "+repas_soir[i]+"</td>"+
// 													"<td>"+dose_avant_coucher[i]+"</td>"+
// 													"<td>"+unite[i]+"</td>"+
// 													"<td>"+jours[i]+" j</td>"+
// 												"</tr>");
// 				//show Modal
// 				$("#modal_display").modal({ show: true });
// 		 	}
// 	});
// 	//function to delete row
// 	$('#tablePrescription').on('click','.fa-times-circle',function(){
// 		$(this).closest('tr').remove();
// 	});

// 	//******************************^^*****^^*****************************// 
// 	// Consultation :
// 	// Ajouter des lignes consultation
// 	// Affichage de la page de confirmation
// 	// Envoi du formulaire au serveur HTTP , la méthode :POST
// 	// Button to delete row
// 	//******************************^^*****^^**************************************// 
// 	$("#tableConsultation>tbody").on('click','#add_consultation',function(){
// 		$(this).closest('tbody').append("<tr> <td width='250px'> <input type='text' class='form form-control' placeholder='Médicament comerciale'> </td> <td width='250px'> <input type='text' class='form form-control'  placeholder='équivalent DCI' name='medicament_dci_id[]'> </td> <td width='80px'><select class='form form-control' name='voie[]'><option>IM</option><option>IV</option></select></td> <td width='80px'><input type='text' class='form form-control' name='dose_matin[]' value='0'></td> <td width='97px'> <select class='form form-control' name='repas_matin[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_midi[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='repas_midi[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_soir[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='repas_soir[]'> <option>Avant</option> <option>Aprés</option> <option>pendants</option> </select> </td> <td width='80px'> <input type='text' class='form form-control' name='dose_avant_coucher[]' value='0'> </td> <td width='97px'> <select class='form form-control' name='unite[]'> <option>gellule</option> <option>comprimé</option> </select> </td> <td> <input type='text' class='form-control' name='nbr_jours[]' value='0'> </td> <td> <button type='button' class='btn btn-info btn-flat' id='add_consultation'>+</button> </td> </tr>");
// 		 $(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer;'></i>");
// 	});	
// 	// Affichage de la page de confirmation	
// 	$(".confirmer").click(function(){
// 		//test if display table is show , submit form so
// 		 if ($('#modal_display_consultation').is(':visible')) {
// 			$('#target_consultation').submit();
// 			event.preventDefault();
// 		 } 
// 		 else {
// 				var medicament_dci = []; var voie = []; var dose_matin = []; var repas_matin = []; var dose_midi = []; var repas_midi = []; var dose_soir = []; var repas_soir = []; var dose_avant_coucher = []; var unite = []; var jours = [];
// 				$('#tableConsultation > tbody > tr').each(function(){
// 					medicament_dci.push($(this).find('td:eq(1) > input').val());
// 					voie.push($(this).find('td:eq(2) > select option:selected').val())
// 					dose_matin.push($(this).find('td:eq(3) > input').val());
// 					repas_matin.push($(this).find('td:eq(4) > select option:selected').val());
// 					dose_midi.push($(this).find('td:eq(5) > input').val());
// 					repas_midi.push($(this).find('td:eq(6) > select option:selected').val());
// 					dose_soir.push($(this).find('td:eq(7) > input').val());
// 					repas_soir.push($(this).find('td:eq(8) > select option:selected').val());
// 					dose_avant_coucher.push($(this).find('td:eq(9) > input').val());
// 					unite.push($(this).find('td:eq(10) > select option:selected').val());
// 					jours.push($(this).find('td:eq(11) > input').val());
// 				});
// 					 console.log(repas_matin);
// 				//affect inputs  to table
// 				for (var i = 0; i < medicament_dci.length; i++) 

// 					$(".display_cons > tbody").append("<tr>"+
// 													"<td>"+medicament_dci[i]+"</td>"+
// 													"<td>"+voie[i]+"</td>"+
// 													"<td>"+dose_matin[i]+" "+repas_matin[i]+"</td>"+
// 													"<td>"+dose_midi[i]+" "+repas_midi[i]+"</td>"+
// 													"<td>"+dose_soir[i]+" "+repas_soir[i]+"</td>"+
// 													"<td>"+dose_avant_coucher[i]+"</td>"+
// 													"<td>"+unite[i]+"</td>"+
// 													"<td>"+jours[i]+" j</td>"+
// 												"</tr>");
// 				//show Modal
// 				$("#modal_display_consultation").modal({ show: true });
// 		 	}
// 	});
// 	//function to delete row
// 	$('#tableConsultation').on('click','.fa-times-circle',function(){
// 		$(this).closest('tr').remove();
// 	});

// 	//******************************^^*****^^*****************************// 
// 	// Patient :
// 	// retourner les inforamtions sur le patient et l'afficher sur le modal  à modifier
// 	//******************************^^*****^^**************************************// 
// 	$(".up_patient").click(function(){
// 		var patient_id = $(this).attr('data');
// 		console.log(patient_id);
// 		$.ajax({
// 			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 			url : '/api/patient/getPatient/'+patient_id,
// 			method :'POST',
// 			datatype : 'json',
// 			success : function (data) {
// 				$("#num_securite_sociale").val(data[0].num_securite_sociale);				
// 				$("#nom").val(data[0].nom);				
// 				$("#prenom").val(data[0].prenom);				
// 				$("#date_naissance").val(data[0].date_naissance);				
// 				$("#sexe").val(data[0].sexe).is(':selected');				
// 				$("#adresse").val(data[0].adresse);				
// 				$("#ville").val(data[0].ville);				
// 				$("#commune").val(data[0].commune);				
// 				$("#taille").val(data[0].taille);				
// 				$("#poids").val(data[0].poids);				
// 				$("#situation_familliale").val(data[0].situation_familliale).is(':selected'); if (data[0].situation_familliale == "Marié(e)") {$("#nbre").val(data[0].nbre_enfants) ;$("#nbre_enfants").show(); }			
// 				if (data[0].travaille == "Retraité" || data[0].travaille == "Universitaire")
// 					{
// 						$("#travaille").val(data[0].travaille).is(':selected');
// 						$("#travaille1").val(data[0].travaille);
// 					} 
// 					else { $("#travaille1").val(data[0].travaille);  $("#autre").show(); }
// 				if(data[0].tabagiste == "on") { $("#tabac").prop('checked' , true); $("#tabac1").val(data[0].tabagiste_depuis); $(".tabac").show(); }				
// 				if(data[0].alcoolique == "on") { $("#alcool").prop('checked' , true); $("#alcool1").val(data[0].alcoolique_depuis); $(".alcool").show(); }				
// 				if(data[0].drogue == "on") { $("#drogue").prop('checked' , true); $("#drogue1").val(data[0].drogue_depuis); $("#type_dr").val(data[0].details); $(".drogue").show(); }	
// 				$("#num_tel_1").val(data[0].num_tel_1);	
// 				$("#num_tel_2").val(data[0].num_tel_2);	
// 				$("#num_dossier").val(data[0].num_dossier);	

// 				$.each(data[1] , function ( i , val) {
// 					$("#date_admission").val(val.date_admission);	
// 					$("#chambre").val(val.chambre);	
// 					$("#lit").val(val.lit);	
// 					console.log(val.service);
// 				});
// 			},
// 			error:function (jqXHR, textStatus) {

// 				console.log( "Request failed: " + textStatus +" "+jqXHR );
// 			}
// 		})
// 	});
//         //Show number of children input's when the situation is married
//         $("#situation_familliale").change(function(){
//             if ($(this).val() == "Marié(e)") {
//                 $("#nbre_enfants").show();
//             } else $("#nbre_enfants").hide();
//         });

//         //Show other works input's 
//         $("#travaille").change(function(){
//             if ($(this).val() == "autre") {
//                 $("#autre").show();
//             } else $("#autre").hide();
//         });

//         $("#tabac").change(function(){
//             if ($(this).is(":checked")) {
//                 $(".tabac").show();
//             } else{
//             	$("#tabac1").val("");
//             	 $(".tabac").hide();
//             }
//         });
//         $("#alcool").change(function(){
//             if ($(this).is(":checked")) {
//                 $(".alcool").show();
//             } else{
//             	$("#alcool1").val("");
//             	$(".alcool").hide();
//             } 
//         });
//                 $("#drogue").change(function(){
//             if ($(this).is(":checked")) {
//                 $(".drogue").show();
//             } else{
//             	$("#drogue1").val("");
//             	$(".drogue").hide();
//             } 
//         });
//                 $("#travaille").change(function(){
//                 	var valeur = $(this).val();
//                 	$("#travaille1").val(valeur);
//                 });


// 	// var options1 = {
// 	// 			  url: function(phrase1) {
// 	// 			    return "/patient/produit_ar/"+ phrase1; // url to send into server
// 	// 			  },
// 	// 			  getValue: "produits_arabe",
// 	// 			  ajaxSettings: { // d'ont touch and mmodify
// 	// 				  	headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
// 	// 				    dataType: "json",
// 	// 				    method: "POST",
// 	// 				    data: {
// 	// 				      dataType: "json"
// 	// 				    }
// 	// 			  },
// 	// 			  preparePostData: function(data) {
// 	// 			    data.phrase = $(".pr_inputt").val(); // returned data before sedn to server
// 	// 			    return data;
// 	// 			  },
// 	// 			  // requestDelay: 10000 // delays for response serve
// 	// 			  list: {
// 	// 						onSelectItemEvent: function() {
// 	// 							var produit_fr = $("#function-index").getSelectedItemIndex();

// 	// 							$(".pr_input").val(produit_fr).trigger("change");
// 	// 						}
// 	// 					};
// 	// $(".ar_input").easyAutocomplete(options1);

// });