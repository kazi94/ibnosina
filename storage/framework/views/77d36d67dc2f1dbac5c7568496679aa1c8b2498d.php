<!-- Modal ajout consultation -->
<div class="modal fade in" id="modal_consultation">
    <div class="modal-dialog modal-lg">
        <form action="<?php echo e(route('consultation.store')); ?>" method="POST">
            <?php echo e(csrf_field()); ?>

            <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
            <div class="modal-content table-responsive">
                <div class="bg-blue modal-header text-center">
                    <div class="row title">
                        <div class="col-md-8">
                            <h4 class="modal-title">Ajouter une consultation</h4>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="date_rapport"
                                value="<?php echo date('Y-m-d'); ?>" required />
                        </div>
                        <div class="col-md-1">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                        </div>
                    </div>

                </div>
                <div class="modal-body">
                    <div id="smartwizard">
                        <ul class="nav">
                            <li class="nav-item"><a class="nav-link" href="#step-1">Etape 1<br /><small>Informations
                                        médicales</small></a></li>
                            <li class="nav-item"><a class="nav-link" href="#step-2">Etape
                                    2<br /><small>Consultation</small></a></li>
                            <li class="nav-item"><a class="nav-link" href="#step-3">Etape
                                    3<br /><small>Rapports</small></a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="step-1" class="tab-pane" role="tabpanel" aria-labelledby="step-1"
                                style="display: block;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Pathologies associées</label>
                                        <select class="form-control pathologies" multiple="multiple"
                                            style="width: 100%;" name="pathologies[]">

                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Antécédents familiaux</label>
                                        <select class="form-control ants_fam" multiple="multiple" style="width: 100%;"
                                            name="famille_antecedants[]">

                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Antécédent chirurgicaux</label>
                                        <select class="form-control select2 select2-hidden-accessible" multiple=""
                                            data-placeholder="Antécedant(s) Chirugicaux" style="width: 100%;"
                                            tabindex="-1" aria-hidden="true" name="operations[]">
                                            <?php
                                                $operations = DB::select('select * from operation_chirugicales');
                                            ?>
                                            <?php $__currentLoopData = $operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($operation->id); ?>" <?php $__currentLoopData = $patient->operations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $operationPatient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  <?php if($operation->id==$operationPatient->id): ?>
                                                    selected <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            ><?php echo e($operation->nom); ?>

                                            </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Allergies associées</label>
                                        <select class="form-control allergies" multiple="multiple" style="width: 100%;"
                                            name="allergies[]">

                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div id="step-2" class="tab-pane" role="tabpanel" aria-labelledby="step-2">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Motif de consultation</label>

                                        <textarea class="form-control" value="Oridinaire"
                                            placeholder="Motif de consultation" name="motif"></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Examens physiques</label>

                                        <textarea class="form-control" placeholder="Examens physiques"
                                            name="examen"></textarea>
                                    </div>

                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Signes fonctionnels</label>
                                        <select class="signes select2" name="signe[]"
                                            data-placeholder="Signes fonctionnels" multiple="multiple"
                                            style="width: 100%;">
                                            <?php
                                                $signes = DB::table('signes')->get();
                                            ?>

                                            <?php $__currentLoopData = $signes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $signe): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($signe->id); ?>"><?php echo e($signe->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="" class="control-label">Début des symptômes</label>

                                        <input type="date" class="form-control" name="debut_symptome">
                                    </div>

                                </div>
                            </div>
                            <div id="step-3" class="tab-pane" role="tabpanel" aria-labelledby="step-3">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Certificat</label>

                                        <textarea class="form-control" placeholder="Certificat..."
                                            name="certificat"></textarea>
                                    </div>


                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Lettre d'orientation</label>

                                        <textarea class="form-control" placeholder="Lettre d'orientation..."
                                            name="orientation"></textarea>
                                    </div>


                                </div>
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="" class="control-label">Compte rendu</label>
                                        <textarea class="form-control" placeholder="Compte rendu..."
                                            name="compte_rendu"></textarea>
                                    </div>


                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade in" id="modal_edit_consultation">
    <div class="modal-dialog modal-lg">
        <form action="" method="POST">
            <?php echo e(csrf_field()); ?>

            <?php echo e(method_field('PATCH')); ?>

            <div class="modal-content table-responsive">
                <div class="bg-blue modal-header text-center">
                    <div class="row title">
                        <div class="col-md-8">
                            <h4 class="modal-title">Modifier une consultation</h4>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="date_rapport" id="date" required />
                        </div>
                        <div class="col-md-1">

                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span></button>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="display: block;">

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Motif :</label>
                            <textarea class="form-control" value="Oridinaire"
                                placeholder="Ordinaire... ou à préciser..." name="motif" id="motif"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Début des symptômes</label>
                            <input type="date" class="form-control" name="debut_symptome" id="debut_symptome">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Signes Fonctionnels</label>
                            <select class="signes" name="signe[]" multiple="multiple">

                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Examens physique</label>
                            <textarea class="form-control" placeholder="Examen physiques..." name="examen"
                                id="examen"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Compte rendu</label>
                            <textarea class="form-control" placeholder="Compte rendu..." name="compte_rendu"
                                id="compte"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Lettre d'orientation</label>
                            <textarea class="form-control" placeholder="Lettre d'orientation..." name="orientation"
                                id="lettre"></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Certificat</label>
                            <textarea class="form-control" placeholder="Certificat" name="certificat"
                                id="cert"></textarea>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer"
                        onclick="$('#target_consultation').reset();">
                    <input type="submit" class="btn btn-primary pull-right" value="Modifer">
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- Modal détails de la consultation -->
<div class="modal fade in" id="modal_detail_consultation">
    <div class="modal-dialog modal-md">

        <div class="modal-content table-responsive">
            <div class="bg-blue modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Détails de la consultation</h4>
            </div>
            <div class="modal-body" style="display: block;">
                <table class="table table-bordered table-striped">
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-default pull-right" data-dismiss="modal" value="Fermer">
            </div>
        </div>
        <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\modals\consultation.blade.php ENDPATH**/ ?>