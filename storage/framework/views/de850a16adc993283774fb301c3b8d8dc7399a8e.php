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

					<h1 class="box-title" aling="center">Pharmacovigilance</h1>

				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
                     <form method="POST" action="<?php echo e(route('pharmaco.update', $pharmaco->id)); ?>" enctype="multipart/form-data">
                     <?php echo e(csrf_field()); ?>

                     <?php echo e(method_field('PATCH')); ?>

                    
                        <?php
		                      $r =  DB::select('select * from pharmacos where id = ?',[$pharmaco]);
		                    ?>
                                                       
                    

                     <div class="form-group col-sm-12">
                         <label for="exampleFormControlSelect">Date de déclaration:</label>
                         <input class="form-control" type="date" id="date_declaration_rapporteur" name="date_declaration_rapporteur" value= "<?php echo e($pharmaco->date_declaration_rapporteur); ?>"/>
                         </div>


                     <div class="form-group col-sm-12">
                      <h3 aling="center" style="color:blue">____________________Informations malade____________________</h3>
                      </div>
                    <div class="row">
                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">Nom:</label>
                      <input type="text" id="nom_pharmaco" name="nom_pharmaco" value= "<?php echo e($pharmaco->nom_pharmaco); ?>"/>
                      </div>
                      
                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">Age:</label>
                      <input type="text" id="ageMalade" name="age_du_malade" value= "<?php echo e($pharmaco->age_du_malade); ?>"/>
                      </div>


                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">poids:</label>
                      <input type="text" id="poids" name="poids" value= "<?php echo e($pharmaco->poids); ?>"/>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">Taille:</label>
                      <input type="text" id="taille" name="taille" value= "<?php echo e($pharmaco->taille); ?>"/>
                      </div>


                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">Sexe:</label>
                      <input type="hidden" name="sexe" value= "<?php echo e($pharmaco->sexe); ?>" data-ghost="1" />
                        
                           <input data-events="[]" name="sexee" value="m" id="sexe0" type="radio" > Masculin
                          <input data-events="[]" name="sexee" value="f" id="sexe1" type="radio"  > Feminin
                            
                            <?php if( $pharmaco->sexe == 'f' ): ?>
                            <script> 
                              document.getElementById("sexe1").checked = true;
                              document.getElementById("sexe0").checked = false;
                              </script>
                              <?php elseif($pharmaco->sexe == 'm'): ?>
                              <script>
                              document.getElementById("sexe0").checked = true;
                              document.getElementById("sexe1").checked = false;
                              </script>
                           <?php endif; ?>
                           
                            
                      </div>

                      </div><!---row-->
                      <div class="form-group col-sm-12">
                      <h3 aling="center" style="color:blue">_____________Description de la réaction indésirable_____________</h3>
                      </div>
                    

                      <div class="form-group">
                        <label for="exampleFormControlTextarea" >Description de la réaction (nature, localisation, gravité, caractéristiques):</label>
                        <textarea class="form-control" id="description_reaction" name="description_reaction" rows="5" require><?php echo e($pharmaco->description_reaction); ?></textarea>
                      </div>
                
                       
                         <div class="form-group col-sm-6">
                         <label for="exampleFormControlSelect">Date d'apparition:</label>
                         <input type="date" id="date_d_apparition" name="date_d_apparition" value= "<?php echo e($pharmaco->date_d_apparition); ?>"/>
                         </div>

                         <div class="form-group col-sm-6">
                         <label for="exampleFormControlSelect">Durée:</label>
                         <input type="text" id="duree" name="duree" value= "<?php echo e($pharmaco->duree); ?>"/>
                         </div>

                         <div role="tabpanel">

                         <ul class="nav nav-tabs"  id="tablist">
                         <li role="presentation" class="active" id ="medic1"><a href="#medicament1" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 1</a></li>
                         <li role="presentation" id="medic2"><a href="#medicament2" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 2</a></li>
                         <li role="presentation" id="medic3"><a href="#medicament3" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 3</a></li>
                         <li role="presentation" id="medic4"><a href="#medicament4" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 4</a></li>
                         <li role="presentation" id="medic5"><a href="#medicament5" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 5</a></li>
                         <li role="presentation" id="medic6"><a href="#medicament6" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 6</a></li>
                         
                         </ul>
                         <div class="tab-content">
                      	    <!--ici c'est le contenu de l'onglet 1-->
                            <div role="tabpanel" class="tab-pane active" id="medicament1">


                            <div class="form-group col-sm-4">
                             <label for="medicament">Médicament 1 en DCI:</label>
                             <input type="text" class="form-control" id="medic1" name="medicament1" value= "<?php echo e($pharmaco->medicament1); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">N° lot:</label>
                             <input type="text" class="form-control" id="n_lot" name="n_lot1" value= "<?php echo e($pharmaco->n_lot1); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Voie d'administration:</label>
                             <input type="text" class="form-control" id="voie_admin1" name="voie_admin1" value= "<?php echo e($pharmaco->voie_admin1); ?>"/>
                            </div>


                            <div class="form-group col-sm-3">
                             <label for="medicament">Posologie:</label>
                             <input type="text" class="form-control" id="posologie1" name="posologie1" value= "<?php echo e($pharmaco->posologie1); ?>"/>
                            </div>
                          
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'amin début:</label>
                             <input type="date" class="form-control" id="date_admin_debu1" name="date_admin_debu1" value= "<?php echo e($pharmaco->date_admin_debu1); ?>"/>
                            </div>
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'aministration fin:</label>
                             <input type="date" class="form-control" id="d_admin_fin1" name="d_admin_fin1" value= "<?php echo e($pharmaco->d_admin_fin1); ?>"/>
                            </div>
                            <div class="form-group col-sm-3">
                             <label for="medicament">Raison d'emploi:</label>
                             <input type="text" class="form-control" id="raison_d_emp1" name="raison_d_emp1" value= "<?php echo e($pharmaco->raison_d_emp1); ?>"/>
                            </div>
                            </div><!--tabpanel medic1-->







                            <div role="tabpanel" class="tab-pane" id="medicament2"><!--onglet 2-->

                            <div class="form-group col-sm-4">
                             <label for="medicament">Médicament 2 en DCI:</label>
                             <input type="text" class="form-control" id="medicament2" name="medicament2" value= "<?php echo e($pharmaco->medicament2); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">N° lot:</label>
                             <input type="text" class="form-control" id="n_lot2" name="n_lot2" value= "<?php echo e($pharmaco->n_lot2); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Voie d'administration:</label>
                             <input type="text" class="form-control" id="voie_admin2" name="voie_admin2" value= "<?php echo e($pharmaco->voie_admin2); ?>"/>
                            </div>


                            <div class="form-group col-sm-3">
                             <label for="medicament">Posologie:</label>
                             <input type="text" class="form-control" id="posologie2" name="posologie2" value= "<?php echo e($pharmaco->posologie2); ?>"/>
                            </div>
                          
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'amin début:</label>
                             <input type="date" class="form-control" id="date_admin_debu2" name="date_admin_debu2" value= "<?php echo e($pharmaco->date_admin_debu2); ?>"/>
                            </div>
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'aministration fin:</label>
                             <input type="date" class="form-control" id="d_admin_fin2" name="d_admin_fin2" value= "<?php echo e($pharmaco->d_admin_fin2); ?>"/>
                            </div>
                            <div class="form-group col-sm-3">
                             <label for="medicament">Raison d'emploi:</label>
                             <input type="text" class="form-control" id="raison_d_emp2" name="raison_d_emp2" value= "<?php echo e($pharmaco->raison_d_emp2); ?>"/>
                            </div>
                                 
                            </div><!--tabpanel medic2-->


                              <div role="tabpanel" class="tab-pane" id="medicament3"><!--onglet 3-->

                            <div class="form-group col-sm-4">
                             <label for="medicament">Médicament 3 en DCI:</label>
                             <input type="text" class="form-control" id="medicament3" name="medicament3" value= "<?php echo e($pharmaco->medicament3); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">N° lot:</label>
                             <input type="text" class="form-control" id="n_lot3" name="n_lot3" value= "<?php echo e($pharmaco->n_lot3); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Voie d'administration:</label>
                             <input type="text" class="form-control" id="voie_admin3" name="voie_admin3" value= "<?php echo e($pharmaco->voie_admin3); ?>"/>
                            </div>


                            <div class="form-group col-sm-3">
                             <label for="medicament">Posologie:</label>
                             <input type="text" class="form-control" id="posologie3" name="posologie3" value= "<?php echo e($pharmaco->posologie3); ?>"/>
                            </div>
                          
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'amin début:</label>
                             <input type="date" class="form-control" id="date_admin_debu3" name="date_admin_debu3" value= "<?php echo e($pharmaco->date_admin_debu3); ?>"/>
                            </div>
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'aministration fin:</label>
                             <input type="date" class="form-control" id="d_admin_fin3" name="d_admin_fin3" value= "<?php echo e($pharmaco->d_admin_fin3); ?>"/>
                            </div>
                            <div class="form-group col-sm-3">
                             <label for="medicament">Raison d'emploi:</label>
                             <input type="text" class="form-control" id="raison_d_emp3" name="raison_d_emp3" value= "<?php echo e($pharmaco->raison_d_emp3); ?>"/>
                            </div>
                                 
                            </div><!--tabpanel medic3-->



                              <div role="tabpanel" class="tab-pane" id="medicament4"><!--onglet 4-->

                            <div class="form-group col-sm-4">
                             <label for="medicament">Médicament 4 en DCI:</label>
                             <input type="text" class="form-control" id="medicament4" name="medicament4" value= "<?php echo e($pharmaco->medicament4); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">N° lot:</label>
                             <input type="text" class="form-control" id="n_lot4" name="n_lot4" value= "<?php echo e($pharmaco->n_lot4); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Voie d'administration:</label>
                             <input type="text" class="form-control" id="voie_admin4" name="voie_admin4" value= "<?php echo e($pharmaco->voie_admin4); ?>"/>
                            </div>


                            <div class="form-group col-sm-3">
                             <label for="medicament">Posologie:</label>
                             <input type="text" class="form-control" id="posologie4" name="posologie4" value= "<?php echo e($pharmaco->posologie4); ?>"/>
                            </div>
                          
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'amin début:</label>
                             <input type="date" class="form-control" id="date_admin_debu4" name="date_admin_debu4" value= "<?php echo e($pharmaco->date_admin_debu4); ?>"/>
                            </div>
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'aministration fin:</label>
                             <input type="date" class="form-control" id="d_admin_fin4" name="d_admin_fin4" value= "<?php echo e($pharmaco->d_admin_fin4); ?>"/>
                            </div>
                            <div class="form-group col-sm-3">
                             <label for="medicament">Raison d'emploi:</label>
                             <input type="text" class="form-control" id="raison_d_emp4" name="raison_d_emp4" value= "<?php echo e($pharmaco->raison_d_emp4); ?>"/>
                            </div>
                                 
                            </div><!--tabpanel medic4-->






                             <div role="tabpanel" class="tab-pane" id="medicament5"><!--onglet 5-->

                            <div class="form-group col-sm-4">
                             <label for="medicament">Médicament 5 en DCI:</label>
                             <input type="text" class="form-control" id="medicament5" name="medicament5"  value= "<?php echo e($pharmaco->medicament5); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">N° lot:</label>
                             <input type="text" class="form-control" id="n_lot5" name="n_lot5" value= "<?php echo e($pharmaco->n_lot5); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Voie d'administration:</label>
                             <input type="text" class="form-control" id="voie_admin5" name="voie_admin5" value= "<?php echo e($pharmaco->voie_admin5); ?>"/>
                            </div>


                            <div class="form-group col-sm-3">
                             <label for="medicament">Posologie:</label>
                             <input type="text" class="form-control" id="posologie5" name="posologie5" value= "<?php echo e($pharmaco->posologie5); ?>"/>
                            </div>
                          
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'amin début:</label>
                             <input type="date" class="form-control" id="date_admin_debu5" name="date_admin_debu5" value= "<?php echo e($pharmaco->date_admin_debu5); ?>"/>
                            </div>
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'aministration fin:</label>
                             <input type="date" class="form-control" id="d_admin_fin5" name="d_admin_fin5" value= "<?php echo e($pharmaco->d_admin_fin5); ?>"/>
                            </div>
                            <div class="form-group col-sm-3">
                             <label for="medicament">Raison d'emploi:</label>
                             <input type="text" class="form-control" id="raison_d_emp5" name="raison_d_emp5" value= "<?php echo e($pharmaco->raison_d_emp5); ?>"/>
                            </div>
                                 
                            </div><!--tabpanel medic5-->





                             <div role="tabpanel" class="tab-pane" id="medicament6"><!--onglet 6-->

                            <div class="form-group col-sm-4">
                             <label for="medicament">Médicament 6 en DCI:</label>
                             <input type="text" class="form-control" id="medicament6" name="medicament6" value= "<?php echo e($pharmaco->medicament6); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">N° lot:</label>
                             <input type="text" class="form-control" id="n_lot6" name="n_lot6" value= "<?php echo e($pharmaco->n_lot6); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Voie d'administration:</label>
                             <input type="text" class="form-control" id="voie_admin6" name="voie_admin6" value= "<?php echo e($pharmaco->voie_admin6); ?>"/>
                            </div>


                            <div class="form-group col-sm-3">
                             <label for="medicament">Posologie:</label>
                             <input type="text" class="form-control" id="posologie6" name="posologie6" value= "<?php echo e($pharmaco->posologie6); ?>"/>
                            </div>
                          
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'amin début:</label>
                             <input type="date" class="form-control" id="date_admin_debu6" name="date_admin_debu6" value= "<?php echo e($pharmaco->date_admin_debu6); ?>"/>
                            </div>
                        
                            <div class="form-group col-sm-3">
                             <label for="medicament">Date d'aministration fin:</label>
                             <input type="date" class="form-control" id="d_admin_fin6" name="d_admin_fin6" value= "<?php echo e($pharmaco->d_admin_fin6); ?>"/>
                            </div>
                            <div class="form-group col-sm-3">
                             <label for="medicament">Raison d'emploi:</label>
                             <input type="text" class="form-control" id="raison_d_emp6" name="raison_d_emp6" value= "<?php echo e($pharmaco->raison_d_emp6); ?>"/>
                            </div>
                                 
                            </div><!--tabpanel medic6-->
                            
                            </div><!--tab content-->
                        </div><!--role tabpanel-->
                      <div class="form-group col-sm-12">
                      <h3 aling="center" style="color:blue">_____________Traitement de la réaction indésirable____________</h3>
                      </div>

                      <div class="form-group col-sm-12">
                      <label >Nature du traitement</label>
                      <input type="hidden" name="nature_traitement"  data-ghost="1" />
                      <div class="inline field" >
                      <div class="ui checkbox radio" >
                       <input  data-events="[]" name="nature_traitementt" id="nature_traitement0" type="radio" value="medic"/>
                       <label for="nature_traitement0" >Médicamenteux</label></div></div>
                       <div class="inline field" >
                       <div class="ui checkbox radio" ><input data-events="[]" name="nature_traitementt" id="nature_traitement1" type="radio" value="non_medic" />
                       <label for="nature_traitement1" >Non médicamenteux</label></div></div>
                    
                       <?php if( $pharmaco->nature_traitement == 'medic' ): ?>
                            <script> 
                              document.getElementById("nature_traitement0").checked = true;
                              document.getElementById("nature_traitement1").checked = false;

                              </script>
                              <?php else: ?> if ( $pharmaco->nature_traitement == 'non_medic' )
                              <script>
                              document.getElementById("nature_traitement1").checked = true;
                              document.getElementById("nature_traitement0").checked = false;

                              </script>
                           <?php endif; ?>
                      </div>

                      <div class="form-group">
                        <label for="exampleFormControlTextarea" >Descriptif du traitement:</label>
                        <textarea class="form-control" id="desc_traitement" name="desc_traitement" rows="5" require><?php echo e($pharmaco->desc_traitement); ?></textarea>
                      </div>
                      
                
                <div class="form-group col-sm-12">
                <label >Evolution</label>
                 <input type="hidden" name="evolution"  data-ghost="1" />
                 <input  name="evolutionn" id="evolution0" value="disparition" type="radio"/>
                 <label for="evolution0" >Disparition</label>
                <input  name="evolutionn" id="evolution1" value="en_cours" type="radio"/>
                 <label for="evolution1" >En cours</label>
                <input name="evolutionn" id="evolution2" value="inconnue" type="radio"/>
                 <label for="evolution2" >Inconnue</label>
               
                 <input name="evolutionn" id="evolution3" value="deces" type="radio"/>
                 <label for="evolution3" >Décès</label>
                

                             <?php if( $pharmaco->evolution == 'disparition' ): ?>
                            <script> 
                              document.getElementById("evolution0").checked = true;
                              document.getElementById("evolution1").checked = false;
                              document.getElementById("evolution2").checked = false;
                              document.getElementById("evolution3").checked = false;

                              </script>
                              
                             <?php elseif($pharmaco->evolution == 'en_cours' ): ?>
                              <script>

                              document.getElementById("evolution0").checked = false;
                              document.getElementById("evolution1").checked = true;
                              document.getElementById("evolution2").checked = false;
                              document.getElementById("evolution3").checked = false;                            
                             </script>


                               <?php elseif($pharmaco->evolution == 'inconnue' ): ?>
                              <script>

                              document.getElementById("evolution0").checked = false;
                              document.getElementById("evolution1").checked = false;
                              document.getElementById("evolution2").checked = true;
                              document.getElementById("evolution3").checked = false;                        
                              </script>
                              
                              <?php elseif($pharmaco->evolution == 'deces' ): ?>
                              <script>
                              document.getElementById("evolution0").checked = false;
                              document.getElementById("evolution1").checked = false;
                              document.getElementById("evolution2").checked = false;
                              document.getElementById("evolution3").checked = true; 
                              </script>
                             <?php endif; ?>
                             </div>
                 
                 <div class="form-group col-sm-12">
                      <label for="exampleFormControlSelect">Sequelle:</label>
                      <input type="hidden" name="sequelle" value= "<?php echo e($pharmaco->sequelle); ?>" data-ghost="1" />
                           <input data-events="[]" name="sequellee" id="sequelle0" type="radio" value="oui"/>
                           <label for="sequelle0" >Oui</label>
                            <input data-events="[]" name="sequellee" id="sequelle1" type="radio" value="non"/>
                            <label for="sequelle1" >Non</label>
                            <?php if( $pharmaco->sequelle == 'oui' ): ?>
                            <script> 
                              document.getElementById("sequelle0").checked = true;
                              document.getElementById("sequelle1").checked = false;

                              </script>
                              <?php else: ?>
                              <script>
                              document.getElementById("sequelle1").checked = true;
                              document.getElementById("sequelle0").checked = false;

                              </script>
                           <?php endif; ?>
                      
                      </div>
                

                <div class="form-group">
                        <label for="exampleFormControlTextarea" >Histoire de la maladie ou commentaires:</label>
                        <textarea class="form-control" id="histoire_maladie" name="histoire_maladie" rows="5" require><?php echo e($pharmaco->histoire_maladie); ?></textarea>
                      </div>

                      
                <div class="form-group">
                        <label for="exampleFormControlTextarea" >Les facteurs de risques associés (insuffisance rénale, exposition antérieure au médicament suspecté, allergies antérieures, modalités d'utilisation)
:</label>
                        <textarea class="form-control" id="facteurs_de_risque" name="facteurs_de_risque" require><?php echo e($pharmaco->facteurs_de_risque); ?></textarea>
                      </div>

                     <div class="form-group col-sm-12">
                      <h3 aling="center" style="color:blue">____________________Identité du rapporteur___________________</h3>
                      </div>
                      <div class="form-group col-sm-4">
                             <label for="medicament">Nom:</label>
                             <input type="text" class="form-control" id="nom" name="nom" value= "<?php echo e($pharmaco->nom); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Prenom:</label>
                             <input type="text" class="form-control" id="prenom" name="prenom" value= "<?php echo e($pharmaco->prenom); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">N° tel/fax:</label>
                             <input type="text" class="form-control" id="tel" name="tel" value= "<?php echo e($pharmaco->tel); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Adresse:</label>
                             <input type="text" class="form-control" id="adresse" name="adresse" value= "<?php echo e($pharmaco->adresse); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Email</label>
                             <input type="text" class="form-control" id="email" name="email" value= "<?php echo e($pharmaco->email); ?>"/>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Type experience:</label>
                             <select type="text" class="form-control" id="type_d_exercice" name="type_d_exercice" value= "<?php echo e($pharmaco->type_d_exercice); ?>">
                            <option id="publique" name="publique" >publique</option>
                            <option id="prive" name="prive" >privé</option>
                            </select>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Adresse postal:</label>
                             <input type="text" class="form-control" id="adresse_postale" name="adresse_postale" value= "<?php echo e($pharmaco->adresse_postale); ?>"/>
                            </div>
                            <div class="form-group col-sm-12">
                            <input type="submit" class="btn btn-primary pull-right" name="enregistrer" value="Enregistrer" >  
                             </div>
                     </form>
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
    <script>
$('#tablist a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\pharm\edit.blade.php ENDPATH**/ ?>