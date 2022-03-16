<?php $__env->startSection('content'); ?>

<div class="content-wrapper">

<?php if(count($errors) > 0): ?>
  <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p class="alert alert-danger"><?php echo e($error); ?></p>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<?php if(session()->has('message')): ?>
	<p class="alert alert-danger"><?php echo e(session('message')); ?></p>
<?php endif; ?>
	<div class="row">
		
		<div class="col-md-6 col-sm-offset-2">

			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h3 class="box-title">Ajouter Compte Patient</h3>

				</div>
				<!-- /.box-header -->

				<!-- form start -->

					<div class="box-body">
						<form class="form-group" role="form" method="POST" action="<?php echo e(route('compte.store')); ?>">
							<?php echo e(csrf_field()); ?>

							<div class="col-sm-6">
								<div class="form-group">
									
									<label for="email" class="label-control"> Email* 

										<input type="email"  class="form-control" name="email" id="email"  placeholder="Ex : '@'email.com" required />

									</label>

								</div>									
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									
									<label for="password" class="label-control"> Mots de passe* 

										<input type="password"  class="form-control" name="password" id="password"  placeholder="Mots de passe" required />

									</label>

								</div>								
							</div>

			

								<div class="form-group">
									
									<label for="role" class="label-control"> Patient </label>

										<select name="patient_id" id="patient" class="form-control">
											
											<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($patient->id); ?>"><?php echo e($patient->nom); ?> <?php echo e($patient->prenom); ?></option>
											<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
										</select>

								</div>


							<button type="submit" class="btn btn-info pull-right">Ajouter</button>

						</form>

					</div>
					<!-- /.box-body -->

			</div>

		</div>
		
	</div>
	
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\compte\create.blade.php ENDPATH**/ ?>