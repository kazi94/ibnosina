<!-- Modal ajouter Prescription -->
<div class="modal fade" id="modal_prescription" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Prescription Médicament</h4>
            </div>
            <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
            <input type="hidden" name="cons_id" id="cons_id" value="" />
            <input type="hidden" name="url" />
            <input type="hidden" name="method" value="post" />
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label for="d_prescription" class="col-sm-3 control-label">Date Prescription</label>

                    <div class="col-sm-9">
                        <input type="date" name="date_prescription" class="form-control"
                            value="<?php echo date('Y-m-d'); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="type_prescription" class="col-sm-3 control-label">Prescriptions type</label>

                    <div class="col-sm-9">
                        <select id="prescriptions_type" class="form-control">
                            <option value=""></option>
                            <?php $__currentLoopData = Auth::user()->prescriptionsType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="p-3 m-1 bg-info">
                    <form id="addLinePrescription">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                        <input type="hidden" name="line_id" value="">
                        <select class="" name='voie' style="display : none"></select>
                        <select class="" name="unite" style="display : none"></select>
                        <div class="form-group">
                            <label for="d_analyse" class="col-sm-2 control-label">Médicament</label>

                            <div class="col-sm-10">
                                <input type="hidden" name="med_sp_id" />
                                <input type="text" class="form-control" placeholder="Médicament DCI / Nom de spécialité"
                                    name="medicament_dci" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Posologie</label>
                            <div class="col-sm-10">

                                <input type="number" step="0.01" name="dose_mat" value="1"
                                    class="form-control posologie">
                                <input type="hidden" name="dose_matin" value="1">
                                <input type='checkbox' class='form-control flat-green d_matin' checked
                                    onclick="this.previousSibling.value=1-this.previousSibling.value" /> Matin

                                <input type="number" step="0.01" name="dose_mid" value="1"
                                    class="form-control posologie">
                                <input type="hidden" name="dose_midi" value="1">
                                <input type='checkbox' class='form-control flat-green d_midi' checked
                                    onclick="this.previousSibling.value=1-this.previousSibling.value" /> Midi

                                <input type="number" step="0.01" name="dose_soi" value="1"
                                    class="form-control posologie">
                                <input type="hidden" name="dose_soir" value="1">
                                <input type='checkbox' class='form-control flat-green d_soir' checked
                                    onclick="this.previousSibling.value=1-this.previousSibling.value" /> Soir

                                <input type="number" step="0.01" name="dose_ac" value="1"
                                    class="form-control posologie">
                                <input type="hidden" name="dose_avant_coucher" value="1">
                                <input type='checkbox' class='form-control flat-green d_av' checked
                                    onclick="this.previousSibling.value=1-this.previousSibling.value" /> Av-coucher
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date de prise" class="col-sm-2 control-label">Pendant</label>

                            <div class="col-sm-10">
                                <input type="number" class="form-control posologie" name="nbr_jours" value="1">
                                <select id="type_j" name='type_j' class="form-control"
                                    style="width: 17%; display: inline;">
                                    <option value="jours">Jours</option>
                                    <option value="semaines">Semaines</option>
                                    <option value="mois">Mois</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-info btn-block add_line_btn"
                                    value="Ajouter Médicament">
                                <input type="button" class="btn btn-success btn-block up_line_btn"
                                    value="Modifier Médicament" style="display: none;">
                            </div>
                        </div>
                    </form>
                    <div class="">
                        <table class="table table-hover" id="tablePrescription">
                            <thead>
                                <tr>
                                    <th class="text-center">Mes médicaments</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-default" data-dismiss="modal" value="Fermer">
                <input type="button" class="btn btn-primary" id="savePrescription" value="Valider">
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal_administrations">
    <div class="modal-dialog  modal-lg ">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Historique des Administrations</h4>
            </div>
            <div class="modal-body">
                <table id="administrations_table" class=" display table table-bordered" style="width:100%">
                    <thead>
                        <tr class="bg-green-active">
                            <th>Médicament</th>
                            <th></th>
                            <th>Prise</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-default" data-dismiss="modal" value="Fermer">
                <!-- <input type="submit" class="btn btn-primary pull-right" value="Ajouter"> -->
            </div>
        </div>
    </div>
</div>


