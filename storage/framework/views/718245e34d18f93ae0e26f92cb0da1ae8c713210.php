<div class="row">

    <div class="col-md-8 col-md-offset-2">

        <!-- general form elements -->
        <div class="box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title text-bold">Informations socio-professionnelles

                </h3>
            </div>
            <input type="text" name="created_by" id="" hidden value="<?php echo e(Auth::user()->id); ?>">
            <div class="box-body" style=" background-color: #e4e4e429">

                <div class="row">
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">N° dossier <span
                                class="text-red">*</span></label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="num_dossier" placeholder="" name="num_dossier"
                                required value="<?php echo e(isset($patient->num_dossier) ? $patient->num_dossier : ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Num sécurité
                            sociale</label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="num_securite_sociale"
                                placeholder="Num sécurité sociale" name="num_securite_sociale"
                                value="<?php echo e(isset($patient->num_securite_sociale) ? $patient->num_securite_sociale : ''); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Code nationale</label>

                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="code_nationale" placeholder="Code nationale"
                                name="code_nationale"
                                value="<?php echo e(isset($patient->code_nationale) ? $patient->code_nationale : ''); ?>">
                        </div>

                    </div>
                    <div class="form-group">
                        <label for="name" class="col-sm-4 control-label">Photo patient</label>
                        <div class="col-sm-4">
                            <input type="file" name="photo" id="photo" accept="image/*" capture="camera">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Nom<span class="text-red">*</span></label>

                    <div class="col-sm-5">
                        <input type="hidden" id="patient-id">
                        <input type="text" class="form-control" id="nom" placeholder="Nom" name="nom" required
                            value="<?php echo e(isset($patient->nom) ? $patient->nom : ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-4 control-label">Prénom<span class="text-red">*</span></label>

                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="prenom" placeholder="Prénom" name="prenom" required
                            value="<?php echo e(isset($patient->prenom) ? $patient->prenom : ''); ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label for="date" class="col-sm-2 control-label float-left contents" style="text-align: left;">Date
                        de
                        Naissance<span class="text-red">*</span></label>

                    <div class="col-sm-4">
                        <input type="date" class="form-control" id="date_naissance" placeholder="" name="date_naissance"
                            value="<?php echo e(isset($patient->date_naissance) ? $patient->date_naissance : ''); ?>" required>
                    </div>
                    
                    <label class="col-sm-1 control-label">Sexe<span class="text-red">*</span></label>

                    <div class="col-sm-2">
                        <select class="form-control" name="sexe"
                            value="<?php echo e(isset($patient->sexe) ? $patient->sexe : ''); ?>">
                            <option selected value="M">M</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div id="etat" style="display:none">
                        <label class="col-sm-1 control-label">Etat</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="etat"
                                value="<?php echo e(isset($patient->etat) ? $patient->etat : ''); ?>">
                                <option selected value="alaitement">Alaitement</option>
                                <option value="grossesse">Grossesse</option>
                                <option value="normal">Normal</option>
                            </select>
                        </div>
                    </div>
                    <div id="grossesse" style="display:none">
                        <label for="" class="col-sm-2 control-label">Mois</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="grossesse_id">
                                <option value=""></option>
                                <?php $__currentLoopData = $grossesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grossesse): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($grossesse->cdf_code_pk); ?>">
                                        <?php echo e($grossesse->cdf_nom); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <label class="col-sm-3 control-label">Début règles</label>

                        <div class="col-sm-4">

                            <input type="date" name="debut_regles" class="form-control">

                        </div>
                        <label class="col-sm-2 control-label">Durée cycle</label>

                        <div class="col-sm-3">

                            <input type="number" name="duree_cycle" class="form-control">

                        </div>

                    </div>
                </div>
                <div class="form-group">

                    <label class="col-sm-2 control-label">Adresse</label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="adresseId" placeholder="Adresse" name="adresse"
                            value="<?php echo e(isset($patient->adresse) ? $patient->adresse : ''); ?>"
                            autocomplete="section-red shipping address-level2">
                    </div>

                    <div class="col-sm-3">
                        
                        <select name="ville" id="villeId" class="form-control select2">
                            <?php $__currentLoopData = $wilayas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wilaya): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($wilaya->id); ?>" <?php echo e($wilaya->id == '13' ? 'selected' : ''); ?>>
                                    <?php echo e($wilaya->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <div class="col-sm-3">
                        
                        <select name="commune" id="communeId" class="select2 form-control ">
                            <?php $__currentLoopData = $dairasTlemcen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $daira): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($daira->id); ?>" <?php echo e($daira->id == '1301' ? 'selected' : ''); ?>>
                                    <?php echo e($daira->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>


                </div>

                

                

                <div class="form-group">

                    <label class="col-sm-4 control-label">Situation familiale</label>

                    <div class="col-sm-4">
                        <select class="form-control" name="situation_familliale" id="situation_familliale"
                            value="<?php echo e(isset($patient->situatin_familliale) ? $patient->situatin_familliale : ''); ?>">

                            <option value="Marié(e)">Marié(e)</option>
                            <option value="Célibataire" selected>Célibataire</option>
                            <option value="Divorcé">Divorcé</option>


                        </select>
                    </div>

                    <div class="col-sm-4" id="nbre_enfants" hidden>
                        <input type="number" class="form-control" placeholder="nombre d'enfants" name="nbre_enfants"
                            value="<?php echo e(isset($patient->nbre_enfants) ? $patient->nbre_enfants : ''); ?>" />
                    </div>

                </div>
                <div class="form-group">

                    <label class="col-sm-4 control-label">Travaile</label>

                    <div class="col-sm-4">
                        <select class="form-control" name="travaille" id="travaille"
                            value="<?php echo e(isset($patient->traville) ? $patient->traville : ''); ?>">

                            <option value="Retraité">Retraité</option>
                            <option value="Universitaire">Universitaire</option>
                            <option value="Autre">Autre :</option>


                        </select>
                    </div>

                    <div class="col-sm-4" id="autre" hidden>
                        <input type="text" class="form-control" placeholder="travaille" name="travaille"
                            value="<?php echo e(isset($patient->travaille) ? $patient->travaille : ''); ?>" />
                    </div>

                </div>
                <label class="control-label">MODE DE VIE :</label>

                <div class="form-group">
                    <div class="row">
                        <label class="col-sm-2 control-label">Tabac </label>

                        <div class="col-sm-1">
                            <div class="checkbox">
                                <label><input type="checkbox" name="tabagiste" id="tabac" class="">Oui
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="tabac" style="display:none">

                            <label class=" col-sm-2 control-label">Depuis</label>

                            <div class="col-sm-2">
                                <input type="number" class="form-control" placeholder="" name="tabagiste_depuis"
                                    value="">
                            </div>
                            <div class="col-sm-1 pt-2">Mois</div>


                            <label class="col-sm-3 control-label flo"> Cigarettes/j</label>
                            <div class=" col-sm-3">
                                <input type="number" class="form-control" placeholder="" name="cigarettes" value="">

                            </div>
                            <label class=" col-sm-3 control-label"> Arréter Depuis</label>
                            <div class=" col-sm-3">
                                <input type="date" class="form-control" placeholder="" name="tabagiste_arreter_depuis"
                                    value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">

                    <label class="col-sm-2 control-label">Alcool </label>

                    <div class="col-sm-1">
                        <div class="checkbox">
                            <label><input type="checkbox" name="alcoolique" id="alcool">Oui </label>
                        </div>
                    </div>

                    <label class="alcool col-sm-2 control-label" hidden> Depuis</label>
                    <div class="alcool col-sm-4" hidden>
                        <input type="date" class="form-control" placeholder="" name="alcoolique_depuis" />
                    </div>

                </div>
                <div class="form-group">

                    <label class="col-sm-2 control-label">Drogue </label>

                    <div class="col-sm-1">
                        <div class="checkbox">
                            <label><input type="checkbox" name="drogue" id="drogue" class="">Oui
                            </label>
                        </div>
                    </div>

                    <label class="drogue col-sm-2 control-label" hidden> Depuis</label>
                    <div class="drogue col-sm-4" hidden>
                        <input type="date" class="form-control" placeholder="" name="drogue_depuis" />
                    </div>
                    <div class="drogue col-sm-3" hidden>
                        <input type="text" name="details" class="form-control" placeholder="Type de drogues" />
                    </div>

                </div>
                <div class="form-group col-sm-7">

                    <label class="control-label">Cordonnées </label>
                    <div class="input-group col-sm-7">
                        <div class="input-group-addon alert-success">
                            <i class="fa fa-phone"></i>
                        </div>
                        <input type="text" class="form-control" name="num_tel_1" data-inputmask=""
                            placeholder="numero obligatoire" data-mask="" required value="00000000">
                    </div><br />
                    <div class="input-group col-sm-7">
                        <div class="input-group-addon alert-success">
                            <i class="fa fa-phone"></i>
                        </div>
                        <input type="text" class="form-control" name="num_tel_2" data-inputmask="" data-mask=""
                            placeholder="Numéro facultatif"
                            value="<?php echo e(isset($patient->num_tel_2) ? $patient->num_tel_2 : ''); ?>">
                    </div>
                </div>

                <div class="form-group col-sm-5" id="p_tierce_div" hidden>
                    <label class="control-label">Tierce personne </label>
                    <input type="text" class="form-control" id="p_tierce" placeholder="personne à contacter"
                        name="p_tierce">
                </div>

            </div>
        </div>
        <div class="">
            <button type="submit" class="btn btn-success pull-right">Suivant</button>
        </div>

    </div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\includes\forms\patient.blade.php ENDPATH**/ ?>