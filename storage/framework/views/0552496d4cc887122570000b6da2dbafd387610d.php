<!--tab prescription -->
<div class="tab-pane <?php echo e(session('tab') == 'tab_2' ? 'active in' : ''); ?>" id="tab_2">


    <div class="clearfix">

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wheelchair"></i> patient</a></li>
            <li class="active">Prescription Service</li>
        </ol>

        <a href="#modal">
            <?php if(!$patient->readonly): ?>
                <button type="button" id="prescrBtn" class="btn btn-primary float-left" title="Raccourci(m)"
                    data-toggle="modal" data-target="#modal_prescription">Ajouter une prescription</button>

            <?php endif; ?>
        </a>

    </div>

    <!--box Prescriptions en attente d'envoie-->
    <?php if(count($patient->prescriptions)): ?>

        <div class="box box-widget">

            <div class="box-body">

                <div class="">
                    <div class="col-sm-12 table-responsive">
                        <h3>Prescriptions en attente d'envoie</h3>

                        <table id="example127" class="table table-bordered table-hover nowrap">
                            <thead>
                                <tr class="bg-blue">
                                    <th class="text-center">Num°:</th>
                                    <th class="text-center">Date Prescription</th>
                                    <th class="text-center">Prescripteur</th>
                                    <th class="text-center">Détails</th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.print', Auth::user())): ?>
                                        <th class="text-center">Imprimer</th>
                                    <?php endif; ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.update', Auth::user())): ?>
                                        <?php if(!$patient->readonly): ?>
                                            <th class="text-center">Modifier</th>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    <th class="text-center">Envoyer</th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.delete', Auth::user())): ?>
                                        <?php if(!$patient->readonly): ?>

                                            <th class="text-center">Supprimer</th>
                                        <?php endif; ?>

                                    <?php endif; ?>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $patient->prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                    <tr class="text-center">
                                        <td> <?php echo e($prescription->id); ?> </td>
                                        <td> <?php echo e($prescription->date_prescription); ?> </td>
                                        <td> Dr.<?php echo e($prescription->prescripteur->name); ?>

                                            <?php echo e($prescription->prescripteur->prenom); ?>

                                        </td>
                                        <td>
                                            <a href="#detail-prescription" class="detailPrescription"
                                                title="Détails de la prescription" data-toggle="modal"
                                                data-target="#modal_detail_prescription"
                                                data-id="<?php echo e($prescription->id); ?>">
                                                <i class="fa fa-plus-circle fa-2x"></i>
                                            </a>
                                        </td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.print', Auth::user())): ?>
                                            <td>
                                                <a href="#" onclick="downloadPrescription(<?php echo e($prescription->id); ?>)">
                                                    <i style="cursor: pointer;" class="fa fa-print fa-2x"></i>
                                                </a>
                                            </td>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.update', Auth::user())): ?>
                                            <?php if(!$patient->readonly): ?>
                                                <td>
                                                    <a href="#modifierPrescription" class="editPrescription"
                                                        title="Modifier la Prescription" data-toggle="modal"
                                                        data-target="#modal_prescription"
                                                        data-id="<?php echo e($prescription->id); ?>">
                                                        <i class="fa fa-edit text-green fa-2x"></i>
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <td>
                                            <a href="/patient/<?php echo e($patient->id); ?>/pre_analyser/<?php echo e($prescription->id); ?>"
                                                title="Envoyé au Pharmacien pour analyse">
                                                <i class="fa fa-envelope-open fa-2x text-warning"></i>
                                            </a>
                                        </td>
                                        <!-- <button id="btn_ann_pres" class="btn btn-default" data-toggle="modal" data-target="#modal_annotation" data-type="prescription" data-id="<?php echo e($prescription->id); ?>" style="border-radius: 50%;background: #34c5d6;">
                                            <i class="fa fa-comment-medical fa-2x"></i>
                                        </button> -->
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.delete', Auth::user())): ?>
                                            <?php if(!$patient->readonly): ?>
                                                <td>
                                                    <a href="" class="deleteRow"
                                                        data-url="<?php echo e(route('prescription.destroy', $prescription->id)); ?>"
                                                        style="color: inherit; cursor: pointer;"><span
                                                            class="fa fa-trash text-red fa-2x"></span>
                                                    </a>
                                                </td>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>
    <!--End box Prescriptions en attente d'evoie-->

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.inject', Auth::user())): ?>
        <!--Prescription en attente d'administration-->
        <?php if(count($patient->prescriptionsDesc)): ?>
            <div class="box box-widget">

                <div class="box-body">

                    <div class="">
                        <div class="col-sm-12 table-responsive">
                            <h3>Prescriptions En cours d'administration</h3>
                            <table id="table_injections" class="nowrap table table-bordered table-hover text-center"
                                style="width:100%">
                                <thead>
                                    <tr class="bg-blue ">
                                        <th></th>
                                        <th class="text-center">Num°:</th>
                                        <th class="text-center">Date de Prescription</th>
                                        <th class="text-center">Historique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $patient->prescriptionsDesc; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(date('Y-m-d') <= $prescription->lastDate): ?>
                                            <tr>
                                                <td>
                                                    <a data-toggle="collapse" href="#a<?php echo e($loop->index + 1); ?>"
                                                        class="text-green"><i class="fa fa-plus fa-2x"></i></a>
                                                </td>
                                                <td> <?php echo e($prescription->id); ?> </td>
                                                <td> <?php echo e($prescription->date_prescription); ?> </td>
                                                <td>
                                                    <button class="btn btn-info" data-toggle="modal"
                                                        data-target="#modal_administrations"
                                                        data-id="<?php echo e($prescription->id); ?>"><i
                                                            class="fa fa-calendar mr-1"></i>
                                                        Administrations</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td colspan="4" style="padding: 0 !important;">
                                                    <div id="a<?php echo e($loop->index + 1); ?>" class="accordian-body collapse">
                                                        <table class="table table-bordered table-condensed">
                                                            <thead>
                                                                <tr class="bg-gray">
                                                                    <th>Num</th>
                                                                    <th>Médicament (DCI)</th>
                                                                    <th>Voie</th>
                                                                    <th>Matin</th>
                                                                    <th>Midi</th>
                                                                    <th>Soir</th>
                                                                    <th>Avant coucher</th>
                                                                    <th>Unité</th>
                                                                    <th>J Restants </th>
                                                                    <th>Administrer </th>
                                                                    <th>Stoppée </th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php $__currentLoopData = $prescription->lignes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr <?php if($ligne->stopped): ?> style='color: gray; pointer-events: none; ' <?php endif; ?>>
                                                                        <th> <?php echo e($loop->index + 1); ?> </th>

                                                                        <th style="text-align: left">
                                                                            <?php
                                                                                $resultats = DB::table('cosac_compo_subact')
                                                                                    ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                                                    ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                                                    ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $ligne->med_sp_id)
                                                                                    ->get();
                                                                                foreach ($resultats as $key => $resultat) {
                                                                                    echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                                                                }
                                                                            ?>
                                                                        </th>
                                                                        <td> <?php echo e($ligne->voie); ?> </td>
                                                                        <td> <?php echo e($ligne->dose_matin ? $ligne->dose_mat . $ligne->repas_matin : ''); ?>

                                                                        </td>
                                                                        <td> <?php echo e($ligne->dose_midi ? $ligne->dose_mid . $ligne->repas_midi : ''); ?>

                                                                        </td>
                                                                        <td> <?php echo e($ligne->dose_soir ? $ligne->dose_soi . $ligne->repas_soir : ''); ?>

                                                                        </td>
                                                                        <td> <?php echo e($ligne->dose_avant_coucher ? $ligne->dose_ac : ''); ?>

                                                                        </td>
                                                                        <td> <?php echo e($ligne->unite); ?> </td>
                                                                        <td> -<?php echo e($ligne->nbr_jours - $ligne->jours_restant); ?>j
                                                                        </td>
                                                                        <td class="text-nowrap">
                                                                            <?php if(!$ligne->stopped): ?>
                                                                                <?php
                                                                                    $injections = $ligne->load([
                                                                                        'todayInjections' => function ($query) use ($ligne) {
                                                                                            $query->orWhere('day_j', $ligne->nbr_jours)->get();
                                                                                        },
                                                                                    ]);
                                                                                    $injections = $injections->todayInjections;
                                                                                ?>
                                                                                <?php if($ligne->dose_matin): ?>

                                                                                    <input type="hidden" name="injected"
                                                                                        data-id="<?php echo e($ligne->id); ?>"
                                                                                        data-prise="matin" value="0">
                                                                                    <?php
                                                                                        $state = '';
                                                                                        foreach ($injections as $injectedLine) {
                                                                                            if ($injectedLine->prise == 'matin') {
                                                                                                $state = 'checked disabled';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <input type='checkbox' name="injected"
                                                                                        class='form-control flat-green'
                                                                                        <?php echo e($state); ?>

                                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />

                                                                                <?php endif; ?>
                                                                                <?php if($ligne->dose_midi): ?>
                                                                                    <input type="hidden" name="injected"
                                                                                        data-id="<?php echo e($ligne->id); ?>"
                                                                                        data-prise="midi" value="0">
                                                                                    <?php
                                                                                        $state = '';
                                                                                        foreach ($injections as $injectedLine) {
                                                                                            if ($injectedLine->prise == 'midi') {
                                                                                                $state = 'checked disabled';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <input type='checkbox' name="injected"
                                                                                        class='form-control flat-green'
                                                                                        <?php echo e($state); ?>

                                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />

                                                                                <?php endif; ?>

                                                                                <?php if($ligne->dose_soir): ?>
                                                                                    <input type="hidden" name="injected"
                                                                                        data-id="<?php echo e($ligne->id); ?>"
                                                                                        data-prise="soir" value="0">
                                                                                    <?php
                                                                                        $state = '';
                                                                                        foreach ($injections as $injectedLine) {
                                                                                            if ($injectedLine->prise == 'soir') {
                                                                                                $state = 'checked disabled';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <input type='checkbox' name="injected"
                                                                                        <?php echo e($state); ?>

                                                                                        class='form-control flat-green'
                                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />
                                                                                <?php endif; ?>

                                                                                <?php if($ligne->dose_avant_coucher): ?>

                                                                                    <input type="hidden" name="injected"
                                                                                        data-id="<?php echo e($ligne->id); ?>"
                                                                                        data-prise="coucher" value="0">
                                                                                    <?php
                                                                                        $state = '';
                                                                                        foreach ($injections as $injectedLine) {
                                                                                            if ($injectedLine->prise == 'coucher') {
                                                                                                $state = 'checked disabled';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    ?>
                                                                                    <input type='checkbox' name="injected"
                                                                                        class='form-control flat-green'
                                                                                        <?php echo e($state); ?>

                                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />

                                                                                <?php endif; ?>

                                                                            <?php endif; ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php if(!$ligne->stopped): ?>
                                                                                <button class="btn btn-danger stopInjection"
                                                                                    data-id="<?php echo e($ligne->id); ?>"><i
                                                                                        class="fa fa-hand-o"></i>Stop</button>
                                                                            <?php else: ?>
                                                                                Arrétée le <?php echo date('d-m-Y', strtotime($ligne->stopped_at)); ?>

                                                                                (<?php echo e($ligne->comment); ?>)
                                                                            <?php endif; ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <!--box Prescription à Administrer-->
    <?php if(count($patient->prescriptionsRetroInvalide)): ?>
        <div class="box box-widget">

            <div class="box-header">
                <h3>Liste des Prescriptions</h3>
            </div>

            <div class="box-body">
                <div class="col-sm-12 table-responsive">
                    <table id="hist_presc" class="table table-bordered table-hover nowrap">
                        <thead>
                            <tr class="bg-blue">
                                <th class="text-center">Num°:</th>
                                <th class="text-center">Date Prescription</th>
                                <th class="text-center">Etats</th>
                                <th class="text-center">Prescripteur</th>
                                <th class="text-center">Détails</th>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.print', Auth::user())): ?>
                                    <th class="text-center">Imprimer</th>
                                <?php endif; ?>
                                <th class="text-center">Modifier</th>
                                <th class="text-center">Supprimer</th>
                                <?php if(!$patient->readonly): ?>
                                    <th>Annotation</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>

                            <?php $__currentLoopData = $patient->prescriptionsRetroInvalide; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <tr class="text-center">
                                    <td> <?php echo e($prescription->id); ?> </td>
                                    <td> <?php echo e($prescription->date_prescription); ?> </td>
                                    <td>
                                        <?php if($prescription->etats == 'risque'): ?> <span
                                                class="badge bg-red">Prescription à analyser par le Pharmacien</span>
                                        <?php endif; ?>
                                        <!-- <?php if($prescription->etats == 'done'): ?> <span class="badge bg-blue">Validée </span> <?php endif; ?> -->
                                        <?php if($prescription->etats == 'in progress'): ?>
                                            <span class="badge bg-orange">En cours de validation par le Médecin</span>
                                        <?php endif; ?>
                                        <?php if($prescription->etats == 'prescription'): ?>
                                            <span class="badge bg-green">Prescription dispensée du service</span>
                                        <?php endif; ?>
                                        <?php if($prescription->etats == 'invalide'): ?> <span
                                                class="badge bg-aqua">Validée</span><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo e($prescription->prescripteur->name); ?>

                                        <?php echo e($prescription->prescripteur->prenom); ?>

                                    </td>
                                    <td>
                                        <a href="#detail-prescription" class="detailPrescription"
                                            title="Détails de la prescription" data-toggle="modal"
                                            data-target="#modal_detail_prescription"
                                            data-id="<?php echo e($prescription->id); ?>">
                                            <i class="fa fa-plus-circle fa-2x"></i>
                                        </a>
                                    </td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.print', Auth::user())): ?>
                                        <td>
                                            <a href="#" onclick="downloadPrescription(<?php echo e($prescription->id); ?>)"><i
                                                    style="cursor: pointer;" class="fa fa-print fa-2x"
                                                    title="Imprimer"></i></a>
                                        </td>
                                    <?php endif; ?>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.update', Auth::user())): ?>
                                            <?php if(!$patient->readonly): ?>
                                                <a href="" class="editPrescription" title="Modifier la Prescription"
                                                    data-toggle="modal" data-target="#modal_prescription"
                                                    style="color: inherit; cursor: pointer;"
                                                    data-id="<?php echo e($prescription->id); ?>"><span
                                                        class="fa fa-edit fa-2x text-green"></span></a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('prescriptions.delete', Auth::user())): ?>
                                            <?php if(!$patient->readonly): ?>
                                                <a href="" class="deleteRow"
                                                    data-url="<?php echo e(route('prescription.destroy', $prescription->id)); ?>"
                                                    style="color: inherit; cursor: pointer;"><span
                                                        class="fa fa-trash fa-2x text-red"></span>
                                                </a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </td>
                                    <?php if(!$patient->readonly): ?>
                                        <td>

                                            <a href="#" id="btn_ann_con" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="prescription"
                                                data-id="<?php echo e($prescription->id); ?>">
                                                <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    <?php endif; ?>

</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views/user/patient/tabs/prescription.blade.php ENDPATH**/ ?>