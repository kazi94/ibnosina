<?php $__env->startSection('script_css'); ?>

<style type="text/css">

.isa_error {
    color: #D8000C;
    background-color: #FFD2D2;
     padding: 0.9em;
    text-align: center;
}
.swal2-popup {
  font-size: 1.6rem !important;
}
    .sectiontitle {
      background-position: center;
      margin: 30px 0 0px;
      text-align: center;
      min-height: 20px;
    }

    .sectiontitle h2 {
      font-size: 40px;
      color: #545454;
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
    .headerLine2 {
      width: 100%;
      height: 2px;
      display: inline-block;
      background: #555555;
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
     .isa_info {
    color: #00529B;
    background-color: #BDE5F8;
    padding: 0.1em;
    text-align: center;
}
</style>
<meta name="csrf_token" content="<?php echo e(csrf_token()); ?>">

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
           <div class="row">
                    <div class="col-sm-12 ">
          

     
          <!-- jQuery Knob -->
          <div class="box box-solid">

        
            <div class="box-header">
             
             
                 <div class="row">
                   <div class="col-sm-12 ">
                             <div class="box-body table-responsive no-padding">
                        <div class="lol">
                                <div class="form-lol front">
                                  <?php if($sequences->isEmpty()): ?>
                                   <div class="isa_info" style="width: 80%; text-align: center;position: relative; left: 10%">
                                     <h4><i class="fa fa-info-circle"></i> il ya rien a affiché</h4>      
                                  </div>
                                  <?php else: ?>
                                  <table id="t_protocole" class="table table-responsive text-center dataTable table table-hover" aria-describedby="t_protocole">
                                <thead>
                                    <tr class="alert alert-info">
                                        <th style="width: 10%">ETAT</th>
                                        <th style="width: 23%">PATIENT</th>
                                        <th style="width: 28%">D.C.I</th>
                                        <th style="width: 18%">VOIE</th> 
                                        <th style="width: 5%">JOUR</th>
                                        <th style="width: 50%">ADMINIST PREVU LE</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $sequences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                      <?php $__currentLoopData = $seq->medicaments()->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dci): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                     <tr onclick="getinfo(<?php echo e($dci); ?>,<?php echo e($seq); ?>,<?php echo e(DB::table('cure')->where('id',$seq->cure_id)->get()); ?>,<?php echo e(DB::table('patients')
                                              ->join('traitements', 'patients.id', '=', 'traitements.patient_id')
                                              ->join('cure', 'traitements.id', '=', 'cure.traitement_id')
                                              ->where('cure.id', $seq->cure_id)   
                                              ->get()); ?>,
                                              <?php echo e(DB::table('users')
                                              ->join('traitements', 'users.id', '=', 'traitements.medecin_id')
                                              ->join('cure', 'traitements.id', '=', 'cure.traitement_id')
                                              ->where('cure.id', $seq->cure_id)   
                                              ->get()); ?>,
                                              <?php echo e(DB::table('traitements')
                                              ->join('cure', 'traitements.id', '=', 'cure.traitement_id')
                                              ->where('cure.id', $seq->cure_id)   
                                              ->get()); ?>

                                     )" 

                                        <?php if($dci->pivot->etat == 'prepare'): ?>
                                          style=" background-color: #94FFB4; cursor: pointer;"
                                        <?php elseif($dci->pivot->etat == 'prescrite'): ?>
                                          style=" background-color: #C7C7C7; cursor: pointer;"
                                        <?php elseif($dci->pivot->etat == 'Dispenser'): ?>
                                          style=" background-color: #F19FA8; cursor: pointer;"
                                        <?php elseif($dci->pivot->etat == 'demande'): ?>
                                          style=" background-color: #C0D6E4;  cursor: pointer;"
                                        <?php elseif($dci->pivot->etat == 'en cours de prep'): ?>
                                          style=" background-color: #FAFFCD;  cursor: pointer;"
                                        <?php elseif($dci->pivot->etat == 'Arreter'): ?>
                                          style=" background-color: #f07777;  cursor: pointer;"
                                        <?php elseif($dci->pivot->etat == 'prevue'): ?>
                                          style=" background-color: #DEFFF0;  cursor: pointer;"
                                        <?php endif; ?>
                                     >
                                        <td><strong><?php echo e($dci->pivot->etat); ?></strong></td>
                                        <td> <?php
                                        $lol=DB::table('patients')
                                              ->join('traitements', 'patients.id', '=', 'traitements.patient_id')
                                              ->join('cure', 'traitements.id', '=', 'cure.traitement_id')
                                              ->where('cure.id', $seq->cure_id)
                                              ->select('patients.nom','patients.prenom')
                                              ->get();
                                                echo $lol[0]->nom.' '.$lol[0]->prenom;
                                               
                                            ?></td>
                                        <td><?php echo e(DB::table('sp_specialite')->where('SP_CODE_SQ_PK',$dci->pivot->medicament_id)->pluck('SP_NOM')->first()); ?></td>
                                        <td><?php echo e($dci->pivot->voie); ?></td>
                                        <td>C<?php echo e(DB::table('cure')->where('id',$seq->cure_id)->pluck('numero')->first()); ?> J<?php echo e($seq->jour); ?></td>
                                        <td><?php echo e($dci->pivot->date_debut); ?> &nbsp; <?php echo e($dci->pivot->heure); ?></td>
                                     </tr>
                                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                 </tbody>
                            </table>
                      <span class="headerLine"></span><br><br>
                      
                                       <div id="notif" class="isa_info" style="width: 80%; text-align: center;position: relative; left: 10%">
                                        <h4><i class="fa fa-info-circle"></i> Aucune ligne D.C.I séléctionner </h4>
                                    </div>
                                
                                  <div class="col-sm-12" style="background-color:  #C0D6E4" id="info" hidden>
                                    <br>
                                 <div class="col-sm-12">

                                  <div class="col-sm-3">
                                    <table border="0">
                                      <tr><td style="padding-top : 4px;padding-bottom : 4px;">Traitement le : </td><td><strong id="traitement"></strong></td></tr>
                                      <tr><td style="padding-top : 4px;padding-bottom : 4px;">Admini prevu : </td><td><strong id="date"></strong></td></tr>
                                    </table>
                                    <p style="padding-top : 4px;padding-bottom : 0px;">Par :<strong id="med"></strong></p>
                                 </div>
                                  <div class="col-sm-3">
                                 <table border="0">
                                      <tr><td style="padding-top : 4px;padding-bottom : 4px;">Date début cure : </td><td><strong id="debut_cure"></strong></td></tr>
                                      <tr><td style="padding-top : 4px;padding-bottom : 4px;">Nbr Cure prevu : </td><td><strong id="nbrcure"></strong></td></tr>
                                      
                                    </table>
                                    <p style="padding-top : 4px;padding-bottom : 0px;">Cure N°:<strong id="cure"> </strong>, Jour N°:<strong id="jour"></strong></p>
                               </div>
                                 <div class="col-sm-4">
                                  <p style="padding-top : 1px;padding-bottom : 0px;">Nom :<strong id="nom"></strong>, Prenom:<strong id="prenom"></strong></p>
                                  <p style="padding-top : 1px;padding-bottom : 0px;">Nais :<strong id="nais"></strong>, Age:<strong> 24 ans 0mois</strong></p>
                                  <p style="padding-top : 1px;padding-bottom : 0px;">Patient N° :<strong id="num"></strong>, Doss N°:<strong id="dossier"></strong></p>
                                  
                               </div>
                               <div class="col-sm-2">
                                   <p style="padding-top : 1px;padding-bottom : 0px;">Taille(cm):<strong id="taille"> </strong></p>
                                   <p style="padding-top : 1px;padding-bottom : 0px;">poids(kg):<strong id="poids"> </strong></p>
                               
                                    <p style="padding-top : 1px;padding-bottom : 0px;">Surf.corpo(m²):<strong id="surf"> </strong></p>
                               </div>
                             </div>
                            <div class="col-sm-12" >
                              
                              <span class="headerLine2"></span><br>
                              <div class="col-sm-6">
                              <label class="col-sm-12 control-label">Solvant</label>
                               <textarea name="" id="solvant" class="col-xs-12 col-md-12" disabled></textarea>
                               </div>
                              <div class="col-sm-6">
                                <label class="col-sm-12 control-label">Commentaire</label>
                               <textarea name="" id="commentaire" class="col-xs-12 col-md-12" disabled></textarea>
                             </div>
                          <div class="col-sm-2"><br>
                            <label class="col-sm-12 control-label">Dose prescrite</label>
                               <input type="number" step="0.01" name="" id="poso" class="form form-control"  style="text-align: center"disabled><br>
                           </div>
                           <div class="col-sm-2"><br>
                            <label class="col-sm-12 control-label">Dose calculée</label>
                               <input type="number" step="0.01" name="" id="dose" class="form form-control"  style="text-align: center" disabled=""><br>
                           </div>
                             <div class="col-sm-2"><br>
                             <label class="col-sm-12 control-label">Réduction(%):</label>
                                 <input type="number" step="0.01" name="" id="redu" class="form form-control"  style="text-align: center"  disabled ><br>
                             </div>
                             <div class="col-sm-6"><br>
                               <label class="col-sm-12 control-label"> &nbsp;</label>
                             <button type="button" class="btn btn-primary" id="preparer">Préparer</button>&nbsp;
                              <button type="button" class="btn " id="imprimer">imprimer l'étiquette</button>
                             </div> 

                                           
                           </div>
                                 
                                       
                                </div>
                                <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
                                
                                  <?php endif; ?>
                            
                              </div>
                             
                        </div>
                  
                </div>
              </div>
          

            </section>

        </div>

       
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>


