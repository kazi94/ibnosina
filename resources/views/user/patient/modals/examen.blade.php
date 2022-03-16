<!-- Modal analyse biologique -->
@include('includes.modals.prescription-examen' , compact('patient'))
<!-- Modal analyse biologique -->
<div class="modal fade" id="modal_update_biologique" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Modifier Examen</h4>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="d_analyse" class="col-xs-3 control-label">Element</label>

                        <div class="col-xs-9">
                            <p id="el"></p>
                        </div>
                    </div>
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
                    <div class="form-group">
                        <label for="labo" class="col-sm-3 control-label">Valeur</label>

                        <div class="col-sm-9">
                            <input type='number' step='0.00001' name="valeur" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="labo" class="col-sm-3 control-label">Commentaire</label>

                        <div class="col-sm-9">
                            <input type="text" name="commentaire" class="form-control">
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
<!-- Modal demande d'examens par le médecin-->
<div class="modal fade" id="modal_demande_examen" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Prescription d'examen</h4>
            </div>
            <form method="POST" action="{{ route('bilan.store') }}" enctype="multipart/form-data"
                class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                <input type="hidden" name="consultation_id" id="cons_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Date de prescription</label>

                        <div class="col-sm-9">
                            <input type="date" name="date_prescription" class="form-control"
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Type d'examen</label>

                        <div class="col-sm-9">
                            <select name="type" id="type_examen" class="form form-control" required
                                onchange="$(this).val() == 'bilan' ? $('#modal_demande_examen #bilan').show() : $('#modal_demande_examen #bilan').hide();">
                                <option value="">Sélectionner le type d'examen</option>
                                <option value="bilan">Biologique</option>
                                <option value="radio">Imagerie</option>
                            </select>
                        </div>
                    </div>
                    <div id="bilan" style="display: none;">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Prescription type</label>

                            <div class="col-sm-9">
                                <select id="examens_type" class="form-control">
                                    <option value="">Sélectionner l'examen type</option>
                                    @foreach (Auth::user()->examensType as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type de bilan</label>

                            <div class="col-sm-9">
                                <select id="type_bilan" class="form form-control">
                                    <option value="">Sélectionner le Bilan</option>
                                    @foreach ($bilans as $bilan)
                                        <option value="{{ $bilan->bilan }}">{{ $bilan->bilan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Eléments</label>

                            <div class="col-sm-9" id="elements">
                                <table>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Note</label>

                            <div class="col-sm-9">
                                <textarea name="note" cols="30" rows="5"></textarea>
                            </div>
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

<!-- Model graphe_billan -->
<div class="modal" id="modal_graphe" style="display: none;">
    <div class="modal-dialog modal-lg" style="width: 100%">
        <div class="modal-content">
            <div class="modal-header text-center">
                <div class="row">
                    <div class="col-md-3">
                        <h4 class="modal-title">Presentation graphique</h4>
                    </div>

                    <div class="col-md-9 form-inline">
                        <label class="form-inline">Debut :
                            <input type="date" class="form-control" id="date_debut" required />
                        </label>
                        <label class="form-inline">Fin :
                            <input type="date" class="form-control" id="date_fin" required />
                        </label>
                        <label class="form-inline">Element 1: </label>
                        <select class="form-inline form-control" id="TypeExamenGraphe1" name="typeBilansGraphe[]"
                            style="font-weight: bolder;">
                        </select>
                        <label class="form-inline">Element 2: </label>
                        <select class="form-inline form-control" id="TypeExamenGraphe2" name="typeBilansGraphe[]"
                            style="font-weight: bolder;">
                        </select>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="modal-body">
                <div class="card-body">
                    <canvas id="Chart" width="100%" height="30%"></canvas>
                </div>

            </div>

            <div class="modal-footer">
                <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal choix d'examen a afficher dans le dashboard -->
<div class="modal" id="modal_Graphes1" style="display: none;">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Les Tableaux de bord</h4>
            </div>

            <div class="modal-body">
                <div class="row col-sm-offset-1">
                    <input type="text" id="id_pat" value="{{ $patient->id }}" hidden>
                    @php
                        $dashboards = DB::table('dashboards')
                            ->select('nom')
                            ->distinct()
                            ->get();
                    @endphp
                    @foreach ($dashboards as $dashboard)
                        <div class="col-md-12">
                            <label><input type="radio" name="dash" value="{{ $dashboard->nom }}" checked=false>
                                {{ $dashboard->nom }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="modal-footer">
                <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
                <input type="submit" class="btn btn-primary pull-right" id="graphesBtn" value="Confirmer" />
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Graphes modals  -->
<div class="modal" id="modal_Graphes2" style="display: none; overflow-y: auto;">
    <div class="modal-dialog modal-lg" style="width: 1200px">
        <div class="modal-content">

            <div class="bg-blue modal-header text-center">
                <div class="row">
                    <div class="col-md-6">
                        <h4 class="modal-title" id="title"></h4>
                    </div>
                    <div class="col-md-6">
                        <label class="form-inline">Debut :
                            <input type="date" class="form-control" id="date_debut_tab" required />
                        </label>
                        <label class="form-inline">Fin :
                            <input type="date" class="form-control" id="date_fin_tab" required />
                        </label>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>

                    </div>
                </div>

            </div>

            <div class="modal-body" style="margin-left: 35px;margin-right: 35px;">
                <div id="div_graphes" class="row">

                </div>
            </div>

            <div class="modal-footer">
                <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">

                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Modal détails analyse Biologique -->
<div class="modal fade in" id="modal_detail_analyse">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <div class="row">
                    <div class="col-md-9">
                        <h4 class="modal-title">Modifier</h4>
                    </div>
                </div>
            </div>
            <div class="modal-body" style="display: block;">
                <div class="row">

                    <div class="col-sm-12">
                        <form action="" class="up_bilan" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                            <table class="table table-bordered table-condensed text-center">
                                <tr>
                                    <td>Bilan*</td>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>Element*</td>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td>Valeur</td>
                                    <td><input type="text" name="valeur" id="valeur" class="form-control"></td>
                                </tr>
                                <tr>
                                    <td>Unite*</td>
                                    <td><select name="unite" id="unite" class="form-control unite"></select></td>
                                </tr>
                                <tr>
                                    <td>Date_analyse*</td>
                                    <td><input type="date" name="date_analyse" id="date_analyse" class="form-control"
                                            required></td>
                                </tr>
                                <tr>
                                    <td>Laboratoire</td>
                                    <td><input type="text" name="laboratoire" id="laboratoire" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Commentaire</td>
                                    <td><input type="text" name="commentaire" id="commentaire" class="form-control">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Fichier Média</td>
                                    <td><input type="file" class="form-control" name="fichiers" id="fichiers"
                                            accept=".png,.jpeg,.mp3,.mp4,.3gp,.jpg"></td>
                                </tr>
                            </table>
                    </div>

                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
                <input type="submit" class="btn btn-default pull-right" value="Modifier">
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- Modal média bilan biologique/education thérapeutique -->
<div class="modal fade in" id="modal_imgs">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <div class="row">
                </div>
            </div>
            <div class="modal-body" style="display: block; text-align: center;">
                <img src="" alt="" style="width: 100%;height: 100%;" />
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-default pull-left rst_media" data-dismiss="modal" value="Fermer">
            </div>
        </div>
    </div>
</div>
