<?php $__env->startSection('script_css'); ?>

<?php $__env->startSection('title'); ?>
    Mes Administrations
<?php $__env->stopSection(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/home"><i class="fa fa-home"></i> Acceuil</a></li>
                <li class="active">Mes Administrations</li>
            </ol>
        </div>
    </section>

    <section class="content">
        <?php if(session()->has('message')): ?>
            <p style="display: none;" id="message"><?php echo e(session('message')); ?></p>
        <?php endif; ?>

        <div class="row">
            <div class="col-sm-12 ">
                <div class="box box-widget">

                    <div class="box-body">

                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <h3>Prescriptions En cours d'administration
                                    <?php
                                        $count = '';
                                    ?>
                                    <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(isset($prescription->patient->hospi)): ?>
                                            <?php if(date('Y-m-d') <= $prescription->lastDate): ?>
                                                <?php
                                                    $count++;
                                                ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($count): ?>
                                        <span class="badge bg-red mb-1">
                                            <?php echo e($count); ?>

                                        </span>

                                    <?php endif; ?>
                                </h3>

                                <table id="table_injections" class="nowrap table table-bordered table-hover text-center"
                                    style="width:100%">
                                    <thead>
                                        <tr class="bg-blue">
                                            <th></th>
                                            <th>Num°:</th>
                                            <th>Patient</th>
                                            <th>Prescripteur</th>
                                            <th>Date de Prescription</th>
                                            <th>Historique</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if(isset($prescription->patient->hospi)): ?>
                                                <?php if(date('Y-m-d') <= $prescription->lastDate): ?>


                                                    <tr>
                                                        <td>
                                                            <a data-toggle="collapse" href="#a<?php echo e($loop->index + 1); ?>"
                                                                class="text-green"><i class="fa fa-plus fa-2x"></i></a>
                                                        </td>
                                                        <td> <?php echo e($prescription->id); ?> </td>
                                                        <td> <?php echo e($prescription->patient->nom); ?>

                                                            <?php echo e($prescription->patient->prenom); ?>

                                                        </td>
                                                        <td> Dr.<?php echo e($prescription->prescripteur->name); ?>

                                                            <?php echo e($prescription->prescripteur->prenom); ?>

                                                        </td>
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
                                                        <td style="display: none;"></td>
                                                        <td style="display: none;"></td>
                                                        <td colspan="6" style="padding: 0 !important;">
                                                            <div id="a<?php echo e($loop->index + 1); ?>"
                                                                class="accordian-body collapse">
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
                                                                            <?php
                                                                                $j_restant = $ligne->nbr_jours - $ligne->jours_restant;
                                                                            ?>

                                                                            <?php if($j_restant >= 0): ?>


                                                                                <tr <?php if($ligne->stopped): ?> style='color:
                                                                                            gray;
                                                                                            pointer-events: none; ' <?php endif; ?>>
                                                                                    <th> <?php echo e($loop->index + 1); ?> </th>

                                                                                    <th>
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
                                                                                    <td> -<?php echo e($j_restant); ?>j
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

                                                                                                <input type="hidden"
                                                                                                    name="injected"
                                                                                                    data-id="<?php echo e($ligne->id); ?>"
                                                                                                    data-prise="matin"
                                                                                                    value="0">
                                                                                                <input type='checkbox'
                                                                                                    name="injected"
                                                                                                    class='form-control flat-green'
                                                                                                    <?php $__currentLoopData = $injections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $injectedLine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                                                                    <?php if($injectedLine->prise=='matin'): ?>
                                                                                                checked disabled
                                                                                                <?php break; ?> <?php endif; ?>
                                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                            onclick="this.previousSibling.value=1-this.previousSibling.value"
                                                                                            />

                                                                                        <?php endif; ?>
                                                                                        <?php if($ligne->dose_midi): ?>
                                                                                            <input type="hidden"
                                                                                                name="injected"
                                                                                                data-id="<?php echo e($ligne->id); ?>"
                                                                                                data-prise="midi" value="0">
                                                                                            <input type='checkbox'
                                                                                                name="injected"
                                                                                                class='form-control flat-green'
                                                                                                <?php $__currentLoopData = $injections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $injectedLine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                                                                <?php if($injectedLine->prise=='midi'): ?>
                                                                                            checked disabled
                                                                                            <?php break; ?> <?php endif; ?>
                                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value"
                                                                                        />
                                                                            <?php endif; ?>

                                                                            <?php if($ligne->dose_soir): ?>
                                                                                <input type="hidden" name="injected"
                                                                                    data-id="<?php echo e($ligne->id); ?>"
                                                                                    data-prise="soir" value="0">
                                                                                <input type='checkbox' name="injected" <?php $__currentLoopData = $injections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $injectedLine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                                                    <?php if($injectedLine->prise=='soir'): ?>
                                                                                checked disabled
                                                                                <?php break; ?> <?php endif; ?>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            class='form-control flat-green'
                                                                            onclick="this.previousSibling.value=1-this.previousSibling.value"
                                                                            />
                                                                        <?php endif; ?>

                                                                        <?php if($ligne->dose_avant_coucher): ?>

                                                                            <input type="hidden" name="injected"
                                                                                data-id="<?php echo e($ligne->id); ?>"
                                                                                data-prise="coucher" value="0">
                                                                            <input type='checkbox' name="injected"
                                                                                class='form-control flat-green' <?php $__currentLoopData = $injections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $injectedLine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  <?php if($injectedLine->prise=='coucher'): ?>
                                                                            checked disabled
                                                                            <?php break; ?> <?php endif; ?>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value"
                                                                        />

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
                                            <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                </td>

                                </tr>
                                <?php endif; ?>

                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
</div>


</section>
<!-- Button trigger modal-->



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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script src="<?php echo e(asset('js/user/patient/gestion-administration.js')); ?>"></script>
<script>
    $("#table_injections").DataTable({
        dom: "<'row'<'col-sm-2'l><'col-sm-4'B> <'col-sm-6'f>>tipr",
        buttons: [{
            text: 'Historique',
            titleAttr: 'Historique des prescriptions administrées',
            action: function(e, dt, node, config) {
                window.location.href = "<?php echo e(route('administrations.archives')); ?>"
            },
            className: 'btn bg-navy'
        }],
        "ordering": false,
    }); //Prescription	
    $('input[type="checkbox"].flat-green').iCheck({
        checkboxClass: 'icheckbox_flat-green'
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\administration\show.blade.php ENDPATH**/ ?>