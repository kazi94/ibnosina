<?php $__env->startSection('content'); ?>

<div class="content-wrapper">

	<section class="content">
		
		<?php if(session()->has('message')): ?>

			<p class="alert alert-success"><?php echo e(session('message')); ?></p>
			
		<?php endif; ?>

		<div class="row">

			<div class="col-sm-12 ">
				<div class="box box-widget">
		      		<div class="box-header with-border">

		       			 <h2 class="box-title">Profiles</h2>

		        		<a class='col-lg-offset-5 btn btn-success' href="<?php echo e(route('profile.create')); ?>">Ajouter nouveau</a>

					</div>

					<div class="box-body">

						<table id="example_list_account" class="table table-responsive text-center dataTable" role="grid" aria-describedby="example3_info">
							<thead>

								<tr role="row" class="thead-dark">

									<th>Num°:</th>

									<th>Profile</th>

									<th>Modifier</th>

									<th>Supprimer</th>

								</tr>

							</thead>

							<tbody>

								<?php $__currentLoopData = $profiles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $profile): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 

									<tr>

										<td> <?php echo e($loop->index + 1); ?>  </td>

										<td> <?php echo e($profile->nom_profile); ?>    </td>


										<td><a href="<?php echo e(route('profile.edit',$profile->id)); ?>"><span class="glyphicon glyphicon-edit"></span></a></td>

										<td>
											<form style="display: none;" method="POST" action="<?php echo e(route('profile.destroy',$profile->id)); ?>" id="delete-form-<?php echo e($profile->id); ?>">
												<?php echo e(csrf_field()); ?> 
												<?php echo e(method_field('DELETE')); ?>

											</form>

											<a href="" onclick="
												if (confirm('voulez vous supprimer cette ligne ?')) {
												event.preventDefault();
												document.getElementById('delete-form-<?php echo e($profile->id); ?>').submit();										}
											"><span class="glyphicon glyphicon-trash"></span></a>
										</td>


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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\profile\show.blade.php ENDPATH**/ ?>