<?php $__env->startSection('script_css'); ?>
	<link rel="stylesheet" href="<?php echo e(asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('plugins/jquery/css/jquery_ui.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<div class="content-wrapper">

	<?php if(count($errors) > 0): ?>

	<?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

	<p class="alert alert-danger"><?php echo e($error); ?></p>

	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

	<?php endif; ?>

	<div class="alert alert-danger" style="display: none;"></div>

	<?php if(session()->has('message')): ?>

	<p class="alert alert-success"><?php echo e(session('message')); ?></p>

	<?php endif; ?>

	<div class="row">
    <div class="col-md-8 col-xs-12 col-md-offset-2">
			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h1 class="box-title" aling="center">Liste des réponses envoyées</h1>

				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
				     <?php $pharmacos = DB::table('pharmacos')
                							->select('pharmacos.*')
											->where('envoye' , 'oui')
                							->get(); ?>
	                            <?php if(count($pharmacos) > 0): ?>
			                	<table class="table table-bordered text-center element " id="id1">
		                        <thead class="thead-dark">
		                            <tr>
		                                <th>Date de déclaration</th>
		                                <th>Nom de rapporteur</th>
                                        <th>prénom</th>
										<th>N° tel</th>
										<th>Adresse</th>
										<th>email</th>
										<th>détail</th>

		                            
		                        </thead>

								<tbody >
		                        		<?php $__currentLoopData = $pharmacos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pharmaco): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<tr>
                                            
				                             	<td><?php echo e($pharmaco->date_declaration_rapporteur); ?></td>
				                            	<td><?php echo e($pharmaco->nom); ?></td>
                                                <td><?php echo e($pharmaco->prenom); ?></td>
												<td><?php echo e($pharmaco->tel); ?></td>
												<td><?php echo e($pharmaco->adresse); ?></td>
												<td><?php echo e($pharmaco->email); ?></td>
												<td><a href="<?php echo e(route('pharmaco.show' ,$pharmaco->id)); ?>"><span  class="fa fa-plus-circle"></span></a></td>


				                             	 </tr>
		                        		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                        </tbody>
	                    	   </table>
							   <?php endif; ?>
                </div><!---body-->
            </div><!--box-info-->
    </div><!--offset-->
    </div><!--row-->

 </div><!--content-->
 <?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
	<script src="<?php echo e(asset('/plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js')); ?>"></script>
	<script src="<?php echo e(asset('plugins/jquery/js/jquery-ui.js')); ?>"></script> 
	<script type="text/javascript" src="<?php echo e(asset('/js/admin/gestion_regle.js')); ?>"></script>
	<script type="text/javascript">
	$('body').find('span > i').remove('i:last');
        $('#id1').dataTable();
       
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\pharm\liste2.blade.php ENDPATH**/ ?>