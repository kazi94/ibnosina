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
                    <div class="box box-info" id="modal_hospitalisation">
                        <div class="box-header with-border  text-center">
                            <h3 class="box-title">
                                Hospitalisation
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <form action="<?php echo e(route('patient.create.step.three.post')); ?>" method="POST">
                            <?php echo e(csrf_field()); ?>

                            <input type="hidden" name="patient_id" value="<?php echo e(session('patient_id')); ?>">
                            <div class="box-body">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="service" class="col-sm-3 control-label">Service</label>

                                        <div class="col-sm-9">
                                            <select class="form form-control" name="service">
                                                <option value="Maladies infectieuses"
                                                    <?php echo e(Auth::user()->service == 'Maladies infectieuses' ? 'selected' : ''); ?>>
                                                    Maladies infectieuses</option>
                                                <option value="Pneumologie"
                                                    <?php echo e(Auth::user()->service == 'Pneumologie' ? 'selected' : ''); ?>>
                                                    Pneumologie</option>
                                                <option value="Hématologie"
                                                    <?php echo e(Auth::user()->service == 'Hématologie' ? 'selected' : ''); ?>>
                                                    Hématologie</option>
                                                <option value="Médecine Interne"
                                                    <?php echo e(Auth::user()->service == 'Médecine Interne' ? 'selected' : ''); ?>>
                                                    Médecine Interne</option>
                                                <option value="Bloc 470"
                                                    <?php echo e(Auth::user()->service == 'Bloc 470' ? 'selected' : ''); ?>>Bloc 470
                                                </option>
                                                <option value="Réanimation Covid"
                                                    <?php echo e(Auth::user()->service == 'Réanimation Covid' ? 'selected' : ''); ?>>
                                                    Réanimation Covid</option>
                                                <option value="Laboratoire de Pharmacologie"
                                                    <?php echo e(Auth::user()->service == 'Laboratoire de Pharmacologie' ? 'selected' : ''); ?>>
                                                    Laboratoire de Pharmacologie
                                                </option>
                                                <option value="Pharmacie Centrale"
                                                    <?php echo e(Auth::user()->service == 'Pharmacie Centrale' ? 'selected' : ''); ?>>
                                                    Pharmacie Centrale</option>
                                                <option value="Laboratoire de Biologie Covid"
                                                    <?php echo e(Auth::user()->service == 'Laboratoire de Biologie Covid' ? 'selected' : ''); ?>>
                                                    Laboratoire de Biologie Covid
                                                </option>
                                                <option value="Laboratoire de Microbiologie"
                                                    <?php echo e(Auth::user()->service == 'Laboratoire de Microbiologie' ? 'selected' : ''); ?>>
                                                    Laboratoire de Microbiologie
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <label class="col-sm-3 control-label">Médecin traitant :</label>

                                        <div class="col-sm-9">
                                            <select class="form-control" name="owned_by">

                                                <?php
                                                $result = DB::table('users')->where('service', Auth::user()->service
                                                )->get();
                                                ?>
                                                <option value=""></option>

                                                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($r->id); ?>"><?php echo e($r->name); ?> <?php echo e($r->prenom); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="d_analyse" class="col-sm-3 control-label">Numéro billet</label>

                                        <div class="col-sm-9">
                                            <input type="number" class="form form-control"
                                                value="<?php echo e(isset($hosp->num_biais) ? $hosp->num_biais : ''); ?>"
                                                name="numbiais" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lit" class="col-sm-3 control-label">Chambre</label>

                                        <div class="col-sm-9">
                                            <input type="number" class="form form-control"
                                                value="<?php echo e(isset($hosp->chambre) ? $hosp->chambre : ''); ?>" name="chambre" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lit" class="col-sm-3 control-label">Lit</label>

                                        <div class="col-sm-9">
                                            <input type="number" class="form form-control"
                                                value="<?php echo e(isset($hosp->lit) ? $hosp->lit : ''); ?>" name="lit" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="d_analyse" class="col-sm-3 control-label">Motif</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form form-control"
                                                value="<?php echo e(isset($hosp->motif) ? $hosp->motif : ''); ?>"
                                                placeholder="Motif d'entrée" name="motif" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="d_analyse" class="col-sm-3 control-label">Date d'entrée</label>

                                        <div class="col-sm-9">
                                            <input type="date" class="form form-control" name="date_admission"
                                                value="<?php echo e(isset($hosp->date_admission) ? $hosp->date_admission : date('Y-m-d')); ?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="<?php echo e(route('patient.create.step.two', ['id' => session('consultation_id')])); ?>">
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
    <script src="<?php echo e(asset('/js/print.js')); ?>"></script>
    <script src="<?php echo e(asset('/js/user/patient/gestion_hospitalisation.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\create_rapide\step_three.blade.php ENDPATH**/ ?>