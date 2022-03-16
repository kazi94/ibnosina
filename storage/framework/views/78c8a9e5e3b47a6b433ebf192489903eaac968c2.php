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

                        <h3 class="box-title">Modifier la règle , type : Patient</h3>

                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <div class="element" style="">
                            <form class="form-group" role="form" method="POST"
                                action="<?php echo e(route('regle.update', $regle->id)); ?>">
                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('PATCH')); ?>


                                <div class="form-group col-sm-4">
                                    <label for="">Nom de la règle</label>
                                    <input type="hidden" name="type_regle" value="patient">
                                    <input type="text" class="form-control" placeholder="Nom règle" name="regle"
                                        value="<?php echo e($regle->regle); ?>">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Type d'élément</label>
                                    <input type="text" class="form-control" placeholder="taper l'élement d'examen"
                                        name="element" value="<?php echo e($regle->element); ?>">
                                </div>

                                <div class="col-sm-8 col-sm-offset-1">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="color: red;">Valeurs normale</th>

                                            </tr>
                                        </thead>
                                        <tbody
                                            style="/* background-color: #ff00002b; */ box-shadow: 0px 3px 9px 0px #000000a6;">
                                            <tr>
                                                <th>Inférieur ou égale à : </th>
                                                <td><input type="text" class="form-control" name="inf"
                                                        value="<?php echo e($regle->inf); ?>"></td>
                                                <th class="unite">Unité</th>

                                            </tr>
                                            <tr>
                                                <th>Supèrieur ou égale à : </th>
                                                <td><input type="text" class="form-control" name="sup"
                                                        value="<?php echo e($regle->sup); ?>"></td>
                                                <th class="unite">Unité</th>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                                <?php $__currentLoopData = $regle->medicament; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $medicament): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>


                                    <div class="col-sm-4 col-sm-offset-0 float-left med_dci">
                                        <label for="Médicament">Médicament (DCI) liée :</label>
                                        <input type="hidden" name='medicament_dci_id[]'
                                            value="<?php echo e($medicament->SAC_CODE_SQ_PK); ?>">
                                        <input type="text" class="form-control" name='medicament_dci'
                                            value="<?php echo e($medicament->SAC_NOM); ?>" autocomplete="off">
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
                                    <input type="text" class="form-control" name='medicament_dci'>
                                </div>
                                <div class="col-sm-1">
                                    <label for=""> </label>
                                    <input type="button" class="btn btn-info" id="addMed" style="margin-top: 25px;"
                                        value="+">
                                </div>

                                <div class="col-sm-4 col-sm-offset-0">
                                    <label for="Classe">Classe Pharmacothérapeutique</label>
                                    <input type="hidden" name="classe_id" value="<?php echo e($regle->classe); ?>">
                                    <?php
                                        $classe = DB::select(
                                            'select cph_nom from cph_classepharmther where cph_code_pk = ?
                                                                            limit 1',
                                            [$regle->classe],
                                        );
                                        if (count($classe) > 0) {
                                            echo "<input type='text' class='form-control' name='classe'
                                                                                value='" .
                                                $classe[0]->cph_nom .
                                                "'>";
                                        }
                                    ?>
                                    <input type="text" class="form-control" name="classe">
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
    <script type="text/javascript" src="/js/admin/gestion_regle.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\regle\edit.blade.php ENDPATH**/ ?>