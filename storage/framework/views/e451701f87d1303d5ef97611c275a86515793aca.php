<!-- modal_act -->
<div class="modal fade in" id="modal_act">
	<div class="modal-dialog modal-md">
		<form action="<?php echo e(route('actestore')); ?>" method="POST" id="target">
			<?php echo e(csrf_field()); ?>

			<input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
			<div class="modal-content">
				<div class="bg-blue modal-header text-center">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
					<div class="row title">
						<div class="col-md-9">
							<h4 class="modal-title">Nouvelle Act</h4>
						</div>
					</div>
				</div>
				<div class="modal-body" style="display: block;">
					<div class="form-group">
						<input type="hidden" name="cons_id" id="cons_id" value="" />
						<label class="col-sm-3 control-label">Nom Act</label>
						<div class="col-sm-9">
							<select class="form-control select2 select2-hidden-accessible" data-placeholder="Choisisez le nom de lact" style="width: 100%;" tabindex="-1" aria-hidden="true" name="actm" id="actm">
								<?php
								$pathologies = DB::table('act_medicales')
								->select('act_medicales.*')
								->get();
								?>
								<?php $__currentLoopData = $pathologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pathologie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
								<option value="<?php echo e($pathologie->id); ?>"><?php echo e($pathologie->nom); ?></option>
								<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="Description" class="col-sm-3 control-label">Description</label>
						<div class="col-sm-9">
							<textarea class="form-control" rows="5" cols="25" name="description" placeholder="entrer description"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label for="Date" class="col-sm-3 control-label">Date Act</label>
						<div class="col-sm-9">
							<input type="date" class="form form-control" name="date_act" value="<?php echo date('Y-m-d'); ?>" required />
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
					<input type="submit" class="btn btn-primary pull-right" value="Confirmer">
				</div>
			</div>
		</form>
	</div>
</div>

<div class="modal fade in" id="modal_detail_act">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="bg-blue modal-header text-center">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<div class="row">
					<div class="col-md-9">
						<h4 class="modal-title">Modifier</h4>
					</div>
				</div>
			</div>
			<div class="modal-body" style="display: block;">
				<div class="row">

					<div class="col-sm-12">
						<form action="" class="up_acts" method="POST" enctype="multipart/form-data">
							<?php echo e(csrf_field()); ?>

							<?php echo e(method_field('PATCH')); ?>

							<table class="table table-bordered table-condensed text-center">
								<tr>
									<td>Nom Act</td>
									<td>
										<input type="hidden" name="patient_id" id="patient_id" value="">
										<input type="hidden" name="cons_id" id="cons_id" value="">
										<select class="form-control select2 select2-hidden-accessible" data-placeholder="Choisisez le nom de lact" style="width: 100%;" tabindex="-1" aria-hidden="true" name="actm" id="actm">
											<?php
											$pathologies = DB::table('act_medicales')
											->select('act_medicales.*')
											->get();
											?>
											<?php $__currentLoopData = $pathologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pathologie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<option value="<?php echo e($pathologie->id); ?>"><?php echo e($pathologie->nom); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>

									</td>
								</tr>
								<tr>
									<td>Description</td>
									<td>

										<textarea class="form-control" rows="5" cols="25" name="description" id="description" placeholder="entrer description"></textarea>
									</td>
								</tr>
								<tr>
									<td>date act</td>
									<td>
										<input type="date" class="form form-control" placeholder="" name="date_act" id="date_act" required />
									</td>
								</tr>
							</table>
					</div>

				</div>
				<td>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
				<input type="submit" class="btn btn-default pull-right" value="Modifier">
				</form>
			</div>
		</div>
		<!-- /.modal-content -->
	</div>
	<!-- /.modal-dialog -->
</div><?php /**PATH C:\laragon\www\anapharm\resources\views/user/patient/modals/act-medicale.blade.php ENDPATH**/ ?>