

<?php $__env->startSection('script_css'); ?>
	<link rel="stylesheet" href="<?php echo e(asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('plugins/jquery/css/jquery_ui.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="content-wrapper">

	<?php if(count($errors) > 0): ?>

	<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

	<p class="alert alert-danger"><?php echo e($error); ?></p>

	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	<?php endif; ?>

	<div class="alert alert-danger" style="display: none;"></div>

	<?php if(session()->has('message')): ?>

	<p class="alert alert-success"><?php echo e(session('message')); ?></p>

	<?php endif; ?>

	<div class="row">
    <div class="col-md-8 col-xs-12 col-md-offset-2">
			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h1 class="box-title" aling="center">Liste des réponses enregistrées</h1>

				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
				     <?php $pharmacos = DB::table('pharmacos')
                							->select('pharmacos.*')
											->where('envoye' , 'non')
                							->get(); ?>
	                            <?php if(count($pharmacos) > 0): ?>
			                	<table class="table table-bordered text-center element " id="id1">
		                        <thead class="thead-dark">
		                            <tr>
		                                <th>Date de déclaration</th>
		                                <th>Nom de rapporteur</th>
                                        <th>prénom</th>
										<th>N° tel</th>
									
										
										<th>détail</th>
										<th>Modifier</th>
										<th>Supprimer</th>
										<th>Envoyer</th>
										

		                            
		                        </thead>

								<tbody >
		                        		<?php $__currentLoopData = $pharmacos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pharmaco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
                                            
				                             	<td id="dec"><?php echo e($pharmaco->date_declaration_rapporteur); ?></td>
				                    			<td style="display:none" id="nom_pharmaco"><?php echo e($pharmaco->nom_pharmaco); ?></td>
												<td style="display:none" id="age_du_malade"><?php echo e($pharmaco->age_du_malade); ?></td>
												<td style="display:none" id="poids"><?php echo e($pharmaco->poids); ?></td>
												<td style="display:none" id="taille"><?php echo e($pharmaco->taille); ?></td>
												<td style="display:none" id="sexe"><?php echo e($pharmaco->sexe); ?></td>
												<td style="display:none" id="description_reaction"><?php echo e($pharmaco->description_reaction); ?></td>
												<td style="display:none" id="date_d_apparition"><?php echo e($pharmaco->date_d_apparition); ?></td>
												<td style="display:none" id="duree"><?php echo e($pharmaco->duree); ?></td>


												<td style="display:none" id="medicament1"><?php echo e($pharmaco->medicament1); ?></td>
												<td style="display:none" id="n_lot1"><?php echo e($pharmaco->n_lot1); ?></td>
												<td style="display:none" id="voie_admin1"><?php echo e($pharmaco->voie_admin1); ?></td>
												<td style="display:none" id="posologie1"><?php echo e($pharmaco->posologie1); ?></td>
                                                <td style="display:none" id="date_admin_debu1"><?php echo e($pharmaco->date_admin_debu1); ?></td>
												<td style="display:none" id="d_admin_fin1"><?php echo e($pharmaco->d_admin_fin1); ?></td>
												<td style="display:none" id="raison_d_emp1"><?php echo e($pharmaco->raison_d_emp1); ?></td>


												<td style="display:none" id="medicament2"><?php echo e($pharmaco->medicament2); ?></td>
												<td style="display:none" id="n_lot2"><?php echo e($pharmaco->n_lot2); ?></td>
												<td style="display:none" id="voie_admin2"><?php echo e($pharmaco->voie_admin2); ?></td>
												<td style="display:none" id="posologie2"><?php echo e($pharmaco->posologie2); ?></td>
                                                <td style="display:none" id="date_admin_debu2"><?php echo e($pharmaco->date_admin_debu2); ?></td>
												<td style="display:none" id="d_admin_fin2"><?php echo e($pharmaco->d_admin_fin2); ?></td>
												<td style="display:none" id="raison_d_emp2"><?php echo e($pharmaco->raison_d_emp2); ?></td>


												<td style="display:none" id="medicament3"><?php echo e($pharmaco->medicament3); ?></td>
												<td style="display:none" id="n_lot3"><?php echo e($pharmaco->n_lot3); ?></td>
												<td style="display:none" id="voie_admin3"><?php echo e($pharmaco->voie_admin3); ?></td>
												<td style="display:none" id="posologie3"><?php echo e($pharmaco->posologie3); ?></td>
                                                <td style="display:none" id="date_admin_debu3"><?php echo e($pharmaco->date_admin_debu3); ?></td>
												<td style="display:none" id="d_admin_fin3"><?php echo e($pharmaco->d_admin_fin3); ?></td>
												<td style="display:none" id="raison_d_emp3"><?php echo e($pharmaco->raison_d_emp3); ?></td>


												<td style="display:none" id="medicament4"><?php echo e($pharmaco->medicament4); ?></td>
												<td style="display:none" id="n_lot4"><?php echo e($pharmaco->n_lot4); ?></td>
												<td style="display:none" id="voie_admin4"><?php echo e($pharmaco->voie_admin4); ?></td>
												<td style="display:none" id="posologie4"><?php echo e($pharmaco->posologie4); ?></td>
                                                <td style="display:none" id="date_admin_debu4"><?php echo e($pharmaco->date_admin_debu4); ?></td>
												<td style="display:none" id="d_admin_fin4"><?php echo e($pharmaco->d_admin_fin4); ?></td>
												<td style="display:none" id="raison_d_emp4"><?php echo e($pharmaco->raison_d_emp4); ?></td>


												<td style="display:none" id="medicament5"><?php echo e($pharmaco->medicament5); ?></td>
												<td style="display:none" id="n_lot5"><?php echo e($pharmaco->n_lot5); ?></td>
												<td style="display:none" id="voie_admin5"><?php echo e($pharmaco->voie_admin5); ?></td>
												<td style="display:none" id="posologie5"><?php echo e($pharmaco->posologie5); ?></td>
                                                <td style="display:none" id="date_admin_debu5"><?php echo e($pharmaco->date_admin_debu5); ?></td>
												<td style="display:none" id="d_admin_fin5"><?php echo e($pharmaco->d_admin_fin5); ?></td>
												<td style="display:none" id="raison_d_emp5"><?php echo e($pharmaco->raison_d_emp5); ?></td>


												<td style="display:none" id="medicament6"><?php echo e($pharmaco->medicament6); ?></td>
												<td style="display:none" id="n_lot6"><?php echo e($pharmaco->n_lot6); ?></td>
												<td style="display:none" id="voie_admin6"><?php echo e($pharmaco->voie_admin6); ?></td>
												<td style="display:none" id="posologie6"><?php echo e($pharmaco->posologie6); ?></td>
                                                <td style="display:none" id="date_admin_debu6"><?php echo e($pharmaco->date_admin_debu6); ?></td>
												<td style="display:none" id="d_admin_fin6"><?php echo e($pharmaco->d_admin_fin6); ?></td>
												<td style="display:none" id="raison_d_emp6"><?php echo e($pharmaco->raison_d_emp6); ?></td>

												
												<td style="display:none" id="nature_traitement"><?php echo e($pharmaco->nature_traitement); ?></td>
												<td style="display:none" id="desc_traitement"><?php echo e($pharmaco->desc_traitement); ?></td>
												<td style="display:none" id="evolution"><?php echo e($pharmaco->evolution); ?></td>
												<td style="display:none" id="sequelle"><?php echo e($pharmaco->sequelle); ?></td>
												<td style="display:none" id="histoire_maladie"><?php echo e($pharmaco->histoire_maladie); ?></td>
												<td style="display:none" id="facteurs_de_risque"><?php echo e($pharmaco->facteurs_de_risque); ?></td>
												<td  id="nom"><?php echo e($pharmaco->nom); ?></td>
												<td id="prenom"><?php echo e($pharmaco->prenom); ?></td>
												<td id="tel"><?php echo e($pharmaco->tel); ?></td>
												<td style="display:none" id="adresse"><?php echo e($pharmaco->adresse); ?></td>
												<td style="display:none" id="email"><?php echo e($pharmaco->email); ?></td>
												<td style="display:none" id="type_d_exercice"><?php echo e($pharmaco->type_d_exercice); ?></td>
												<td style="display:none" id="adresse_postale"><?php echo e($pharmaco->adresse_postale); ?></td>

												









												<td><a href="<?php echo e(route('pharmaco.show' ,$pharmaco->id)); ?>"><span  class="fa fa-plus-circle"></span></a></td>
												<td><a href="<?php echo e(route('pharmaco.edit',$pharmaco->id)); ?>"><span class="glyphicon glyphicon-edit"></span></a>
												</td>
				                             	<td> 
				                             		<form style='display: none;' method='POST' action="<?php echo e(route('pharmaco.destroy',$pharmaco->id)); ?>" id='delete-form-<?php echo e($pharmaco->id); ?>'> 
						                             		<?php echo e(csrf_field()); ?> 
						                             	<?php echo e(method_field('DELETE')); ?> 
						                             </form>
						                             <a href="" onclick="if (confirm('voulez vous supprimer cette ligne ?')) {event.preventDefault(); documalorsent.getElementById('delete-form-<?php echo e($pharmaco->id); ?>').submit();} ">
						                             	<span class="glyphicon glyphicon-trash"></span>
						                             </a>
				                             	</td>

                                                    
												 <td><a onclick="idclicks()" href="<?php echo e(route('envoie',$pharmaco->id)); ?>" ><span  class="fa fa-paper-plane"></span></a></td>
												<td style="display:none"><a id="idclick" href="<?php echo e(url('http://ibno-sina.com/dashboard/page_receive.php
												?id='.$pharmaco->id.'&date_declaration_rapporteur='.$pharmaco->date_declaration_rapporteur
												.'&nom_pharmaco='.$pharmaco->nom_pharmaco.'&age_du_malade='.$pharmaco->age_du_malade
												.'&poids='.$pharmaco->poids.'&taille='.$pharmaco->taille.'&sexe='.$pharmaco->sexe
												.'&description_reaction='.$pharmaco->description_reaction.'&date_d_apparition='.$pharmaco->date_d_apparition
												.'&duree='.$pharmaco->duree.

												'&medicament1='.$pharmaco->medicament1.'&n_lot1='.$pharmaco->n_lot1
												.'&voie_admin1='.$pharmaco->voie_admin1.'&posologie1='.$pharmaco->posologie1.'&date_admin_debu1='.$pharmaco->date_admin_debu1
												.'&d_admin_fin1='.$pharmaco->d_admin_fin1.'&raison_d_emp1='.$pharmaco->raison_d_emp1

												.'&medicament2='.$pharmaco->medicament2.'&n_lot2='.$pharmaco->n_lot2
												.'&voie_admin2='.$pharmaco->voie_admin2.'&posologie2='.$pharmaco->posologie2.'&date_admin_debu2='.$pharmaco->date_admin_debu2
												.'&d_admin_fin2='.$pharmaco->d_admin_fin2.'&raison_d_emp2='.$pharmaco->raison_d_emp2
												
												.'&medicament3='.$pharmaco->medicament3.'&n_lot3='.$pharmaco->n_lot3
												.'&voie_admin3='.$pharmaco->voie_admin3.'&posologie3='.$pharmaco->posologie3.'&date_admin_debu3='.$pharmaco->date_admin_debu3
												.'&d_admin_fin3='.$pharmaco->d_admin_fin3.'&raison_d_emp3='.$pharmaco->raison_d_emp3
												
												.'&medicament4='.$pharmaco->medicament4.'&n_lot4='.$pharmaco->n_lot4
												.'&voie_admin4='.$pharmaco->voie_admin4.'&posologie4='.$pharmaco->posologie4.'&date_admin_debu4='.$pharmaco->date_admin_debu4
												.'&d_admin_fin4='.$pharmaco->d_admin_fin4.'&raison_d_emp4='.$pharmaco->raison_d_emp4
												
												.'&medicament5='.$pharmaco->medicament5.'&n_lot5='.$pharmaco->n_lot5
												.'&voie_admin5='.$pharmaco->voie_admin5.'&posologie5='.$pharmaco->posologie5.'&date_admin_debu5='.$pharmaco->date_admin_debu5
												.'&d_admin_fin5='.$pharmaco->d_admin_fin5.'&raison_d_emp5='.$pharmaco->raison_d_emp5
												
												.'&medicament6='.$pharmaco->medicament6.'&n_lot6='.$pharmaco->n_lot6
												.'&voie_admin6='.$pharmaco->voie_admin6.'&posologie6='.$pharmaco->posologie6.'&date_admin_debu6='.$pharmaco->date_admin_debu6
												.'&d_admin_fin6='.$pharmaco->d_admin_fin6.'&raison_d_emp6='.$pharmaco->raison_d_emp6
												
												.'&nature_traitement='.$pharmaco->nature_traitement.'&desc_traitement='.$pharmaco->desc_traitement
												.'&evolution='.$pharmaco->evolution.'&sequelle='.$pharmaco->sequelle.'&histoire_maladie='.$pharmaco->histoire_maladie
												.'&facteurs_de_risque='.$pharmaco->facteurs_de_risque.'&nom='.$pharmaco->nom
												.'&prenom='.$pharmaco->prenom.'&tel='.$pharmaco->tel
												.'&adresse='.$pharmaco->adresse.'&email='.$pharmaco->email
												.'&type_d_exercice='.$pharmaco->type_d_exercice.'&adresse_postale='.$pharmaco->adresse_postale
												
												
												)); ?> " 
												target="_blank"><span  class="fa fa-paper-plane"></span></a></td>
												 <!--<td><a onclick="clicks()" href="<?php echo e(route('envoie',$pharmaco->id)); ?>" ><span  class="fa fa-paper-plane"></span></a></td>-->

												  
												  </tr>




		                        		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                        </tbody>
	                    	   </table>
							   <?php endif; ?>
                </div><!---body-->
            </div><!--box-info-->
    </div><!--offset-->
    </div><!--row-->

 </div><!--content-->
 <?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script src="<?php echo e(asset('/plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/jquery/js/jquery-ui.js')); ?>"></script> 
	<script type="text/javascript" src="<?php echo e(asset('/js/admin/gestion_regle.js')); ?>"></script>
	<script type="text/javascript">
	$('body').find('span > i').remove('i:last');
        $('#id1').dataTable();
       
</script>

<script>
function idclicks() {
	//alert('hllo');
  document.getElementById("idclick").click(); // Click on the checkbox
}
</script>

<!--<script>
function clicks() {
	alert('hllo');
  document.getElementById("idclick").click(); // Click on the checkbox
  var nom = document.getElementById("nom");
  var prenom = document.getElementById("prenom");
  window.location.replace = 'http://ibno-sina.com/dashboard/page2.php';
 /* $.ajax({
        type: 'GET',
        url: 'http://ibno-sina.com/dashboard/page2.php',
        data: { nom: nom, prenom: prenom},
        success: function(result) {
    
	
		   location.href = 'http://ibno-sina.com/dashboard/page2.php';
           
        }
    });*/
}
</script>-->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\pharm\liste1.blade.php ENDPATH**/ ?>