<?php $__env->startSection('content'); ?>

<div class="content-wrapper">

	<section class="content">

		<?php if(session()->has('message')): ?>

			<p class="alert alert-success"><?php echo e(session('message')); ?></p>

		<?php endif; ?>

		<div class="row">

			<div class="col-sm-12 ">

	      		<div class="box-header with-border">

	       			 <h2 class="box-title">Produits alimentaires</h2>

	        		<a class='col-lg-offset-5 btn btn-success' href="<?php echo e(route('produit.create')); ?>">Ajouter nouveau</a>

				</div>

				<div class="box-body">

					<?php if(count($produits) > 0): ?>
	
                    <table class="table table-responsive table-bordered table-stripped text-center dataTable" id="t_produits">

                        <thead>

                            <tr class="thead-dark">

                                <th>Produit FR</th>

                                <th>Produit Latin</th>

                                <th>Produits Arabe </th>



                                <th>Effets médicamenteux</th>

                                <th>Modifier</th>

                                <th>Supprimer</th>
                            </tr>


                        </thead>

                        <tbody>

                         	<?php $__currentLoopData = $produits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                                

                            <tr>
                                <td><?php echo e($produit->produit_naturel_fr); ?></td>

                                <td><?php echo e($produit->produit_naturel_latin); ?></td>

                                <td><?php echo e($produit->produits_arabe); ?></td>

		                        <td><a href="<?php echo e(route('produit.edit',$produit->id)); ?>">Détails</a></td>

								
								
								<td>

									<a href="<?php echo e(route('produit.edit',$produit->id)); ?>"><span class="glyphicon glyphicon-edit"></span></a>

								</td>

								<td>

									<form style="display: none;" method="POST" action="<?php echo e(route('produit.destroy',$produit->id)); ?>" id="delete-form-<?php echo e($produit->id); ?>">
										<?php echo e(csrf_field()); ?>

										<?php echo e(method_field('DELETE')); ?>

									</form>

									<a href="" onclick="
										if (confirm('voulez vous supprimer cette ligne ?')) {
										event.preventDefault();
										document.getElementById('delete-form-<?php echo e($produit->id); ?>').submit();										}
									"><span class="glyphicon glyphicon-trash"></span></a>
								</td>

                            </tr>
	                                

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

                        </tbody>

                    </table>
					
					<?php else: ?>
					<div class="container-fluid callout callout-danger">
						<h5 class="">Veuiller Ajouter un nouveau produit alimentaire !!</h5>
					</div>
					<?php endif; ?>
				</div>

			</div>

		</div>

	</section>
</div>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\regle\show.blade.php ENDPATH**/ ?>