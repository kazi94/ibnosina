
<div class="modal fade in" id="modal_analyse_pharm">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Résultat d'analyses</h4>
            </div>

            <form action="<?php echo e(route('analyse.store')); ?>" method="POST" id="formInterventions">
                <?php echo e(csrf_field()); ?>

                <div class="modal-body">
                    <div role="tabpanel">
                        <ul class="nav nav-tabs" id="tablist">
                            <li role="presentation" class="active"><a href="#theriaque" aria-controls="theriaque"
                                    role="tab" data-toggle="tab">Thériaque</a></li>
                            <li role="presentation"><a href="#interne" aria-controls="interne" role="tab"
                                    data-toggle="tab">Banque Interne</a></li>
                        </ul>

                        <div class="tab-content">
                            <!--ici c'est le contenu de l'onglet 1-->
                            <div class="tab-pane active" id="theriaque">
                                <div class="table-responsive">
                                    <table class="analyse_table table table-bordered table-condensed table-hover">
                                        <thead>
                                            <tr class="text-center text-bold bg-gray">
                                                <td>Niveau</td>
                                                <td>Médicament</td>
                                                <td>Détails</td>
                                                <td style="width: 300px">Problèmes</td>
                                                <td>Commentaire</td>
                                                <td>Intervention pharmaceutique</td>
                                                <td>Commentaire</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>

                            </div>



                            <div role="tabpanel" class="tab-pane" id="interne">
                                <table class="table table-bordered analyse_table_interne">
                                    <thead>
                                        <tr>
                                            <th>Détails</th>
                                            <th style="width: 300px">Problèmes</th>
                                            <th>Commentaire</th>

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
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="bg-red">
                                Problème majeur:
                                <select class="form-control" name="first_prob">
                                    <option></option>
                                    <option>Non conformité aux référentiel ou Contre indication</option>
                                    <option>Indication non traitée</option>
                                    <option>Sous dosage</option>
                                    <option>Surdosage</option>
                                    <option>Médicament non indiqué</option>
                                    <option>Interaction : A prendre en compte</option>
                                    <option>Interaction : Précaution d’emploi</option>
                                    <option>Interaction : Association déconseillée</option>
                                    <option>Interaction : Association contre-indiquée</option>
                                    <option>Interaction : Publiée (= hors GTIAM de l’A FSSAPS ) </option>
                                    <option>Voie et/ou administration inappropiée</option>
                                    <option>Traitement non reçu</option>
                                    <option>Monitorage à suivre</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="bg-orange">
                                Problème Modéré :
                                <select class="form-control" name="second_prob">
                                    <option></option>
                                    <option>Non conformité aux référentiel ou Contre indication</option>
                                    <option>Indication non traitée</option>
                                    <option>Sous dosage</option>
                                    <option>Surdosage</option>
                                    <option>Médicament non indiqué</option>
                                    <option>Interaction : A prendre en compte</option>
                                    <option>Interaction : Précaution d’emploi</option>
                                    <option>Interaction : Association déconseillée</option>
                                    <option>Interaction : Association contre-indiquée</option>
                                    <option>Interaction : Publiée (= hors GTIAM de l’A FSSAPS ) </option>
                                    <option>Voie et/ou administration inappropiée</option>
                                    <option>traitement non reçu</option>
                                    <option>Monitorage à suivre</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="bg-yellow-gradient">
                                Problème mineur :
                                <select class="form-control" name="third_prob">
                                    <option></option>
                                    <option>Non conformité aux référentiel ou Contre indication</option>
                                    <option>Indication non traitée</option>
                                    <option>Sous dosage</option>
                                    <option>Surdosage</option>
                                    <option>Médicament non indiqué</option>
                                    <option>Interaction : A prendre en compte</option>
                                    <option>Interaction : Précaution d’emploi</option>
                                    <option>Interaction : Association déconseillée</option>
                                    <option>Interaction : Association contre-indiquée</option>
                                    <option>Interaction : Publiée (= hors GTIAM de l’A FSSAPS ) </option>
                                    <option>Voie et/ou administration inappropiée</option>
                                    <option>traitement non reçu</option>
                                    <option>Monitorage à suivre</option>
                                </select>
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="accord_patient" class="label-control"> Accord Patient ?

                                <select name="patient_decision" class="form-control">
                                    <option value="2"></option>
                                    <option value="1">Accepter</option>
                                    <option value="3">Refuser</option>
                                </select>

                            </label>

                            <label for="accord_pharmacien" class="label-control"> Accord Pharmacien ?

                                <select name="pharmacien_decision" class="form-control">
                                    <option value="2"></option>
                                    <option value="1">Accepter</option>
                                    <option value="3">Refuser</option>
                                </select>

                            </label>
                        </div>
                    </div>






                    <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>" />
                    <input type="hidden" name="presc_id" />
                    <div class="col-sm-8">
                        <textarea name="global_comment" class="form-control" rows="4" cols="10"
                            placeholder="Commentaires global (optionnel)...."></textarea>
                    </div>
                    <input type="reset" class="btn btn-default " data-dismiss="modal" value="Fermer">
                    <input type="submit" class="btn btn-primary " value="Confirmer">
                </div>
            </form>
        </div>
    </div>
</div>




<div class="modal fade in" id="modal_alertes">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="bg-blue-active modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title alrt_med"></h4>
            </div>
            <div class="modal-body" class="table-responsive">
                <div class="box-group" id="alertes_accordion">

                </div>
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade in" id="modal_executer">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="bg-blue modal-header ">
                <h4 class="modal-title col-sm-4">Résultats D'analyses Pharmaceutiques</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form action="" method="POST">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('PATCH')); ?>

                <div class="modal-body">
                    <div class="table-responsive">
                        <div class="">
                            <div class="col-sm-3 alert alert-danger pt-1 no-border pl-1 pr-0 pri" hidden></div>
                            <div class="col-sm-3 alert alert-warning pt-1 no-border pl-1 pr-0 sec" hidden></div>
                            <div class="col-sm-3 alert alert-success pt-1 no-border pl-1 pr-0 sef" hidden></div>
                            <div class="col-sm-3 alert bg-gray pt-1 no-border pl-1 pr-0 det" hidden></div>
                        </div>
                        <table class="execute_table table table-bordered table-stripede">
                            <thead class="text-nowrap bg-gray">
                                <tr>
                                    <th>Médicament A</th>
                                    <th>Médicament(s) B</th>
                                    <th>Problèmes</th>
                                    <th>Intervention Pharmacien</th>
                                    <th>Commentaire</th>
                                    <th>Accepter</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="col-sm-4">
                        <input type="textarea" name="refus" size="50" height="3" placeholder="Motifs de refus......"
                            class="form-control pull-left refus" disabled="true">
                    </div>
                    <input type="reset" class="btn btn-default" data-dismiss="modal" value="Fermer">
                    <input type="submit" class="btn btn-primary" value="Valider mon Avis">
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\user\patient\modals\analyse-pharmaceutique.blade.php ENDPATH**/ ?>