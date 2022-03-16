<?php $__env->startSection('script_css'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('plugins/iCheck/all.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('plugins/toastr/toastr.css')); ?>">
     <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <style>  
    .swal2-popup {
  font-size: 1.6rem !important;
}
.isa_error {
    color: #D8000C;
    background-color: #FFD2D2;
     padding: 0.9em;
    text-align: center;
}
    .sectiontitle {
      background-position: center;

      text-align: center;
      min-height: 20px;
    }

    .sectiontitle h2 {
      font-weight: bold;
      font-size: 25px;
      color: #000000;
      margin-bottom: 0px;
      padding-right: 10px;
      padding-left: 10px;
    }
    


    .headerLine {
      width: 960px;
      height: 2px;
      display: inline-block;
      background: #101F2E;
    }    


.form-lol {
  background: #288CF0;
  background: #FFF;
  border: 2px solid #545454;
  padding: 25px;
  margin-bottom: 40px;
  margin: 2rem auto;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);

  position: relative;
}

.form-label {
  position: absolute;
  top: 0;
  left: 3rem;
  background: #FFF;
  padding: 0.5rem 1rem;
  margin: 0;
  transform: translateY(-50%);
  color: #545454;
}
    </style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 <div class="row">
                    <div class="col-sm-12 ">

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="row">
                    <div class="col-sm-12 ">
                      <?php if(!empty($erreurformule)): ?>
                          <div class="isa_error" style="text-align: center; width: 80%;position: relative; left: 10%">
                         <h4><i class="fa fa-times-circle"></i> <?php echo e($erreurformule); ?></h4>
                          </div>
                          <br>
                      <?php else: ?>
          <form action="<?php echo e(route('addTraitement')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

           <input type="hidden"name="patient_id" value="<?php echo e($patient->id); ?>">
           <input type="submit" class="btn btn btn-primary" id="sauv" value="Sauvegarder">

           <a type="button" class="btn  btn-default" href="<?php echo e((route('listProtocole'))); ?>">Lister les protocoles</a>
           <a type="button" class="btn  btn-default" href="<?php echo e((route('listMaladie.index'))); ?>">Lister les maladies</a>
           <a type="button" class="btn  btn-default" href="<?php echo e(route('para')); ?>">Paramètre général</a>
           <button type="button" onclick="javascript:history.back();" class="btn  btn-secondary">Annuler</button>

          <div class="box box-solid">
            <div class="box-header">
                <div class="sectiontitle">
                  <h2><?php echo e(strtoupper($patient->nom)); ?> <?php echo e($patient->prenom); ?>, né le <?php echo e($patient->date_naissance); ?></h2>
                  <h4><?php
                   if($patient->sexe =='M') echo "Homme"; else echo "Femme";?>  
                 <?php echo e($patient->age($patient->date_naissance)); ?> </h4>
                  <h5>Numéro D'identification: <strong> <?php echo e($patient->id); ?>  </strong>,
                 Numéro du Dossier: <strong> <?php echo e($patient->num_dossier); ?>   </strong></h5>
                </div><br>
            <div class="col-sm-12">
              <div class="lol">
                <div class="form-lol front">
                    <h3 class="form-label"><strong> Information Protocole</strong></h3>
                      <div class="col-sm-12">
                        <div class="col-sm-4">
                          <label class="control-label">Maladie</label>
                          <input type="text" class="form-control"  placeholder="Nom de la Maladie" name="maladie_nom" id="maladie_nom" required>
                        </div>
                        <div class="col-sm-4">
                          <label class="control-label">Protocole</label>
                          <select class="form form-control" name="protocole" id="protocole_presc" onchange="getRemarque()"disabled required></select>
                        </div>
                        <div class="col-sm-4">
                          <label  class="control-label">Nature</label>
                          <input type="text" class="form-control" placeholder="Nature" id="nature" disabled>
                          <input type="hidden"  name="nature" id="naturee" >
                          <br>
                        </div>
                      </div>
                      <br><br><br>
                      <div id="remarque"></div>       
                </div>
              </div>
            </div>
            <br>
 <div class="col-sm-12">
    <div class="col-sm-5">
      <div class="lol">
        <div class="form-lol front">
          <h3 class="form-label"><strong> Information Cure</strong></h3>
          <div class="col-sm-12">
            <div class="col-sm-6">
              <label class="control-label">Date Traitement</label>
              <input type="text" class="form-control"  style="text-align: center" value="<?php echo e(date('Y-m-d')); ?>" disabled >
              <input type="hidden" name="dater" value="<?php echo e(date('Y-m-d')); ?>"><br>
               <label class="control-label">Cure de :</label>
              <input type="text" class="form-control" id="nbrsequence" style="text-align: center" disabled> <br>   
            </div>
            <div class="col-sm-6">      
              <label class="control-label">Nombre Cure Prévu</label>
              <input type="number" class="form-control" id="cycle" style="text-align: center"  name="prevu" required disabled> <br>  

               <label class="control-label">Date Premier Cure</label>
              <input type="date" class="form-control" name="dateCure" id="datee" required disabled> 
            </div>
             

          </div>
          <label class="control-label">Nom Prénom du Médecin</label>
              <input type="text" class="form-control" style="text-align: center" disabled value="Dr <?php echo e(strtoupper(Auth::user()->name)); ?> <?php echo e(Auth::user()->prenom); ?>" name="">
        </div>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="lol">
         <div class="form-lol front">
            <h3 class="form-label"><strong>Renseignements</strong></h3><br>
            <div class="form-group" style="text-align: center">
               <label class="col-sm-4 control-label">Localisation</label>
                <div class="col-sm-8">
                 <input type="text" class="form-control"  required placeholder="Localisation" name="localisation" id="" ><br>
                </div>
            </div>


            <div class="form-group" style="text-align: center">
               <label class="col-sm-4 control-label">Stade</label>
                <div class="col-sm-8">
              <select class="form form-control" name="stade" id="stade" disabled>
                
              </select><br>
                </div>
            </div>
           
            <div class="col-sm-4"><select class="form form-control" name="" id=""></select></div>
            <div class="col-sm-4"><select class="form form-control" name="" id=""></select></div>
            <div class="col-sm-4"><select class="form form-control" name="" id=""></select></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-8"><br>
                 <input type="text" class="form-control"  required placeholder="" name="" id="" disabled ><br>
                </div>

             <br><br><br><br><br><br><br><br><br>
              
             
          </div>
         </div>
    </div>
   <div class="col-sm-3">
      <div class="lol">
    <div class="form-lol front">
   <h3 class="form-label"><strong> Détail </strong></h3><br>
  
    <div class="form-group" style="text-align: center">
       <label class="col-sm-5 control-label">Taille(cm)</label>
       <div class="col-sm-7">
           <input type="number" name="taille" id="taillee" class="form form-control"  placeholder="Taille" style="text-align: center" value="<?php echo e($patient->taille); ?>" required onchange="calculeSC()"><br>
       </div>
     </div>
    
    <div class="form-group" style="text-align: center">
       <label class="col-sm-5 control-label">Poids(kg)</label>
       <div class="col-sm-7">
           <input type="number" step="0.01" name="poids" id="poidss" class="form form-control"  placeholder="Poids" style="text-align: center"  value="<?php echo e($patient->poids); ?>" required onchange="calculeSC()"><br>
       </div>
    </div>
    <div class="form-group" style="text-align: center">
       <label class="col-sm-5 control-label">Surf. corporelle</label>
       <div class="col-sm-7">
           <input type="number" step="0.01" id="surff" required class="form form-control"  placeholder="Surf (m²)" style="text-align: center" disabled><br>
            <input type="hidden" step="0.01" name="surf" id="surfff" required>
       </div><br>
     </div>
       <div class="form-group" >
       <label class="col-sm-9 control-label">Ajouter un Commentaire</label>
       <div >
        <input type="checkbox" name="checkfield" id="" onchange="getComm(this)"/>
       </div>
     </div>

    </div>
   
    </div>

</div>
   </div>
   <div class="col-sm-12" hidden="true" id="commm">
              <div class="lol">
                <div class="form-lol front">
                    <h3 class="form-label"><strong>Commentaire</strong></h3>
                    <div class="form-group col-sm-6">  
                      <label class="col-sm-6 control-label">Commenter la fiche du traitement</label> 
                                <textarea id="" name="commentaire" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos du Traitement" name="commm" ></textarea>
                   </div>  
                   <div class="form-group col-sm-6">  
                     <label class="col-sm-6 control-label">Commenter la premiere cure</label> 
                                <textarea id="" name="commentaireCure" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos de la premiere cure" name="commm" ></textarea>
                   </div><br><br><br><br>
       
                </div>
              </div>
    </div>

</div>




</div>
<?php endif; ?>
</div>

            


       </form></div>
          </div>
            </section>
        </div>
      </div>

            <!-- /.box-body -->
        

                
               
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

<script src="<?php echo e(asset('plugins/sweetAlert/sweetalert.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/math.js')); ?>"></script>

 <?php if($erreur): ?>
      <script type="text/javascript">
        Swal.fire({
        type: 'error',
        title: 'Oops...',
        text: '<?php echo e($erreur); ?>'
      })
        $('#sauv').attr('disabled', true);

    
      </script>
<?php endif; ?>

  <script type="text/javascript">
    //calcule SC
    onload =calculeSC();
    function calculeSC(){

      //récupérer formule
      var formule = '<?php echo e($formule); ?>';

      var taille = document.getElementById("taillee").value;
      var poids = document.getElementById("poidss").value;
      //replacer poids et taille dans la formule
      formule = formule.replace("POIDS", poids);
      formule = formule.replace("TAILLE", taille);

      if (taille!=0 && poids !=0) {
        var SC = math.eval(formule) ;
        document.getElementById("surff").value = SC.toFixed(2);
        document.getElementById("surfff").value = SC.toFixed(2);
      }
      else
        document.getElementById("surff").value='';
    }
    
    
        $('input[id="maladie_nom"]').keydown(function() { 
        $(this).autocomplete({
          appendTo: $(this).parent(), // selectionner l'element pour ajouter la liste des suggestion
          source: function( request, response ) {
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                url: "/maladie",
                method : "POST",
                data: {
                  phrase: request.term // value on field input
                },
                success: function( data , status , code ) {
                    response($.map(data.slice(0, 20), function (item) { // slice cut number of element to show
                      return {
                          label : item.pathologie, // pour afficher dans la liste des suggestions
                          value:  item.pathologie, // value c la valeur à mettre dans l'input this
                          id_pathologie:  item.id
                      };
                  }));
                }
              });
            },// END SOURCE
            select: function( event, ui ) {
              $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                url: "/protocolesPathologie",
                method : "POST",
                data: {
                  maladie_id: ui.item.id_pathologie
                },
                success: function( data , status , code ) {
                  //console.log(data);
                  if (data == 0) {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'Acun protocole trouve pour cette maladie!',
                        footer: '<a href="<?php echo e((route('listMaladie.index'))); ?>">Attacher des protocole a la maladie</a>'
                      })
                   
                  }else{
                  $('#protocole_presc').attr('disabled', false);
                  $("#protocole_presc").empty();
                 
             
                    $("#protocole_presc").append("<option>choisir un protocole</option>");
                    console.log(data);
                  data[0].forEach(function(d) {
                      $("#protocole_presc").append("<option value="+d.id+">"+d.nom+"</option>");
                  });
                   $('#stade').attr('disabled', false);
                        $("#stade").empty();
                        $("#stade").append("<option>choisir un stade</option>");

                        data[1].forEach(function(d) {
                            $("#stade").append("<option value="+d+">"+d+"</option>");
                        });
                      }
                  
                },
                error : function (error) {
                  console.log(error);
                }
              });
            $("#maladie_id").attr("value",ui.item.id_pathologie);
            }


          }).data("ui-autocomplete")._renderItem = function (ul, item) {//cette method permet de gérer l'affichage de la liste des suggestions
               

                 return $("<li></li>")
                     .data("item.autocomplete", item)//récupérer les donnée de l'autocomplete
                     //.attr( "data-value", item.id )
                     .append( item.label)//ajouter à la liste de suggestions
                     .appendTo(ul); 
                 };

      });
        //getRemarque
         function getRemarque() {
          //add nature
          document.getElementById("nature").value = 'Classique';
          document.getElementById("naturee").value = 'Classique';

          var x = document.getElementById("protocole_presc").value;
          $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                url: "/getRemarquesProtocole/"+x,
                method : "POST",
               
                success: function(data) {
                  
                  if (data.remarque == null) {
                     document.getElementById("remarque").innerHTML = "";
                  }else{
                     document.getElementById("remarque").innerHTML = "<h4><strong>Remarque:</strong></h4><p>"+data.remarque+"</p>"; 
                  }
                  document.getElementById("cycle").placeholder = "de "+data.nbrcure_min+" a "+data.nbrcure_max+" Cures";
                  //document.getElementById("nbrsequence").val = ":p" ;
                  $('#protocole_presc').attr('disabled', false);
                  $('#datee').attr('disabled', false);
                  $('#cycle').attr('disabled', false);
                  document.getElementById("nbrsequence").value=data.nbr_sequence+" j" ;
                },
                error: function(data){
                          Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Quelque chose a mal tourné!',
                          })
                        }

              });
        }
        //getComm
        function getComm(checkboxElem) {
          if (checkboxElem.checked) {
             document.getElementById("commm").hidden = false;
          } else {
            document.getElementById("commm").hidden = true;
            //document.getElementById("commm").value = "";
          }
        }
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\chimio\traitement.blade.php ENDPATH**/ ?>