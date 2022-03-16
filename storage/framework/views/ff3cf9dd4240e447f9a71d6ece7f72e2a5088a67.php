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

                        <h3 class="box-title">Modifier Profile</h3>

                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST"
                            action="<?php echo e(route('profile.update', $role->id)); ?>">

                            <?php echo e(csrf_field()); ?>

                            <?php echo e(method_field('PATCH')); ?>

                            <div class="form-group">
                                <label for="nom_profile" class="control-label col-sm-3"> Nom profile*</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nom_profile" id="nom_profile"
                                        placeholder="Profile" value="<?php echo e($role->nom_profile); ?>">
                                </div>
                            </div>



                            <div class="form-group ">

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="analyse_ph" <?php if($role->analyse_ph === 'on'): ?> checked <?php endif; ?>>
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut faire l'analyse pharmaceutique

                                </label>

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="administrer" <?php if($role->administrer === 'on'): ?> checked <?php endif; ?>>
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut Administrer le médicament </label>
                            </div>


                            <div class="form-group">

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="verif_medic" <?php if($role->verif_medic === 'on'): ?> checked <?php endif; ?>>
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Verifie la disponibilité du médicament</label>
                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="afficher_rdv" <?php if($role->afficher_rdv === 'on'): ?> checked <?php endif; ?>>
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut voir les rendez-vous rédigé par les autres
                                    utilisateurs</label>

                            </div>

                            <div class="form-group">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="executer_demande_examen" <?php if($role->executer_demande_examen === 'on'): ?> checked </beautify
                                                            end=" <?php endif; ?>">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut éxecuter les demandes d'examens</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="medecin_presc" <?php if($role->medecin_presc === 'on'): ?> checked <?php endif; ?>>
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Médecin prescripteur</label>
                            </div>

                            <div class="form-group ">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="analyse_th" <?php if($role->analyse_th === 'on'): ?> checked <?php endif; ?>>
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut voir le résultat de l'analyse
                                    thérapeutique</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="analyse_sv" <?php if($role->analyse_sv === 'on'): ?> checked <?php endif; ?>>
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut voir le résultat de l'analyse de
                                    suivie</label>
                            </div>

                            <div class="form-group ">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="editeur_regle" <?php if($role->editeur_regle === 'on'): ?> checked <?php endif; ?>>
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut accéder l'éditeur de règles</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="ok_chimio" <?php if($role->ok_chimio === 'on'): ?> checked <?php endif; ?>>

                                </div>
                                <label for="nom_profile" class="col-sm-5"> Chimiothérapie</label>
                            </div>

                            <div class="form-group">

                            </div>


                            <div class="table-responsive">

                                <table class="table table-bordered">
                                    <thead class="bg-gray">
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
                                            
                                            $tableau = ['Patient', 'Prescription', 'Automédication', 'Analyse biologique', 'Traitement chronique', 'Questionnaire', 'Phytothérapie', 'Education thérapeutique', 'Consultation', 'Hospitalisation', 'Acte Médicale', 'Tableau de bord', 'Compte Patient', 'Compte Externe', 'Prescription Chimiothérapeute', 'Protocole Chiomiothérapeute'];
                                            
                                            $tableau1 = ['patient', 'prescription', 'auto', 'analyse_bio', 'traitement', 'question', 'phyto', 'et', 'consultation', 'ho', 'act', 'dashboard', 'cpt_pat', 'cpt_ext', 'Prescription_chimio', 'Protocole_chimio'];
                                            
                                            $k = 0;
                                        ?>
                                        <?php for($i = 0; $i < count($tableau); $i++): ?>
                                            <?php
                                                $y = 'ajouter_' . $tableau1[$i];
                                                $z = 'modifier_' . $tableau1[$i];
                                                $w = 'supprimer_' . $tableau1[$i];
                                                $a = 'imprimer_' . $tableau1[$i];
                                                $b = 'lister_details_' . $tableau1[$i];
                                                $f = 'lister_' . $tableau1[$i];
                                                $e = 'exporter_' . $tableau1[$i];
                                            ?> <tr>
                                                <td><?php echo e($tableau[$i]); ?></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="lister_<?php echo e($tableau1[$i]); ?>" <?php if($role->$f === 'on'): ?> checked <?php endif; ?>></label></td>

                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="détails_<?php echo e($tableau1[$i]); ?>" <?php if($role->$b === 'on'): ?> checked <?php endif; ?>></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="ajouter_<?php echo e($tableau1[$i]); ?>" <?php if($role->$y === 'on'): ?> checked <?php endif; ?>></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="modifier_<?php echo e($tableau1[$i]); ?>" <?php if($role->$z === 'on'): ?> checked <?php endif; ?>></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="supprimer_<?php echo e($tableau1[$i]); ?>" <?php if($role->$w === 'on'): ?> checked <?php endif; ?>></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="imprimer_<?php echo e($tableau1[$i]); ?>" <?php if($role->$a === 'on'): ?> checked <?php endif; ?>></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="exporter_<?php echo e($tableau1[$i]); ?>" <?php if($role->$e === 'on'): ?> checked <?php endif; ?>></label></td>
                                                <!-- <td>
                                                            <?php if($tableau[$i] === 'Prescription'): ?>
                                                                <label><input type="checkbox" class="flat-red"
                                                                        name="cloner_<?php echo e($tableau1[$i]); ?>" <?php if($role->cloner_prescription === 'on'): ?> checked </beautify
                                                                    end=" <?php endif; ?>"> ></label>
                                                            <?php endif; ?>
                                                        </td> -->
                                                <td>
                                                    <?php if($tableau[$i] === 'Analyse biologique'): ?>
                                                        <label><input type="checkbox" class="flat-red"
                                                                name="dessiner_graphe" <?php if($role->dessiner_graphe === 'on'): ?> checked <?php endif; ?>></label>
                                                    <?php endif; ?>
                                                </td>

                                            </tr>
                                        <?php endfor; ?>
                                    </tbody>
                                </table>

                            </div>
                            <button type="submit" class="btn btn-warning pull-right">Modifier</button>


                        </form>

                    </div>
                    <!-- /.box-body -->

                </div>

            </div>

        </div>

    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>

    <script src="<?php echo e(asset('js/admin/profil/profil.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\profile\edit.blade.php ENDPATH**/ ?>