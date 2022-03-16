<div class="modal fade" id="modal_biologique" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Bilans d'examen</h4>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal">
                <?php echo e(csrf_field()); ?>

                <?php echo e(method_field('PATCH')); ?>

                <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Date d'analyse</label>

                        <div class="col-sm-9">
                            <input type="date" name="date_analyse" class="form-control"
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="labo" class="col-sm-3 control-label">Laboratoire</label>

                        <div class="col-sm-9">
                            <input type="text" name="laboratoire" class="form-control">
                        </div>
                    </div>
                    <div id="radioDiv" style="display: none;">
                        <div class="form-group">
                            <label for="fichier" class="col-sm-3 control-label">Fichier</label>

                            <div class="col-sm-9">
                                <input type="file" name="fichier" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Imagerie</label>

                            <div class="col-sm-9">
                                <select name="is_imagery" class="form-control">
                                    <option value="0">Absente</option>
                                    <option value="1">Présente</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Taux d'atteinte</label>

                            <div class="col-sm-9">
                                <input type="text" name="attack_rate" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="commentaire" class="col-sm-3 control-label">Commentaire</label>

                            <div class="col-sm-9">
                                <textarea name="comment" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="bilanDiv">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="bilansTable">
                                <thead>
                                    <tr class="bg-green ">
                                        <th class="text-center">Element</th>
                                        <th>Valeur</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default mb-0" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary mb-0">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php /**PATH C:\laragon\www\anapharm\resources\views\includes\modals\prescription-examen.blade.php ENDPATH**/ ?>