                            
                        
	<div class="tab-pane" id="tab_suivie">  
		<div class="box box-widget">
			<div class="box-header">
			   <h3>Pilotage données patient:</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="box-body table-responsive no-padding">  
							<table class="table table-responsive text-center dataTable" id="tabtous">
								<thead>
									<tr class="alert alert-info">
										
										<th>Regle de suivie</th>
										<th>commentaire</th>
										<th>valeur(s) déclenchante(s)</th>
										<th>Date et heure:</th>
										<th>niveau</th>
										<th>etat</th>
										
									</tr>
								</thead>
									
									<tbody>
										<?php $__currentLoopData = $patient->ReglesSuiviPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_suivie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php if($regle_suivie->RegleSuiviConcerne->niveau ==1): ?>
												<tr>
											
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->si); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->commentaire); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->valeursDeclenchantes); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->created_at); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->niveau); ?>

													</td>
													<td>
														<i class="glyphicon glyphicon-alert" style="font-size:30px;color: red;"></i>
													</td>
												</tr>
											<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<?php $__currentLoopData = $patient->ReglesSuiviPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_suivie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php if($regle_suivie->RegleSuiviConcerne->niveau ==2): ?>
														
											<tr>			
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->si); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->commentaire); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->valeursDeclenchantes); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->created_at); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->niveau); ?>

													</td>
													<td>
														<?php if($regle_suivie->etat=="nonVu"): ?>
														<a href="<?php echo e(route('regleSuivPatient.vu', [ $patient->id ,$regle_suivie->RegleSuiviConcerne->id ] )); ?>">
															<img src="<?php echo e(asset('/images/nonVu.png')); ?>" alt=""></a>
														<?php endif; ?>
														<?php if($regle_suivie->etat=="Vu"): ?>
															<img src="<?php echo e(asset('/images/Vu.png')); ?>" alt="">
														<?php endif; ?>
													</td>
												</tr>
											<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										<!--<?php $__currentLoopData = $patient->ReglesSuiviPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_suivie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<?php if($regle_suivie->RegleSuiviConcerne->niveau ==1 && $regle_suivie->RegleSuiviConcerne->etat == "rique"): ?>
							    				
												<tr bgcolor=''>
													
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->si); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->commentaire); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->valeursDeclenchantes); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->created_at); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->RegleSuiviConcerne->niveau); ?>

													</td>
													<td>
														<?php echo e($regle_suivie->etat); ?>

													</td>
												</tr>
											<?php endif; ?>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>-->
								</tbody>

							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\tabs\suivie.blade.php ENDPATH**/ ?>