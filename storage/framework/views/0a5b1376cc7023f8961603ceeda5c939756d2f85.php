    <div class="col-md-3 d-sm-none" id="aside-profil">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">

            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class=" widget-user-header" style="background: #3c8dbc; padding-left:5px">
                <h3 class="widget-user-username"><?php echo e($patient->nom); ?> <?php echo e($patient->prenom); ?></h3>
                
                <button class="switch " id="" style="right: 0%;
                    position: absolute;
                    bottom: 82px;
                    background-color: transparent;
                    border: none;">
                    <span style="font-size:  40px;">-</span>
                </button>
                <?php if($patient->hospi): ?>
                    <p class="">
                        <strong>Chambre n°: <?php echo e($patient->hospi->chambre); ?> Lit n°:
                            <?php echo e($patient->hospi->lit); ?></strong>
                    </p>
                    <h4 class="text-uppercase">
                        <span class="label label-success"><?php echo e($patient->hospi->service); ?></span>
                    </h4>
                <?php else: ?> <span class="label label-danger">Hors CHU</span>
                <?php endif; ?>
            </div>
            <div class="widget-user-image ">
                <a href="<?php echo e(asset('images/avatar/' . $patient->photo . '')); ?>" target="_blank"
                    style="position: absolute; top: 65px; right: 8px;">
                    <i class="bg-blue-gradient fa fa-arrows-alt img-thumbnail"></i>
                </a>
                <img class="img-circle" src="<?php echo e(asset('images/avatar/' . $patient->photo . '')); ?>" alt="User Avatar" />
            </div>
        </div>
        <!-- /.widget-user -->
        <div class="box box-primary" style="margin-top: -10px;">
            <div class="box-header with-border">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('patients.update', Auth::user())): ?>
                    

                    <button class="btn btn-success up_patient" data="<?php echo e($patient->id); ?>"
                        title="Modifier le profile du patient"
                        style="position: absolute;top: 7px;border: none;font-size: 12.5px;right: 2%;">
                        <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                    </button>
                    <button id="btn_ann_pat" class="btn btn-primary" data-toggle="modal"
                        title="Ajouter une annotation sur le patient" data-target="#modal_annotation" data-type="patient"
                        style="position: absolute;top: 7px;border: none;right: 43px;font-size: 12.5px;">
                        <i class="fa fa-comment-medical" aria-hidden="true"></i>
                    </button>
                    
                <?php endif; ?>
                <h3 class="box-title">A propos du Patient
                </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <?php if($patient->date_naissance != ''): ?>
                    <p><strong>Age : </strong>
                        <?php echo e($patient->age); ?>

                        ans
                    </p>
                <?php endif; ?>

                <?php if(isset($patient->poids)): ?>

                    <p><strong>Poids : </strong>
                        <?php echo e($patient->poids); ?> kg
                    </p>
                <?php endif; ?>
                <?php if($patient->taille != ''): ?>
                    <p><strong>Taille : </strong> <?php echo e($patient->taille); ?> cm </p>
                <?php endif; ?>
                <?php if($patient->travaille != ''): ?>
                    <p><strong>Travaille: </strong>
                        <?php echo e($patient->travaille == 'autre' ? $patient->travaille1 : $patient->travaille); ?>

                    </p>
                <?php endif; ?>
                <?php if(isset($patient->situation_familliale)): ?>
                    <p>
                        <strong>Situation familliale: </strong>
                        <?php echo e($patient->situation_familliale); ?>

                        <?php echo e(isset($patient->nbre_enfants) ? '(' . $patient->nbre_enfants . ' enfants)' : ''); ?>

                    </p>
                <?php endif; ?>
                <strong>Adresse : </strong>
                <p>
                    <?php if($patient->villes): ?> <?php echo e($patient->villes->name); ?> ,
                    <?php endif; ?>
                    <?php if($patient->communes): ?> <?php echo e($patient->communes->name); ?> ,
                    <?php endif; ?>
                    <?php if($patient->adresse): ?> <?php echo e($patient->adresse); ?> .
                    <?php endif; ?>
                </p>
                <strong>Cordonnées</strong>
                <?php if($patient->num_tel_1): ?>
                    <p><?php echo e($patient->num_tel_1); ?></p>
                <?php endif; ?>
                <?php if($patient->num_tel_2): ?>
                    <p><?php echo e($patient->num_tel_2); ?></p>
                <?php endif; ?>
                <p>
                    <strong>
                        <?php echo e($patient->tabagiste ? 'Tabagiste' : ''); ?>

                        <?php echo $patient->paquets ? ' (<span class="text-info">' . $patient->paquets . ' Pa/jours</span>)' : ''; ?>

                        <?php echo e($patient->tabagiste_arreter_depuis ? ' Arréter le : ' . $patient->tabagiste_arreter_depuis . '.' : ''); ?>


                        <?php if($patient->alcoolique): ?> alcoolique
                            (<?php echo e($patient->alcoolique_depuis); ?>).<?php endif; ?>
                        <?php if($patient->drogue): ?> drogué
                            (<?php echo e($patient->details); ?>)(<?php echo e($patient->drogue_depuis); ?>)<?php endif; ?>
                    </strong>
                </p>
                <?php if(!is_null($patient->pathologies)): ?>
                    <strong>Pathologie(s) associée(s) :</strong>
                    <p>
                        <?php $__currentLoopData = $patient->pathologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $path): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e(strtolower($path->pathologie)); ?> <?php echo e($patient->pathologies != '' ? ',' : ' '); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                <?php endif; ?>
                <?php if(!empty($patient->allergies)): ?>

                    <p>
                        <strong>Allergie(s) associée(s) :</strong>
                        <?php $__currentLoopData = $patient->allergies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e(strtolower($all->allergie)); ?> <?php echo e($patient->allergies != '' ? ',' : ''); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                <?php endif; ?>
                <?php if(isset($patient->operations)): ?>
                    <p>
                        <strong>Antécedants Chirugicaux: </strong>
                        <?php $__currentLoopData = $patient->operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e($all->nom); ?> <?php echo e($patient->operations != '' ? ',' : ''); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                <?php endif; ?>
                <?php if(isset($patient->antecedentsFamilliaux)): ?>
                    <p>
                        <strong>Antécédents Familiaux :</strong>
                        <?php $__currentLoopData = $patient->antecedentsFamilliaux; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php echo e(strtolower($ant->pathologie)); ?>

                            <?php echo e($patient->antecedentsFamilliaux != '' ? ',' : ''); ?>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </p>
                <?php endif; ?>
                <?php if($patient->groupe_sanguin): ?>
                    <p>
                        <strong>Groupe Sanguin: </strong>
                        <?php echo e($patient->groupe_sanguin); ?>

                    </p>
                <?php endif; ?>
                <?php if(!empty($patient->grossesse_id)): ?>
                    <p>
                        <strong>Mois de grossesse: </strong>
                        <?php echo e($patient->pregnant->cdf_nom); ?>

                    </p>
                <?php endif; ?>
                <?php if($patient->debut_regles): ?>
                    <p>
                        <strong>Règles début : </strong>
                        <?php echo e($patient->debut_regles); ?>

                        <?php if($patient->duree_cycle): ?>
                            <strong>Durée du cycle : </strong>
                            <?php echo e($patient->duree_cycle); ?>

                        <?php endif; ?>
                    </p>
                <?php endif; ?>
                <?php if($patient->cosanguinite): ?>
                    <p>
                        <strong>Co-sanguinite: </strong>
                        <?php echo e($patient->cosanguinite); ?> er degré
                    </p>
                <?php endif; ?>
            </div>
            <!-- /.box-body -->
        </div>
    </div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\profile.blade.php ENDPATH**/ ?>