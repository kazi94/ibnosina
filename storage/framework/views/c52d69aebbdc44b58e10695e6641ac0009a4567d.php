<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="clearfix">
                <ol class="breadcrumb">
                    <li><a href="/home"><i class="fa fa-home"></i> Acceuil</a></li>
                    <li><a href="<?php echo e(route('pharmacie.index')); ?>"><i class="fa fa-clinic-medical"></i> Mon Armoire
                            Pharmaceutique</a></li>
                    <li class="active">Mes Educations Thérapeutiques</li>
                </ol>
            </div>
        </section>
        <section class="content">
            <?php if(count($errors) > 0): ?>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p class="alert alert-danger"><?php echo e($error); ?></p>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

            <?php if(session()->has('message')): ?>
                <p class="alert alert-success" id="message" style="display: none;"><?php echo e(session('message')); ?></p>
            <?php endif; ?>

            <div class="row">
                <div class="col-sm-12 ">
                    <div class="box  box-info">
                        <div class="box-header with-border">
                            <h3>Educations Thérapeutiques</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="">
                                    <div class="col-sm-3 mb-2">
                                        <select id="ip" class="form-control">
                                            <option value="faire">à faire</option>
                                            <option value="historique">historique</option>
                                            <option value="tous">tous</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="faireDiv table-responsive">
                                <table class="table table-condensed table-bordered table-striped text-center" id="tabfaire">
                                    <thead>
                                        <tr class="bg-green text-center">
                                            <th>Num° prescription</th>
                                            <th>Patient</th>
                                            <th>Médecin Prescripteur</th>
                                            <th>Titre</th>
                                            <th>Date et heure</th>
                                            <th>Action</th>
                                            <th>Détails</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $patient->ReglesEduPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_presc_edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'risqueTherap'): ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->prescription_id); ?>

                                                        </td>
                                                        <td>
                                                            <?php if(Auth::user()->can('patients.module')): ?>
                                                                <a
                                                                    href="<?php echo e(route('patient.edit', ['id' => $patient->id])); ?>">
                                                                    <?php echo e($patient->nom); ?>

                                                                    <?php echo e($patient->prenom); ?>

                                                                </a>
                                                            <?php else: ?>
                                                                <?php echo e($patient->nom); ?>

                                                                <?php echo e($patient->prenom); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->name); ?>

                                                            <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->prenom); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->RegleEducConcerne->titre); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->created_at); ?>

                                                        </td>
                                                        <td>
                                                            <a
                                                                href="<?php echo e(route('patient.FaireEducation', [$regle_presc_edu->prescription_id])); ?>">
                                                                <button class="btn btn-primary">Faire</button>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn BTNANALYSE"
                                                                data-id="<?php echo e($patient->id); ?>"
                                                                data-risque="<?php echo e($regle_presc_edu->prescription_id); ?>">Details</button>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="historiqueDiv table-responsive ">
                                <table class="table table-condensed table-bordered table-stripped text-center"
                                    id="tabhistorique">
                                    <thead>
                                        <tr class="text-center bg-green">
                                            <th>Num° prescription</th>
                                            <th>Patient</th>
                                            <th>Médecin Prescripteur</th>
                                            <th>Titre</th>
                                            <th>Date et heure</th>
                                            <th>Action</th>
                                            <th>Détails</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $patient->ReglesEduPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_presc_edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'faite'): ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->prescription_id); ?>

                                                        </td>
                                                        <td>
                                                            <?php if(Auth::user()->can('patients.module')): ?>
                                                                <a
                                                                    href="<?php echo e(route('patient.edit', ['id' => $patient->id])); ?>">
                                                                    <?php echo e($patient->nom); ?>

                                                                    <?php echo e($patient->prenom); ?>

                                                                </a>
                                                            <?php else: ?>
                                                                <?php echo e($patient->nom); ?>

                                                                <?php echo e($patient->prenom); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->name); ?>

                                                            <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->prenom); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->RegleEducConcerne->titre); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->created_at); ?>

                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary disabled">Faire</button>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn BTNANALYSE"
                                                                data-id="<?php echo e($patient->id); ?>"
                                                                data-risque="<?php echo e($regle_presc_edu->prescription_id); ?>">Details</button>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>

                                </table>
                            </div>

                            <div class="tousDiv table-responsive">
                                <table class="table table-condensed  table-bordered table-stripped text-center"
                                    id="tabtous">
                                    <thead>
                                        <tr class="text-center bg-green">
                                            <th>Num° prescription</th>
                                            <th>Patient</th>
                                            <th>Médecin Prescripteur</th>
                                            <th>Titre</th>
                                            <th>Date et heure</th>
                                            <th>Action</th>
                                            <th>Détails</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $patient->ReglesEduPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_presc_edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'faite'): ?>
                                                    <tr class="bg-green">
                                                        <td>
                                                            <?php echo e($regle_presc_edu->prescription_id); ?>

                                                        </td>
                                                        <td>
                                                            <?php if(Auth::user()->can('patients.module')): ?>
                                                                <a
                                                                    href="<?php echo e(route('patient.edit', ['id' => $patient->id])); ?>">
                                                                    <?php echo e($patient->nom); ?>

                                                                    <?php echo e($patient->prenom); ?>

                                                                </a>
                                                            <?php else: ?>
                                                                <?php echo e($patient->nom); ?>

                                                                <?php echo e($patient->prenom); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->name); ?>

                                                            <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->prenom); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->RegleEducConcerne->titre); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->created_at); ?>

                                                        </td>
                                                        <td>
                                                            <button class="btn btn-primary disabled">Faire</button>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn BTNANALYSE"
                                                                data-id="<?php echo e($patient->id); ?>"
                                                                data-risque="<?php echo e($regle_presc_edu->prescription_id); ?>">Details</button>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


                                            <?php $__currentLoopData = $patient->ReglesEduPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $regle_presc_edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'risqueTherap'): ?>
                                                    <tr>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->prescription_id); ?>

                                                        </td>
                                                        <td>
                                                            <?php if(Auth::user()->can('patients.module')): ?>
                                                                <a
                                                                    href="<?php echo e(route('patient.edit', ['id' => $patient->id])); ?>">
                                                                    <?php echo e($patient->nom); ?>

                                                                    <?php echo e($patient->prenom); ?>

                                                                </a>
                                                            <?php else: ?>
                                                                <?php echo e($patient->nom); ?>

                                                                <?php echo e($patient->prenom); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->name); ?>

                                                            <?php echo e($regle_presc_edu->PrescEducConcerne->prescripteur->prenom); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->RegleEducConcerne->titre); ?>

                                                        </td>
                                                        <td>
                                                            <?php echo e($regle_presc_edu->created_at); ?>

                                                        </td>
                                                        <td>
                                                            <a
                                                                href="<?php echo e(route('patient.FaireEducation', [$regle_presc_edu->prescription_id])); ?>">
                                                                <button class="btn btn-primary">Faire</button>
                                                            </a>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn BTNANALYSE"
                                                                data-id="<?php echo e($patient->id); ?>"
                                                                data-risque="<?php echo e($regle_presc_edu->prescription_id); ?>">Details</button>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </section>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="modal_analyse_therap" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Détails de l'éducation thérapeutique</h4>
                </div>

                <div class="modal-body" id="div_body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background-color:blue; color:#ffffff"
                        data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('plugins/jquery/js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/bootstrap/dist/js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/adminlte2/js/adminlte.min.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/datatable-1.10.24/datatables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/user/patient/analyse.js')); ?>"></script>
    <script type="text/javascript">
        $('body').find('span > i').remove('i:last');
        $('#tabfaire').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
        $('#tabhistorique').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
        $('#tabtous').DataTable({
            "order": [
                [0, "desc"]
            ]
        });

        $('.historiqueDiv').toggle(false);
        $('.tousDiv').toggle(false);
        $('#ip').change(function() { //fonction pour alterner entre les deux type de règles
            if ($(this).val() == "faire") {
                $('.faireDiv').toggle(true);
                $('.historiqueDiv').toggle(false);
                $('.tousDiv').toggle(false);
            } else if ($(this).val() == "historique") {
                $('.faireDiv').toggle(false);
                $('.historiqueDiv').toggle(true);
                $('.tousDiv').toggle(false);
            } else {
                $('.faireDiv').toggle(false);
                $('.historiqueDiv').toggle(false);
                $('.tousDiv').toggle(true);
            }
        });

    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model-table', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\user\pharmacien\education\todo.blade.php ENDPATH**/ ?>