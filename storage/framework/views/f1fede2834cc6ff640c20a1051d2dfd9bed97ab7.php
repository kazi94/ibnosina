<!-- Modal modifier Prescription ville Traitement Chronique / Automédication-->
<div class="modal fade in" id="modalUpdatePrescriptionVille">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modifier Médicament</h4>
            </div>
            <form class="form-horizontal" method="post" action="">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('PATCH')); ?>

                <!-- <input type="hidden" name="old_date" id="date_etats">-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <!-- Formulaire de modification -->

                            <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                            <div class="form-group">
                                <label for="" class="control-label col-sm-3">Médecin externe</label>
                                <div class="col-sm-9">
                                    <input type="text" name="medecin_externe" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-sm-3">Posologie</label>
                                <div class="col-sm-9">
                                    <input type="text" name="dose" value="1" class="form-control"
                                        style="width: 25%; display: inline;">
                                    <input type="hidden" name="dose_matin" value="0">
                                    <input type='checkbox' id="dose_matin" class='form-control flat-green'
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" /> Matin
                                    <select style="width: 25%;display: inline;" class="form-control" name="repas_matin">
                                        <option value=""></option>
                                        <option value="Avant">Avant</option>
                                        <option value="Pendant">Pendant</option>
                                        <option value="Aprés">Aprés</option>
                                    </select>
                                    <input type="hidden" name="dose_midi" value="0">
                                    <input type='checkbox' id="dose_midi" class='form-control flat-green'
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" /> Midi
                                    <select style="width: 25%;display: inline;" class="form-control"
                                        name="repas_midi  ">
                                        <option value=""></option>
                                        <option value="Avant">Avant</option>
                                        <option value="Pendant">Pendant</option>
                                        <option value="Aprés">Aprés</option>
                                    </select>
                                    <input type="hidden" name="dose_soir" value="0">
                                    <input type='checkbox' id="dose_soir" class='form-control flat-green'
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" /> Soir
                                    <select style="width: 25%;display: inline;" class="form-control" name="repas_soir">
                                        <option value=""></option>
                                        <option value="Avant">Avant</option>
                                        <option value="Pendant">Pendant</option>
                                        <option value="Aprés">Aprés</option>
                                    </select>
                                    <input type="hidden" name="dose_avant_coucher" value="0">
                                    <input type='checkbox' id="dose_avant_coucher" class='form-control flat-green'
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />Av-coucher
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-sm-3">Etats</label>
                                <div class="col-sm-9">
                                    <span id="state" class="badge"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-sm-3">Date états</label>
                                <div class="col-sm-9">
                                    <input type="date" name="date_etats" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="control-label col-sm-3">Hopital</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="status_hopital" value="1">
                                    <input type='checkbox' class='form-control flat-green' id="hopital" checked
                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default mb-0" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary mb-0">Modifier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Prescription Chronique/Automedication -->
<div class="modal fade in" id="modalPrescriptionVille">
    <div class="modal-dialog modal-md">
        <div class="modal-content ">

            <div class="bg-blue bg-blue modal-header text-center text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ajouter Médicaments</h4>
            </div>
            <div class="modal-body form-horizontal">
                <div class="form-group">
                    <label for="medecin externe" class="col-sm-3 control-label">Médecin externe</label>

                    <div class="col-sm-9">
                        <input type="text" class="form-control" name="medecin_externe"
                            placeholder="Renseigner le médecin qui a prescrit le(s) médicament(s) ">
                    </div>
                </div>

                <div class="p-3 m-1 bg-info">
                    <form id="addLineTraitement">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                        <select class="" name='voie' style="display : none"></select>
                        <select class="" name="unite" style="display : none"></select>
                        <div class="form-group">
                            <label for="d_analyse" class="col-sm-3 control-label">Médicament</label>

                            <div class="col-sm-9">
                                <input type="hidden" name="med_sp_id" />
                                <input type="text" class="form-control"
                                    placeholder="Médicament DCI ou médicament commerciale" name="medicament_dci"
                                    autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="d_analyse" class="col-sm-3 control-label">Posologie</label>
                            <div class="col-sm-9">
                                <input type="text" name="dose" value="1" class="form-control"
                                    style="width: 25%; display: inline;">
                                <input type="hidden" name="dose_matin" value="1">
                                <input type='checkbox' class='form-control flat-green' checked
                                    onclick="this.previousSibling.value=1-this.previousSibling.value" /> Matin
                                <input type="hidden" name="dose_midi" value="1">
                                <input type='checkbox' class='form-control flat-green' checked
                                    onclick="this.previousSibling.value=1-this.previousSibling.value" /> Midi
                                <input type="hidden" name="dose_soir" value="1">
                                <input type='checkbox' class='form-control flat-green' checked
                                    onclick="this.previousSibling.value=1-this.previousSibling.value" /> Soir
                                <input type="hidden" name="dose_avant_coucher" value="1">
                                <input type='checkbox' class='form-control flat-green' checked
                                    onclick="this.previousSibling.value=1-this.previousSibling.value" /> Av-coucher
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date de prise" class="col-sm-3 control-label">Début prise</label>

                            <div class="col-sm-9">
                                <input type="date" name="date_etats" class="form-control"
                                    value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="date de prise" class="col-sm-3 control-label">Hopital</label>

                            <div class="col-sm-9">
                                <input type="hidden" name="status_hopital" value="1">
                                <input type='checkbox' class='form-control flat-green' checked
                                    onclick="this.previousSibling.value=1-this.previousSibling.value" />

                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="submit" class="btn btn-success btn-block " value="Ajouter Médicament">
                            </div>
                        </div>
                    </form>
                    <div class="">
                        <div class="">
                            <table class="table table-hover" id="tableTraitement">
                                <thead>
                                    <tr>
                                        <th class="text-center">Mes médicaments</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
                <input type="button" class="btn btn-primary pull-right" id="saveTraitement" value="Valider">
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<div class="modal fade" id="updateTraitAutoModal" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="bg-red modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Mettre à jour !</h4>
            </div>
            <form action="" method="post">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('put')); ?>

                <div class="modal-body form-horizontal">
                    <div class=" form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Nouvelle état</label>

                        <div class="col-sm-9">
                            <input type="hidden" name="etats">
                            <p id="state"></p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Date Nouvelle état</label>

                        <div class="col-sm-9">
                            <input type="date" class="form-control" name="date_etats"
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>


                    <div class="">
                        <table class="table table-hover" id="historyStates">
                            <thead>
                                <tr>
                                    <th class="text-center">Historique des états</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-default" data-dismiss="modal" value="Fermer">
                    <input type="submit" class="btn btn-primary" id="savePrescription" value="Valider">
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\modals\auto-traitement.blade.php ENDPATH**/ ?>