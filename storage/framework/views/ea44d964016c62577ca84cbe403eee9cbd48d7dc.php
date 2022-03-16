<?php $__env->startSection('script_css'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('plugins/iCheck/all.css')); ?>">
     <link rel="stylesheet" href="<?php echo e(asset('plugins/toastr/toastr.css')); ?>">
     <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
      <style>  
        .isa_success {
    color: #4F8A10;
    background-color: #DFF2BF;
     padding: 0.6em;
    text-align: center;
}
        .isa_error {
    color: #D8000C;
    background-color: #FFD2D2;
    padding: 0.6em;
    text-align: center;
}
        .isa_warning {
    color: #9F6000;
    background-color: #FEEFB3;
    padding: 0.6em;
    text-align: center;
}
    .swal2-popup {
  font-size: 1.6rem !important;
}
    .sectiontitle {

      text-align: center;
    }

    .sectiontitle h2 {
      font-weight: bold;
      font-size: 20px;
      color: #000000;
      margin-bottom: 0px;
      padding-right: 10px;
      padding-left: 10px;
    }
    .headerLine {
      width: 100%;
      height: 2px;
      display: inline-block;
      background: #101F2E;
    }    


.form-lol {
  background: #288CF0;
  background: #FFF;
  border: 2px solid #545454;
  padding: 10px;
  margin-bottom: 10px;
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


.ligne_verticale
{
    width:5px;
    border-left:3px solid;
    height:120px;
}
 .ho {
      background: lightblue;
      padding: 0.4em;
    }


div.ui {
  height: 60px;
  width: 250px;
  
}

div.ui {
  background-color: #444;
  background-image: -moz-linear-gradient(top, #444, #444);
  position: relative;
  color: #ccc;
  padding: 10px;
  border-radius: 3px;
  box-shadow: 0px 0px 20px #999;
  margin: 10px;
  min-height: 50px;
  border: 1px solid #333;
  text-shadow: 0 0 1px #000;
  
  /*box-shadow: 0 1px 0 rgba(255, 255, 255, 0.2) inset;*/
}

.ui::before {
  content: "";
  width: 0px;
  height: 0px;
  border: 0.8em solid transparent;
  position: absolute;
}


.ui.right::before {
  left: -20px;
  top: 30%;
  border-right: 10px solid #444;
}



.ui.top-right::before {
  right: 7px;
  bottom: -30px;
  border-top: 10px solid #444;
}
    </style>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
 
    <div class="content-wrapper">
      <div class="row">
                    <div class="col-sm-12 ">

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <form action="<?php echo e(route('edit')); ?>" method="POST" id="formAddPrescription">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="etat" id="etat" value="">
            <input type="hidden" name="id" value="<?php echo e($sequence->id); ?>">
            <input type="hidden" name="etatt" id="etatt" value="0">
            <input type="hidden" name="nature" id="nature" value="<?php echo e($sequence->nature); ?>">

            <?php if($sequence->etat =='prevue'): ?>
              <input type="submit"  id="saav" class="btn btn btn-primary"  value="Valider la prescription">
            <?php endif; ?>
            <?php if($sequence->etat =='prescrite'): ?>
              <input type="submit"  id="okChimio" class="btn btn btn-primary" value="Ok Chimio">
            <?php endif; ?>
            <?php if($sequence->etat =='demande' || $sequence->etat =='Dispenser'): ?>
              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ChimioPolicy.okChimio')): ?>
                <input type="submit"  id="AnnOkChimio" class="btn btn-default" value="Annuler le ok chimio">
              <?php endif; ?>

              <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('ChimioPolicy.verif_medic')): ?>
                <input type="button"  hidden id="encourss" onclick="encours(<?php echo e($sequence->id); ?>)"class="btn btn-primary" value="Valider la prescription">
                <input type="button"  hidden id="Dispenser" onclick="disp(<?php echo e($sequence->id); ?>)" class="btn btn-default" value="Dispenser">
            
              <?php endif; ?>
            <?php endif; ?>
            <?php if($sequence->etat =='prescrite' || $sequence->etat =='demande' || $sequence->etat =='Dispenser'): ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptionChimio.update', Auth::user())): ?>
              <input type="submit"  id="AnnValide" class="btn btn-default" value="Annuler la validation">
            <?php endif; ?>
            <?php endif; ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptionChimio.delete', Auth::user())): ?>
              <button type="button" class="btn  btn-default" id="suppp" onclick="deletePrescription(<?php echo e($sequence->id); ?>)">Supprimer la prescription</button>
            <?php endif; ?>
           <?php if($sequence->etat != 'Arreter'): ?>
            <button type="button" class="btn btn-default" id="arreter" onclick="arreterSequence(<?php echo e($sequence->id); ?>)">Arrêter la prescription</button> 
          <?php else: ?>
            <button type="button" class="btn btn-default " onclick="afficheCommArreterSeq('<?php echo e(DB::table('users')->where('id',$sequence->id_user_arrete)->pluck('name')->first()); ?>', '<?php echo e($sequence->comm_arrete); ?>','<?php echo e($sequence->date_arrete); ?>')">Raison d'arrêter la prescription </button> 
          <?php endif; ?>
           <button type="button" class="btn  btn-default" id="">Imprimer</button>
           <button type="button" class="btn  btn-secondary" onclick="javascript:history.back();">Retour</button>
           <div class="clearfix" style="float: right; width: 23%">
                <div class="breadcrumb" >
                     <b><img src="<?php echo e(asset('/images/741.png')); ?>" style="width: 5%"> Fiche Traitement signé par <?php echo e(DB::table('users')->where('id',$traitement->medecin_id)->pluck('name')->first()); ?></b>                   
                 </div>           
              </div>
          <div class="box box-solid">
            <div class="box-header">
              <?php if($sequence->etat =='prevue'): ?>
                  <div class="isa_error">
                     <i class="fa fa-times-circle"></i>
                  <strong>ATTENTION: Cette precription n'est pas validée.</strong>
                  </div> 
              <?php endif; ?> 
              <?php if($sequence->etat == 'prescrite' || $sequence->etat =='demande' || $sequence->etat =='Dispenser' || $sequence->etat =='en cours de prep' ): ?>
                <div class="isa_success">
                     <i class="fa fa-check"></i>
                     <strong>VALIDATION MEDECIN: le <?php echo e(DB::table('prescriptions_chimio')->where('sequence_id',$sequence->id)->pluck('med_validate_at')->first()); ?> par Dr <?php echo e(DB::table('users')->where('id',DB::table('prescriptions_chimio')->where('sequence_id',$sequence-> id)->pluck('medecin_id')->first())->pluck('name')->first()); ?></strong><br>
                </div>
                 <?php if($sequence->etat == 'Dispenser'): ?>
                 <div class="isa_warning">
                     <i class="fa fa-warning"></i>
                     <strong>VALIDATION PHARMACIEN: le <?php echo e(DB::table('prescriptions_chimio')->where('sequence_id',$sequence->id)->pluck('phar_validate_at')->first()); ?> par Dr <?php echo e(DB::table('users')->where('id',DB::table('prescriptions_chimio')->where('sequence_id',$sequence->id)->pluck('pharmacien_id')->first())->pluck('name')->first()); ?></strong>
                   </div>
                   <?php endif; ?>
                   <?php if($sequence->etat == 'en cours de prep'): ?>
                 <div class="isa_success">
                     <i class="fa fa-check"></i>
                     <strong>VALIDATION PHARMACIEN: le <?php echo e(DB::table('prescriptions_chimio')->where('sequence_id',$sequence->id)->pluck('phar_validate_at')->first()); ?> par Dr <?php echo e(DB::table('users')->where('id',DB::table('prescriptions_chimio')->where('sequence_id',$sequence->id)->pluck('pharmacien_id')->first())->pluck('name')->first()); ?></strong>
                   </div>
                   <?php endif; ?>
                <?php elseif($sequence->etat == 'Arreter'): ?>
                <div class="isa_warning">
                     <i class="fa fa-warning"></i>
                     <strong>PRESCRIPTION ARRETER PAR DR: <?php echo e(DB::table('users')->where('id',$sequence->id_user_arrete)->pluck('name')->first()); ?> ,LE :<?php echo e($sequence->date_arrete); ?><br>
                         <?php echo e($sequence->comm_arrete); ?>  </strong>
                </div>

              <?php endif; ?>    
              <div class="lol">
                <div class="form-lol front">
                    <div class="col-sm-4">
                    <div class="sectiontitle">
                      <h2><?php echo e(strtoupper($patient->nom)); ?> <?php echo e($patient->prenom); ?>, né le <?php echo e($patient->date_naissance); ?></h2>
                      <h4><?php
                   if($patient->sexe =='M') echo "Homme"; else echo "Femme";?>  
                 <?php echo e($patient->age($patient->date_naissance)); ?> </h4>
                      <h5>N° D'identification: <strong> <?php echo e($patient->id); ?>  </strong>,
                      N°de Dossier: <strong> <?php echo e($patient->num_dossier); ?>  </strong></h5>
                    </div>
                    </div>
                    <div class="col-sm-1 ligne_verticale">
                    </div>
                    <div class="col-sm-4">                    
                      <table border="0"> 
                        <tr><td style="padding-top : 4px;padding-bottom : 4px;">Protocole:</td><td><strong> <a class="ho" href="<?php echo e(route('detailProtocole',$sequence->protocole_id)); ?>"><?php echo e(DB::table('protocole')->where('id',$sequence->protocole_id)->pluck('nom')->first()); ?></a></strong></td></tr>
                        <tr><td style="padding-top : 4px;padding-bottom : 4px;">Nature: </td><td><strong><?php echo e($sequence->nature); ?></strong></td></tr>
                        <tr><td style="padding-top : 4px;padding-bottom : 4px;">Maladie:</td><td><strong> <?php echo e(DB::table('pathologies')->where('id',$traitement->pathologies_id)->pluck('pathologie')->first()); ?></strong></td></tr>
                        <tr ><td style="padding-top : 4px;padding-bottom : 0px;">Localisation: </td><td><strong> <?php echo e($traitement->localisation); ?></strong> &nbsp; ,Stade:&nbsp;  <strong><?php echo e($traitement->stade); ?></strong></td></tr>
                       </table><br>
                    </div>
                <div class="col-sm-1 ligne_verticale"></div>
                    <div class="col-sm-3">
                      <table border="0">
                        <tr><td style="padding-top : 4px;padding-bottom : 4px;">Inclution le : </td><td><strong> <?php echo e($traitement->date_debut_traitement); ?></strong></td></tr>
                        <tr><td style="padding-top : 4px;padding-bottom : 4px;">Data début cure: </td><td><strong> <?php echo e($cure->date_debut_cure); ?></strong></td></tr>
                        <tr><td style="padding-top : 4px;padding-bottom : 4px;">Nbr Cure prevu: </td><td><strong> <?php echo e($traitement->nombre_cure_prevu); ?></strong></td></tr>
                        </table>
                      <p style="padding-top : 4px;padding-bottom : 0px;">Cure N°:<strong> <?php echo e($cure->numero); ?> </strong>, Jour N°:<strong> <?php echo e($sequence->jour); ?></strong></p>
                      </div>
                      <span class="headerLine"></span>
                       <div class="col-sm-12" ><br>
                          <div class="col-sm-2">
                            <label class="col-sm-12 control-label">Date Prescription</label>
                               <input type="date" name="datePresc" id="datePresc" class="form form-control"  placeholder="" style="text-align: center" value="<?php echo e($sequence->date_debut); ?>" required onchange="alertDateChange()"><br>
                               <input type="hidden" id="datePreschidden" name="datePreschidden" value="<?php echo e($sequence->date_debut); ?>">
                           </div>
                           <div class="col-sm-2">
                            <label class="col-sm-2 control-label">Taille(cm)</label>
                               <input type="number" name="taille" id="taillee" class="form form-control"  placeholder="Taille" style="text-align: center" value="<?php echo e($sequence->taille); ?>" required onchange="calculeSC()"><br>
                           </div>
                             <div class="col-sm-2">
                             <label class="col-sm-2 control-label">Poids(kg)</label>
                                 <input type="number" step="0.01" name="poids" id="poidss" class="form form-control"  placeholder="Poids" style="text-align: center"  value="<?php echo e($sequence->poids); ?>" required onchange="calculeSC()" ><br>
                             </div>
                             <div class="col-sm-3">
                             <label class="col-sm-8 control-label">Surf. corporelle(m²)</label>
                                 <input type="number" step="0.01" id="surff" required class="form form-control"  placeholder="Surf (m²)" style="text-align: center" disabled value="<?php echo e($sequence->masse); ?>" >
                                  <input type="hidden" step="0.01" name="surf" id="surfff" required value="<?php echo e($sequence->masse); ?>" >
                             </div> 
                                  <input type="hidden" name="confirmer" id="confirmer" value="0">
                                          <?php if($sequence->etat == 'prevue'): ?>
                                            <div class="ui right col-sm-5" id="confirmed"><strong>Taille et poids son pas a jour<br>
                                              Confirmer les informarions <a style="cursor: pointer;" onclick="confimerDonnee()">ici</a></strong>
                                            </div>
                                          <?php else: ?>
                                            <div class="ui right col-sm-5" id="confirmed"><h5><strong> Taille et poids son a jour</strong></h5>
                                            </div>
                                            <script type="text/javascript">
                                              document.getElementById("confirmer").value = 1;
                                            </script>
                                          <?php endif; ?>

                                           
                           </div> <br><br><br><br><br><br>
                       </div>
                 </div>   
              <br>
              <div class="lol">
        <div class="form-lol front">
          <h3 class="form-label"><strong> Jour <?php echo e($sequence->jour); ?> (<b id="dateAffiche"><?php echo e($sequence->date_debut); ?></b>) (<?php echo e($sequence->etat); ?>)</strong></h3><br>
                      
                            <div class="table-responsive">
                              <div id="divTab">
                                <table class="table no-wrap user-table mb-0" id="tab">
                                  <thead>
                                    <tr id="firstTr">
                                      <th scope="col" class="border-0 text-uppercase font-medium" style="width: 3%;text-align: center">Etape</th>
                                      <th scope="col" class="border-0 text-uppercase font-medium" style="width: 24%">Dci et Produit</th>
                                      <th scope="col" class="border-0 text-uppercase font-medium" style="width: 13%">Voie</th>
                                      <th scope="col" class="border-0 text-uppercase font-medium" style="width: 24%">Dose prescrite </th>
                                      <th scope="col" class="border-0 text-uppercase font-medium" style="width: 6%">D.calculé</th>
                                      <th scope="col" class="border-0 text-uppercase font-medium" style="width: 8%">Réduction(%)</th>
                                      <th scope="col" class="border-0 text-uppercase font-medium" style="width: 10%">Heure admin</th>
                                      
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr id="trPrem0">
                                        <td style="text-align: center;" id="tdPrem" rowspan=" 1">
                                          <span class="text-muted">Prémidication</span><br>
                                           <a style="color:black; cursor: pointer;" id="addlignePrem">
                                                  <span class="glyphicon glyphicon-plus-sign"></span></a>
                                        </td> 
                                    </tr>
                                    
                                    <tr id="trTrait0">
                                        <td style="text-align: center" id="tdTrait" rowspan="1">
                                          <span class="text-muted">Traitement</span><br>
                                           <a  style="color:black; cursor: pointer;" id="addligneTrait">
                                                  <span class="glyphicon glyphicon-plus-sign"></span></a>
                                        </td>
                                    </tr>
                                   
                                  </tbody>
                                </table>
                         
                        </div>
        </div>

      </div>
  
      <br>
              <div class="lol">
                <div class="form-lol front">
                    <h3 class="form-label"><strong>Commentaire</strong></h3><br>
                    <div class="form-group col-sm-6">  
                      <label class="col-sm-6 control-label">Commentaire Médecin DR <?php echo e(DB::table('users')->where('id',$traitement->medecin_id)->pluck('name')->first()); ?></label> 
                                <textarea id="commentaireMed" name="commentaireMed" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos de la prescription"><?php echo e(DB::table('prescriptions_chimio')->where('sequence_id',$sequence->id)->pluck('commentaireMed')->first()); ?></textarea>
                   </div>  
                   <div class="form-group col-sm-6">  
                     <label class="col-sm-6 control-label">Commentaire pharmaceutique</label> 
                                <textarea id="commentairePharma" name="commentairePharma" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos de la prescription" ><?php echo e(DB::table('prescriptions_chimio')->where('sequence_id',$sequence->id)->pluck('commentairePha')->first()); ?></textarea>
                   </div><br><br><br><br>
       
                </div>
              </div>
              </form>
                                    <!-- modal add arrete sequence-->
<div class="modal fade" id="modal-arreterSeq">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rasion d'arreter la prescription</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">               
              <div class="col-sm-12" style="text-align: center"><b id="arreterrseq" ></b></div>  
              </div>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-primary" data-dismiss="modal">Quiter</button>
              </div> 
               
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
</div>
</div>
</div>
       </form>
         </div>
          </div>
            </section>
        </div>   
          <!-- /.box --> 
               
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>


<script src="<?php echo e(asset('plugins/sweetAlert/sweetalert.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/math.js')); ?>"></script>
<script type="text/javascript">
  //unite 
  var opt = '<option value=""></option>';
  var unites = <?php echo $unites; ?>;
  unites.forEach(function(unite) {
      opt = opt.concat('<option value="'+unite.unite+'">'+unite.unite+'</option>');
  });
  //delete prescription
  function deletePrescription(id){
   Swal.fire({
    backdrop: `
    rgba(255,0,0,0.4)
  `,
  title: 'Êtes-vous sûr?',
  text: "Vous ne pourrez pas revenir en arrière!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, supprimez-le!',
  cancelButtonText:'Annuler'

}).then((result) => {
  if (result.value) {
        $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/prescriptionDelete/"+id,
                method : "GET",              
                success: function(data){                  
                  Swal.fire({
                    title:'Supprimé!',
                    text:'La Prescription a été supprimé..',
                    type:'success',
                     onClose :function () {
                        location.href = '<?php echo e(route("patient.edit",$patient->id)); ?>';
                      }
                  }                   
                  )           
                },
                error: function(data){
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Quelque chose a mal tourné!'
                    })
                  }
              }); 
  }
})
  }

   onload =checkDate('<?php echo e($sequence->etat); ?>');

  // calcule SC
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
        calculeDose(0.0);
      }
      else{
        document.getElementById("surff").value='';
        document.getElementById("surfff").value = '';
        calculeDose(0.0);}
    }
    //check date
    function checkDate(etat){
      if (etat == 'Arreter') {
        return 0;
      }

      var date2 = new Date();
      var day = date2.getDate();
      var month = (date2.getMonth()+1);
      var year = date2.getFullYear();

      date2=day+"-"+month+"-"+year;
  
      var date= new Date(document.getElementById("datePresc").value);
      var aday = date.getDate();
      var amonth = (date.getMonth()+1);
      var ayear = date.getFullYear();

      date= aday+'-'+amonth+"-"+ayear;
     
     if(date2!=date ){
         Swal.fire(
      'Etes-vous perdu ?',
      "Cette prescription n'est pas programmé pour aujourd'hui",
      'question'
    )
         /*if('<?php echo e($sequence->etat); ?>' != 'Arreter' || '<?php echo e($sequence->etat); ?>' == 'prevue'|| '<?php echo e($sequence->etat); ?>' != 'demande') {
             document.getElementById("saav").disabled = true;
        } */

         
     } 


    }
    //alert date change
    function alertDateChange(){
      document.getElementById("dateAffiche").innerHTML = document.getElementById("datePresc").value ;
      var date = document.getElementById("datePreschidden").value;
      Swal.fire({
  title: '<strong>Date prévu le &nbsp;</strong> '+date,
  type: 'info',
  html:
    '<b>Attention :</b> ' +
    'changer la date de la prescription va décaler tous les autres prescription non validé',
  showCloseButton: false,
  showCancelButton: false,
  focusConfirm: true,
  confirmButtonText:
    '<i class="fa fa-thumbs-up"></i> Continuer!',
  confirmButtonAriaLabel: 'Thumbs up, great!',
 
})
    
    }
    //taille poids confirmer
    function confimerDonnee(){
      document.getElementById("confirmer").value = 1;
      document.getElementById("confirmed").innerHTML = "<h5><strong> Taille et poids son a jour</strong></h5>";
    }
    // tab



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
      $("tbody").on('keydown',"input[id='medicament_dci']",function(){
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
            },// END SOURCE
            minLength: 2,
          select: function( event, ui ) {
              var unit = $(this).closest('tr').find("td >select[name='unites[]']");
              if($(this).attr('name')==="prem"){
                var voie = $(this).closest('tr').find("td >select[name='voie_prem[]']");
              }
              else if($(this).attr('name')==="trait"){
                var voie = $(this).closest('tr').find("td >select[name='voie_trait[]']");
              }
              var input_sp_id = $(this).closest('tr').find("input[name='med_sp_id[]']");
          // var input_dci = $(this).closest('tr').find("input[name='medicament_dci']");
              
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
                  bg ="style = 'background-color:red; '";
                    $(this).addClass('type');
                } 
                 return $("<li></li>")
                     .data("item.autocomplete", item)//récupérer les donnée de l'autocomplete
                     //.attr( "data-value", item.id )
                     .append("<a "+bg+">" + item.label + "</a>")//ajouter à la liste de suggestions
                     .appendTo(ul); 
                 };
        
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
 
      $(unit).empty();      $(voie).empty();  
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



