<?php $__env->startSection('script_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('/plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('/plugins/jquery/css/jquery_ui.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">

        <?php if(count($errors) > 0): ?>

            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <p class="alert alert-danger"><?php echo e($error); ?></p>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php endif; ?>

        <div class="alert alert-danger" style="display: none;"></div>

        <?php if(session()->has('message')): ?>

            <p class="alert alert-success"><?php echo e(session('message')); ?></p>

        <?php endif; ?>

        <div class="row">
            <div class="col-md-8 col-xs-12 col-md-offset-2">
                <!-- Horizontal Form -->
                <div class="box box-info">

                    <div class="box-header with-border">

                        <a href="#aideModal" style="float: right;" data-toggle="modal" data-target="#aideModal">Aide <span
                                class="fa fa-question-circle"></span></a>

                        </ul>
                        <!--<h3 class="box-title">Ajouter une règle</h3>-->

                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <!--pour choisir entre regle medic ou patient-->

                    <div class="box-body">
                        <div role="tabpanel">

                            <ul class="nav nav-tabs" id="tablist">
                                <li role="presentation" class="active" id="the"><a href="#analysepharm"
                                        aria-controls="theriaque" role="tab" data-toggle="tab">Analyse pharmaceutique</a>
                                </li>
                                <li role="presentation" id="educ"><a href="#edu" aria-controls="theriaque" role="tab"
                                        data-toggle="tab">Education thérapeutique</a></li>
                                <li role="presentation" id="sui"><a href="#suivi" aria-controls="theriaque" role="tab"
                                        data-toggle="tab">Pilotage donnée patient</a></li>

                            </ul>

                            <div class="tab-content">
                                <!--ici c'est le contenu de l'onglet 1-->
                                <div role="tabpanel" class="tab-pane active" id="analysepharm">
                                    <!--onglet 1-->

                                    <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                                        <p> </p><br>
                                        ______________________________REGLE PATIENT______________________________
                                        <p> </p><br>
                                    </div>

                                    <div class="element" style="">
                                        <form method="POST" action="<?php echo e(route('reglee.store')); ?>"
                                            enctype="multipart/form-data">
                                            <?php echo e(csrf_field()); ?>

                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="exampleFormControlSelect2">Choisissez:</label>
                                                    <select class="form-control" id="critere" onclick="showAttribut()">
                                                        <option></option>
                                                        <option>Age(ans)</option>
                                                        <option>Taille(cm)</option>
                                                        <option>Poids(kg)</option>
                                                        <option>Sexe</option>
                                                        <option>Mode de vie</option>
                                                        <option>Pathologie(s) associée(s)</option>
                                                        <option>Allergie(s) associée(s)</option>
                                                        <option>Examens</option>
                                                        <option>Service</option>
                                                        <option>Durée hospitalisation(jours)</option>
                                                        <option>état de la patiente</option>
                                                        <!--<option>Observance</option>-->
                                                        <option>Activité professionnel</option>
                                                        <option>Nombre de ligne prescription</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="divDynamque1">
                                                </div>
                                                <div class="form-group col-sm-4" id="divDynamque2">
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="row">
                                                <div class="form-group col-sm-6" id="divDynamque11">
                                                </div>
                                                <div class="form-group col-sm-6" id="divDynamque22">
                                                </div>

                                            </div>
                                            <!--row-->


                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                                                ____________________________REGLE MEDICAMENT____________________________
                                                <p> </p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="exampleFormControlSelect2">Choisissez:</label>
                                                    <select class="form-control" id="choice" onclick="showMedicament()">
                                                        <option></option>
                                                        <option>Produits Alimentaires</option>
                                                        <option>Médicament</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-4" id="div1">
                                                </div>
                                                <div class="form-group col-sm-4" id="div2">
                                                </div>
                                            </div>
                                            <!--row-->
                                            <div class="row">
                                                <div class="form-group col-sm-6" id="div11">
                                                </div>
                                                <div class="form-group col-sm-6" id="div22">
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                ________________________________FONCTIONS________________________________
                                                <p></p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4" id="operation">
                                                    <label for="exampleFormControlSelect1">operation</label>
                                                    <select class="form-control" id="operationSelect"
                                                        onclick="recuperer('operationSelect')">
                                                        <option></option>
                                                        <option>+</option>
                                                        <option>-</option>
                                                        <option>/</option>
                                                        <option>=</option>
                                                        <option>!=</option>
                                                        <option>></option>
                                                        <option>
                                                            << /option>
                                                        <option>>=
                                                        </option>
                                                        <option>
                                                            <=< /option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="operateur">
                                                    <label for="exampleFormControlSelect1">operateur</label>
                                                    <select class="form-control" id="operateurSelect"
                                                        onclick="recuperer('operateurSelect')">
                                                        <option></option>
                                                        <option>ET</option>
                                                        <option>OU</option>
                                                        <!--<option>NON</option>-->
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="autre">
                                                    <label for="exampleFormControlSelect1">autre:</label>
                                                    <select class="form-control" id="autreSelect"
                                                        onclick="recuperer('autreSelect')">
                                                        <option>;</option>
                                                        <option>/</option>
                                                        <option>.</option>
                                                        <option>{</option>
                                                        <option>}</option>
                                                        <option value="abs">abs</option>
                                                        <option>(</option>
                                                        <option>)</option>
                                                        <option>[</option>
                                                        <option>]</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="form-group" id="textSelection">
                                                <!--premier si -->
                                                <label for="exampleFormControlTextarea1">Si:</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" name="si"
                                                    rows="5" onkeypress="interdireEcriture()" require></textarea>
                                            </div>
                                            <div class="form-group" id="resultat">
                                                <label for="exampleFormControlSelectAge">Alors:</label>
                                                <select class="form-control" id="resultatSelect" name="alors">
                                                    <option>prescription à risque</option>
                                                    <option>patient à risque</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">commentaire :</label>
                                                <textarea class="form-control" name="commentaire"
                                                    id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                            <input type="hidden" name="type" value="patient">
                                            <input type="submit" class="btn btn-primary pull-right" value="Confirmer">
                                            <p> </p><br><br><br>
                                        </form>
                                    </div>
                                    <!--element-->

                                    <div class="box-footer ">
                                        <?php $reglees = DB::table('reglees')
                                        ->select('reglees.*')
                                        ->get(); ?>
                                        <?php if(count($reglees) > 0): ?>
                                            <table class="table table-bordered text-center element " id="id1">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Si</th>
                                                        <th>Alors</th>
                                                        <th>Commentaire</th>

                                                        <th>Modifier</th>
                                                        <th>Supprimer</th>
                                                </thead>
                                                <tbody class="regle_footer">
                                                    <?php $__currentLoopData = $reglees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reglee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>

                                                            <td><?php echo e($reglee->si); ?></td>
                                                            <td><?php echo e($reglee->alors); ?></td>
                                                            <td><?php echo e($reglee->commentaire); ?></td>

                                                            <td><a href="<?php echo e(route('reglee.edit', $reglee->id)); ?>"><span
                                                                        class="glyphicon glyphicon-edit"></span></a></td>
                                                            <td>
                                                                <form style="display: none;" method="POST"
                                                                    action="<?php echo e(route('reglee.destroy', $reglee->id)); ?>"
                                                                    id="delete-form-<?php echo e($reglee->id); ?>">
                                                                    <?php echo e(csrf_field()); ?>

                                                                    <?php echo e(method_field('DELETE')); ?>

                                                                </form>
                                                                <a href="" onclick="
                             if (confirm('voulez vous supprimer cette ligne ?')) {
                             event.preventDefault();
                             document.getElementById('delete-form-<?php echo e($reglee->id); ?>').submit();										}
                            " style="color: inherit; "><span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        <?php endif; ?>

                                    </div>
                                    <!--div footer-->

                                </div>
                                <!---onglet 1-->




                                <div role="tabpanel" class="tab-pane" id="edu">
                                    <!--Onglet 2-->
                                    <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                                        <p> </p><br>
                                        ______________________________Education thérapeutique______________________________
                                        <p> </p><br>
                                    </div>
                                    <div class="element_onglet2" style="">
                                        <form method="POST" action="<?php echo e(route('education.store')); ?>"
                                            enctype="multipart/form-data">
                                            <?php echo e(csrf_field()); ?>

                                            <div class="row">
                                                <div class="form-group col-sm-4" id="choix">
                                                    <label for="exampleFormControlSelect2">Choisissez:</label>
                                                    <select class="form-control" id="choixSelect"
                                                        onclick="recuperer('choixSelect')">
                                                        <option></option>
                                                        <option>pathologie</option>
                                                        <!--option>observance</option-->
                                                        <option>médicament</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4" id="patho">
                                                    <label for="exampleFormControlSelect2">Pathologie(s) associée(s)</label>
                                                    <select class="form-control" id="pathoSelect"
                                                        onclick="recuperer('pathoSelect')">
                                                        <?php
                                                        $pathologies = DB::select("select * from pathologies");
                                                        ?>
                                                        <?php $__currentLoopData = $pathologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pathologie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($pathologie->pathologie); ?>">
                                                                <?php echo e($pathologie->pathologie); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="ob">
                                                    <label for="exampleFormControlSelect2">Observance</label>
                                                    <select class="form-control" id="obSelect"
                                                        onclick="recuperer('obSelect')">
                                                        <option>modérément observant</option>
                                                        <option>très observant</option>
                                                        <option>non observant</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="med">
                                                    <label for="exampleFormControlSelect2">Médicament DCI</label>
                                                    <input type="text" class="form form-control"
                                                        placeholder="Médicament DCI ou médicament commerciale"
                                                        name="medicament_dci" autocomplete="off" id="medSelect"
                                                        onclick="recuperer('medSelect')">
                                                </div>


                                            </div>
                                            <!--row-->



                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                ________________________________FONCTIONS________________________________
                                                <p></p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4" id="op">
                                                    <label for="exampleFormControlSelect1">operation</label>
                                                    <select class="form-control" id="opSelect"
                                                        onclick="recuperer('opSelect')">
                                                        <option></option>
                                                        <option>+</option>
                                                        <option>-</option>
                                                        <option>/</option>
                                                        <option>=</option>
                                                        <option>!=</option>
                                                        <option>></option>
                                                        <option>
                                                            << /option>
                                                        <option>>=
                                                        </option>
                                                        <option>
                                                            <=< /option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="operateurr">
                                                    <label for="exampleFormControlSelect1">operateur</label>
                                                    <select class="form-control" id="operateurrSelect"
                                                        onclick="recuperer('operateurrSelect')">
                                                        <option></option>
                                                        <option>ET</option>
                                                        <option>OU</option>
                                                        <!--<option>NON</option>-->
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="autres">
                                                    <label for="exampleFormControlSelect1">autre:</label>
                                                    <select class="form-control" id="autresSelect"
                                                        onclick="recuperer('autresSelect')">
                                                        <option>;</option>
                                                        <option>/</option>
                                                        <option>.</option>
                                                        <option>{</option>
                                                        <option>}</option>
                                                        <option value="abs">abs</option>
                                                        <option>(</option>
                                                        <option>)</option>
                                                        <option>[</option>
                                                        <option>]</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="form-group" id="titreSelection">
                                                <label>Titre de la règle:</label>
                                                <textarea class="form-control" name="titre"></textarea>
                                            </div>
                                            <div class="form-group" id="texteSelection">
                                                <label for="exampleFormControlTextarea2">Si:</label>
                                                <!--deuxieme si-->
                                                <textarea class="form-control" id="exampleFormControlTextarea2" name="si"
                                                    rows="5" onkeypress="interdireEcriture()" require></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label ">commentaire :</label>
                                                    <textarea class=" form-control" name="commentaire" rows="3"></textarea>
                                            </div>
                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                _____________________________A propos de
                                                l'éducation_____________________________
                                                <p></p><br>
                                            </div>
                                            <div class="form-group">
                                                <label>Explication de la maladie :</label>
                                                <textarea class="form-control" name="maladie" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Effets de médicament :</label>
                                                <textarea class="form-control" name="effet" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Conduite à tenir pendant le voyage :</label>
                                                <textarea class="form-control" name="voyage" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Act chirurgical :</label>
                                                <textarea class="form-control" name="act" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Comment utiliser le médicament :</label>
                                                <textarea class="form-control" name="utilisation" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Effets indésirables:</label>
                                                <textarea class="form-control" name="effet_indiserable" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>regles hygiéno-diètétique :</label>
                                                <textarea class="form-control" name="regime" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Ajouter URL :</label>
                                                <textarea class="form-control" name="url" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Joindre un fichier :</label>
                                                <input type="file" name="pdf" id="pdf" multiple>
                                            </div>


                                            <input type="hidden" name="type" value="educRegle">
                                            <input type="submit" class="btn btn-primary pull-right" value="Confirmer">
                                            <p> </p><br><br><br>
                                        </form>
                                    </div>
                                    <!--element-->

                                    <div class="box-footer ">
                                        <?php $education = DB::table('education')
                                        ->select('education.*')
                                        ->get(); ?>
                                        <?php if(count($education) > 0): ?>
                                            <table class="table table-bordered text-center element " id="id2">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Si</th>
                                                        <th>Commentaire</th>
                                                        <th>Détails</th>
                                                        <th>Modifier</th>
                                                        <th>Supprimer</th>
                                                </thead>
                                                <tbody class="regle_footer">
                                                    <?php $__currentLoopData = $education; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $education): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>

                                                            <td><?php echo e($education->si); ?></td>
                                                            <td><?php echo e($education->commentaire); ?></td>
                                                            <td>
                                                                <button type="button" class="btn DetailsEdu"
                                                                    data-id="<?php echo e($education->id); ?>">Details</button>

                                                                <!--a href="#myModal" data-toggle="modal" data-target="#myModal">
                                                             <span class="glyphicon glyphicon-edit DetailsEdu"></span>
                                                             </a-->

                                                            </td>
                                                            <td><a href="<?php echo e(route('education.edit', $education->id)); ?>"><span
                                                                        class="glyphicon glyphicon-edit"></span></a></td>
                                                            <td>
                                                                <form style="display: none;" method="POST"
                                                                    action="<?php echo e(route('education.destroy', $education->id)); ?>"
                                                                    id="delete-form-<?php echo e($education->id); ?>">
                                                                    <?php echo e(csrf_field()); ?>

                                                                    <?php echo e(method_field('DELETE')); ?>

                                                                </form>
                                                                <a href="" onclick="
                             if (confirm('voulez vous supprimer cette ligne ?')) {
                             event.preventDefault();
                             document.getElementById('delete-form-<?php echo e($education->id); ?>').submit();										}
                            " style="color: inherit; "><span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        <?php endif; ?>

                                    </div>
                                    <!--div footer-->

                                </div>
                                <!--onglet 2--->





                                <div role="tabpanel" class="tab-pane" id="suivi">
                                    <!--Onglet 3-->



                                    <div class="element_suivi" style="">
                                        <form method="POST" action="<?php echo e(route('suivi.store')); ?>"
                                            enctype="multipart/form-data">
                                            <?php echo e(csrf_field()); ?>


                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <p> </p><br>
                                                    <label>niveau:</label>
                                                    <select class="form-control" id="niveau" name="niveau">
                                                        <option>1</option>
                                                        <option>2</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4"></div>
                                                <div class="form-group col-sm-4">
                                                    <p> </p><br>
                                                    <label>Evoyer un:</label><br>
                                                    <input type="checkbox" name="envoie" value="sms" />SMS<br>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                    ______________________________REGLE
                                                    PATIENT______________________________
                                                    <p> </p><br>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="exampleFormControlSelect2_">Choisissez:</label>
                                                    <select class="form-control" id="critere_" onclick="showAttributt()">
                                                        <option></option>
                                                        <option>Poids(kg)</option>
                                                        <option>Pathologie(s) associée(s)</option>
                                                        <option>Allergie(s) associée(s)</option>
                                                        <option>Examens</option>
                                                        <option>Service</option>
                                                        <option>Durée hospitalisation(jours)</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="divDynamque1_">
                                                </div>
                                                <div class="form-group col-sm-4" id="divDynamque2_">
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="row">
                                                <div class="form-group col-sm-6" id="divDynamque11_">
                                                </div>
                                                <div class="form-group col-sm-6" id="divDynamque22_">
                                                </div>

                                            </div>
                                            <!--row-->


                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                                                ____________________________REGLE MEDICAMENT____________________________
                                                <p> </p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="exampleFormControlSelect2_">Choisissez:</label>
                                                    <select class="form-control" id="choice_" onclick="showMedic()">
                                                        <option></option>
                                                        <option>Produits Alimentaires</option>
                                                        <option>Médicament</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-4" id="div1_">
                                                </div>
                                                <div class="form-group col-sm-4" id="div2_">
                                                </div>
                                            </div>
                                            <!--row-->
                                            <div class="row">
                                                <div class="form-group col-sm-6" id="div11_">
                                                </div>
                                                <div class="form-group col-sm-6" id="div22_">
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                ________________________________FONCTIONS________________________________
                                                <p></p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4" id="operation_">
                                                    <label for="exampleFormControlSelect1_">operation</label>
                                                    <select class="form-control" id="operationSelect_"
                                                        onclick="recup('operationSelect_')">
                                                        <option></option>
                                                        <option>+</option>
                                                        <option>-</option>
                                                        <option>/</option>
                                                        <option>=</option>
                                                        <option>!=</option>
                                                        <option>></option>
                                                        <option>
                                                            << /option>
                                                        <option>>=
                                                        </option>
                                                        <option>
                                                            <=< /option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="operateur_">
                                                    <label for="exampleFormControlSelect1_">operateur</label>
                                                    <select class="form-control" id="operateurSelect_"
                                                        onclick="recup('operateurSelect_')">
                                                        <option></option>
                                                        <option>ET</option>
                                                        <option>OU</option>
                                                        <!--<option>NON</option>-->
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="autre_">
                                                    <label for="exampleFormControlSelect1_">autre:</label>
                                                    <select class="form-control" id="autreSelect_"
                                                        onclick="recup('autreSelect_')">
                                                        <option>;</option>
                                                        <option>/</option>
                                                        <option>.</option>
                                                        <option>{</option>
                                                        <option>}</option>
                                                        <option value="abs">abs</option>
                                                        <option>(</option>
                                                        <option>)</option>
                                                        <option>[</option>
                                                        <option>]</option>
                                                        <option>à la hausse</option>
                                                        <option>à la baisse</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="form-group" id="textSelection_">
                                                <!--premier si -->
                                                <label for="exampleFormControlTextarea1_">Si:</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1_" name="si"
                                                    rows="5" onkeypress="interdireEcriture()" require></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1_">commentaire :</label>
                                                <textarea class="form-control" name="commentaire"
                                                    id="exampleFormControlTextarea1_" rows="3"></textarea>
                                            </div>
                                            <input type="submit" class="btn btn-primary pull-right" value="Confirmer">
                                            <p> </p><br><br><br>
                                        </form>
                                    </div>
                                    <!--element-->

                                    <div class="box-footer ">

                                        <?php $suivi = DB::table('suivis')
                                        ->select('suivis.*')
                                        ->get(); ?>
                                        <?php if(count($suivi) > 0): ?>
                                            <table class="table table-bordered text-center element " id="id3">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Si</th>
                                                        <th>Commentaire</th>
                                                        <th>Niveau</th>

                                                        <th>Modifier</th>
                                                        <th>Supprimer</th>
                                                </thead>
                                                <tbody class="regle_footer">
                                                    <?php $__currentLoopData = $suivi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suivi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr>

                                                            <td><?php echo e($suivi->si); ?></td>
                                                            <td><?php echo e($suivi->commentaire); ?></td>
                                                            <td><?php echo e($suivi->niveau); ?></td>
                                                            <td><a href="<?php echo e(route('suivi.edit', $suivi->id)); ?>"><span
                                                                        class="glyphicon glyphicon-edit"></span></a></td>
                                                            <td>
                                                                <form style="display: none;" method="POST"
                                                                    action="<?php echo e(route('suivi.destroy', $suivi->id)); ?>"
                                                                    id="delete-form-<?php echo e($suivi->id); ?>">
                                                                    <?php echo e(csrf_field()); ?>

                                                                    <?php echo e(method_field('DELETE')); ?>

                                                                </form>
                                                                <a href="" onclick="
                             if (confirm('voulez vous supprimer cette ligne ?')) {
                             event.preventDefault();
                             document.getElementById('delete-form-<?php echo e($suivi->id); ?>').submit();										}
                            " style="color: inherit; "><span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </td>

                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        <?php endif; ?>


                                    </div>
                                    <!--div footer-->


                                </div>
                                <!--onglet 3-->



                            </div>
                            <!--tab content--->
                        </div>
                        <!--tab panel-->

                    </div>
                    <!--box body-->
                </div>
                <!--box info-->

                <!-------------------LES DIV DYNAMYQUE DE DE L'ONGLET 1------------------------------->
                <div class="row">
                    <div class="form-group col-sm-6" id="age">
                        <label for="exampleFormControlSelectAge">Nombre:</label>
                        <select class="form-control" id="ageSelect" onclick="recuperer('ageSelect')">
                            <?php for($i = 1; $i < 100; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>


                    <!--div class="form-group col-sm-4" id="uniteAge">
                                                    <label for="exampleFormControlSelectAge">Jour/Mois/ans:</label>
                                                    <select class="form-control" id="uniteAgeSelect" onclick="recuperer('uniteAgeSelect')">
                                                        <option>Jours</option>
                                                        <option>Mois</option>
                                                        <option>ans</option>
                                                    </select>
                                                </div-->
                    <div class="form-group col-sm-6" id="taille">

                        <label for="exampleFormControlSelect1">Taille:</label>
                        <select class="form-control" id="tailleCmSelect" onclick="recuperer('tailleCmSelect')">
                            <?php for($i = 0; $i < 380; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-4" id="poids">
                        <label class="col-sm-2 control-label">Poids:</label>
                        <select class="form-control" id="poidsCmSelect" onclick="recuperer('poidsCmSelect')">
                            <?php for($i = 0; $i < 300; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="sexe">
                        <label for="exampleFormControlSelect1">Sexe</label>
                        <select class="form-control" id="sexeSelect" onclick="recuperer('sexeSelect')">
                            <option>Homme</option>
                            <option>Femme</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="modeDeVie">
                        <label for="exampleFormControlSelect1">Mode de vie</label>
                        <select class="form-control" id="modeDeVieSelect" onclick="recuperer('modeDeVieSelect')">
                            <option>Tabac</option>
                            <option>Alcool</option>
                            <option>Drogue</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4" id="pathologie">
                        <label for="exampleFormControlSelect1">Pathologie(s) associée(s)</label>
                        <select class="form-control" name="pathologies[]" id="pathologieSelect"
                            onclick="recuperer('pathologieSelect')">
                            <?php
                            $pathologies = DB::select("select * from pathologies");
                            ?>
                            <?php $__currentLoopData = $pathologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pathologie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($pathologie->pathologie); ?>"><?php echo e($pathologie->pathologie); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="allergie">
                        <label for="exampleFormControlSelect1">Allergie(s) associée(s)</label>
                        <select class="form-control" name="allergies[]" id="allergieSelect"
                            onclick="recuperer('allergieSelect')">
                            <?php
                            $allegries = DB::select("select * from allergies");
                            ?>
                            <?php $__currentLoopData = $allegries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allegrie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($allegrie->allergie); ?>"><?php echo e($allegrie->allergie); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="service">
                        <label for="exampleFormControlSelect1">Service</label>
                        <select class="form-control" id="serviceSelect" onclick="recuperer('serviceSelect')">
                            <?php
                            $result = DB::table('users')->where('service','<>','')->select('service')->distinct()->get();
                                ?>

                                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($r->service); ?>"><?php echo e($r->service); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-sm-6" id="examens">
                        <label for="exampleFormControlSelect1">Examens</label>
                        <select class="form-control" id="annalysesSelect" onclick="recuperer('annalysesSelect')">
                            <?php
                            $elements = DB::select("select * from elements");
                            // $elements = DB::table('elements')
                            // ->join('variantes' , 'elements.id' , 'variantes.element_id')
                            // ->get();
                            ?>
                            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($element->element == 'Poids' || $element->element == 'poids' || $element->element == 'POIDS'): ?>
                                    <option value="Poids(Kg)"><?php echo e($element->element); ?> (<?php echo e($element->unite); ?> )</option>
                                <?php else: ?>
                                    <option value="<?php echo e($element->element); ?> (<?php echo e($element->unite); ?>)"><?php echo e($element->element); ?>

                                        (<?php echo e($element->unite); ?>)</option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-6" id="valeur">
                        <label for="exampleFormControlSelect1">Entrez valeur:</label>
                        <br>
                        <input type="number" class="form-control" step="any" id="valeurSelect"
                            onchange="recuperer('valeurSelect')" />
                    </div>

                </div>

                <div class="row">
                    <div class="form-group col-sm-3" id="mmte_p">
                        <label for="exampleFormControlSelect2">Médicament DCI</label>
                        <input type="text" class="form form-control" placeholder="Médicament DCI ou médicament commerciale"
                            name="medicament_dci" autocomplete="off" id="preinscriptionSelect"
                            onclick="recuperer('preinscriptionSelect')">
                    </div>

                    <div class="form-group col-sm-3" id="produitalimentaire">
                        <label for="exampleFormControlSelect2">Produits Alimentaires:</label>
                        <select class="form-control" id="phytoSelect" onclick="recuperer('phytoSelect')">
                            <?php
                            $produitalimentaires = DB::select("select produit_naturel_fr from produitalimentaires");
                            ?>
                            <?php $__currentLoopData = $produitalimentaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit_naturel_fr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($produit_naturel_fr->produit_naturel_fr); ?>">
                                    <?php echo e($produit_naturel_fr->produit_naturel_fr); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                    </div>

                    <div class="form-group col-sm-3" id="valDosage">
                        <label for="exampleFormControlSelect2">Fois/Jour:</label>
                        <select class="form-control" id="foisSelect" onclick="recuperer('foisSelect')">
                            <?php for($i = 0; $i < 20; $i++): ?>
                                <option value="[ <?php echo e($i); ?>ParJour ]"><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-3" id="freq">
                        <label for="exampleFormControlSelect2">Fréquence</label>
                        <select class="form-control" id="freqSelect" onclick="showFrequence()">
                            <option>Occasionnellement</option>
                            <option>Exceptionnellement</option>
                            <option>Depuis(jours)</option>
                        </select>
                    </div>



                    <div class="form-group col-sm-4" id="etat">
                        <label for="exampleFormControlSelect2">état de la patiente</label>
                        <select class="form-control" id="etatSelect" onclick="recuperer('etatSelect')">
                            <option>normale</option>
                            <option>grossesse</option>
                            <option>Allaitement</option>
                        </select>
                    </div>



                    <div class="form-group col-sm-6" id="travail">
                        <label for="exampleFormControlSelectAge">Activité professionnel</label>
                        <select class="form-control" id="travailSelect" onclick="recuperer('travailSelect')">
                            <?php
                            $travails = DB::select("select nom from travails");
                            ?>
                            <?php $__currentLoopData = $travails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $travail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($travail->nom); ?>"><?php echo e($travail->nom); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>


                <div class="form-group col-sm-4" id="ligne">
                    <label for="exampleFormControlSelect2">Nombre de ligne</label>
                    <select class="form-control" id="ligneSelect" onclick="recuperer('ligneSelect')">
                        <?php for($i = 1; $i < 30; $i++): ?>
                            <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                        <?php endfor; ?>
                    </select>
                </div>









                <!---DIV DYNAMIQUE ONGLET 3--->
                <div class="row">
                    <div class="form-group col-sm-6" id="age_">
                        <label for="exampleFormControlSelectAge_">Nombre:</label>
                        <select class="form-control" id="ageSelect_" onclick="recup('ageSelect_')">
                            <?php for($i = 1; $i < 100; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group col-sm-4" id="poids_">
                        <label class="col-sm-2 control-label">Poids:</label>
                        <select class="form-control" id="poidsCmSelect_" onclick="recup('poidsCmSelect_')">
                            <?php for($i = 0; $i < 300; $i++): ?>
                                <option value="<?php echo e($i); ?>"><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="form-group col-sm-4" id="pathologie_">
                        <label for="exampleFormControlSelect1_">Pathologie(s) associée(s)</label>
                        <select class="form-control" name="pathologies[]" id="pathologieSelect_"
                            onclick="recup('pathologieSelect_')">
                            <?php
                            $pathologies = DB::select("select * from pathologies");
                            ?>
                            <?php $__currentLoopData = $pathologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pathologie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($pathologie->pathologie); ?>"><?php echo e($pathologie->pathologie); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                </div>
                <div class="row">
                    <div class="form-group col-sm-4" id="allergie_">
                        <label for="exampleFormControlSelect1_">Allergie(s) associée(s)</label>
                        <select class="form-control" name="allergies[]" id="allergieSelect_"
                            onclick="recup('allergieSelect')">
                            <?php
                            $allegries = DB::select("select * from allergies");
                            ?>
                            <?php $__currentLoopData = $allegries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allegrie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($allegrie->allergie); ?>"><?php echo e($allegrie->allergie); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="service_">
                        <label for="exampleFormControlSelect1_">Service</label>
                        <select class="form-control" id="serviceSelect_" onclick="recup('serviceSelect_')">
                            <?php
                            $result = DB::table('users')->where('service','<>','')->select('service')->distinct()->get();
                                ?>

                                <?php $__currentLoopData = $result; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($r->service); ?>"><?php echo e($r->service); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>


                    <div class="form-group col-sm-6" id="examens_">
                        <label for="exampleFormControlSelectntrolSelect1_">Examens</label>
                        <select class="form-control" id="annalysesSelect_" onclick="recup('annalysesSelect_')">
                            <?php
                            $elements = DB::table('elements')->get();
                            ?>
                            @endphp
                            <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($element->element == 'Poids' || $element->element == 'poids' || $element->element == 'POIDS'): ?>
                                    <option value="Poids(Kg)"><?php echo e($element->element); ?> (<?php echo e($element->unite); ?>)</option>
                                <?php else: ?>
                                    <option value="<?php echo e($element->element); ?> (<?php echo e($element->unite); ?>)"><?php echo e($element->element); ?>

                                        (<?php echo e($element->unite); ?>)</option>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-6" id="valeur_">
                        <label for="exampleFormControlSelect1_">Entrez valeur:</label>
                        <br>
                        <input type="number" class="form-control" step="any" id="valeurSelect_"
                            onchange="recup('valeurSelect_')" />
                    </div>


                    <div class="form-group col-sm-3" id="mmte_p_">
                        <label for="exampleFormControlSelect2_">Médicament DCI</label>
                        <input type="text" class="form form-control" placeholder="Médicament DCI ou médicament commerciale"
                            name="medicament_dci" autocomplete="off" id="preinscriptionSelect_"
                            onclick="recup('preinscriptionSelect_')">
                    </div>



                    <div class="form-group col-sm-3" id="valDosage_">
                        <label for="exampleFormControlSelect2_">Fois/Jour:</label>
                        <select class="form-control" id="foisSelect_" onclick="recup('foisSelect_')">
                            <?php for($i = 0; $i < 20; $i++): ?>
                                <option value="[ <?php echo e($i); ?>ParJour ]"><?php echo e($i); ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3" id="freq_">
                        <label for="exampleFormControlSelect2_">Fréquence</label>
                        <select class="form-control" id="freqSelect_" onclick="showFreq()">
                            <option>Occasionnellement</option>
                            <option>Exceptionnellement</option>
                            <option>Depuis(jours)</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-3" id="produitalimentaire_">
                        <label for="exampleFormControlSelect2_">Produits Alimentaires</label>
                        <select class="form-control" id="phytoSelect_" onclick="recup('phytoSelect_')">
                            <?php
                            $produitalimentaires = DB::select("select produit_naturel_fr from produitalimentaires");
                            ?>
                            <?php $__currentLoopData = $produitalimentaires; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $produit_naturel_fr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                <option value="<?php echo e($produit_naturel_fr->produit_naturel_fr); ?>">
                                    <?php echo e($produit_naturel_fr->produit_naturel_fr); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </select>
                    </div>
                </div>







            </div>
            <!--div offset--->

        </div><!-- div row--->

    </div>
    <!--div wrapper-->











    <!-- Modal -->
    <div class="modal fade" id="detailsEdu" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Education Thérapeutique</h4>
                </div>

                <div class="modal-body" id="details_body">



                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background-color:blue; color:#ffffff"
                        data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>





    <!--------MODAL AIDE--------->


    <!-- Modal -->
    <div class="modal fade" id="aideModal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Aide à propos des règles </h4>
                </div>

                <div class="modal-body">

                    <h4>1- Comment utiliser cet éditeur?</h4>
                    <p>Cet éditeur de règle est composé de 3 parties : <br> 1-Analyse pharmaceutique.
                        <br> 2- Education thérapeutique. <br> 3- pilotage de donné patient <br>
                        Sur chaque onglet existe des champs à choisir. les champs cliqués sont visible sur la parie Si,
                        cette dernière n'est pas cliquable c-à-d vous ne pouvez pas écrire avec le clavier dans cette partie
                        les autres champs libres sont cliquable.
                        <br>Sous chaque onglet il y a une liste ou vous pouver modifier/supprimer vos règles.
                    </p>

                    <h4>1- Comment ecrire une règle "Si" ?</h4>

                    <p>Il faut bien respecter la syntaxe de la règle expliqué ici.</p>
                    <p>Il existe 2 différents de choix de mots dans les champs <br> 1- (age, taille,sexe,durée
                        hospitalisation, examen,
                        état de la patiente, activité, nombre de locale_get_display_name): après ces mot il est obligatoire
                        de mettre les opérandes suivantes
                        (<,>,=,!=), après choisissez le mot qui suit.<br>
                            2- (mode de vie, pathologie, phytothérapie, médicament, allergies): ces des mots qui peuvent
                            s'écrire des ensembles, il est recommendé de séparer entre les mots dans ces ensemble avec
                            ";" pour exprimer le ET, et le "/" pour le ou puis il faut fermer l'ensemble "}".<br>
                            exp: Médicament(s) = { PARACETAMOL 500MG ORAL [ 2ParJour ] } les crochets c'est pour exprimé la
                            dose journalière </p>

                    il est strictement interdit de supprimer les espaces entre les mots</p>

                    <h4>Comment fusionner plusieurs règles?</h4>
                    <p>en utilisant le "OU" et le "ET" <br> exemple: médicament = { PARALYOC 500MG LYOPHILISAT ORAL } ET
                        pathologie = { CANCERS } ET non observant</p>

                    <h4>En cas d'erreur?</h4>
                    <p>Il est obligé de modifier vos règle si vous n'avez pas suivi la règle de syntaxe donnée, si non vos
                        règles ne seront pas pris en compte</p>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background-color:blue; color:#ffffff"
                        data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('/plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/js/admin/gestion_regle.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/js/admin/gestion_reglee.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/js/admin/regle/showDiv1.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('/js/admin/regle/showDiv2.js')); ?>"></script>

    <script>
        $('#tablist a').click(function(e) {
            e.preventDefault()
            $(this).tab('show')
        })

    </script>

    <script type="text/javascript">
        $('body').find('span > i').remove('i:last');
        $('#id1').dataTable();
        $('#id2').dataTable();
        $('#id3').dataTable();

    </script>

    <script>
        function Hide(addr) {
            document.getElementById(addr).style.visibility = "hidden";
        }

        /** Pour que la page soit vide avant de séléctionner */

        window.onload = function clearPage() {
            Hide("age_");
            Hide("etat");
            Hide("travail");
            Hide("pathologie_");
            Hide("allergie_");
            Hide("poids_");
            Hide("service_");
            Hide("examens_");
            Hide("valeur_");
            Hide("mmte_p_");
            Hide("valDosage_");
            Hide("freq_");
            Hide("produitalimentaire_");


            Hide("ligne");
            Hide("age");
            Hide("sexe");
            Hide("modeDeVie");
            Hide("pathologie");
            Hide("allergie");
            Hide("taille");
            Hide("poids");
            Hide("service");
            Hide("examens");
            Hide("valeur");
            Hide("mmte_p");
            Hide("valDosage");
            Hide("freq");
            Hide("produitalimentaire");
            Hide("observance");

        };

    </script>
    <script src="<?php echo e(asset('/js/admin/regle/detailsRegleEdu.js')); ?>"></script>
    <style>
        .panel-group .panel {
            border-radius: 0;
            box-shadow: none;
            border-color: #EEEEEE;
        }

        .panel-default>.panel-heading {
            padding: 0;
            border-radius: 0;
            color: #212121;
            background-color: #FAFAFA;
            border-color: #EEEEEE;
        }

        .panel-title {
            font-size: 14px;
        }

        .panel-title>a {
            display: block;
            padding: 15px;
            text-decoration: none;
        }

        .more-less {
            float: right;
            color: #212121;
        }

        /*	.panel-default > .panel-heading + .panel-collapse > .panel-body {
              border-top-color: #EEEEEE;
             }*/

        }

    </style>
    <script>
        function toggleIcon(e) {
            $(e.target)
                .prev('.panel-heading')
                .find(".more-less")
                .toggleClass('glyphicon-plus glyphicon-minus');
        }
        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);

    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views/admin/regle/create.blade.php ENDPATH**/ ?>