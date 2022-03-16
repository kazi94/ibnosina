<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
	<section class="content">

		<div class="row">

			<div class="col-sm-12 ">
							<div class="box  box-widget">
								<div class="box-header">
									<h2>Historique des Observances</h2>
								</div>

								<div class="box-body">
										<div class="row">
											<div class="col-sm-12">
												<table id="his_obs" class="table table-responsive text-center dataTable" >
													<thead>
														<tr class="bg-teal-active">
															<th>Num</th>
															<th>Patient </th>
															<th>Questionnaire</th>
															<th>Observance </th>
															<th>Date Observance</th>
															
														</tr>
													</thead>
													
													<tbody>
														<?php $__currentLoopData = $questionnaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ques): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<tr>
																<th> <?php echo e($loop->index+1); ?></th>
																<td> <?php echo e($ques->nom); ?>  <?php echo e($ques->prenom); ?> </td>
																<td> <?php echo e($ques->type); ?>  </td>
																<th> 
																	<?php if($ques->reponse == "1" || $ques->reponse =="2"): ?>
																			<p class=" label-warning">Patient modérément observant</p>
																			<?php elseif($ques->reponse == "3" || $ques->reponse == "4"): ?>
																			<p class=" label-danger">Patient non observant</p>
																			<?php else: ?>
																			<p class=" label-success">Patient très observant</p>
																		<?php endif; ?>
																</th>
																<td> <?php echo e(date('d/m/Y',strtotime($ques->date_questionnaire))); ?></td>

															</tr>
														<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
													</tbody>
												</table>
											</div>
										</div>
								</div>
							</div>
			</div>

		</div>

	</section>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script type="text/javascript">
	$("#his_obs").DataTable(); //phyto    
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\pharmacien\observance\observ_history.blade.php ENDPATH**/ ?>