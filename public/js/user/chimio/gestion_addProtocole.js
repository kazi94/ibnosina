$(
	function()
	{

		//******************************^^*****^^*****************************// 
		// Prescription :
		// Ajouter des lignes prescriptions
		// Aide à la saise médicament dci ou médicament spécialité
		// Affichage de la page de confirmation
		// Envoi du formulaire au serveur HTTP , la méthode :POST
		// Button to delete row
		//******************************^^*****^^**************************************// 
		
		$options = "<option>BILLE(S)</option> <option>BOUFFEE(S)</option> <option>CACHET(S)</option> <option>GELULE(S)</option> <option>CAPSULE(S) MOLLE(S)</option> <option>CATAPLASME(S)</option> <option>CHAMP(S) MEDICAMENTEUX</option> <option>CIGARETTE(S)</option> <option>COMPRESSE(S)</option> <option>COMPRIME(S)</option> <option>DISPOSITIF(S) INTRAUTERIN(S)</option> <option>DISPOSITIF(S) TRANSDERMIQUE(S)</option> <option>DOSE(S)</option> <option>EMPLATRE(S)</option> <option>EPONGE(S)</option> <option>GAZE(S)</option> <option>GOMME(S)</option> <option>GRANULE(S)</option> <option>IMPLANT(S)</option> <option>INSERT(S)</option> <option>LYOPHILISAT(S)</option> <option>OVULE(S)</option> <option>PASTILLE(S)</option> <option>PATE(S)</option> <option>PILULE(S)</option> <option>SUPPOSITOIRE(S)</option> <option>TAMPON(S)</option> <option>TIMBRE(S)</option> <option>CUILLERE(S) A CAFE</option> <option>CUILLERE(S) A SOUPE</option> <option>CUILLERE(S) A DESSERT</option> <option>CUILLERE(S) MESURE</option> <option>GOUTTE(S)</option> <option>GOBELET(S)</option> <option>PULVERISATION(S)</option> <option>MESURE(S)</option> <option>PANSEMENT(S) ADHESIF(S)</option> <option>MECHE(S)</option> <option>SYSTEME DE DIFFUSION VAGINAL</option> <option>DISPOSITIF(S)</option> <option>RECIPIENT(S) UNIDOSE(S)</option> <option>BATON(S)</option> <option>FILM(S) ORODISPERSIBLE(S)</option> <option>DOSE(S) KG</option> <option>MATRICE(S)</option> <option>APPLICATION(S)</option>";
		
		
		
			
	    //Fonction de recherche de medicament dci
	    $( "tbody" ).on('keydown',"input[id='medicament_dci']",function(){
	    	$(this).autocomplete({
	    		appendTo: $(this).parent(), // selectionner l'element pour ajouter la liste des suggestion
			    source: function( request, response ) {
			        $.ajax( {
			          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},	
			          url: "/medicament",
			          method : "POST",
			          data: {
			            phrase: request.term // value on field input
			          },
			          success: function( data , status , code ) {
			          		response($.map(data.slice(0, 20), function (item) { // slice cut number of element to show
			          			dosage = "";
			          			if (item.status == "médicament") {//pour afficher le status du medicament sp en couleur
			          				style ="style='color:red;'";
			          			} else { // status : substance active
			          				//dosage = item.dosage+""+item.unite;
			          				style = "style='color: green;'";
			          			} 
			          			status = "<i "+style+">"+item.status+"</i>";

					            return {
					                label : item.medicament+" "+dosage+" "+status, // pour afficher dans la liste des suggestions
					                sac_id: item.sac_code_sq_pk,
					                dosage: item.dosage,
					                unite:  item.unite, 
					                sp_id:  item.sp_code_sq_pk,
					                value:  item.medicament+" "+dosage // value c la valeur à mettre dans l'input this
					            };
					        }));
			          }
			        });
			      },// END SOURCE
			      minLength: 2,
			    select: function( event, ui ) {
						$(this).attr("disabled","true");
							var unit = $(this).closest('tr').find("td >select[name='unites[]']");
							if($(this).attr('name')==="prem"){
								var voie = $(this).closest('tr').find("td >select[name='voie_prem[]']");
							}
							else if($(this).attr('name')==="trait"){
								var voie = $(this).closest('tr').find("td >select[name='voie_trait[]']");
							}
			      	var input_sp_id = $(this).prev();
					// var input_dci = $(this).closest('tr').find("input[name='medicament_dci']");
			      	console.log(ui.item.sp_id);
			      	console.log(ui.item.sac_id);
			      	if (typeof ui.item.sp_id != 'undefined' || ui.item.sp_id != null) { // si le médicament selectionner est une spécialité
			      		$(input_sp_id).val(""); 
	      				get_unite_voie (ui.item.sp_id , ui.item.label , unit , voie);
	      				$(this).prev().val(ui.item.sp_id);
			      	} else { // si le médicament selectionner est un médicament DCI
			      		//Récuprérer le code spécialité du médicament DCI
			      		//par le biais du code specialite , récuprer la voie et l'unite
			      		// ajouter le code sp récupérer via le serveur
			      		$.ajax({// INPUT : spec_id // OUTPUT : unité(s)
							headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
							url :"/medicamentSp",method : "POST", dataType :'json',data :{ code_dci : ui.item.sac_id , dosage : ui.item.dosage , unite : ui.item.unite},
							success : (data ) => {
								$(this).prev().val(data[0].cosac_sp_code_fk_pk ); // affecter l'id de la sp retourné
								get_unite_voie (data[0].cosac_sp_code_fk_pk , 'null' , unit , voie) //afficher l'unite et la voie de la specialite retourné
								}
						});		      		
			      	}
			      	
			      },
			       open: function() {
				        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
				      },
				   close: function() {
				        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
				      }
			    }).data("ui-autocomplete")._renderItem = function (ul, item) {//cette method permet de gérer l'affichage de la liste des suggestions
				        var bg = "";
				        if ((item.label).indexOf("NSFP") != -1) {
				        	bg ="style = 'background-color:red; color:white;'";
			          		$(this).addClass('type');

				        } 
				         return $("<li></li>")
				             .data("item.autocomplete", item)//récupérer les donnée de l'autocomplete
				             //.attr( "data-value", item.id )
				             .append("<a "+bg+">" + item.label + "</a>")//ajouter à la liste de suggestions
				             .appendTo(ul); 
				         };
	    });

				


		function get_unite_and_dci (spec,spec_id , unit, voie,input_sp_id) { 			
  			$.ajax({//Input : spec_id .pre //Output : DCI , DCI_ID
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url :"/medicamentDci",method : "POST",dataType :'json', data :{ spec_id : spec_id},
				success : (data ) => {	
					$.each(data,function(i , value){
						var med_dci_id = value.sac_code_sq_pk;
						$(input_sp_id).val(med_dci_id + ( ($(input_sp_id).val() != "") ? "," + $(input_sp_id).val() : '' ) ); // affecter les id du dci
						//var med_dci= value.sac_nom + " " + value.cosac_dosage + "" + value.cosac_unitedosage;
						//$(input_dci).attr('title',med_dci + ( ($(input_dci).val() != "") ? "/" + $(input_dci).val() : '' ) ); // créer une chaine de dci et l'afficher
						//$(input_dci).val(med_dci + ( ($(input_dci).val() != "") ? "/" + $(input_dci).val() : '' ) ); // créer une chaine de dci et l'afficher				
					});
				},
				error : function (jQxr , status ,code) { // status = error , code : Unprocessable Entity
					console.log(status);
				} 
			});
		}
		//fonction qui permet de retourner l'unite et la voie de la specialite
		function get_unite_voie (spec_id , spec , unit , voie) {
			$(unit).empty();			$(voie).empty();	
      		$.ajax({// INPUT : spec_id // OUTPUT : unité(s)
					headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
					url :"/medicamentSpUnit",method : "POST", dataType :'json',data :{ spec_id : spec_id},
					success : (data ) => {
						if ( data[0].length == 0) {
				      		 $(unit).append($options);		
						}
					    $.each(data[0],function(i , value) {//ajouter les unites coresspondant à la spécialité sélectionner
				      			$(unit).append("<option value="+value.unite_nom+">"+value.unite_nom+"</option>");
				      	});

					    $.each(data[1],function(i , value) {//ajouter les voie coresspondant à la spécialité sélectionner
				      		$(voie).append("<option value="+value.cdf_nom+">"+value.cdf_nom+"</option>");
				      	});							  
				     }});
		}
	}
);