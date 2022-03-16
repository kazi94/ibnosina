
    
   function Hide (addr) { document.getElementById(addr).style.visibility = "hidden";	}

  

    /** Fonction showAttribut pour afficher/cacher les champs select 
                selon le choix séléctionné avant *******/

    function showMedic(){
        var at = document.getElementById("choice_").value;
        var div1_ = document.getElementById("div1_");
        writee(at);writee('= {');

      //  writee(at);
        if(at == "Médicament"){
            Hide("div11_");Hide("div22_");
            var mmte_p_ = document.getElementById("mmte_p_");
            var valDosage_ = document.getElementById("valDosage_");

            div1_.innerHTML = mmte_p_.innerHTML;
            div2_.innerHTML = valDosage_.innerHTML;
            
        }
        if(at == "Produits Alimentaires"){
            Hide("div11_");Hide("div22_");
            var produitalimentaire_ = document.getElementById("produitalimentaire_");
            var freq_ = document.getElementById("freq_");

            div1_.innerHTML = produitalimentaire_.innerHTML;
            div2_.innerHTML = freq_.innerHTML;
        }

    
    }

    function showFreq(){

        var at = document.getElementById("freqSelect_").value;  
        writee(at);
        if(at == "Depuis(jours)"){
            Hide("div11_");Hide("div22_");

            var nb = document.getElementById("age_");
            //var j = document.getElementById("uniteAge_");
            
            Show("div11_");//Show1("div22_");
            div11_.innerHTML = nb.innerHTML;
            //div22_.innerHTML = j.innerHTML;
            
        }
    }

    function showAttributt(){
        var att = document.getElementById("critere_").value;

        var divDynamque1_ = document.getElementById("divDynamque1_");

        if(att== "Pathologie(s) associée(s)" || att== "Allergie(s) associée(s)" || att=="Mode de vie"){

            writee(att);writee('= {');
        }
        else if(att != "Examens")
        {  writee(att); }
        
        if(att == "Age(ans)"){
            Hide("divDynamque11_");
            var divAge_ = document.getElementById("age_");
            //var divUniteAge_ = document.getElementById("uniteAge_");
            var divDynamque2_ = document.getElementById("divDynamque2_"); 
            Show1("divDynamque2_"); 

            divDynamque1_.innerHTML = divAge_.innerHTML;
            //divDynamque2_.innerHTML = divUniteAge_.innerHTML;
            
        }

          
        if(att == "Poids(kg)"){
            Hide("divDynamque2_"); Hide("divDynamque11_");
            var divPoids_ = document.getElementById("poids_");
            
            divDynamque1_.innerHTML = divPoids_.innerHTML;
        
        }
        if(att == "Pathologie(s) associée(s)"){
            Hide("divDynamque2_"); Hide("divDynamque11_");
            var divPathologie_ = document.getElementById("pathologie_");
        
            divDynamque1_.innerHTML = divPathologie_.innerHTML;
        
        }
        if(att == "Allergie(s) associée(s)"){
            Hide("divDynamque2_");  Hide("divDynamque11_");
            var divAllergie_ = document.getElementById("allergie_"); 

            divDynamque1_.innerHTML = divAllergie_.innerHTML;

        }
        if(att == "Service"){
            Hide("divDynamque2_");  Hide("divDynamque11_");
            var divService_ = document.getElementById("service_");
            
            divDynamque1_.innerHTML = divService_.innerHTML;
            
        }
       
        if(att == "Durée hospitalisation(jours)"){
            Hide("divDynamque2_");  Hide("divDynamque11_");
            /** même code d'age .. nombre + jour/mois/annee */
            var divAge_ = document.getElementById("age_");
            
            divDynamque1_.innerHTML = age_.innerHTML;
            
        }


        if(att == "Examens"){

         Hide("divDynamque2_");

            var divAnnalyses_ = document.getElementById("examens_");
            var divVleur_ = document.getElementById("valeur_");
            var divDynamque2_ = document.getElementById("divDynamque2_");

            Show("divDynamque2_"); 

            divDynamque1_.innerHTML = divAnnalyses_.innerHTML;
            divDynamque2_.innerHTML = divVleur_.innerHTML;
        
        }



    }


    function writee(att){

        if(att !=""){
            var textAr = document.getElementById("exampleFormControlTextarea1_");
            var contenu = document.getElementById("exampleFormControlTextarea1_").value;
            if(contenu.endsWith(' ')) textAr.value = contenu+""+att;
            else textAr.value = contenu+" "+att;   
        }
    }
  


    function recup(selectName){
       
        var s = document.getElementById(selectName).value;
        if(s != "abs")
        
        writee(s);

        if(s == "abs"){
            changeOnSelectAbs();
                    }
          if(selectName=="preinscriptionSelect_") reset(selectName);
       
        }

       
        function reset(selectMed){
            var s = document.getElementById(selectMed);
            s.value ="";
            }

    /*** pour la valeur abs des nombres */
    function interdire(){
        event.returnValue = false;
    }

    function changeOnSelectAbs(){
        var str=document.getElementById("exampleFormControlTextarea1_").value; 
        var towrite="abs("+p+")"
        var n=str.replace(p,"abs("+p+")");
        document.getElementById("exampleFormControlTextarea1_").value=n;
    }
    var p='';
    document.addEventListener('mouseup', function(){
        var thetext = window.getSelection().toString();
        if (thetext.length > 0){ // check there's some text selected
        if(Math.sign(thetext)==1 || Math.sign(thetext)==-1){
        console.log(thetext);
        p=thetext;
        }
        // logs whatever textual content the user has selected on the page
        }
    }, false);