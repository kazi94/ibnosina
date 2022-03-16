<?php $__env->startSection('script_css'); ?>

<?php $__env->startSection('title'); ?>
    Mes Demandes d'Examens
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/home"><i class="fa fa-home"></i> Acceuil</a></li>
                <li class="active">Mes Demandes d'examens</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <?php if(session()->has('message')): ?>
            <p style="display: none;" id="message"><?php echo e(session('message')); ?></p>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12 ">
                <div class="box box-widget">

                    <div class="box-body">

                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <h3>Demandes d'Examens

                                    <?php if(count($result)): ?>
                                        <span class="badge bg-red mb-1">
                                            <?php echo e(count($result)); ?>

                                        </span>

                                    <?php endif; ?>
                                </h3>

                                <table id="demandes_table"
                                    class="nowrap table  table-hover table-bordered table-condensed">
                                    <thead class="bg-gray">
                                        <tr>
                                            <th>#</th>
                                            <th>Patient</th>
                                            <th>Service</th>
                                            <th>Prescripiteur</th>
                                            <th>Date de prescription</th>
                                            <th>Type de demande</th>
                                            <th>Note</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $demande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1); ?></td>
                                                <td><?php echo e($demande->patient->nom); ?>

                                                    <?php echo e($demande->patient->prenom); ?>

                                                </td>
                                                <td><?php echo e($demande->patient->hospi ? $demande->patient->hospi->service : ''); ?>

                                                </td>
                                                <td>Dr.<?php echo e($demande->prescripteur->name); ?>

                                                    <?php echo e($demande->prescripteur->prenom); ?>

                                                </td>
                                                <td><?php echo e($demande->date_prescription); ?></td>
                                                <td><?php echo $demande->type == 'radio'
    ? 'Examen Radiologique'
    : 'Examen
                                                    Biologique'; ?></td>
                                                <td><?php echo e($demande->note); ?></td>
                                                <td>
                                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('analyses_biologique.executeRequest', Auth::user())): ?>
                                                        <button class="btn btn-primary remplir" data-toggle="modal"
                                                            data-target="#modal_biologique"
                                                            data-id="<?php echo e($demande->id); ?>">Remplir</button>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 ">
                <div class="box box-widget">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <h3>Historique des demandes d'examens faites</h3>
                                <table id="demandes_table_history" class="nowrap table  table-hover table-bordered">
                                    <thead class="bg-gray">
                                        <tr>
                                            <th>#</th>
                                            <th>Patient</th>
                                            <th>Service</th>
                                            <th>Prescripiteur</th>
                                            <th>Date de prescription</th>
                                            <th>Type de demande</th>
                                            <th>Note</th>
                                            <th>Status</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $demande): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->index + 1); ?></td>
                                                <td><?php echo e($demande->patient->nom); ?>

                                                    <?php echo e($demande->patient->prenom); ?>

                                                </td>
                                                <td><?php echo e($demande->patient->hospi ? $demande->patient->hospi->service : ''); ?>

                                                </td>
                                                <td>Dr.<?php echo e($demande->prescripteur->name); ?>

                                                    <?php echo e($demande->prescripteur->prenom); ?>

                                                </td>
                                                <td><?php echo e($demande->date_prescription); ?></td>
                                                <td><?php echo $demande->type == 'radio'
    ? 'Examen Radiologique'
    : 'Examen
                                                    Biologique'; ?></td>
                                                <td><?php echo e($demande->note); ?></td>
                                                <td>
                                                    <span class="label label-success"> Faite le
                                                        <?php echo e(date('Y-m-d', strtotime($demande->updated_at))); ?>

                                                    </span>
                                                </td>
                                                
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
    </section>
</div>


<?php echo $__env->make('includes.modals.prescription-examen', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('plugins/jquery/js/jquery.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/adminlte2/js/adminlte.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/datatable-1.10.24/datatables.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/iCheck/icheck.min.js')); ?>"></script>
<script src="<?php echo e(asset('plugins/select2/dist/js/select2.full.min.js')); ?>"></script>
<script src="<?php echo e(asset('js/user/patient/gestion_bilan.js')); ?>"></script>
<script>
    $("#demandes_table").DataTable();
    $("#demandes_table_history").DataTable();
    $('input[type="checkbox"].flat-green').iCheck({
        checkboxClass: 'icheckbox_flat-green'
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model-table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\examen\show.blade.php ENDPATH**/ ?>