//calcule dose
var doseT = <?php echo e($ligne_dci_trait->count()); ?>;

function calculeDose(id,ou){
 if (ou == 1) {
  document.getElementById("dose"+id).value = (document.getElementById("posologie"+id).value);
  document.getElementById("doseH"+id).value = (document.getElementById("posologie"+id).value);
}else if (ou == 2 ) {
  var dose= (document.getElementById("surfff").value *100 ) / document.getElementById("posologieT"+id).value;
  document.getElementById("doseT"+id).value = dose.toFixed(2);
  document.getElementById("doseTH"+id).value = dose.toFixed(2);
}else{
 for (var y = 0; y < doseT; y++){
  document.getElementById("doseT"+y).value = ((document.getElementById("surfff").value *100 ) / document.getElementById("posologieT"+y).value).toFixed(2);
  document.getElementById("doseTH"+y).value = ((document.getElementById("surfff").value *100 ) / document.getElementById("posologieT"+y).value).toFixed(2);
 }
}
}
//calcul réduction
  function calculReduction(id){
    var reduction = 100 - document.getElementById("redu"+id).value;
  var dose = (document.getElementById("doseTH"+id).value * reduction) /100 ;
  document.getElementById("doseT"+id).value = dose.toFixed(2);

  }

  var tdprem= <?php echo e($ligne_dci_prem->count()); ?>;
  var tdtrait= <?php echo e($ligne_dci_trait->count()); ?>;
  var prem =0;
  var trait =0;

  //get tab
  if (testLignePrem()){
     $("#tdPrem").attr('rowspan', tdprem+1);
    <?php $__currentLoopData = $ligne_dci_prem; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $premedicament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
    $('<tr id="trPrem'+(prem+1)+'"><td class="form-inline"><i class="fa fa-times-circle" id="deleteP"'
      +'style="color:red;cursor :pointer;"></i>'
      +'<input type="hidden" name="med_sp_id_prem[]" value="<?php echo e($premedicament->SP_CODE_SQ_PK); ?>">'
      +'<input type="text" class="form-control"  placeholder="Dci et Produit" name="prem" id="medicament_dci"required style="width:90%;" autocomplete="off" value="<?php echo e($premedicament->SP_NOM); ?>" disabled></td>'

      +'<td><select class="form form-control" name="" id="voiee"  disabled required >' 
      +'<option value="<?php echo e($premedicament->pivot->voie); ?>"><?php echo e($premedicament->pivot->voie); ?></option></select></td>'
      +'<input type="hidden" name ="voie_prem[]" value="<?php echo e($premedicament->pivot->voie); ?>">'

      +'<td style="text-align:center"><div class="form-inline"><input type="number" step="0.01" class="pos form form-control" name="pos_prem[]" id="posologie'+prem+'"  required style="text-align:center;width: 28%"  value="<?php echo e($premedicament->pivot->posologie); ?>" onchange="calculeDose('+prem+','+1+')">'
      +'&nbsp;<select class="pos form form-control" name="" disabled style="width:65px">'
      +'<option value="<?php echo e($premedicament->pivot->u1); ?>"><?php echo e($premedicament->pivot->u1); ?></option></select>&nbsp;'    
      +'<select class="pos form form-control" name="" style="width:65px" disabled>'
      +'<option value="<?php echo e($premedicament->pivot->u2); ?>"><?php echo e($premedicament->pivot->u2); ?></option></select>'
      +'</div></td>'
      +'<input type="hidden" name ="u1_prem[]" value="<?php echo e($premedicament->pivot->u1); ?>">'
      +'<input type="hidden" name ="u2_prem[]" value="<?php echo e($premedicament->pivot->u2); ?>">'

      +'<td><input type="number" disabled step="0.01" class="form-control" name="" id="dose'+prem+'"  required style="width: 100%; text-align: center;">'
        +'<input type="hidden"  name="dose_prem[]" id="doseH'+prem+'"></td>'

      +'<td><input type="number" disabled step="0.01" class="form-control" name="" id="" placeholder="0.00 %"style="width: 80%; text-align: center;"></td>'

       +'<td><input type="time"  class="form-control" name="time_prem[]" id="" value="<?php echo e($premedicament->pivot->heure); ?>" style="width: 80%; text-align: center;float: left"> &nbsp;<span class="glyphicon glyphicon-chevron-right" data-toggle="modal" data-target="#modal-'+prem+'" data-backdrop="static" style="color: black; cursor: pointer; position: relative; top: 10px;" ></span>'
       +'<div class="modal fade" id="modal-'+prem+'">'
                  +'<div class="modal-dialog">'
                    +'<div class="modal-content">'
                      +'<div class="modal-header">'
                        +'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                          +'<span aria-hidden="true">&times;</span></button>'
                        +'<h4 class="modal-title">DÉTAIL</h4>'
                      +'</div>    '       
                      +'<div class="modal-body">'
                        +'<div class="box-body">'
                          +'<div class="col-sm-12">'
                          +'<label class="col-sm-12 control-label">Solvant</label>'
                               +'<textarea name="solvant_prem[]" id="" class="col-xs-12 col-md-12"><?php echo e($premedicament->pivot->solvant); ?></textarea> <br><br>'
                               +'<br><br><label class="col-sm-12 control-label">Commentaire</label>'
                               +'<textarea name="commentairedci_prem[]" id="" class="col-xs-12 col-md-12"><?php echo e($premedicament->pivot->remarque); ?></textarea>'
                          +'</div>'
                      +'</div>'
                      +'</div>'
                      +'<div class="modal-footer">'
                         +'<input type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">'
                      +'</div>   '   
                    +'</div>'
                  +'</div>'
                +'</div> </td>'
  
                            ).insertAfter($("#trPrem"+prem));
    calculeDose(prem,1);
     prem++;
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  }
  if (testLigneTrait()) {

     $("#tdTrait").attr('rowspan', tdtrait+1);
      <?php $__currentLoopData = $ligne_dci_trait; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $traitement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
      $('<tr id="trTrait'+(trait+1)+'"><td class="form-inline"><i class="fa fa-times-circle" id="delete"'
      +'style="color:red;cursor :pointer;"></i>'
       +'<input type="hidden" name="med_sp_id_trait[]" value="<?php echo e($traitement->SP_CODE_SQ_PK); ?>">'
       +'<input type="text" class="form-control"  placeholder="Dci et Produit" name="trait" id="medicament_dci"required style="width:90%;" autocomplete="off" value="<?php echo e($traitement->SP_NOM); ?>" disabled></td>'

      +'<td><select class="form form-control" name="" id="voiee"  required disabled>' 
      +'<option value="<?php echo e($traitement->pivot->voie); ?>"><?php echo e($traitement->pivot->voie); ?></option></select></td>'
      +'<input type="hidden" name ="voie_trait[]" value="<?php echo e($traitement->pivot->voie); ?>">'

      +'<td style="text-align:center"><div class="form-inline"><input type="number" step="0.01" class="pos form form-control" name="pos_trait[]" id="posologieT'+trait+'"  required style="text-align:center; width: 28%" value="<?php echo e($traitement->pivot->posologie); ?>" onchange="calculeDose('+trait+','+2+')">'
      +'&nbsp;<select class="pos form form-control" name="" style="width:65px" disabled>'
      +'<option value="<?php echo e($traitement->pivot->u1); ?>"><?php echo e($traitement->pivot->u1); ?></option></select>&nbsp;'
      +'<select class="pos form form-control" name="" style="width:65px" disabled>'
      +'<option value="<?php echo e($traitement->pivot->u1); ?>"><?php echo e($traitement->pivot->u2); ?></option></select>&nbsp;'
      +'<select class="pos form form-control" name="" style="width:50px" disabled>'
      +'<option value="<?php echo e($traitement->pivot->u3); ?>"><?php echo e($traitement->pivot->u3); ?></option></select>'
      +'</div></td>'
      +'<input type="hidden" name ="u1_trait[]" value="<?php echo e($traitement->pivot->u1); ?>">'
      +'<input type="hidden" name ="u2_trait[]" value="<?php echo e($traitement->pivot->u2); ?>">'
      +'<input type="hidden" name ="u3_trait[]" value="<?php echo e($traitement->pivot->u3); ?>">'

      +'<td><input type="number" step="0.01" class="form-control" name="" id="doseT'+trait+'" required style="width: 100%; text-align: center;"disabled>'
        +'<input type="hidden"  name="dose_trait[]" id="doseTH'+trait+'"></td>'

      +'<td><input type="number" step="0.01" class="form-control" name="red_trait[]"  onchange="calculReduction('+trait+')" id="redu'+trait+'" value="<?php echo e($traitement->pivot->reduction); ?>" placeholder="0.00 %"style="width: 80%; text-align: center;"></td>'

       +'<td><input type="time"  value="<?php echo e($traitement->pivot->heure); ?>" class="form-control" name="time_trait[]" id="" style="width: 80%; text-align: center;float: left">&nbsp;<span class="glyphicon glyphicon-chevron-right" data-toggle="modal" data-target="#modal-'+(trait+100)+'" data-backdrop="static" style="color: black; cursor: pointer; position: relative; top: 10px;" ></span>'
         +'<div class="modal fade" id="modal-'+(trait+100)+'">'
                  +'<div class="modal-dialog">'
                    +'<div class="modal-content">'
                      +'<div class="modal-header">'
                        +'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                          +'<span aria-hidden="true">&times;</span></button>'
                        +'<h4 class="modal-title">DÉTAIL</h4>'
                      +'</div>    '       
                      +'<div class="modal-body">'
                        +'<div class="box-body">'
                          +'<div class="col-sm-12">'
                          +'<label class="col-sm-12 control-label">Solvant</label>'
                               +'<textarea name="solvant_trait[]" id="" class="col-xs-12 col-md-12"><?php echo e($traitement->pivot->solvant); ?></textarea> <br><br>'
                               +'<br><br><label class="col-sm-12 control-label">Commentaire</label>'
                               +'<textarea name="commentairedci_trait[]" id="" class="col-xs-12 col-md-12"><?php echo e($traitement->pivot->remarque); ?></textarea>'
                          +'</div>'
                      +'</div>'
                      +'</div>'
                      +'<div class="modal-footer">'
                         +'<input type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">'
                      +'</div>   '   
                    +'</div>'
                  +'</div>'
                +'</div> </td>'
                            ).insertAfter($("#trTrait"+trait));
      calculeDose(trait,2);
      trait++;

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    }

    $('#tab').on('click','#addlignePrem',function(){
      //modif nature
      document.getElementById("nature").value = 'Modifie';

      /*if (tdprem == 0) {
        $("#tdTrait").attr('rowspan', 2);
         $(this).closest('tr').remove();
          $(this).closest('tr').hide();
      }*/
        tdprem++;
        $("#tdPrem").attr('rowspan', tdprem+1);
         $('<tr id="trPrem'+(prem+1)+'"><td class="form-inline"><i class="fa fa-times-circle" id="deleteP"'
      +'style="color:red;cursor :pointer;"></i>'
       +'<input type="hidden" name="med_sp_id_prem[]">'
       +'<input type="text" class="form-control"  placeholder="Dci et Produit" name="prem" id="medicament_dci" required style="width:90%;" autocomplete="off"></td>'

      +'<td><select class="form form-control" name="voie_prem[]" id="voiee"  required >'

      +'<td style="text-align:center"><div class="form-inline"><input type="number" step="0.01" class="pos form form-control" name="pos_prem[]" id="posologie'+prem+'" required style="width: 28%;text-align:center" onchange="calculeDose('+prem+','+1+')">'
      +'&nbsp;<select style="width:65px;"class=" form-control" name="u1_prem[]" >'+opt+'</select>&nbsp;'
      +'<select class="pos form form-control" name="u2_prem[]" style="width:65px;">'+opt+'</select>'
      +'</div></td>'

      +'<td><input type="number" disabled step="0.01" class="form-control" name="" id="dose'+prem+'"  required style="width: 100%; text-align: center;">'
      +'<input type="hidden"  name="dose_prem[]" id="doseH'+prem+'"></td>'

      +'<td><input type="number" disabled step="0.01" class="form-control" name="" id="" placeholder="0.00 %"style="width: 80%; text-align: center;"></td>'

       +'<td><input type="time"  required class="form-control" name="time_prem[]" id="" style="width: 80%; text-align: center;float: left">&nbsp;<span class="glyphicon glyphicon-chevron-right" data-toggle="modal" data-target="#modal-'+prem+'" data-backdrop="static" style="color: black; cursor: pointer; position: relative; top: 10px;"></span>'
     
        +'<div class="modal fade" id="modal-'+prem+'">'
                  +'<div class="modal-dialog">'
                    +'<div class="modal-content">'
                      +'<div class="modal-header">'
                        +'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                          +'<span aria-hidden="true">&times;</span></button>'
                        +'<h4 class="modal-title">DÉTAIL</h4>'
                      +'</div>    '       
                      +'<div class="modal-body">'
                        +'<div class="box-body">'
                          +'<div class="col-sm-12">'
                          +'<label class="col-sm-12 control-label">Solvant</label>'
                               +'<textarea name="solvant_prem[]" id="" class="col-xs-12 col-md-12"></textarea> <br><br>'
                               +'<br><br><label class="col-sm-12 control-label">Commentaire</label>'
                               +'<textarea name="commentairedci_prem[]" id="" class="col-xs-12 col-md-12"></textarea>'
                          +'</div>'
                      +'</div>'
                      +'</div>'
                      +'<div class="modal-footer">'
                         +'<input type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">'
                      +'</div>   '   
                    +'</div>'
                  +'</div>'
                +'</div> </td>'
                            ).insertAfter($("#trPrem"+prem));
          calculeDose(prem,1);

     prem++;
    });

    $('#tab').on('click','#addligneTrait',function(){
      //modif nature
      document.getElementById("nature").value = 'Modifie';
       tdtrait++;
        $("#tdTrait").attr('rowspan', tdtrait+1);
         $('<tr id="trTrait'+(trait+1)+'"><td class="form-inline"><i class="fa fa-times-circle" id="delete"'
      +'style="color:red;cursor :pointer;"></i>'
      +'<input type="hidden" name="med_sp_id_trait[]">'
      +'<input type="text" class="form-control"  placeholder="Dci et Produit" name="trait" id="medicament_dci" required style="width:90%;" autocomplete="off"></td>'
      +'<td><select class="form form-control" name="voie_trait[]" id="voiee"  required >'

      +'<td style="text-align:center"><div class="form-inline"><input type="number" step="0.01" class="pos form form-control" name="pos_trait[]" id="posologieT'+trait+'"  required style="text-align:center; width: 28%" onchange="calculeDose('+trait+','+2+')">'
      +'&nbsp;<select class="pos form form-control" name="u1_trait[]" style="width:65px">'+opt+'</select>&nbsp;'
      +'<select class="pos form form-control" name="u2_trait[]" style="width:65px">'+opt+'</select>&nbsp;'
      +'<select class="pos form form-control" name="u3_trait[]" style="width:50px">'+opt+'</select>'
      +'</div></td>'

      +'<td><input type="number" step="0.01" class="form-control" name="" id="doseT'+trait+'" required style="width: 100%; text-align: center;"disabled>'
      +'<input type="hidden"  name="dose_trait[]" id="doseTH'+trait+'"></td>'

      +'<td><input type="number" step="0.01" class="form-control" name="red_trait[]" onchange="calculReduction('+trait+')" id="redu'+trait+'"  placeholder="0.00 %" value="0"style="width: 80%; text-align: center;"></td>'
       +'<td><input type="time"  class="form-control" name="time_trait[]" id="" style="width: 80%; text-align: center;float: left">&nbsp;<span class="glyphicon glyphicon-chevron-right" data-toggle="modal" data-target="#modal-'+(trait+100)+'" data-backdrop="static" style="color: black; cursor: pointer; position: relative; top: 10px;"></span>'
       +'<div class="modal fade" id="modal-'+(trait+100)+'">'
                  +'<div class="modal-dialog">'
                    +'<div class="modal-content">'
                      +'<div class="modal-header">'
                        +'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
                          +'<span aria-hidden="true">&times;</span></button>'
                        +'<h4 class="modal-title">DÉTAIL</h4>'
                      +'</div>    '       
                      +'<div class="modal-body">'
                        +'<div class="box-body">'
                          +'<div class="col-sm-12">'
                          +'<label class="col-sm-12 control-label">Solvant</label>'
                               +'<textarea name="solvant_trait[]" id="" class="col-xs-12 col-md-12"></textarea> <br><br>'
                               +'<br><br><label class="col-sm-12 control-label">Commentaire</label>'
                               +'<textarea name="commentairedci_trait[]" id="" class="col-xs-12 col-md-12"></textarea>'
                          +'</div>'
                      +'</div>'
                      +'</div>'
                      +'<div class="modal-footer">'
                         +'<input type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">'
                      +'</div>   '   
                    +'</div>'
                  +'</div>'
                +'</div> </td>'
                            ).insertAfter($("#trTrait"+trait));
         calculeDose(trait,2);
          doseT++;
      trait++;
    });
  
 

