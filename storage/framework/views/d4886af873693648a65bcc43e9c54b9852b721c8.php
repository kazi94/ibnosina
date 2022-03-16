<?php $__env->startSection('script_css'); ?>

<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
    <!-- Content Wrapper. Contains page content -->
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
        <!-- Content Header (Page header) -->
        <section class="content-header text-center">
            <h2>Ajouter un Patient </h2>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border  text-center">
                            <h3 class="box-title">
                                Rapports et détails
                            </h3>
                        </div>
                        <form class="form-horizontal" method="POST"
                            action="<?php echo e(route('patient.create.step.final.post', ['id' => session('consultation_id')])); ?>"
                            id="formReport">
                            <div class="box-body">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="patient_id" value="<?php echo e(session('patient_id')); ?>">
                                <input type="hidden" name="user_id" value="<?php echo e(Auth::user()->id); ?>">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Lettre d'Orientation</label>

                                    <div class="col-sm-9">
                                        <textarea name="orientation" cols="32" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Certificat</label>

                                    <div class="col-sm-9">
                                        <textarea name="certificat" cols="32" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Rapport</label>

                                    <div class="col-sm-9">
                                        <textarea name="compte_rendu" cols="32" rows="3"></textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-md-3">
                                    <a href="<?php echo e(route('patient.create.step.six', ['id' => session('bilan_id')])); ?>">
                                        <button type="button" class="btn btn-default pull-left"><i
                                                class="fa fa-arrow-left"></i> Précédent </button>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-file pull-right mr-1"><i
                                            class="fa fa-print mr-1"></i>Confirmer </button>
                                    <button type="button" class="btn btn-linkedin pull-right mr-1"
                                        onclick="downloadPrescription(<?php echo e(session('presc_id')); ?>)"><i
                                            class="fa fa-print mr-1"></i>Prescription </button>
                                    <button type="button" class="btn btn-success pull-right mr-1"
                                        onclick="downloadExamen(<?php echo e(session('bilan_id')); ?>)"><i
                                            class="fa fa-print mr-1"></i>Examen </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <!-- <script src="/plugins/datatables.net/pdfmake-0.1.36/pdfmake.min.js"></script>
        <script src="/plugins/datatables.net/pdfmake-0.1.36/vfs_fonts.js"></script> -->
    <script src="<?php echo e(asset('plugins/datatable-1.10.24/datatables.min.js')); ?>"></script>

    <script src="/js/print.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model-table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\create_rapide\step_final.blade.php ENDPATH**/ ?>