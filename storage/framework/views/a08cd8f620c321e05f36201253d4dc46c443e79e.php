
<div class="modal fade in" id="modal_question">
	<form action="<?php echo e(route('questionnairePatient.store')); ?>" method="POST">
		<?php echo e(csrf_field()); ?>

		<input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="bg-blue modal-header text-center">
					<div class="row">
						<div class="col-md-4">
							<h4 class="modal-title">Questionnaire</h4>
						</div>
						<div class="col-md-6 col-md-offset-2 form-inline">
							<input type="date" name="date_qs" class="form-control" value="<?php echo date('Y-m-d'); ?>" />

							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">×</span></button>
						</div>
					</div>
				</div>
				<div class="modal-body table-responsive" style="display: block;">

					<table class="table border-0 border-primary table-bordered">
						<thead>
							<tr>
								<th>Questionnaire :
									<select class="form-control" id="questionnaireChoiceId" name="questionnaire_id" required>
										<option value=""></option>
										<?php $__currentLoopData = $questionnaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questionnaire): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($questionnaire->id); ?>"><?php echo e($questionnaire->type); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</th>
								<th>OUI</th>
								<th>NON</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
					<input type="submit" class="btn btn-primary pull-right" value="Confirmer">
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
	</form>
	<!-- /.modal-dialog -->
</div><?php /**PATH C:\laragon\www\anapharm\resources\views/user/patient/modals/observance.blade.php ENDPATH**/ ?>