//tester si il reste une ligne a afficher 
function testLignePrem(){
  if (tdprem == 0) {
    $("#tdPrem").attr('rowspan', 2);
     $('<tr id="trPrem'+(1)+'"><td colspan="6"> <div class="isa_warning d"><i class="fa fa-warning"></i> <b>ATTENTION: Aucune ligne prémidicament touvé</b> </div> </td>' ).insertAfter($("#trPrem"+0));
    return 0 ;
  }
  return 1;
}
function testLigneTrait(){
   if (tdtrait == 0) {
    $("#tdTrait").attr('rowspan', 2);
     $('<tr id="trTrait'+(1)+'"><td colspan="6"> <div class="isa_warning d"><i class="fa fa-warning"></i> <b>ATTENTION: Aucun traitement touvé</b> </div> </td>' ).insertAfter($("#trTrait"+0));
    return 0 ;
  }
  return 1;
}

    
      //function to delete row
    $('#tab').on('click','#delete',function(){
         Swal.fire({
      title: 'Êtes-vous sûr?',
  text: "Vous ne pourrez pas revenir en arrière!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, supprimez-le!',
  cancelButtonText:'Annuler'
    }).then((result) => {
      if (result.value) {
            document.getElementById("nature").value = 'Modifie';
            tdtrait--;
            $("#tdTrait").attr('rowspan', tdtrait+1);
            $(this).closest('tr').find('input,select').remove();
            $(this).closest('tr').hide();
            testLigneTrait();
      }
    })
            
        });

        //function to delete row
    $('#tab').on('click','#deleteP',function(){
      Swal.fire({
        title: 'Êtes-vous sûr?',
     text: "Vous ne pourrez pas revenir en arrière!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Oui, supprimez-le!',
      cancelButtonText:'Annuler'
    }).then((result) => {
      if (result.value) {
            document.getElementById("nature").value = 'Modifie';
            tdprem--;
            $("#tdPrem").attr('rowspan', tdprem+1);
            $(this).closest('tr').find('input,select').remove();
            $(this).closest('tr').hide();
            testLignePrem();
      }
    })
            
        });

      //valider
     $("#saav").click(function () {
          event.preventDefault();
          $this = $("#formAddPrescription");
          Swal.fire({
          title: 'Question 1',
          text: "Voulez-vous validé la prescription ?",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonText: 'Non',
          confirmButtonText: 'Oui'
        }).then((result) => {
          if (result.value) {
            Swal.fire({
                title: 'Question 2',
                text: "Voulez-vous demandé les produits ( OK CHIMIO ) ?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonText: 'Non',
                confirmButtonText: 'Oui'
              }).then((result) => {
                if (result.value) {
                  document.getElementById("etat").value = 'demande';   
                }else{
                  document.getElementById("etat").value = 'prescrite';
                }

               $.ajax({
                  url: $this.attr('action'),
                  method: $this.attr('method'),
                  data: $this.serialize(),
                  datatype :'json' ,
                  success : function (data) {
                   if (data =='confirmer') {
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Veillez confirmer la taille , le poids du patient !'
                     
                    })
                   }else if (data == 'rien') {
                      Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Aucune ligne traitement ou prescription trouvé veillez les renseigner ou sipprimer la prescription !'
                    })

                   }else{

                    Swal.fire({
                      position: 'top-end',
                      type: 'success',
                      title: 'Votre travail a été enregistré',
                      showConfirmButton: false,
                      timer: 1500
                    })
                   window.setTimeout(function(){location.reload(true)},1600);
                   }
                          
                    },
                    error : function (error) {
                          Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Quelque chose a mal tourné!'
                        })
                    }
            });
              })
          }
        })


    });
     //ok chimio
     $("#okChimio").click(function () {
          event.preventDefault();
          $this = $("#formAddPrescription");
          Swal.fire({
          title: 'Confirmation',
          text: "Voulez-vous demandé les produits ( OK CHIMIO ) ?",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonText: 'Non',
          confirmButtonText: 'Oui'
        }).then((result) => {
          if (result.value) {
            document.getElementById("etat").value = 'demande';
            document.getElementById("etatt").value = 1;
            $.ajax({
                  url: $this.attr('action'),
                  method: $this.attr('method'),
                  data: $this.serialize(),
                  datatype :'json' ,
                  success : function (data) {
                   if (data =='confirmer') {
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Veillez confirmer la taille , le poids du patient !'
                     
                    })
                   }else if (data == 'rien') {
                      Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Aucune ligne traitement ou prescription trouvé veillez les renseigner ou sipprimer la prescription !'
                    })

                   }else{

                    Swal.fire({
                      position: 'top-end',
                      type: 'success',
                      title: 'Votre travail a été enregistré',
                      showConfirmButton: false,
                      timer: 1500
                    })
                   window.setTimeout(function(){location.reload(true)},1600);
                   }
                          
                    },
                    error : function (error) {
                          Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                        })
                    }
            });   
            
          }
        })


    });
     //AnnOkChimio
      $("#AnnOkChimio").click(function () {
          event.preventDefault();
          $this = $("#formAddPrescription");
          Swal.fire({
          title: 'Confirmation!',
          text: "Voulez-vous Annuler la demande des produits ( OK CHIMIO ) ?",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonText: 'Non',
          confirmButtonText: 'Oui'
        }).then((result) => {
          if (result.value) {
            document.getElementById("etat").value = 'prescrite';
            document.getElementById("etatt").value = 1;
            $.ajax({
                  url: $this.attr('action'),
                  method: $this.attr('method'),
                  data: $this.serialize(),
                  datatype :'json' ,
                  success : function (data) {
                   if (data =='confirmer') {
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Veillez confirmer la taille , le poids du patient !'
                     
                    })
                   }else if (data == 'rien') {
                      Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Aucune ligne traitement ou prescription trouvé veillez les renseigner ou sipprimer la prescription !'
                    })

                   }else{

                    Swal.fire({
                      position: 'top-end',
                      type: 'success',
                      title: 'Votre travail a été enregistré',
                      showConfirmButton: false,
                      timer: 1500
                    })
                   window.setTimeout(function(){location.reload(true)},1600);
                   }
                          
                    },
                    error : function (error) {
                          Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                        })
                    }
            });   
            
          }
        })


    });
      //AnnValide
    $("#AnnValide").click(function () {
          event.preventDefault();
          $this = $("#formAddPrescription");
          Swal.fire({
          title: 'Confirmation!',
          text: "Voulez-vous Annuler la validation de la prescription ?",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonText: 'Non',
          confirmButtonText: 'Oui'
        }).then((result) => {
          if (result.value) {
            document.getElementById("etat").value = 'prevue';
            document.getElementById("etatt").value = 1;
            $.ajax({
                  url: $this.attr('action'),
                  method: $this.attr('method'),
                  data: $this.serialize(),
                  datatype :'json' ,
                  success : function (data) {
                   if (data =='confirmer') {
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Veillez confirmer la taille , le poids du patient !'
                     
                    })
                   }else if (data == 'rien') {
                      Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Aucune ligne traitement ou prescription trouvé veillez les renseigner ou sipprimer la prescription !'
                    })

                   }else{

                    Swal.fire({
                      position: 'top-end',
                      type: 'success',
                      title: 'Votre travail a été enregistré',
                      showConfirmButton: false,
                      timer: 1500
                    })
                   window.setTimeout(function(){location.reload(true)},1600);
                   }
                          
                    },
                    error : function (error) {
                          Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                        })
                    }
            });   
            
          }
        })


    });
      //arreter sequence
  function arreterSequence(id){

Swal.fire({
title: 'Pourquoi voulez vous arrêter la prescription ?',
input: 'textarea',
inputPlaceholder: 'Tapez votre commentaire ici...',
cancelButtonText:'Annuler',
confirmButtonText: 'Arrêter',
showCancelButton: true
}).then((result) => {
if (result.value) {
    $.ajax({
             // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              url: "/chimio/sequence/arrete/"+id,
              method : "GET", 
              data : {
                id: id,
                text :result.value
              },            
              success: function(){                  
                Swal.fire({
                  title:'Arrêter!',
                  text:'La Prescription a été Arrêter...',
                  type:'success',
                  onClose :function () {
                      window.location.reload();
                    }
                }                   
                )           
              },
              error: function(data){
                  Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Quelque chose a mal tourné!'
                  })
                }
            });   
}

})

}
 function afficheCommArreterSeq(nom , comm, date){
    var myModal = $('#modal-arreterSeq');
    document.getElementById("arreterrseq").innerHTML = 'Prescription arrêter par: '+nom+' le: '+date+'<br>'+comm;
    myModal.modal({ show: true });
  }

      //Dispenser
      function disp(id) {
          Swal.fire({
          title: 'Confirmation!',
          text: "Voulez-vous  ?",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonText: 'Non',
          confirmButtonText: 'Oui'
        }).then((result) => {
          if (result.value) {
            var comm = document.getElementById("commentairePharma").value;
            $.ajax({
                  url: "/dispenser/",
                  method : "get",
                  data: { 
                      id: id,
                      commm: comm                   
                  },     
                  success : function (data) {
                    Swal.fire({
                      position: 'top-end',
                      type: 'success',
                      title: 'Votre travail a été enregistré',
                      showConfirmButton: false,
                      timer: 1500
                    })
                   window.setTimeout(function(){location.reload(true)},1600);
                   
                          
                    },
                    error : function (error) {
                          Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                        })
                    }
            });   
            
          }
        })


    }
    
    //encours
      function encours(id) {
          Swal.fire({
          title: 'Confirmation!',
          text: "Voulez-vous valider la prescription ?",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonText: 'Non',
          confirmButtonText: 'Oui'
        }).then((result) => {
          if (result.value) {
            var comm = document.getElementById("commentairePharma").value;
            $.ajax({
                  url: "/encours/",
                  method : "get",
                  data: { 
                      id: id,
                      commm: comm                   
                  },     
                  success : function (data) {
                    Swal.fire({
                      position: 'top-end',
                      type: 'success',
                      title: 'Votre travail a été enregistré',
                      showConfirmButton: false,
                      timer: 1500
                    })
                   window.setTimeout(function(){location.reload(true)},1600);
                   
                          
                    },
                    error : function (error) {
                          Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                        })
                    }
            });   
            
          }
        })


    }
      
  
</script>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\chimio\prescription.blade.php ENDPATH**/ ?>