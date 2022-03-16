
<div class="modal fade" id="modal_entretien">
	<div class="modal-dialog  modal-md ">
		<div class="modal-content">
			<div class="bg-blue modal-header text-center">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Ajouter Education thérapeutique</h4>
			</div>
			<form method="POST" action="<?php echo e(route('education_therapeutique.store')); ?>" enctype="multipart/form-data" class="form-horizontal" id="formEducation">
				<?php echo e(csrf_field()); ?>

				<input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
				<div class="modal-body">
					<div class="form-group">
						<label for="d_analyse" class="col-sm-3 control-label">Date </label>

						<div class="col-sm-9">
							<input type="date" class="form-control" name="date_et" value="<?php echo date('Y-m-d'); ?>" />
						</div>
					</div>
					<div class="form-group">
						<label for="labo" class="col-sm-3 control-label">Type</label>

						<div class="col-sm-9">
							<select class="form form-control" name="type">
								<option>Brochure</option>
								<option>Formation</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="labo" class="col-sm-3 control-label">Fichier</label>

						<div class="col-sm-9">
							<input type="file" class="form-control" name="fichier" id="fichier" accept=".png,.jpeg,">
						</div>
					</div>
					<div class="form-group">
						<label for="labo" class="col-sm-3 control-label">Notes</label>

						<div class="col-sm-9">
							<textarea class="form-control" rows="4" name="notes" required></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
					<input type="submit" class="btn btn-primary pull-right" value="Ajouter">
				</div>
			</form>

		</div>
	</div>
</div>

<div class="modal fade" id="modal_analyse_therap" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="bg-blue modal-header text-center">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Details de l'éducation thérapeutique</h4>
			</div>
			<div class="modal-body" id="div_body">

			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
			</div>
		</div>
	</div>
</div><?php /**PATH C:\laragon\www\anapharm\resources\views/user/patient/modals/education-therapeutique.blade.php ENDPATH**/ ?>