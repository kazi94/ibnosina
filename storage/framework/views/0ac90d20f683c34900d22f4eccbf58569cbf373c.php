


<div class="tab-pane" id="tab_123" >
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptionChimio.create')): ?>
  <a type="button" class="btn btn-primary float-left" href="<?php echo e((route('po',$patient))); ?>">Ajouter un Traitement</a>
<?php endif; ?>

   <?php if($traitement->isEmpty()): ?>
   <br><br>
                      
                         <div class="isa_info" style="width: 80%; text-align: center;position: relative; left: 10%">
                          <h4><i class="fa fa-info-circle"></i> Aucun Traitement de chimiothérapie trouvé veuillez ajouter un</h4>
                          
                      </div>
                        <?php else: ?>
                       
<!--box tous les prescriptions -->
<div class="box box-widget">	
	<div class="box-body">
		 <div class="box-header">
									<h4>LIST DES TRAITEMENTS</h4>
								</div>

	<table class="fold-table" id="tab_trait">
		<thead>
			<tr>
			<th>Etat</th><th>Protocole</th><th>Date Traitement</th><th>Maladie</th><th>Localisation</th><th>N° Cure prevu</th><th>Date Début Cure</th><th>Médecin</th>
			</tr>
		</thead>
		<tbody>
			<?php $__currentLoopData = $traitement; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<tr class="view">
      <td><?php echo e($t->valide); ?></td>
			<td><?php echo e(DB::table('protocole')->where('id',$t->protocole_id)->pluck('nom')->first()); ?></td>
			<td><?php echo e($t->date_debut_traitement); ?></td>
			<td><?php echo e(DB::table('pathologies')->where('id',$t->pathologies_id)->pluck('pathologie')->first()); ?></td>
			<td><?php echo e($t->localisation); ?></td>
			<td><?php echo e($t->nombre_cure_prevu); ?></td>
			<td><?php echo e(DB::table('cure')->where('traitement_id',$t->id)->pluck('date_debut_cure')->first()); ?></td>
			<td><?php echo e(DB::table('users')->where('id',$t->medecin_id)->pluck('name')->first()); ?></td>
			</tr>




			<tr class="fold">
			<td colspan="8">
				<div class="fold-content">
				<div class="col-sm-12" style="text-align:right">
					<a href="<?php echo e(route('detailProtocole',$t->protocole_id)); ?>" class="btn btn-default btn-xs">Afficher le protocole</a>&nbsp;
					<button type="button" class="btn btn-default btn-xs" onclick="getRemarque('<?php echo e($t->commentaire); ?>')">Afficher le commentaire</button>&nbsp;
           <?php if($t->valide != 'Arreter'): ?>
           <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptionChimio.create')): ?>
					<button type="button" class="btn btn-default btn-xs" id="addcure" onclick="addCure(<?php echo e($t->id); ?>,<?php echo e($t->nombre_cure_prevu); ?>)">Ajouer une cure</button>&nbsp;
					<?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptionChimio.update', Auth::user())): ?>
          <button type="button" id="modifcurenb" class="btn btn-default btn-xs">modifier nombre de cure prevu</button>&nbsp;
					<button type="button" onclick="arreterTraitement(<?php echo e($t->id); ?>)"  id="arreter" class="btn btn-danger btn-xs">Arrêter le traitement
          </button>
          <?php endif; ?>
          <?php else: ?>

          <button type="button" class="btn btn-default btn-xs" onclick="afficheCommArreter('<?php echo e(DB::table('users')->where('id',$t->medecin_id)->pluck('name')->first()); ?>', '<?php echo e($t->comm_arrete); ?>','<?php echo e($t->date_arrete); ?>')">Raison d'arreter le traitement </button> &nbsp;

          <?php endif; ?>
          <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptionChimio.delete', Auth::user())): ?>
          <button type="button" onclick="deletetraitement(<?php echo e($t->id); ?>)" class="btn btn-danger btn-xs">Supprimer</button>&nbsp;
          <?php endif; ?>
        
				</div><br><br>

        
					<h3>List des prescriptions du traitement chimiothérapie suivie: </h3>

				 <?php $cures = DB::table('cure')->where('traitement_id',$t->id)->get();?>
				<?php $__currentLoopData = $cures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$cure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

				<strong>Cure n°<?php echo e($cure->numero); ?> (<?php echo e($cure->date_debut_cure); ?>): <?php echo e($cure->commentaire); ?></strong>
				<table>
					<thead>
					<tr>
						<th style="width: 10%;text-align:center">Etat</th>
            <th style="width: 40%;text-align:center">Date prescription</th>
            <th style="width: 10%;text-align:center">Jour</th>
            <th style="width: 40%;text-align:center">Action</th>
					</tr>
					</thead>
					<tbody>
						<?php $sequences = DB::table('sequences')->where('cure_id',$cure->id)->get();?>
						  <input type="hidden" id="taillehhid" value="<?php echo e($sequences[0]->taille); ?>">
						   <input type="hidden" id="poidshidd" value="<?php echo e($sequences[0]->poids); ?>">
						    <input type="hidden" id="massehidd" value="<?php echo e($sequences[0]->masse); ?>">
						<?php $__currentLoopData = $sequences; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $seq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>						
					<tr 
          <?php if($seq->etat == 'prevue' && $seq->date_debut != date('Y-m-d')): ?>
          style="background-color: #DDDDDD;text-align: center"
          <?php elseif($seq->etat == 'demande'): ?>
          style="background-color: #C6E2FF;text-align: center"
          <?php elseif($seq->etat == 'Arreter'): ?>
          style="background-color: #FF7373;text-align: center"

          <?php else: ?>
          style="background-color:  #FFFFFF;text-align: center"

          <?php endif; ?>
          >
						<td><?php echo e($seq->etat); ?></td>
						<td><?php echo e($seq->date_debut); ?></td>
						<td><?php echo e($seq->jour); ?></td>

						<td><a href="<?php echo e((route('pres',$seq->id))); ?>" class="btn btn-default btn-xs">Afficher</a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptionChimio.delete', Auth::user())): ?>
					
          <?php if($seq->etat != 'Arreter'): ?>
            <button type="button" class="btn btn-danger btn-xs" id="arreter" onclick="arreterSequence(<?php echo e($seq->id); ?>)">Arreter</button>	
          <?php else: ?>
            <button type="button" class="btn btn-default btn-xs" onclick="afficheCommArreterSeq('<?php echo e(DB::table('users')->where('id',$seq->id_user_arrete)->pluck('name')->first()); ?>', '<?php echo e($seq->comm_arrete); ?>','<?php echo e($seq->date_arrete); ?>')">Raison d'arreter la sequence </button> &nbsp;
					<?php endif; ?>
          <?php if($seq->etat == 'prevue' || $seq->etat == 'prescrite' || $seq->etat == 'demande' || $seq->etat == 'Arreter'): ?>
            <button type="button" class="btn btn-danger btn-xs" id="suppp" onclick="deletePrescription(<?php echo e($seq->id); ?>)">Supprimer</button>
          <?php endif; ?>
            <?php endif; ?>
						</td>
					</tr>
					
					<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					</tbody>
				</table>  <br>
        

				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>  
        
				</div>
			</td>
			</tr>

			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		
            </tbody>
          </table>
									
	</div>	
