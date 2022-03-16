<?php $__env->startSection('script_css'); ?>

    <link rel="stylesheet" href="<?php echo e(asset('plugins/iCheck/all.css')); ?>">

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
                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class=" box-header with-border text-center">
                            <h3 class="box-title">
                                Traitements Chronique
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body" id="modalPrescriptionVille">
                            <div class="bg-success col-xs-6 form-horizontal pt-2">
                                <div class="form-group">
                                    <label for="medecin externe" class="col-sm-3 control-label">Médecin externe</label>

                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="medecin_externe"
                                            placeholder="Dr.example">
                                    </div>
                                </div>
                                <form id="addLineTraitement" action="<?php echo e(route('patient.create.step.five.post')); ?>">
                                    <?php echo e(csrf_field()); ?>

                                    <input type="hidden" name="patient_id" value="<?php echo e(session('patient_id')); ?>">
                                    <select class="" name='voie' style="display : none"></select>
                                    <select class="" name="unite" style="display : none"></select>
                                    <div class="form-group">
                                        <label for="d_analyse" class="col-sm-3 control-label">Médicament</label>

                                        <div class="col-sm-9">
                                            <input type="hidden" name="med_sp_id" />
                                            <input type="text" class="form-control"
                                                placeholder="Médicament DCI ou médicament commerciale" name="medicament_dci"
                                                autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="d_analyse" class="col-sm-3 control-label">Posologie</label>
                                        <div class="col-sm-9">
                                            <input type="text" name="dose" value="1" class="form-control"
                                                style="width: 25%; display: inline;">
                                            <input type="hidden" name="dose_matin" value="1">
                                            <input type='checkbox' class='form-control flat-green' checked
                                                onclick="this.previousSibling.value=1-this.previousSibling.value" /> Matin
                                            <input type="hidden" name="dose_midi" value="1">
                                            <input type='checkbox' class='form-control flat-green' checked
                                                onclick="this.previousSibling.value=1-this.previousSibling.value" /> Midi
                                            <input type="hidden" name="dose_soir" value="1">
                                            <input type='checkbox' class='form-control flat-green' checked
                                                onclick="this.previousSibling.value=1-this.previousSibling.value" /> Soir
                                            <input type="hidden" name="dose_avant_coucher" value="1">
                                            <input type='checkbox' class='form-control flat-green' checked
                                                onclick="this.previousSibling.value=1-this.previousSibling.value" />
                                            Av-coucher
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date de prise" class="col-sm-3 control-label">Début prise</label>

                                        <div class="col-sm-9">
                                            <input type="date" name="date_etats" class="form-control"
                                                value="<?php echo date('Y-m-d'); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date de prise" class="col-sm-3 control-label">Hopital</label>

                                        <div class="col-sm-9">
                                            <input type="hidden" name="status_hopital" value="1">
                                            <input type='checkbox' class='form-control flat-green' checked
                                                onclick="this.previousSibling.value=1-this.previousSibling.value" />

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <input type="submit" class="btn btn-success btn-block "
                                                value="Ajouter Médicament">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="bg-gray-light col-xs-6 pt-2">
                                <table class="table table-hover" id="tableTraitement">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Mes médicaments</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">

                            <a href="<?php echo e(route('patient.create.step.four', ['id' => session('presc_id')])); ?>">
                                <button type="button" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i>
                                    Précédent </button>
                            </a>
                            <button type="button" id="saveTraitement" class="btn btn-success pull-right">Suivant <i
                                    class="fa fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script src="<?php echo e(asset('plugins/iCheck/icheck.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/user/patient/gestion_prescription.js')); ?>"></script>
    <script src="<?php echo e(asset('js/user/patient/gestion_traitement_auto.js')); ?>"></script>
    <script>
        $(function() {
            $('input[type="checkbox"].flat-green').iCheck({
                checkboxClass: 'icheckbox_flat-green'
            });
        });

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\create_rapide\step_five.blade.php ENDPATH**/ ?>