<div class="modal fade in" id="prescription_details">
    <div class="modal-dialog modal-lg" style="width: 1100px">
        <div class="modal-content table-responsive">
            <div class="bg-blue modal-header text-center">
                <div class="row">
                </div>
            </div>
            <div class="modal-body" style="display: block; text-align: center;">
                <table class="table table-bordered text-center">
                    <thead>
                        <tr class="alert" style="background-color: #004a5cde !important; color: white">
                            <th>Médicament</th>
                            <th>Unite/Prise</th>
                            <th>Matin</th>
                            <th>Midi</th>
                            <th>Soir</th>
                            <th>Av-coucher</th>
                            <th>Pendant:</th>
                        </tr>
                    </thead>
                    <?php if(isset($pr_risque)): ?>
                        <?php
                        $ra = DB::table('ligneprescriptions')
                        ->where('prescription_id',$pr_risque)
                        ->select('ligneprescriptions.*')
                        ->get();
                        ?>
                        <?php $__currentLoopData = $ra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <?php
                                    $resultats = DB::table('cosac_compo_subact')
                                    ->join('sac_subactive as t0','t0.SAC_CODE_SQ_PK' ,
                                    'cosac_compo_subact.cosac_sac_code_fk_pk')
                                    ->select('t0.sac_nom','cosac_compo_subact.cosac_dosage','cosac_compo_subact.cosac_unitedosage')
                                    ->where('cosac_compo_subact.cosac_sp_code_fk_pk' , $val->med_sp_id)
                                    ->get();
                                    foreach ($resultats as $key => $resultat) {
                                    echo $resultat->sac_nom." ". $resultat->cosac_dosage .$resultat->cosac_unitedosage.(
                                    ($key == (count($resultats)-1)) ? '.' : '/' );
                                    }
                                    ?>
                                </td>
                                <td>
                                    <?php if($val->dose_matin): ?>
                                        <?php echo e($val->dose_matin); ?>

                                    <?php elseif($val->dose_midi): ?>
                                        <?php echo e($val->dose_midi); ?>

                                    <?php elseif($val->dose_soir): ?>
                                        <?php echo e($val->dose_soir); ?>

                                    <?php else: ?>
                                        <?php echo e($val->dose_avant_coucher); ?>

                                    <?php endif; ?>
                                    <?php echo e($val->unite); ?>

                                </td>
                                <td>
                                    <?php if($val->dose_matin): ?> <input type="checkbox"
                                            checked> <?php echo e($val->repas_matin); ?> <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($val->dose_midi): ?> <input type="checkbox"
                                            checked> <?php echo e($val->repas_midi); ?> <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($val->dose_soir): ?><input type="checkbox"
                                            checked> <?php echo e($val->repas_soir); ?> <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($val->dose_avant_coucher): ?><input
                                            type="checkbox" checked> <?php endif; ?>
                                </td>
                                <td> <?php echo e($val->nbr_jours); ?>j </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </table>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
            </div>
        </div>
    </div>
</div>


<div class="modal fade in" id="modal_display">
    <div class="modal-dialog" style="width: auto;">
        <div class="modal-content table-responsive">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                    onclick="$('.display>tbody').empty();">
                    <span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body" style="display: block;">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <table class="table table-condensed table-bordered display text-center">
                            <thead>
                                <tr>
                                    <th>Médicament (DCI)</th>
                                    <th>Voie</th>
                                    <th>Matin</th>
                                    <th>Midi</th>
                                    <th>Soir</th>
                                    <th>Avant coucher</th>
                                    <th>Unité</th>
                                    <th>Pendant :</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer"
                    onclick="$('.display>tbody').empty();">
                <input type="button" class="btn btn-primary pull-right confirmer" value="Confirmer">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal détails de la prescription -->
<div class="modal fade in" id="modal_detail_prescription">
    <div class="modal-dialog modal-md">

        <div class="modal-content table-responsive">
            <div class="bg-blue modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Détails de la prescription</h4>
            </div>
            <div class="modal-body" style="display: block;">

                <ol class="mb-1 mt-1"></ol>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-default pull-right" data-dismiss="modal" value="Fermer">
            </div>
        </div>
        <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\modals\prescription.blade.php ENDPATH**/ ?>