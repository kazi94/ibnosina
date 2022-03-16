
    function Hide (addr) { document.getElementById(addr).style.visibility = "hidden";	}
    function Show (addr) { document.getElementById(addr).style.visibility = "visible";	} 

    /** Pour que la page soit vide avant de séléctionner */  


    /** Fonction showAttribut pour afficher/cacher les champs select 
                selon le choix séléctionné avant *******/

    function showMedicament(){
        var at = document.getElementById("choice").value;
        var div1 = document.getElementById("div1");
        write(at);write('= {');
        if(at == "Médicament"){
            Hide("div11");Hide("div22");
            var medic = document.getElementById("mmte_p");
            var valDosage = document.getElementById("valDosage");

            div1.innerHTML = mmte_p.innerHTML;
            div2.innerHTML = valDosage.innerHTML;
            
        }
        if(at == "Produits Alimentaires"){
            Hide("div11");Hide("div22");
            var produitalimentaire = document.getElementById("produitalimentaire");
            var freq = document.getElementById("freq");

            div1.innerHTML = produitalimentaire.innerHTML;
            div2.innerHTML = freq.innerHTML;
        }

    
    }
 
    function showFrequence(){

        var at = document.getElementById("freqSelect").value;  
        write(at);
        if(at == "Depuis(jours)"){
            Hide("div11");Hide("div22");

            var nb = document.getElementById("age");
           // var j = document.getElementById("uniteAge");
            
            Show("div11");//Show("div22");
            div11.innerHTML = nb.innerHTML;
            //div22.innerHTML = j.innerHTML;
            
        }
    }

    function showAttribut(){
        var att = document.getElementById("critere").value;

        var divDynamque1 = document.getElementById("divDynamque1");
        

        if(att== "Pathologie(s) associée(s)" || att== "Allergie(s) associée(s)" || att=="Mode de vie"){

            write(att);write('= {');
        }
        else if(att != "Examens" && att != "Observance")
        {  write(att); }
       
       
        
        if(att == "Age(ans)"){
            Hide("divDynamque11");
            var divAge = document.getElementById("age");
            //var divUniteAge = document.getElementById("uniteAge");
            var divDynamque2 = document.getElementById("divDynamque2"); 
            Show("divDynamque2"); 

            divDynamque1.innerHTML = age.innerHTML;
            //divDynamque2.innerHTML = divUniteAge.innerHTML;
            
        }

        if(att == "Mode de vie"){
            Hide("divDynamque2");   Hide("divDynamque11");
            var divMode = document.getElementById("modeDeVie");
        
            divDynamque1.innerHTML = divMode.innerHTML;

        }

        if(att == "Activité professionnel"){
            Hide("divDynamque2");   Hide("divDynamque11");
            var divtr = document.getElementById("travail");
        
            divDynamque1.innerHTML = divtr.innerHTML;

        }



        if(att == "Nombre de ligne prescription"){
            Hide("divDynamque2");   Hide("divDynamque11");
            var divl = document.getElementById("ligne");
        
            divDynamque1.innerHTML = divl.innerHTML;

        }
        if(att == "Observance"){
            Hide("divDynamque2");   Hide("divDynamque11");
            var divOb = document.getElementById("observance");
        
            divDynamque1.innerHTML = divOb.innerHTML;

        }
        if(att == "Taille(cm)"){
            Hide("divDynamque2"); Hide("divDynamque11");

            var divTaille = document.getElementById("taille");

            divDynamque1.innerHTML = divTaille.innerHTML;
        
        }
        if(att == "Sexe"){
            Hide("divDynamque2");   Hide("divDynamque11");
            var divSexe = document.getElementById("sexe");
            
            divDynamque1.innerHTML = divSexe.innerHTML;
            
        }
        if(att == "Poids(kg)"){
            Hide("divDynamque2"); Hide("divDynamque11");
            var divPoids = document.getElementById("poids");
            
            divDynamque1.innerHTML = divPoids.innerHTML;
        
        }
        if(att == "Pathologie(s) associée(s)"){
            Hide("divDynamque2"); Hide("divDynamque11");
            var divPathologie = document.getElementById("pathologie");
        
            divDynamque1.innerHTML = divPathologie.innerHTML;
        
        }
        if(att == "Allergie(s) associée(s)"){
            Hide("divDynamque2");  Hide("divDynamque11");
            var divAllergie = document.getElementById("allergie"); 

            divDynamque1.innerHTML = divAllergie.innerHTML;

        }
        if(att == "Service"){
            Hide("divDynamque2");  Hide("divDynamque11");
            var divService = document.getElementById("service");
            
            divDynamque1.innerHTML = divService.innerHTML;
            
        }
        if(att == "état de la patiente"){
            Hide("divDynamque2");  Hide("divDynamque11");
            var divService = document.getElementById("etat");
            
            divDynamque1.innerHTML = divService.innerHTML;
            
        }
        if(att == "Durée hospitalisation(jours)"){
            Hide("divDynamque2");  Hide("divDynamque11");
            /** même code d'age .. nombre + jour/mois/annee */
            var divAge = document.getElementById("age");
           
            divDynamque1.innerHTML = divAge.innerHTML;
           
            
        }


        if(att == "Examens"){

            Hide("divDynamque2");

            var divAnnalyses = document.getElementById("examens");
            var divVleur = document.getElementById("valeur");
            var divDynamque2 = document.getElementById("divDynamque2");

            Show("divDynamque2"); 

            divDynamque1.innerHTML = divAnnalyses.innerHTML;
            divDynamque2.innerHTML = divVleur.innerHTML;
        
        }

    }


    function write(att){

        if(att != ""){
            var textAr = document.getElementById("exampleFormControlTextarea1");
            var contenu = document.getElementById("exampleFormControlTextarea1").value;
            if(contenu.endsWith(' ')) textAr.value = contenu+""+att;
            else textAr.value = contenu+" "+att;  
        }
    }
    function write2(att){
        if(att != ""){
            var text2 = document.getElementById("exampleFormControlTextarea2");
            var contenu2 = document.getElementById("exampleFormControlTextarea2").value;
            if(contenu2.endsWith(' ')) text2.value = contenu2+""+att;
            else text2.value = contenu2+" "+att;   
        }
    }

   function write3(att){
        if(att != ""){
            var text2 = document.getElementById("exampleFormControlTextarea3");
            var contenu2 = document.getElementById("exampleFormControlTextarea3").value;
            if(contenu2.endsWith(' ')) text2.value = contenu2+""+att;
            else text2.value = contenu2+" "+att;  
        }
   }
   function writeMed(att){
        if(att != ""){
            var text2 = document.getElementById("exampleFormControlTextarea1");
            var contenu2 = document.getElementById("exampleFormControlTextarea1").value;
            if(contenu2.endsWith(' ')) text2.value = contenu2+""+att;
            else text2.value = contenu2+" "+att; 
        }

    }

    function recuperer(selectName){
        if(document.getElementById("the").classList.contains("active")){
        var s = document.getElementById(selectName).value;
        if(s != "abs"){
            write(s);
        }else{
            changeOnSelectAbs();
        }
        if(selectName=="preinscriptionSelect") reset(selectName);
       
                    
        }
        else if(document.getElementById("educ").classList.contains("active")){
            var s = document.getElementById(selectName).value;
            //console.log(s);
            if(selectName=="medSelect") reset(selectName);
            if(s=="médicament" || s=="pathologie" ) write2(s+" = {");
            else write2(s);
            
        }
        else if(document.getElementById("sui").classList.contains("active")){
            var s = document.getElementById(selectName).value;
            //console.log(s);
            write3(s);
        }

    }

    function recupModif1(selectName){
        /**fait le même travail de la fct recuperer mais c pour la page modifier 
         * car cette dernier ne contient pas d'onglets.
         * recupModif1 : fonction utilisé dans edit1 qui permet de modifier 
         * les règles du 1er onglet "analyse pharmaceutique".
         */
        var s = document.getElementById(selectName).value;
        if(s != "abs")
        
        write(s);

        if(s == "abs"){
            changeOnSelectAbs();
                    }
        if(selectName=="preinscriptionSelect") reset(selectName);

                    
   }
    
   function recupModif2(selectName){
    /**pour education therapeutique
     */
    var s = document.getElementById(selectName).value;
    if(s != "abs")
    
    write2(s);

    if(s == "abs"){
        changeOnSelectAbs();
                }
       if(selectName=="medSelect") reset(selectName);

                
    }
    function recupModif3(selectName){
        /** pour le suivi 
         */
        var s = document.getElementById(selectName).value;
        if(s != "abs")
        
        write3(s);
    
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
    function interdireEcriture(){
        event.returnValue = false;
    }

    function changeOnSelectAbs(){
        var str=document.getElementById("exampleFormControlTextarea1").value; 
        var towrite="abs("+p+")"
        var n=str.replace(p,"abs("+p+")");
        document.getElementById("exampleFormControlTextarea1").value=n;
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