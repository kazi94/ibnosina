
		$(
			function() 
			{


				$('form').on('click','#addMed',function() {// function to add new filed dynamlicly without refresh

					$("<div class='col-sm-4 col-sm-offset-0 float-left med_dci' > <label for='Médicament'>Médicament (DCI) liée :</label> <input type='hidden' name='med_sp_id[]'> <input type='text' class='form-control' name='medicament_dci'></div> <div class='col-sm-1'> <label for=''> </label> <input type='button' class='btn btn-info' id='addMed' style='margin-top: 25px;' value='+' /></div>").insertAfter($(this).parent());
					$(this).replaceWith("<i class='fa fa-times-circle' style='color:red;cursor : pointer; margin-top:30px;'></i>"); });


			    //Fonction de recherche de medicament dci
			    $( "form" ).on('keydown',"input[name='medicament_dci']",function(){
			    	$(this).autocomplete({
			    		 appendTo: $(this).parent(), // selectionner l'element pour ajouter la liste des suggestion
					      source: function( request, response ) {
					        $.ajax( {
					          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},	
					          url: "/medicamentDci",
					          dataType: "json",
					          method : "POST",
					          data: {
					            phrase_dci: request.term // value on field input
					          },
					          success: function( data , status , code ) {
					                    response($.map(data.slice(0, 10), function (item) { // slice cut number of element to show
							            return {
							                label: item.sac_nom , // pour afficher dans la liste des suggestions
							                sac_id: item.sac_code_sq_pk,
							                value: item.sac_nom  // value c la valeur à mettre dans l'input this
							            };
							        }));
					          }
					        });
					      },// END SOURCE
					      minLength: 2,
					      select: function( event, ui ) {
					      	$(this).prev().val(ui.item.sac_id);
					      },
					       open: function() {
						        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
						      },
						   close: function() {
						        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
						      }
					    }).data("ui-autocomplete")._renderItem = function (ul, item) {//cette method permet de gérer l'affichage de la liste des suggestions
				        var bg = "";
				        if ((item.label).indexOf("NSFP") != -1) bg ="style = 'background-color:red;' ";
				         return $("<li></li>")
				             .data("item.autocomplete", item)//récupérer les donnée de l'autocomplete
				             //.attr( "data-value", item.id )
				             .append("<a "+bg+">" + item.label + "</a>")//ajouter à la liste de suggestions
				             .appendTo(ul); 
				         };
			    });
			    //fonction de recherche des classes pharmacotherapeutique
				$('form').on('click','.fa.fa-times-circle',function(){
					$(this).parent().prev().remove();
					$(this).parent().remove(); }); 
			    //Fonction de recherche de classe médicament			
			}
		);