</div>
<!--box prescription-->
 <?php endif; ?>
  
</div>
<!-- modal commentaire-->
<div class="modal fade" id="modal-commentaire">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">COMMENTAIRE</h4>
              </div>           
              <div class="modal-body">
                <div class="box-body">
                	<div class="col-sm-12" style="text-align: center"><b id="commt" ></b></div>
              </div>
              </div>
              <div class="modal-footer">
                 <input id="b" type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">
              </div>      
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>  

        <!-- modal add cure-->
<div class="modal fade" id="modal-cure">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">AJOUTER UNE CURE</h4>
              </div>           
                	<form action="<?php echo e(route('addCure')); ?>" method="post">
                            <?php echo e(csrf_field()); ?>

              <div class="modal-body">
                <div class="box-body">
                	<div class="col-sm-12">
                		<div class="col-sm-6">
                			<div class="form-group" style="text-align: center">
						       <label class="control-label">Numero de cure</label>
						           <input type="number" name="numeroCure" id="numeroCure" class="form form-control" style="text-align: center" value="" required disabled>
						           <input type="hidden" name="numeroCuree" id="numeroCuree">
				     		</div>
                		</div>
                		<div class="col-sm-6">
                			<div class="form-group" style="text-align: center">
						       <label class="control-label">Début de la cure</label>
						           <input type="date" name="datecure" id="datecure" class="form form-control"  placeholder="" style="text-align: center" value="" required onchange="commRequired()">
				     		</div>
                		</div>
                		<div class="col-sm-4">	
                			<label class="control-label">Taille(cm)</label>
             				<input type="number" id="taillecure" name="taillecure" class="form-control"  style="text-align: center" value="" onchange="calculeSC()" required>
                		</div>
                		<div class="col-sm-4">
                			<label class="control-label">Poids(kg)</label>
             				<input type="number" id="poidscure" name="poidscure" step="0.01" class="form-control"  style="text-align: center" value="" onchange="calculeSC()" required>
                		</div>
                		<div class="col-sm-4">
                			<label class="control-label">Surf. corporelle(m²)</label>
             				<input type="number" id="massecure" name="massecure" class="form-control" step="0.01" style="text-align: center" value="" disabled required placeholder="Surff (m²)"><br>
             				<input type="hidden" name="massecuree" id="massecuree" value="">
                		</div>
                		<div class="form-group" style="text-align: center">  
                     		 <label class="control-label" hidden id="commR"><p style="color: red; font-size: 18px">Date début = date fin cure précédente + intervalle entre cure</p>Date début de la cure est calculé automatiquement <br>Changé la date vous oblige a écrire un commentaire</label>
                                <textarea id="commmm" name="commmm" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos de la cure ajouté" name="commmm" ></textarea>
                   </div>  
                	</div>
              
				    
                	
              </div>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Annuler</button>
                 <input id="bx" type="submit" class="btn btn-primary" value="Ajouter">
              </div>  
              <input type="hidden" name="idTraitement" id="idTraitement">
                </form>    
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
               <!-- modal add arrete-->
<div class="modal fade" id="modal-arreter">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rasion d'arreter le traitement</h4>
              </div>           .
              <div class="modal-body">
                <div class="box-body">               
              <div class="col-sm-12" style="text-align: center"><b id="arreterr" ></b></div>  
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
         


<?php /**PATH C:\laragon\www\anapharm\resources\views\chimio\chimio.blade.php ENDPATH**/ ?>