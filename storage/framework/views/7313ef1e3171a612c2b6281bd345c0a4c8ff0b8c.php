<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" media="screen" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" media="print" />
    <link rel="stylesheet" href="<?php echo e(asset('plugins/bootstrap/dist/css/bootstrap.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/font-awesome/css/font-awesome.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/Ionicons/css/ionicons.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/AdminLTE.css')); ?>">
    <title>Prescription#<?php echo e($prescription[0]->p_id); ?></title>
</head>

<body onload="window.print();">
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <img src="<?php echo e(asset('/images/logo_chut.png')); ?>" style="width: 40px; height: 40px;">
                        <?php echo e($prescription[0]->hopital); ?>, <?php if(strlen($prescription[0]->hopital) > 20): ?>
                            <br />
                        <?php endif; ?> <?php echo e($prescription[0]->service); ?>.
                        <small class="pull-right">Date: <?php echo now(); ?></small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <strong>Patient:</strong>
                    <address>
                        <strong><?php echo e($prescription[0]->p_nom); ?>, <?php echo e($prescription[0]->p_prenom); ?>.</strong><br>
                        <?php echo e($prescription[0]->p_dn); ?> ,<?php echo $prescription[0]->ville ?? '.'; ?> <br>
                        <?php echo $prescription[0]->p_num1 ? 'Phone: (213)' . $prescription[0]->p_num1 : ''; ?>

                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    Médecin Prescripteur:
                    <address>
                        <strong>Dr.<?php echo e($prescription[0]->name); ?> <?php echo e($prescription[0]->prenom); ?>.</strong><br>
                        <?php echo e($prescription[0]->hopital); ?>, <?php echo e($prescription[0]->service); ?><br>
                        <?php echo e($prescription[0]->specialite); ?>, <?php echo e($prescription[0]->grade); ?><br>
                        <?php echo $prescription[0]->telephone ? 'Phone: (213)' . $prescription[0]->telephone : ''; ?><br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>prescription #<?php echo e($prescription[0]->p_id); ?></b><br>
                    <b>Date prescription:</b> <?php echo e($prescription[0]->date_prescription); ?><br>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 ">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Médicament</th>
                                <th>Prise</th>
                                <th>Matin</th>
                                <th>Midi</th>
                                <th>Soir</th>
                                <th>Avant coucher</th>
                                <th>Pendant</th>
                            </tr>
                        </thead>
                        <?php
                            $r = DB::table('ligneprescriptions')
                                ->where('prescription_id', $prescription[0]->p_id)
                                ->select('ligneprescriptions.*')
                                ->get();
                        ?>
                        <?php $__currentLoopData = $r; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr style="text-align: center;">
                                <td><?php echo e($loop->index + 1); ?></td>
                                <td>
                                    <?php
                                        $resultats = DB::table('cosac_compo_subact')
                                            ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                            ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                            ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $val->med_sp_id)
                                            ->get();
                                        foreach ($resultats as $key => $resultat) {
                                            echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
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
                                <td> <?php echo $val->dose_matin ? "<i class='fa  fa-check-circle ' style='font-size: 22px;'></i>" . $val->repas_matin : '/'; ?> </td>
                                <td> <?php echo $val->dose_midi ? "<i class='fa  fa-check-circle ' style='font-size: 22px;'></i>" . $val->repas_midi : '/'; ?> </td>
                                <td> <?php echo $val->dose_soir ? "<i class='fa  fa-check-circle ' style='font-size: 22px;'></i>" . $val->repas_soir : '/'; ?> </td>
                                <td> <?php echo $val->dose_avant_coucher ? "<i class='fa  fa-check-circle ' style='font-size: 22px;'><i>" : '/'; ?> </td>
                                <td> <?php echo $val->nbr_jours ? $val->nbr_jours . 'jours' : '/'; ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">
                    <p class="lead">Signature:................</p>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
</body>

</html>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\print\print_prescription.blade.php ENDPATH**/ ?>