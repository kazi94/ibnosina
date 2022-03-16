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
            <div class="row text-center">
                <div class="col-sm-8 col-sm-push-2">
                    <div class="box box-info">
                        <div class="box-header with-border text-center">
                            <h2 class="box-title ">
                                <b>Consultation</b>
                            </h2>
                        </div>
                        <!-- /.box-header -->
                        <form action="<?php echo e(route('patient.create.step.two.post')); ?>" method="POST">
                            <?php echo e(csrf_field()); ?>


                            <input type="hidden" name="patient_id" value="<?php echo e(session('patient_id')); ?>">
                            <input type="hidden" name="date_rapport"
                                value="<?php echo date('Y-m-d'); ?>">

                            <div class="box-body">

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Motif de Consultation</label>
                                        <textarea class="form-control" placeholder="Motifs..." name="motif"
                                            required><?php echo e(isset($consultation->motif) ? $consultation->motif : ''); ?></textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Signes Fonctionnels</label>
                                        <select class="signes" name="signe[]" multiple="multiple">
                                            <?php
                                            $signes = DB::table('signes')->get();
                                            ?>

                                            <?php $__currentLoopData = $signes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $signe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($signe->id); ?>"><?php echo e($signe->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Début des symptômes</label>
                                        <input type="date" class="form-control" name="debut_symptome" id="debut_symptome">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Examens physiques</label>
                                        <textarea class="form-control" placeholder="Examen physiques..." name="examen"
                                            required><?php echo e(isset($consultation->examen) ? $consultation->examen : ''); ?></textarea>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <a href="<?php echo e(route('patient.create.step.one.get', ['id' => session('patient_id')])); ?>">
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
    <script>
        $(function() {
            $(".signes").select2({
                width: '100%'
            })
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\create_rapide\step_two.blade.php ENDPATH**/ ?>