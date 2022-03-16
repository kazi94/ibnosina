<?php $__env->startSection('script_css'); ?>
<?php $__env->startSection('title'); ?>
    Mes Prescriptions à Analyser
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
    <section class="content-header">
        <div class="clearfix">
            <ol class="breadcrumb">
                <li><a href="<?php echo e(route('home')); ?>"><i class="fa fa-home"></i> Acceuil</a></li>
                <li><a href="<?php echo e(route('pharmacie.index')); ?>"><i class="fa fa-clinic-medical"></i> Mon Armoire
                        Pharmaceutique</a></li>
                <li class="active">Prescriptions à Analyser</li>
            </ol>
        </div>
        <h2 class="box-title">Prescriptions à Analyser</h2>
    </section>
    <section class="content">
        <?php if(session()->has('message')): ?>
            <p class="alert alert-success" id="message" style="display: none;"><?php echo e(session('message')); ?></p>
        <?php endif; ?>
        <div class="row">
            <div class="col-sm-12 ">
                <div class="box box-info">


                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center table-hover" id="tabfaire">

                                <thead>
                                    <tr class="bg-gray">
                                        <th>Num Prescription</th>
                                        <th>Patient</th>
                                        <th>Médecin prescripteur</th>
                                        <th>Service</th>
                                        <th>Chambre</th>
                                        <th>lit</th>
                                        <th>Date Prescription</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                        <?php $__currentLoopData = $patient->prescriptionsRisquePharma; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pr_risque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <?php echo e($pr_risque->id); ?>


                                                </td>
                                                <td>
                                                    <?php echo e($patient->nom); ?> <?php echo e($patient->prenom); ?>

                                                </td>
                                                <td>
                                                    <?php echo e($pr_risque->prescripteur->name); ?>

                                                    <?php echo e($pr_risque->prescripteur->prenom); ?>

                                                </td>
                                                <td>
                                                    <?php if(isset($patient->hospi->service)): ?>
                                                        <?php echo e($patient->hospi->service); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if(isset($patient->hospi->chambre)): ?>
                                                        <?php echo e($patient->hospi->chambre); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if(isset($patient->hospi->lit)): ?>
                                                        <?php echo e($patient->hospi->lit); ?>

                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php echo e($pr_risque->date_prescription); ?>

                                                </td>
                                                <td>
                                                    <a
                                                        href="<?php echo e(route('patient.intervenir', [$patient->id, $pr_risque->id])); ?>">
                                                        <button class="btn btn-success">Intervenir <i
                                                                class="fa fa-arrow-right"></i></button>
                                                    </a>
                                                </td>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('plugins/jquery/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/adminlte2/js/adminlte.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatable-1.10.24/datatables.min.js')); ?>"></script>
<script type="text/javascript">
    $("#tabfaire").DataTable({
        "order": [
            [6, "desc"]
        ]
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model-table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views/user/pharmacien/intervention/show.blade.php ENDPATH**/ ?>