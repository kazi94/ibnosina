<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
	<section class="content">

		<div class="flash-message">
			<?php $__currentLoopData = ['danger', 'warning', 'success', 'info']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $msg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				<?php if(Session::has('alert-' . $msg)): ?>
					<p class="alert alert-<?php echo e($msg); ?>"><?php echo e(Session::get('alert-' . $msg)); ?> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
				<?php endif; ?>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>

		<div class="row">

			<div class="col-sm-12 ">
				<div class="box box-info">
					

			      		<div class="box-header with-border">

			       			 <h2 class="box-title">Compte Patients</h2>
			       			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_patient.create',Auth::user())): ?>
			        		<a class='col-lg-offset-8 btn btn-success' href="<?php echo e(route('compte.create')); ?>">Ajouter nouveau</a>
			        		<?php endif; ?>
						</div>

						<div class="box-body">

			
		                    <table class="table table-responsive table-bordered table-stripped text-center dataTable" id="t_user">

		                        <thead>
		                            <tr class="thead-dark">
		                                <th>Num°</th>
		                                <th>Email</th>
		                                <th>Tel</th>
		                                <th>Patient</th>
		                                <th>Code</th>
		                                <th>Informations</th>
		                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_update',Auth::user())): ?>
		                                <th>Modifier</th>
		                                <?php endif; ?>
		                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_patient.delete',Auth::user())): ?>
		                                <th>Supprimer</th>
		                                <?php endif; ?>
		                            </tr>
		                        </thead>

		                        <tbody>

		                         	<?php $__currentLoopData = $comptes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $compte): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

		                            <tr>
		                            	<td><?php echo e($loop->index +1); ?></td>

										<td><?php echo e($compte->email); ?></td>

										<td><?php echo e($compte->tel); ?></td>

										<td><?php echo e($compte->name); ?></td>
										
										<td><?php echo e($compte->code); ?></td>
										
										<td>
											<a href="<?php echo e(route('send',$compte->patient_id)); ?>" onclick="return confirm('Voulez vous envoyer les Informations a: <?php echo e($compte->name); ?> ?')">
											<span class="glyphicon glyphicon-envelope" ></span></a>
										</td>
										<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_update',Auth::user())): ?>
										<td>
											<a href="#modal_compte" data-toggle="modal" data-email="<?php echo e($compte->email); ?>" data-tel="<?php echo e($compte->tel); ?>" data-id="<?php echo e($compte->id); ?>" data-target="#modal_compte"><span class="glyphicon glyphicon-edit"></span>
											</a>
										</td>
										<?php endif; ?>
										<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_patient.delete',Auth::user())): ?>
										<td>
											<form style="display: none;" method="POST" action="<?php echo e(route('compte.destroy',$compte->id)); ?>" id="delete-form-<?php echo e($compte->id); ?>">
												<?php echo e(csrf_field()); ?>

												<?php echo e(method_field('DELETE')); ?>

											</form>

											<a href="" onclick="
												if (confirm('voulez vous supprimer cette ligne ?')) {
												event.preventDefault();
												document.getElementById('delete-form-<?php echo e($compte->id); ?>').submit();										}
											"><span class="glyphicon glyphicon-trash"></span></a>
										</td>
										<?php endif; ?>

		                            </tr>

		                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

		                        </tbody>
		                    </table>

						</div>

				</div>

			</div>

		</div>

	</section>
</div>

<div class="modal" id="modal_compte" style="display: none;">
	<div class="modal-dialog modal-lg" style="width: 1200px">
		<div class="modal-content">				
			<div class="modal-header">
				<button type="button" class="close left turnOff" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<div class="row">
					<div class="col-md-9">
						<h4 class="modal-title" style="">Modifier compte</h4>
					</div>
				</div>
			</div>
			
			<div class="modal-body">
				<div class="row ">
					<form action="<?php echo e(route('compte.update','_')); ?>" method="POST">
						<?php echo e(csrf_field()); ?>

						<?php echo e(method_field('PATCH')); ?>

						<div class="col-sm-4 col-sm-offset-1">
							<label>Email* </label>
							<input type="text" name="email" id="email" class="form form-control" required>
							<input type="hidden" name="id" id="id">
						</div>
						<div class="col-sm-4 col-sm-offset-1">
							<label>Mot de passe* </label>
							<input type="password" name="password" id="password" class="form form-control" required>	
						</div>
						<div class="col-sm-4 col-sm-offset-1">
							<label>Tel* </label>
							<input type="text" name="tel" id="tel" class="form form-control" >	
						</div>			
				</div>
				<div class="modal-footer row">      
					<input type="submit" class="btn btn-primary pull-right" value="Confirmer">          
					<input type="reset" class="btn btn-default pull-left turnOff" data-dismiss="modal" value="Fermer">
				</form>		
						<!-- <input type="submit" class="btn btn-primary pull-right" value="Confirmer" > -->
					<!-- </form> -->
				</div>
			</div>			
		</div>	
	</div>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

	<script>
		$(function () {
			$('#t_biologique').DataTable();
		})
	
		$('#modal_compte').on('show.bs.modal', function(event){
			var button = $(event.relatedTarget);
			var mail = button.data('email');
			var id = button.data('id');
			var tel = button.data('tel');
			$(this).find(".modal-body #id").val(id);
	    	$(this).find(".modal-body #tel").val(tel);
	    	$(this).find(".modal-body #email").val(mail);
  		})

  		$('.flash-message').delay(3000).slideUp(200);

	</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\compte\show.blade.php ENDPATH**/ ?>