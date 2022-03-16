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
                                Prescription d'Examen
                            </h3>
                        </div>

                        <!-- /.box-header -->
                        <form action="<?php echo e(route('patient.create.step.six.post')); ?>" method="POST" class="form-horizontal">
                            <div class="box-body" id="modal_demande_examen">
                                <?php echo e(csrf_field()); ?>

                                <input type="hidden" name="patient_id" value="<?php echo e(session('patient_id')); ?>">
                                <input type="hidden" name="consultation_id" value="<?php echo e(session('consultation_id')); ?>">
                                <input type="hidden" name="date_prescription"
                                    value="<?php echo date('Y-m-d'); ?>">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Type d'examen</label>

                                    <div class="col-sm-9">
                                        <select name="type" id="type_examen" class="form form-control"
                                            onchange="$(this).val() == 'bilan' ? $(' #bilan').show() : $(' #bilan').hide();">
                                            <option value="">Sélectionner le type d'examen</option>
                                            <option value="bilan">Biologique</option>
                                            <option value="radio">Imagerie</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="bilan" style="display: none;">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Prescription type</label>

                                        <div class="col-sm-9">
                                            <select id="examens_type" class="form-control">
                                                <option value="">Sélectionner l'examen type</option>
                                                <?php $__currentLoopData = Auth::user()->examensType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Type de bilan</label>

                                        <div class="col-sm-9">
                                            <select id="type_bilan" class="form form-control">
                                                <option value="">Sélectionner le Bilan</option>
                                                <?php $__currentLoopData = $bilans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bilan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($bilan->bilan); ?>"><?php echo e($bilan->bilan); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Eléments</label>

                                        <div class="col-sm-9" id="elements">
                                            <table>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Note</label>

                                        <div class="col-sm-9">
                                            <textarea name="note" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="<?php echo e(route('patient.create.step.five', ['id' => session('trait_ids')])); ?>">
                                    <button type="button" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i>
                                        Précédent </button>
                                </a>
                                <button type="submit" class="btn btn-success pull-right">Suivant <i
                                        class="fa fa-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('js/user/patient/gestion_bilan.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\create_rapide\step_six.blade.php ENDPATH**/ ?>