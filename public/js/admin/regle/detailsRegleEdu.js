$(
	function()
	{	
        $('.DetailsEdu').on('click', function() { // afficher les details de l'Analyse thérapeutique
			var myModal2 = $('#detailsEdu');
			$('#details_body').empty();
			var education_id = $(this).data('id');
			
			$.ajax({
			   //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				url : '/admin/education/'+education_id+'/details',
			   method :'get',
			   datatype : 'html',
			   success : function (data) {

				   if(data.education.si == "") {
					   
				   }else{

					var name_pdf = data.education.pdf;
							   $('#details_body').append("<div class='panel-group' id='accordion' role='tablist' aria-multiselectable='true'>"+
								
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#titre' aria-expanded='true' aria-controls='titre'>"+
											"Titre :"+	
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='titre' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body'>"+
										data.education.titre+
										"</div>"+
										"</div>"+
									"</div>"+
									
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#maladie' aria-expanded='true' aria-controls='maladie'>"+
											"Maladie :"+	
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='maladie' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body'>"+
										data.education.maladie+
										"</div>"+
										"</div>"+
									"</div>"+
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#effet' aria-expanded='true' aria-controls='effet'>"+
											"Effet :"+	
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='effet' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body'>"+
										data.education.effet+
										"</div>"+
										"</div>"+
									"</div>"+
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#voyage' aria-expanded='true' aria-controls='voyage'>"+
											"Voyage :"+	
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='voyage' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body'>"+
										data.education.voyage+
										"</div>"+
										"</div>"+
									"</div>"+
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#act' aria-expanded='true' aria-controls='act'>"+
											"Act :"+
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='act' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body'>"+
										data.education.act+
										"</div>"+
										"</div>"+
									"</div>"+
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#utilisation' aria-expanded='true' aria-controls='utilisation'>"+
											"Utilisation :"+	
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='utilisation' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body'>"+
										data.education.utilisation+
										"</div>"+
										"</div>"+
									"</div>"+
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#effet_indiserable' aria-expanded='true' aria-controls='effet_indiserable'>"+
											"Effet indésirable :"+	
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='effet_indiserable' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body'>"+
										data.education.effet_indiserable+
										"</div>"+
										"</div>"+
									"</div>"+
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#regime' aria-expanded='true' aria-controls='regime'>"+
											"Regime allimentaire :"+
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='regime' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body'>"+
										data.education.regime+
										"</div>"+
										"</div>"+
									"</div>"+
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#url' aria-expanded='true' aria-controls='url'>"+
											"URL :"+	
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='url' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body' id='urlBody'> "+
										
										"</div>"+
										"</div>"+
									"</div>"+
									"<div class='panel panel-default'>"+
										"<div class='panel-heading' role='tab' id='headingTwo'>"+
										"<h4 class='panel-title'>"+
											"<a class='collapsed' role='button' data-toggle='collapse' data-parent='#accordion' href='#pdff' aria-expanded='true' aria-controls='pdff'>"+
											"PDF :"+	
											"</a>"+
										"</h4>"+
										"</div>"+
										"<div id='pdff' class='panel-collapse collapse' role='tabpanel' aria-labelledby='headingTwo'>"+
										"<div class='panel-body' id='pdfBody'>"+
										
										"</div>"+
										"</div>"+
									"</div>"+
								"</div>");
								if(data.education.url!=""){
									$('#urlBody').append(
										"<a href='"+data.education.url+"' target='_blank'>"+
										"Aller sur le site"+
										"</a>");		
								   }else{
									$('#urlBody').append(
										"Aucun site enregistré");
								   }
								if(data.education.pdf!=null){
									$('#pdfBody').append(
										data.education.pdf+
										"<a href='https://ibno-sina.com/pdfs/"+name_pdf+"' target='_blank'>"+
										"  Ouvrir");		
								   }else{
									$('#pdfBody').append(
										"Aucun pdf enregistré");
								}   


				   }
				   myModal2.modal({ show: true });
			   },				
			   error:function (jqXHR, textStatus) {
				   alert( "Erreur Serveur: " + textStatus +" "+jqXHR );
			   }
			});
	   });
	});
	

