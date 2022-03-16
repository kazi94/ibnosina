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

			       			 <h2 class="box-title">Utilisateurs Externes</h2>
			       			<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_externe.create',Auth::user())): ?>
			        		<a class='col-lg-offset-8 btn btn-success' href="<?php echo e(route('userEx.create')); ?>">Ajouter nouveau</a>
			        		<?php endif; ?>
						</div>

						<div class="box-body">

			
		                    <table class="table table-responsive table-bordered table-stripped text-center dataTable" id="t_user">

		                        <thead>
		                            <tr class="thead-dark">
		                                <th>Num°</th>
		                                <th>Utilisateur</th>
		                                <th>Email</th>
		                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_externe.update',Auth::user())): ?>
		                                <th>Modifier</th>
		                                <?php endif; ?>
		                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_externe.delete',Auth::user())): ?>
		                                <th>Supprimer</th>
		                                <?php endif; ?>
		                            </tr>
		                        </thead>

		                        <tbody>

		                         	<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

		                            <tr>
		                            	<td><?php echo e($loop->index +1); ?></td>

		                                <td><?php echo e($user->nom); ?> <?php echo e($user->prenom); ?></td>

		                                <td><?php echo e($user->email); ?></td>
		                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_externe.update',Auth::user())): ?>
										<td>
											<a href="#modal_userEx" data-toggle="modal" data-email="<?php echo e($user->email); ?>" data-id="<?php echo e($user->id); ?>" data-target="#modal_userEx"><span class="glyphicon glyphicon-edit">
											</a>
										</td>
										<?php endif; ?>
										<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('compte_externe.delete',Auth::user())): ?>
										<td>
											<form style="display: none;" method="POST" action="<?php echo e(route('userEx.destroy',$user->id)); ?>" id="delete-form-<?php echo e($user->id); ?>">
												<?php echo e(csrf_field()); ?>

												<?php echo e(method_field('DELETE')); ?>

											</form>

											<a href="" onclick="
												if (confirm('voulez vous supprimer cette ligne ?')) {
												event.preventDefault();
												document.getElementById('delete-form-<?php echo e($user->id); ?>').submit();										}
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

<div class="modal" id="modal_userEx" style="display: none;">
	<div class="modal-dialog modal-lg" style="width: 1200px">
		<div class="modal-content">				
			<div class="modal-header">
				<button type="button" class="close left turnOff" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<div class="row">
					<div class="col-md-9">
						<h4 class="modal-title" style="">Modifier utilisateur</h4>
					</div>
				</div>
			</div>
			
			<div class="modal-body">
				<div class="row ">
					<form action="<?php echo e(route('userEx.update','_')); ?>" method="POST">
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

        $('#modal_userEx').on('show.bs.modal', function(event){
			var button = $(event.relatedTarget);
			var mail = button.data('email');
			var id = button.data('id');
			$(this).find(".modal-body #id").val(id);
	    	$(this).find(".modal-body #email").val(mail);
  		})
    		$('.flash-message').delay(2000).slideUp(200);

        </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\userEx\show.blade.php ENDPATH**/ ?>