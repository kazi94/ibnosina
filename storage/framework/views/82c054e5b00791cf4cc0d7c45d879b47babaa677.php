<!-- Modal modifier Profile-->
<div class="modal" id="modal_modifier">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h3 class="modal-title"><b>Modifier Profile </b></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <!-- general form elements -->
                        <div class="box box-info" style="background: #5bc9f387;box-shadow: 3px 4px 7px 1px #cecece;">
                            <div class="box-header with-border">
                                <h3 class="box-title">Informations socio /profesionnelles
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                                action="<?php echo e(route('patient.update', $patient->id)); ?>">
                                <?php echo e(csrf_field()); ?> <?php echo e(method_field('PATCH')); ?>

                                <input type="text" name="created_by" hidden value="<?php echo e(Auth::user()->id); ?>">
                                <div class="box-body" style=" background-color: #e4e4e429">

                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-6 control-label">Num Sécurité
                                                    sociale</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="num_securite_sociale"
                                                        placeholder="Num sécurité sociale" name="num_securite_sociale">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-6 control-label">Code nationale</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="code_nationale"
                                                        placeholder="Code nationale" name="code_national">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-6 control-label">Ajouter Photo De
                                                    Profil</label>
                                                <div class="col-sm-6">
                                                    <!-- <button type="button" id="takePic" class="btn btn-primary " data-toggle="modal" data-target="#modal_webcam"><i class="fa fa-camera"></i></button> -->
                                                    <input type="file" name="photo" id="photo">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="col-sm-4 widget-user-image">
          <label ><img class="img-circle" id="photo" src="" style="max-height: 150px; max-width: 150px;"></label>
         </div> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Nom*</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nom" placeholder="Nom"
                                                name="nom" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Prénom*</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="prenom" placeholder="Prénom"
                                                name="prenom" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date" class="col-sm-2 control-label float-left contents"
                                            style="text-align: left;">Date de Naissance*</label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" id="date_naissance1" placeholder=""
                                                name="date_naissance" required>
                                        </div>
                                        <label class="col-sm-1 control-label">Sexe*</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="sexe" id="sexe">
                                                <option <?php if($patient->sexe == 'M'): ?> selected <?php endif; ?> value="M">M</option>
                                                <option <?php if($patient->sexe == 'F'): ?> selected <?php endif; ?> value="F">F</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="etat" <?php if($patient->sexe == 'M'): ?> style="display:none" <?php endif; ?>>
                                            <label class="col-sm-1 control-label">Etat</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" name="etat">
                                                    <option></option>
                                                    <option <?php if($patient->etat == 'alaitement'): ?> selected <?php endif; ?> value="alaitement">
                                                        Alaitement</option>
                                                    <option <?php if($patient->etat == 'grossesse'): ?> selected <?php endif; ?> value="grossesse">
                                                        Grossesse</option>
                                                    <option <?php if($patient->etat == 'normal'): ?> selected <?php endif; ?> value="normal">Normal
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="grossesse" <?php if($patient->sexe == 'M' && $patient->etat != 'grossesse'): ?> style="display:none" <?php endif; ?>>
                                            <label for="" class="col-sm-2 control-label">Mois</label>
                                            <div class="col-sm-5">
                                                <select class="form-control" name="grossesse_id">
                                                    <?php $__currentLoopData = $grossesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grossesse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($grossesse->cdf_code_pk); ?>"
                                                            <?php echo e($patient->grossesse_id == $grossesse->cdf_code_pk ? 'selected' : ''); ?>>
                                                            <?php echo e($grossesse->cdf_nom); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>

                                            <label class="col-sm-3 control-label">Début règles</label>

                                            <div class="col-sm-4">

                                                <input type="date" name="debut_regles" class="form-control"
                                                    value="<?php echo e($patient->debut_regles); ?>">

                                            </div>
                                            <label class="col-sm-2 control-label">Durée cycle</label>

                                            <div class="col-sm-3">

                                                <input type="number" name="duree_cycle" class="form-control"
                                                    value="<?php echo e($patient->duree_cycle); ?>">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Adresse</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="adresse" placeholder="Adresse"
                                                name="adresse">
                                        </div>

                                        <div class="col-sm-3">
                                            <select name="ville" id="villeId" class="form-control">
                                                <?php $__currentLoopData = $wilayas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wilaya): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($wilaya->id); ?>"
                                                        <?php echo e(isset($patient->villes) && $wilaya->id == $patient->villes->id ? 'selected' : ($wilaya->id == '13' ? 'selected' : '')); ?>>
                                                        <?php echo e($wilaya->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>

                                        <div class="col-sm-3">
                                            
                                            <select name="commune" id="communeId" class="form-control">
                                                <?php $__currentLoopData = $dairasPatient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daira): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($daira->id); ?>"
                                                        <?php echo e(isset($patient->communes) && $daira->id == $patient->communes->id ? 'selected' : ''); ?>>
                                                        <?php echo e($daira->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Taille(cm)</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" id="taille" placeholder="taille"
                                                name="taille">
                                        </div>
                                        <label class="col-sm-2 control-label">Poids (kg)</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="poids" placeholder="poids"
                                                name="poids">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Situation familiale</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="situation_familliale"
                                                id="situation_familliale">

                                                <option value="Marié(e)">Marié(e)</option>
                                                <option value="Célibataire" selected>Célibataire</option>
                                                <option value="Divorcé">Divorcé</option>

                                            </select>
                                        </div>
                                        <div class="col-sm-4" id="nbre_enfants" hidden>
                                            <input type="number" class="form-control" placeholder="nombre d'enfants"
                                                id="nbre" name="nbre_enfants" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Travaile</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="travaille" id="travaille">

                                                <option value="Retraité">Retraité</option>
                                                <option value="Universitaire">Universitaire</option>
                                                <option value="autre">autre :</option>

                                            </select>
                                        </div>
                                        <div class="col-sm-4" id="autre" hidden>
                                            <input type="text" class="form-control" placeholder="travaile"
                                                id="travaille1" name="travaille1"
                                                value="<?php echo e($patient->travaille1); ?>" />
                                        </div>
                                    </div>
                                    <label class="control-label">MODE DE VIE :</label>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Tabac :</label>

                                            <div class="col-sm-1">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="tabagiste" id="tabac"
                                                            class="">Oui </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="tabac" style="display:none">

                                                <label class=" col-sm-2 control-label"> Depuis:</label>

                                                <div class="col-sm-2">
                                                    <input type="number" class="form-control" placeholder=""
                                                        name="tabagiste_depuis" value="" id="tabac1">
                                                </div>
                                                <div class="col-sm-1 pt-2">Mois</div>


                                                <label class="col-sm-3 control-label flo"> Cigarettes/j:</label>
                                                <div class=" col-sm-3">
                                                    <input type="number" class="form-control" placeholder=""
                                                        name="cigarettes" id="cigarettes">

                                                </div>
                                                <label class=" col-sm-3 control-label"> Arréter Depuis:</label>
                                                <div class=" col-sm-3">
                                                    <input type="date" class="form-control" placeholder=""
                                                        name="tabagiste_arreter_depuis" id="tabac_stop">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Alcool :</label>
                                        <div class="col-sm-1">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="alcoolique" id="alcool" class="">Oui
                                                </label>
                                            </div>
                                        </div>
                                        <label class="alcool col-sm-2 control-label" hidden> Depuis:</label>
                                        <div class="alcool col-sm-4" hidden>
                                            <input type="date" class="form-control" placeholder="" id="alcool1"
                                                name="alcoolique_depuis" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Drogue :</label>
                                        <div class="col-sm-1">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="drogue" id="drogue" class="">Oui
                                                </label>
                                            </div>
                                        </div>
                                        <label class="drogue col-sm-2 control-label" hidden> Depuis:</label>
                                        <div class="drogue col-sm-4" hidden>
                                            <input type="date" class="form-control" placeholder="" id="drogue1"
                                                name="drogue_depuis" />
                                        </div>
                                    </div>
                                    <div class="drogue col-sm-12" hidden><input type="text" name="details" id="type_dr"
                                            class="form-control" placeholder="Type de drogues"></div>
                                    <div class="form-group col-sm-7">

                                        <label class="control-label">Cordonnées :</label>
                                        <div class="input-group col-sm-7">
                                            <div class="input-group-addon alert-success">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" class="form-control" name="num_tel_1" required
                                                data-inputmask="" data-mask="" id="num_tel_1">
                                        </div><br />
                                        <div class="input-group col-sm-7">
                                            <div class="input-group-addon alert-success">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" class="form-control" name="num_tel_2" data-inputmask=""
                                                data-mask="" id="num_tel_2">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-5" id="p_tierce_div" hidden>
                                        <label class="control-label">Tierce personne :</label>
                                        <input type="text" class="form-control" id="p_tierce"
                                            placeholder="personne à contacter" name="p_tierce">
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <!-- general form elements -->
                        <div class="box box-info" style="background: #5bc9f387; box-shadow: 3px 4px 7px 1px #cecece;">
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="form-horizontal" style="background-color: #e4e4e429">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 control-label">N° Dossier:</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="num_dossier" placeholder=""
                                                name="num_dossier">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label">Pathologie(s) associée(s) :</label>
                                        <div class="col-sm-6">

                                            <select class="form-control pathologies" multiple="multiple"
                                                style="width: 100%;" name="pathologies[]">

                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label">Antécedent(s) Familiaux:</label>
                                        <div class="col-sm-6">

                                            <select class="form-control ants_fam" multiple="multiple"
                                                style="width: 100%;" name="famille_antecedants[]">

                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-5 control-label">Antécedant(s) Chirugicaux :</label>
                                        <div class="col-sm-6 col-xs-10">

                                            <select class="form-control select2 select2-hidden-accessible" id="acts"
                                                multiple="" data-placeholder="Antécedant(s) Chirugicaux"
                                                style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                name="operations[]">
                                                <?php
                                                    $operations = DB::select('select * from operation_chirugicales');
                                                ?>
                                                <?php $__currentLoopData = $operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($operation->id); ?>" <?php $__currentLoopData = $patient->operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operationPatient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  <?php if($operation->id==$operationPatient->id): ?>
                                                        selected <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                ><?php echo e($operation->nom); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>

                                        </div>
                                        <div class="col-sm-1 no-padding">
                                            <button type="button" class="btn btn-sm btn-primary mt-1"
                                                data-toggle="modal" data-target="#modal-add-act">+</button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-5 control-label">Allergie(s) associée(s):</label>
                                        <div class="col-sm-6">

                                            <select class="form-control allergies" multiple="multiple"
                                                style="width: 100%;" name="allergies[]">

                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Co-sanguinité :</label>

                                        <div class="col-sm-8">
                                            <select class="form-control" name="cosanguinite">
                                                <option value="1"
                                                    <?php echo e($patient->cosanguinite == 1 ? 'selected' : ''); ?>>
                                                    1er dégré</option>
                                                <option value="2"
                                                    <?php echo e($patient->cosanguinite == 2 ? 'selected' : ''); ?>>
                                                    2ème degré</option>
                                            </select>
                                        </div>

                                    </div>
                                    


                                    <div class="form-group">

                                        <label class="col-sm-5 control-label">Group Sanguin :</label>

                                        <div class="col-sm-4">
                                            <select class="form-control" name="groupe_sanguin">
                                                <option value=""></option>
                                                <option value="O RH+" <?php if ($patient->groupe_sanguin
                                                    == 'O RH+') {
                                                    echo 'selected';
                                                    } ?>>O RH+</option>
                                                <option value="O RH-" <?php if ($patient->groupe_sanguin
                                                    == 'O RH-') {
                                                    echo 'selected';
                                                    } ?>>O RH-</option>
                                                <option value="AB RH+" <?php if ($patient->groupe_sanguin
                                                    == 'AB RH+') {
                                                    echo 'selected';
                                                    } ?>>AB RH+</option>
                                                <option value="AB RH-" <?php if ($patient->groupe_sanguin
                                                    == 'AB RH-') {
                                                    echo 'selected';
                                                    } ?>>AB RH-</option>
                                                <option value="A RH+" <?php if ($patient->groupe_sanguin
                                                    == 'A RH+') {
                                                    echo 'selected';
                                                    } ?>>A RH+</option>
                                                <option value="A RH-" <?php if ($patient->groupe_sanguin
                                                    == 'A RH-') {
                                                    echo 'selected';
                                                    } ?>>A RH-</option>
                                                <option value="B RH+" <?php if ($patient->groupe_sanguin
                                                    == 'B RH+') {
                                                    echo 'selected';
                                                    } ?>>B RH+</option>
                                                <option value="B RH+" <?php if ($patient->groupe_sanguin
                                                    == 'B RH-') {
                                                    echo 'selected';
                                                    } ?>>B RH-</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-default btn-lg" data-dismiss="modal" value="fermer">
                    <input type="submit" class="btn btn-primary btn-lg pull-right" value="Modifier">
                    </form>
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-detail-profil">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="bg-blue modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h3 class="modal-title"><b>Profile patient</b></h3>
            </div>
            <div class="modal-body">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">

                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class=" widget-user-header" style="background: #3c8dbc; padding-left:5px">
                        <h3 class="widget-user-username"><?php echo e($patient->nom); ?> <?php echo e($patient->prenom); ?></h3>
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
                        <h3 class="box-title">A propos du Patient</h3>
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
                            <?php if($patient->communes): ?> <?php echo e($patient->communes->name); ?>

                                ,
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

                                <?php echo $patient->paquets
                                ? ' (<span class="text-info">' .
                                    $patient->paquets .
                                    '
                                    Pa/jours</span>)'
                                : ''; ?>

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
                                    <?php echo e(strtolower($path->pathologie)); ?>

                                    <?php echo e($patient->pathologies != '' ? ',' : ' '); ?>

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
                    <div class="modal-footer">
                        <input type="reset" class="btn btn-default" data-dismiss="modal" value="fermer">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $__env->make('includes.modals.add-act', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\modals\profile.blade.php ENDPATH**/ ?>