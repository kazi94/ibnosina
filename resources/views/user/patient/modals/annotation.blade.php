<!-- modal annotation -->
<div class="modal fade in" id="modal_annotation">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Ajouter une Annotation</h4>
            </div>
            <div class="row mt-1 mb-2">
                <div class="col-sm-12 text-center" id="controls">
                    <button class="btn btn-default" id="recordButton">Enregistrer</button>
                    <button class="btn btn-default" id="pauseButton">Pause</button>
                    <button class="btn btn-default" id="stopButton">Arréter</button>
                </div>
                <div class="col-sm-12" id="recorderList">

                </div>
            </div>
            <form action="{{ route('addAnnotation') }}" class="form-horizontal" method="post"
                enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                <input type="hidden" id="object_id" name="object_id">
                <input type="hidden" id="object_type" name="object_type">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="domaine" class="col-sm-3 control-label">Domaine</label>

                        <div class="col-sm-9">
                            <input type="hidden" name="domaine" value="{{ Auth::user()->specialite }}">
                            {{ Auth::user()->specialite }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date" class="col-sm-3 control-label">Date</label>

                        <div class="col-sm-9">
                            <input type="date" name="date" class="form-control"
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Visibilité" class="col-sm-3 control-label">Visibilité</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="lecture">
                                <option value="public">Public</option>
                                <option value="prive">Privé</option>
                                <option value="personne">Personne</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Fichier" class="col-sm-3 control-label">Fichier enregistré</label>

                        <div class="col-sm-9">
                            <input type="file" class="form-control" name="file" type="audio/*">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Commentaire" class="col-sm-4 control-label">Commentaire</label>

                        <div class="col-sm-12">
                            <textarea rows="4" cols="31" name="commentaire" class="form-*control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary pull-right" value="Ajouter">
                    <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
                </div>
            </form>
        </div>
    </div>
</div>
