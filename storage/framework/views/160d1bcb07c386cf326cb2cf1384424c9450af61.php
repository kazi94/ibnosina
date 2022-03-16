<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">

        <?php if(count($errors) > 0): ?>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="alert alert-danger"><?php echo e($error); ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>

        <?php if(session()->has('message')): ?>
            <p class="alert alert-success"><?php echo e(session('message')); ?></p>
        <?php endif; ?>
        <div class="row">

            <div class="col-sm-12 mt-2 p-4">

                <!-- Horizontal Form -->
                <div class="box box-info">

                    <div class="box-header with-border">

                        <h3 class="box-title">Ajouter Profile</h3>

                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->

                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="<?php echo e(route('profile.store')); ?>">

                            <?php echo e(csrf_field()); ?>

                            <div class="form-group">
                                <label for="nom_profile" class="control-label col-sm-3"> Nom profile*</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nom_profile" id="nom_profile"
                                        placeholder="Profile">
                                </div>
                            </div>



                            <div class="form-group ">

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="analyse_ph">
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut faire l'analyse pharmaceutique

                                </label>

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="administrer">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut Administrer le médicament </label>
                            </div>


                            <div class="form-group">

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="verif_medic">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Verifie la disponibilité du médicament</label>
                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="afficher_rdv">
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut voir les rendez-vous rédigé par les autres
                                    utilisateurs</label>

                            </div>

                            <div class="form-group">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="executer_demande_examen">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut éxecuter les demandes d'examens</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="medecin_presc">
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Médecin prescripteur</label>
                            </div>

                            <div class="form-group ">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="analyse_th">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut voir le résultat de l'analyse
                                    thérapeutique</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="analyse_sv">
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut voir le résultat de l'analyse de
                                    suivie</label>
                            </div>

                            <div class="form-group ">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="editeur_regle">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut accéder l'éditeur de règles</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="ok_chimio">

                                </div>
                                <label for="nom_profile" class="col-sm-5"> Chimiothérapie</label>
                            </div>

                            <div class="form-group">

                            </div>


                            <div class="table-responsive">

                                <small>Cliquer sur le titre de la colonne pour cocher toute la colonne*</small>

                                <table class="table table-bordered table-responsive">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Lister</th>
                                            <th>Module</th>
                                            <th>Ajouter</th>
                                            <th>Modifier</th>
                                            <th>Supprimer</th>
                                            <th>Imprimer</th>
                                            <th>Exporter</th>
                                            <th>Graphe</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">

                                        <?php
                                            $tableau = [
                                                'Patient',
                                                'Prescription',
                                                'Automédication',
                                                'Analyse
                                                                                                                                biologique',
                                                'Traitement chronique',
                                                'Phytothérapie',
                                                'Questionnaire',
                                                'Education
                                                                                                                                thérapeutique',
                                                'Consultation',
                                                'Hospitalisation',
                                                'act_medicale',
                                                'dashboard',
                                                'compte patient',
                                                'compte
                                                                                                                                externe',
                                                'Prescription_chimio',
                                                'Protocole_chimio',
                                            ];
                                            $k = 0;
                                        ?>
                                        <?php for($i = 0; $i < count($tableau); $i++): ?>
                                            <tr>
                                                <td><?php echo e($tableau[$i]); ?></td>

                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="lister_<?php echo e($tableau[$i]); ?>">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="détails_<?php echo e($tableau[$i]); ?>">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="ajouter_<?php echo e($tableau[$i]); ?>">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="modifier_<?php echo e($tableau[$i]); ?>">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="supprimer_<?php echo e($tableau[$i]); ?>">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="imprimer_<?php echo e($tableau[$i]); ?>">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="exporter_<?php echo e($tableau[$i]); ?>">
                                                    </label>
                                                </td>
                                                <!-- <td>
                                                        <?php if($tableau[$i] === 'Prescription'): ?>
                                                            <label>
                                                                <input type="checkbox" class="flat-red"
                                                                    name="cloner_<?php echo e($tableau[$i]); ?>">
                                                            </label>
                                                        <?php endif; ?>
                                                    </td> -->
                                                <td>
                                                    <?php if($tableau[$i] === 'Analyse biologique'): ?>
                                                        <label>
                                                            <input type="checkbox" class="flat-red" name="dessiner_graphe">
                                                        </label>
                                                    <?php endif; ?>
                                                </td>

                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>

                            </div>

                            <button type="submit" class="btn btn-info pull-right">Ajouter</button>

                        </form>

                    </div>
                    <!-- /.box-body -->

                </div>

            </div>

        </div>

    </div>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>

    <script src="<?php echo e(asset('js/admin/profil/profil.js')); ?>"> </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\profile\create.blade.php ENDPATH**/ ?>