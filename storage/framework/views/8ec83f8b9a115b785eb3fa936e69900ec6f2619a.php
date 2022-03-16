<?php $__env->startSection('script_css'); ?>
    <link rel="stylesheet" href="plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css">
    <link rel="stylesheet" href="plugins/jquery/css/jquery_ui.css">
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

                        <h3 class="box-title">Modifier Médicament spécialité</h3>

                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <div class="element" style="">
                            <form class="form-group" role="form" method="POST"
                                action="<?php echo e(route('specialite.update', $sp[0]->SP_CODE_SQ_PK)); ?>">
                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('PATCH')); ?>


                                <div class="form-group col-sm-4">
                                    <label for="">Médicament spécialité*</label>
                                    <input type="hidden" class="form-control" placeholder="taper le médicament spécialité"
                                        name="sp_id" value="<?php echo e($sp[0]->SP_CODE_SQ_PK); ?>" required>
                                    <input type="text" class="form-control" placeholder="taper le médicament spécialité"
                                        name="sp_nom" value="<?php echo e($sp[0]->SP_NOM); ?>" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Voie</label>
                                    <select name="voie" class="form-control">
                                        <?php
                                            $voies = DB::table('voies')
                                                ->select('voies.*')
                                                ->distinct()
                                                ->orderBy('cdf_nom', 'ASC')
                                                ->get();
                                            
                                        ?>
                                        <?php $__currentLoopData = $voies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $voie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($voie->CDF_CODE_PK); ?>" <?php if($voie->CDF_CODE_PK == $sp[0]->SPVO_CDF_VO_CODE_FK_PK): ?> selected
                                                     <?php endif; ?>><?php echo e($voie->CDF_NOM); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Unité</label>
                                    <select name="unite" class="form-control">
                                        <?php
                                            $unites = DB::table('unites')
                                                ->select('unites.*')
                                                ->distinct()
                                                ->orderBy('unite_nom', 'asc')
                                                ->get();
                                        ?>
                                        <?php $__currentLoopData = $unites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($unite->id); ?>" <?php if($unite->id == $sp[0]->PRE_CDF_UP_CODE_FK): ?> selected <?php endif; ?>><?php echo e($unite->unite_nom); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                                <?php
                                    $resultats = DB::table('cosac_compo_subact')
                                        ->join('sac_subactive', 'sac_subactive.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                        ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $sp[0]->SP_CODE_SQ_PK)
                                        ->get();
                                ?>
                                <?php $__currentLoopData = $resultats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <div class="col-sm-4 col-sm-offset-0 float-left med_dci">
                                        <label for="Médicament">Médicament (DCI) liée :</label>
                                        <input type="hidden" name='medicament_dci_id[]'
                                            value="<?php echo e($val->SAC_CODE_SQ_PK); ?>">
                                        <input type="text" class="form-control" name='medicament_dci'
                                            value="<?php echo e($val->SAC_NOM); ?>" autocomplete="off">
                                    </div>

                                    <div class="col-sm-1">
                                        <label for=""> </label>
                                        <i class="fa fa-times-circle"
                                            style="color:red;cursor : pointer; margin-top:30px;"></i>

                                    </div>

                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <div class="col-sm-4 col-sm-offset-0 float-left med_dci">
                                    <label for="Médicament">Médicament (DCI) liée :</label>
                                    <input type="hidden" name='medicament_dci_id[]'>
                                    <input type="text" class="form-control" name='medicament_dci' autocomplete="off">
                                </div>
                                <div class="col-sm-1">
                                    <label for=""> </label>
                                    <input type="button" class="btn btn-info" id="addMed" style="margin-top: 25px;"
                                        value="+">
                                </div>


                        </div>
                        <div class="col-sm-12 col-sm-offset-9">
                            <input type="submit" value="Modifier" class="btn btn-primary" />
                        </div>
                        </form>
                    </div>

                </div><!-- /.box-body -->

            </div>

        </div>

    </div>


    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/jquery/js/jquery-ui.js')); ?>"></script>
    <script src="<?php echo e(asset('js/admin/gestion_regle.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\specialite\edit.blade.php ENDPATH**/ ?>