<script src="<?php echo e(asset('plugins/sweetAlert/sweetalert.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/toastr/toastr.js')); ?>"></script>


<script type="text/javascript">
//get info
function getinfo(dci,seq,cure,patient,med,trait){
  //window.scroll(0,10000);
  document.getElementById('notif').hidden = true;
  document.getElementById('info').hidden = false;
  //backgroundColor
   if (Object.values(Object.values(dci)[7])[9] == 'prescrite') {
    document.getElementById('preparer').disabled = true;
    document.getElementById('imprimer').disabled = true;
    document.getElementById("info").style.backgroundColor = "#C7C7C7";
  }
  else if(Object.values(Object.values(dci)[7])[9] == 'demande'){
    document.getElementById('preparer').disabled = true;
    document.getElementById('imprimer').disabled = true;
    document.getElementById("info").style.backgroundColor = "#C0D6E4";
  }
  else if(Object.values(Object.values(dci)[7])[9] == 'prepare'){
    document.getElementById('preparer').disabled = true;
    document.getElementById('imprimer').disabled = true;
    document.getElementById("info").style.backgroundColor = "#94FFB4";
  }
  else if(Object.values(Object.values(dci)[7])[9] == 'Dispenser'){
    document.getElementById('preparer').disabled = true;
    document.getElementById('imprimer').disabled = true;
    document.getElementById("info").style.backgroundColor = "#F19FA8";
  }
   else if(Object.values(Object.values(dci)[7])[9] == 'en cours de prep'){
    document.getElementById('preparer').disabled = false;
    document.getElementById('imprimer').disabled = false;
    document.getElementById("info").style.backgroundColor = "#FAFFCD";
  }
  else if(Object.values(Object.values(dci)[7])[9] == 'Arreter'){
    document.getElementById('preparer').disabled = true;
    document.getElementById('imprimer').disabled = true;
    document.getElementById("info").style.backgroundColor = "#f07777";
  }
  else if(Object.values(Object.values(dci)[7])[9] == 'prevue'){
    document.getElementById('preparer').disabled = true;
    document.getElementById('imprimer').disabled = true;
    document.getElementById("info").style.backgroundColor = "#DEFFF0";
  }
  
  //replir donnee
  document.getElementById('nom').innerHTML = '&nbsp' +Object.values(Object.values(patient)[0])[5];
  document.getElementById('prenom').innerHTML = '&nbsp' +Object.values(Object.values(patient)[0])[6];
  document.getElementById('nais').innerHTML = '&nbsp' +Object.values(Object.values(patient)[0])[7];
  document.getElementById('num').innerHTML = '&nbsp' +Object.values(Object.values(patient)[0])[0];
  document.getElementById('dossier').innerHTML = '&nbsp' +Object.values(Object.values(patient)[0])[4];

  document.getElementById('med').innerHTML = '&nbsp Dr ' +Object.values(Object.values(med)[0])[6]+'&nbsp'+Object.values(Object.values(med)[0])[2];

  document.getElementById('nbrcure').innerHTML = '&nbsp' +Object.values(Object.values(trait)[0])[2];
  document.getElementById('traitement').innerHTML = '&nbsp' +Object.values(Object.values(trait)[0])[1];


  document.getElementById('debut_cure').innerHTML = '&nbsp' +Object.values(Object.values(cure)[0])[3];
  document.getElementById('cure').innerHTML = '&nbsp' +Object.values(Object.values(cure)[0])[1] ;
  document.getElementById('jour').innerHTML = '&nbsp' +Object.values(seq)[1] ;
  
  document.getElementById('taille').innerHTML = '&nbsp' +Object.values(seq)[3] ;
  document.getElementById('poids').innerHTML = '&nbsp' +Object.values(seq)[2] ;
  document.getElementById('surf').innerHTML = '&nbsp' +Object.values(seq)[4].toFixed(2) ;

  document.getElementById('date').innerHTML = Object.values(Object.values(dci)[7])[2] + '&nbsp;'+ Object.values(Object.values(dci)[7])[3] ;

  document.getElementById('solvant').value = Object.values(Object.values(dci)[7])[11];
  document.getElementById('commentaire').value = Object.values(Object.values(dci)[7])[4];

  document.getElementById('redu').value = Object.values(Object.values(dci)[7])[10];
  document.getElementById('dose').value = Object.values(Object.values(dci)[7])[8];
  document.getElementById('poso').value = Object.values(Object.values(dci)[7])[5];
}

  
//data table
      $(function () {
            $('#t_protocole').DataTable();
            if ($("#message").text()) {
                    toastr.options = {
                      "closeButton": false,
                      "debug": false,
                      "newestOnTop": false,
                      "progressBar": false,
                      "positionClass": "toast-bottom-center",
                      "preventDuplicates": false,
                      "onclick": null,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "3000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
                    toastr.success($("#message").text())    
            }

          })

        </script>

 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\chimio\preparation.blade.php ENDPATH**/ ?>