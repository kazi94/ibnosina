<?php $__env->startSection('script_css1'); ?>
    <style>
        .no-record #default_table {
            display: none;
        }

    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="content-wrapper">
        <section class="content">
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

                <div class="col-sm-12">
                    <!-- Horizontal Form -->
                    <div class="box box-info mt-3">

                        <div class="box-header with-border bg-aqua">

                            <h3 class="box-title">Ajouter Produit alimentaire</h3>

                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">

                            <form class="form-group" role="form" method="POST" action="<?php echo e(route('produit.store')); ?>">
                                <?php echo e(csrf_field()); ?>


                                <div class="row">
                                    <div class="form-group col-sm-6">

                                        <label>Produit naturel (FR) </label>

                                        <input type="text" class="form-control" name="produit_naturel_fr"
                                            placeholder="placer votre produit en Fran??ais" required>

                                    </div>

                                    <div class="form-group col-sm-6">

                                        <label>Nom scientifique(Latin) </label>

                                        <input type="text" class="form-control" name="produit_naturel_latin"
                                            placeholder="placer votre nom scientifique">

                                    </div>

                                    <div class="form-group col-sm-6">

                                        <label>Partie Active </label>

                                        <select name="partie_active" class="form-control">
                                            <option value="Racine">Racine</option>
                                            <option value="Tige">Tige</option>
                                            <option value="Feuille">Feuille</option>
                                            <option value="Fleur">Fleur</option>
                                            <option value="Sommit?? fleurie">Sommit?? fleurie</option>
                                            <option value="Partie a??rienne">Partie a??rienne</option>
                                            <option value="Graine">Graine</option>
                                            <option value="Fruit">Fruit</option>
                                        </select>

                                    </div>

                                    <div class="form-group col-sm-6">

                                        <label>Mode de Pr??paration</label>

                                        <textarea name="mode_preparation" class="form-control" cols="40"
                                            rows="3"></textarea>
                                    </div>

                                    <div class="form-group col-sm-6">

                                        <label>Nom en Arabe</label>

                                        <table class="table">

                                            <tr>

                                                <td><input type="text" class="form-control"
                                                        placeholder="placer votre produit en arabe" name=""
                                                        id="produit_arabe"></td>

                                                <td><button type="button" class="btn btn-primary addPlanteArBtn">+</button>
                                                </td>

                                            </tr>

                                        </table>

                                    </div>

                                    <div class="form-group col-sm-6">
                                        <label>Liste des Noms Arabes</label>

                                        <ul id="arabe_words" class="menu navbar navbar-default">

                                        </ul>
                                    </div>
                                </div>

                                <hr class="mt-0" />


                                <div class="row">
                                    <div class="ml-4">
                                        <h4> Int??ractions M??dicamenteuses</h4>
                                    </div>

                                    <div>

                                        <div class="form-group col-sm-6">

                                            <label>M??dicaments (DCI) </label>
                                            <input type="hidden" class="medicament_dci_id" id="medicament_dci_id">

                                            <input type="text" class="form-control m??dicament_dci"
                                                placeholder="M??dicament DCI" id="medic_input">

                                        </div>


                                        <div class="form-group col-sm-6">
                                            <label>Type d'effet </label>
                                            <select class="form-control" name="type_effet[]" id="type">
                                                <option value="Interaction Pharmacocin??tique">Interaction Pharmacocin??tique
                                                </option>
                                                <option value="Interaction Pharmacodynamique">Interaction Pharmacodynamique
                                                </option>
                                                <option value="Physicoch??mique">Physicoch??mique</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-6">

                                            <label>Effet de l'int??raction</label>

                                            <textarea type="text" class="form-control"
                                                placeholder="Effet de l'int??raction...." rows="2" cols="40"
                                                id="effet"></textarea>

                                        </div>


                                        <div class="form-group col-sm-6">

                                            <label>Niveau d'interaction</label>

                                            <select id="niveau" class="form-control">
                                                <option value="1">Contre indication</option>
                                                <option value="2">Association d??conseill??</option>
                                                <option value="3">Pr??caution d'emploi</option>
                                            </select>

                                        </div>

                                        <div class="form-group col-sm-7">

                                            <label>Indication traditionelle</label>

                                            <textarea type="text" class="form-control"
                                                placeholder="Indication Traditionnelle..." rows="2" cols="40"
                                                id="indic"></textarea>

                                        </div>

                                        <div class="form-group col-sm-5">

                                            <label>Effets Pharmacologiques document??</label>

                                            <textarea type="text" class="form-control"
                                                placeholder="Effets Pharmacologiques document??..." rows="2" cols="40"
                                                id="ef_pharm"></textarea>

                                        </div>

                                        <div class="form-group col-sm-12">

                                            <label>Recommendations</label>

                                            <textarea type="text" class="form-control" placeholder="Recommendations..."
                                                rows="2" cols="40" id="reco"></textarea>

                                        </div>

                                    </div>

                                    <div class="col-sm-12 text-center mb-3">
                                        <button type="button" class="btn btn-primary btn-block addMedBtn">Ajouter
                                            l'int??raction</button>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed produit_tab"
                                        id="interactions_plantes">
                                        <thead class="bg-info">
                                            <tr>
                                                <th>M??dicament</th>
                                                <th>Effet de l'interaction</th>
                                                <th>Type effet</th>
                                                <th>Indication traditionelle</th>
                                                <th>Effets Pharmacologiques document??</th>
                                                <th>Recommendations</th>
                                                <th>Niveau</th>
                                                <th>Supprimer</th>
                                            </tr>
                                        </thead>
                                        <tbody style="text-align: center;">
                                        </tbody>
                                    </table>
                                </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-lg" id="submit">Je valide</button>
                                </div>
                            </form>

                        </div>

                        <!-- /.box-body -->
                    </div>

                </div>

            </div>

        </section>

    </div>



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script> -->
    <script src="<?php echo e(asset('plugins/datatable-1.10.24/datatables.min.js')); ?>"></script>

    <script src="<?php echo e(asset('plugins/jquery/js/jquery-ui.js')); ?>"></script>
    <script type="text/javascript" src="/js/admin/gestion_produit.js"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.model1', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\anapharm\resources\views\admin\phyto\create.blade.php ENDPATH**/ ?>