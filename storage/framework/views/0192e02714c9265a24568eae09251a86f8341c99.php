<?php $__env->startSection('script_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('plugins/jquery/css/jquery_ui.css')); ?>">
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

                        <h3 class="box-title">Modifier la règle</h3>

                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <!--pour choisir entre regle medic ou patient-->

                    <div class="box-body">

                        <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                            <p> </p><br>
                            ______________________________Education thérapeutique______________________________
                            <p> </p><br>
                        </div>
                        <div class="element_onglet2" style="">
                            <form method="POST" action="<?php echo e(route('education.update', $education->id)); ?>"
                                enctype="multipart/form-data">
                                <?php echo e(csrf_field()); ?>

                                <?php echo e(method_field('PATCH')); ?>


                                <div class="row">
                                    <div class="form-group col-sm-4" id="choix">
                                        <label for="exampleFormControlSelect2">Choisissez:</label>
                                        <select class="form-control" id="choixSelect" onclick="recupModif2('choixSelect')">
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
                                        <select class="form-control" id="pathoSelect" onclick="recupModif2('pathoSelect')">
                                            <?php
                                                $pathologies = DB::select('select * from pathologies');
                                            ?>
                                            <?php $__currentLoopData = $pathologies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pathologie): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($pathologie->pathologie); ?>">
                                                    <?php echo e($pathologie->pathologie); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="ob">
                                        <label for="exampleFormControlSelect2">Observance</label>
                                        <select class="form-control" id="obSelect" onclick="recupModif2('obSelect')">
                                            <option>modérément observant</option>
                                            <option>très observant</option>
                                            <option>non observant</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="med">
                                        <label for="exampleFormControlSelect2">Médicament DCI</label>
                                        <input type="text" class="form form-control"
                                            placeholder="Médicament DCI ou médicament commerciale" name="medicament_dci"
                                            autocomplete="off" id="medSelect" onclick="recupModif2('medSelect')">
                                    </div>


                                </div>
                                <!--row-->



                                <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                    ________________________________FONCTIONS________________________________
                                    <p></p><br>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4" id="op">
                                        <label for="exampleFormControlSelect1">operation</label>
                                        <select class="form-control" id="opSelect" onclick="recupModif2('opSelect')">
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
                                            onclick="recupModif2('operateurrSelect')">
                                            <option></option>
                                            <option>ET</option>
                                            <option>OU</option>
                                            <!--<option>NON</option>-->
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="autres">
                                        <label for="exampleFormControlSelect1">autre:</label>
                                        <select class="form-control" id="autresSelect"
                                            onclick="recupModif2('autresSelect')">
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
                                    <?php
                                        $r = DB::select('select * from education where id = ?', [$education]);
                                    ?>
                                    <label>Titre de la règle:</label>
                                    <textarea class="form-control" name="titre"><?php echo e($education->titre); ?></textarea>
                                </div>
                                <div class="form-group" id="ancienSi">
                                    <!--ancien si -->
                                    <label>Ancien Si:</label>

                                    <?php
                                        $r = DB::select('select * from education where id = ?', [$education]);
                                    ?>

                                    <textarea class="form-control" rows="5" onkeypress="interdireEcriture()"
                                        require><?php echo e($education->si); ?></textarea>



                                </div>

                                <div class="form-group" id="texteSelection">
                                    <label for="exampleFormControlTextarea2">Si:</label>
                                    <!--deuxieme si-->
                                    <textarea class="form-control" id="exampleFormControlTextarea2" name="si" rows="5"
                                        onkeypress="interdireEcriture()" require></textarea>
                                </div>

                                <div class="form-group">

                                    <label>commentaire :</label>
                                    <textarea class="form-control" name="commentaire"
                                        rows="3"><?php echo e($education->commentaire); ?></textarea>
                                </div>
                                <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                    _____________________________A propos de l'éducation_____________________________
                                    <p></p><br>
                                </div>
                                <div class="form-group">
                                    <label>Explication de la maladie :</label>
                                    <textarea class="form-control" name="maladie"
                                        rows="3"><?php echo e($education->maladie); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Effets de médicament :</label>
                                    <textarea class="form-control" name="effet"
                                        rows="3"><?php echo e($education->effet); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Conduite à tenir pendant le voyage :</label>
                                    <textarea class="form-control" name="voyage"
                                        rows="3"><?php echo e($education->voyage); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Act chirurgical :</label>
                                    <textarea class="form-control" name="act" rows="3"><?php echo e($education->act); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Comment utiliser le médicament :</label>
                                    <textarea class="form-control" name="utilisation"
                                        rows="3"><?php echo e($education->utilisation); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Effets indésirables:</label>
                                    <textarea class="form-control" name="effet_indiserable"
                                        rows="3"><?php echo e($education->effet_indiserable); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>regles hygiéno-diètétique :</label>
                                    <textarea class="form-control" name="regime"
                                        rows="3"><?php echo e($education->regime); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Ajouter URL :</label>
                                    <textarea class="form-control" name="url" rows="3"><?php echo e($education->url); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Joindre un fichier :</label>
                                    <input type="file" name="pdf">
                                </div>


                                <input type="hidden" name="type" value="educRegle">
                                <input type="submit" class="btn btn-primary pull-right" value="Confirmer">
                                <p> </p><br><br><br>
                            </form>
                        </div>
                        <!--element-->



                    </div>
                    <!--body-->
                </div>
                <!--boxinfo-->

            </div>
            <!--offset-->
        </div>
        <!--row-->
    </div>
    <!--content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js')); ?>"></script>
    <script src="<?php echo e(asset('plugins/jquery/js/jquery-ui.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/admin/gestion_regle.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/admin/gestion_reglee.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/admin/regle/showDiv1.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('js/admin/regle/showDiv2.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/jquery/js/jquery.min.js')); ?>"></script>
    <script type="text/javascript" src="<?php echo e(asset('plugins/jquery/js/jquery-ui.min.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\regle\edit2.blade.php ENDPATH**/ ?>