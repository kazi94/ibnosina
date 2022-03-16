$(
	function()
	{
     	    //Fonction de recherche de medicament dci
           $( "form" ).on('keydown',"input[name='medicament_dci']",function(){
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
                      response($.map(data.slice(0, 10), function (item) { // slice cut number of element to show
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
              }// END SOURCE
              }); 
            });      
    }
);