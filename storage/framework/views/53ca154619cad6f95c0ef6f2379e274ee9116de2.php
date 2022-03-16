<!-- Content Header (Page header) -->
<?php if(isset($pr_risque)): ?>
    <div class="row p-1">
        <div class="col-xs-12">
            <div class="btn-group float-right">
                <button type="button" class="btn  btn-danger float-right" id="analyseBtn" data-id="<?php echo e($patient->id); ?>"
                    data-risque="<?php echo e($pr_risque); ?>">Lancer l'analyse</button>
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">

                    <li><a href="#" data-target="#prescription_details" data-toggle="modal">Détails prescription</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php endif; ?>
<section class="content-header d-md-none" id="horizontal-profil">
    <div class="row">
        <div class="col-sm-12">
            <!-- <?php $color_h = '#1c80b9'; ?>
            <?php $__currentLoopData = $patient->ReglesSuiviPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_suivie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($regle_suivie->RegleSuiviConcerne->niveau == 1): ?>
            <?php $color_h = '#fd1c1c'; ?> <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> -->
            <div class="bg-blue-gradient box no-margin" id="divUrgence">
                <div class="box-body table-responsive">
                    <table class="no-border table table-condensed text text-center text-nowrap">
                        <tr>
                            <td><b>Patient:</b> <?php echo e($patient->nom); ?> <?php echo e($patient->prenom); ?></td>
                            <td><b>Sexe:</b> <?php echo e($patient->sexe); ?></td>
                            <td>
                                <b>Taille:</b>
                                <?php if($patient->taille != ''): ?>
                                    <?php echo e($patient->taille); ?> cm
                                <?php endif; ?>
                            </td>
                            <td>
                                <b>Poids:</b> <?php echo e($patient->poids ? $patient->poids . ' Kg' : ''); ?>

                            </td>
                            <td><b>Ville:</b>
                                <?php if($patient->villes): ?>
                                    <?php echo e($patient->villes->name); ?>

                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><b>Age :</b>
                                <?php if($patient->date_naissance != ''): ?>
                                    <?php echo e(intval(date('Y/m/d', strtotime('now'))) - intval(date('Y/m/d', strtotime($patient->date_naissance)))); ?>

                                    ans
                                <?php endif; ?>
                            </td>
                            <td><b>Situation familliale:</b> <?php echo e($patient->situation_familliale); ?></td>
                            <td><b>Travaille:</b> <?php echo e($patient->travaille); ?></td>
                            <td><b>Cordonnées:</b> <?php echo e($patient->num_tel_1); ?></td>
                            <td><b>Group Sangauin:</b> <?php echo e($patient->groupe_sanguin); ?></td>
                        </tr>
                    </table>

                    <?php $var = false; ?>
                    <i></i>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.update', Auth::user())): ?>
                        <?php $__currentLoopData = $patient->ReglesSuiviPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_suivie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($regle_suivie->RegleSuiviConcerne->niveau == 1): ?>
                                <?php $var = true; ?>
                                <?php if(!$patient->readonly): ?>
                                    <button class="btn btn-primary up_patient" data-toggle="modal"
                                        data-target="#modal_modifier" data="<?php echo e($patient->id); ?>"
                                        style=" position: absolute; right: 30px; top: 15px; border: none; font-size: 12.5px;background-color: DarkRed ;">
                                        <i class="fa fa-pencil-alt" aria-hidden="true"></i></button>
                                <?php endif; ?>
                                <?php break; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php if($var == false): ?>
                            <?php if(!$patient->readonly): ?>
                                <button class="btn btn-success up_patient" data="<?php echo e($patient->id); ?>"
                                    style=" position: absolute; left: 0px; top: 0px; border: none;"> <i
                                        class="fa fa-pencil-alt" aria-hidden="true"></i></button>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if(!$patient->readonly): ?>
                            <button id="btn_ann_pat" class="btn btn-info" data-toggle="modal"
                                data-target="#modal_annotation" data-type="patient"
                                style=" position: absolute; left: 0px; top: 37px; border: none;"> <i
                                    class="fa fa-comment-medical" aria-hidden="true"></i></button>
                        <?php endif; ?>
                    <?php endif; ?>
                    <button class="switch " class="d-sm-none"
                        style="position: absolute; right: 5px; top: -1px; border: none; font-size: 30px; background-color: transparent;">-</button>
                    <button data-toggle="modal" data-target="#modal-detail-profil" class="d-md-none"
                        style="position: absolute; right: 5px; top: -1px; border: none; font-size: 30px; background-color: transparent;"><i
                            class="fa fa-plus-circle"></i></button>
                </div>

            </div>

        </div>
    </div>
</section>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\content_header.blade.php ENDPATH**/ ?>