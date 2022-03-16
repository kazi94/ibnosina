<!--tab Automédication-->
<div class="tab-pane <?php echo e(session('tab') == 'tab_5' ? 'active in' : ''); ?>" id="tab_5">
    <div class="clearfix">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wheelchair"></i> patient</a></li>
            <li><a href="#">médicaments</a></li>
            <li class="active">Automédication</li>
        </ol>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('automedications.create', Auth::user())): ?>
            <?php if(!$patient->readonly): ?>
                <button type="button" class="btn btn-primary float-left"
                    onclick='$("#modalPrescriptionVille form").attr("action", "<?php echo e(route('automedication.store')); ?>");'
                    data-toggle="modal" data-target="#modalPrescriptionVille" title="Raccourci(t)">Ajouter
                    médicament(s)</button>
            <?php endif; ?>
        <?php endif; ?>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('automedications.export', Auth::user())): ?>
            <a href="/export/auto/<?php echo e($patient->id); ?>"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        <?php endif; ?>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('automedications.view', Auth::user())): ?>
        <div class="box box-widget">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-body">
                            <table id="example6" class=" table table-bordered table-hover text-center table-condensed">
                                <thead class="text-nowrap" style="background-color: #00a65a !important; color:white">
                                    <tr>
                                        <th class="text-center">Num°:</th>
                                        <th class="text-center">Médicament</th>
                                        <th class="text-center">Médecin externe</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Date de prise</th>
                                        <th class="text-center">Mettre à jour</th>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('automedications.update', Auth::user())): ?>
                                            <?php if(!$patient->readonly): ?>
                                                <th class="text-center">Modifier</th>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('automedications.delete', Auth::user())): ?>
                                            <?php if(!$patient->readonly): ?>

                                                <th class="text-center">Supprimer</th>
                                            <?php endif; ?>

                                        <?php endif; ?>
                                        <th>Annotation</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $patient->autos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td> <?php echo e($loop->index + 1); ?></td>
                                            <td style="text-align: left">
                                                <?php
                                                    $medicament = '';
                                                    $resultats = DB::table('cosac_compo_subact')
                                                        ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                        ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                        ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $ligne->med_sp_id)
                                                        ->get();
                                                    foreach ($resultats as $key => $resultat) {
                                                        $medicament .= $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                                    }
                                                ?>

                                                <b> <?php echo e($medicament); ?> </b> <?php echo e($ligne->voie); ?>.
                                                <?php echo $ligne->dose_matin != 0 ? $ligne->dose_matin . ' <b>' .
                                                    strtolower($ligne->unite) . '</b> le <b class="text-info">Matin</b>, ' :
                                                ''; ?>

                                                <?php echo $ligne->dose_midi != 0
                                                ? $ligne->dose_midi .
                                                ' à <b class="text-green">Midi</b>, '
                                                : ''; ?>

                                                <?php echo $ligne->dose_soir != 0
                                                ? $ligne->dose_soir .
                                                ' le <b class="text-yellow">Soir</b>, '
                                                : ''; ?>

                                                <?php echo $ligne->dose_avant_coucher != 0
                                                ? $ligne->dose_avant_coucher .
                                                ' <b class="text-red">Avant-coucher</b>'
                                                : ''; ?>.
                                            </td>

                                            <td><?php echo e($ligne->medecin_externe ? 'Dr.' . $ligne->medecin_externe : '-'); ?>

                                            </td>
                                            <td>
                                                <?php if($ligne->etats == 'En cours' || $ligne->etats == 'Reprise'): ?>
                                                    <span class="label label-success text-sm"><?php echo e($ligne->etats); ?> </span>
                                                <?php else: ?>
                                                    <span class="label label-danger text-sm"><?php echo e($ligne->etats); ?></span>
                                                <?php endif; ?>
                                            </td>

                                            <td> <?php echo e($ligne->date_etats); ?> </td>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('traitements_chronique.update', Auth::user())): ?>
                                                <?php if(!$patient->readonly): ?>
                                                    <td>
                                                        <a href="#mise-a-jour" class="updateTraitAuto" data-type="auto"
                                                            data-dci="<?php echo e($ligne->med_sp_id); ?>"
                                                            data-id="<?php echo e($ligne->id); ?>"><i
                                                                class="fa fa-sync text-info fa-2x"></i></a>

                                                    </td>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('traitements_chronique.update', Auth::user())): ?>
                                                <?php if(!$patient->readonly): ?>
                                                    <td>
                                                        <a href="javascript:void(0)" class="editPrescriptionVille"
                                                            data-type="trait" data-id="<?php echo e($ligne->id); ?>"><i
                                                                class="fa fa-edit text-green fa-2x"></i></a>

                                                    </td>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('traitements_chronique.delete', Auth::user())): ?>
                                                <?php if(!$patient->readonly): ?>
                                                    <td>
                                                        <a href="javascript:void(0)" class="deleteRow"
                                                            data-url="<?php echo e(route('automedication.destroy', $ligne->automedication_id)); ?>"><span
                                                                class="fa fa-trash text-red fa-2x"></span></a>
                                                    </td>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <?php if(!$patient->readonly): ?>
                                                <td>
                                                    <a href="#" id="btn_ann_chron" data-toggle="modal"
                                                        data-target="#modal_annotation" data-type="auto"
                                                        data-id="<?php echo e($ligne->traitementchronique_id); ?>">
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
            </div>
        </div>
    <?php endif; ?>

    <?php if(count($patient->tmp_autos) > 0): ?>

        <div class="box box-widget">

            <div class="box-header">
                <h3>Récolter par les pharmaciens </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example7" class=" table table-bordered table-hover text-center table-condensed">
                            <thead style="background-color: #00a65a !important; color:white">
                                <tr>
                                    <th>Médicament (DCI)</th>
                                    <th>Voie</th>
                                    <th>Matin</th>
                                    <th>Midi</th>
                                    <th>Soir</th>
                                    <th>Av-coucher</th>
                                    <th>Unité</th>
                                    <th>Médecin externe</th>
                                    
                                    <th>Le :</th>
                                    <th>Hopital</th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.valide', $patient)): ?>
                                        <th>Valider?</th>
                                        <th>Refuser?</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $patient->tmp_autos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tmp_auto_ligne): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <th>
                                            <?php
                                                $resultats = DB::table('cosac_compo_subact')
                                                    ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                    ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                    ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $tmp_auto_ligne->med_sp_id)
                                                    ->get();
                                                foreach ($resultats as $key => $resultat) {
                                                    echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                                }
                                            ?>
                                        </th>
                                        <th> <?php echo e($tmp_auto_ligne->voie); ?> </th>
                                        <td> <?php echo e($tmp_auto_ligne->dose_mat); ?>

                                            <?php echo e($tmp_auto_ligne->repas_matin); ?>

                                        </td>
                                        <td> <?php echo e($tmp_auto_ligne->dose_mi); ?>

                                            <?php echo e($tmp_auto_ligne->repas_midi); ?>

                                        </td>
                                        <td> <?php echo e($tmp_auto_ligne->dose_so); ?>

                                            <?php echo e($tmp_auto_ligne->repas_soir); ?>

                                        </td>
                                        <td> <?php echo e($tmp_auto_ligne->dose_avant_coucher); ?> </td>
                                        <td> <?php echo e($tmp_auto_ligne->unite); ?> </td>
                                        <td>Dr.<?php echo e($tmp_auto_ligne->medecin_externe); ?> </td>
                                        
                                        <td> <?php echo e($tmp_auto_ligne->date_etats); ?> </td>
                                        <td>
                                            <?php if($tmp_auto_ligne->status_hopital == '1'): ?> H
                                            <?php else: ?> V <?php endif; ?>
                                        </td>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.valide', $patient)): ?>
                                            <td>
                                                <a href="" class="deleteRow"
                                                    data-url="<?php echo e(route('automedication.confirm', $tmp_auto_ligne->id)); ?>"
                                                    style="color: inherit; cursor: pointer;"><i class="fa  fa-check-circle "
                                                        style="color: green;font-size: 22px;"></i></a>
                                            </td>
                                            <td>;

                                                <a href="" class="deleteRow"
                                                    data-url="<?php echo e(route('automedication.destroy_tmp', $tmp_auto_ligne->id)); ?>"
                                                    style="color: inherit; cursor: pointer;"><i class="fa  fa-times-circle "
                                                        style="color: red;font-size: 22px;"></i></a>

                                            </td>
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

</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\tabs\automedication.blade.php ENDPATH**/ ?>