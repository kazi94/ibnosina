<!-- Modal: Hospitalisation et Transferts -->
<div class="modal fade" id="modal_hospitalisation">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Demande d'hospitalisation</h4>
            </div>
            <form method="POST" action="{{ route('hospitalisation.store') }}" enctype="multipart/form-data"
                class="form-horizontal">
                {{ csrf_field() }}
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="service" class="col-sm-3 control-label">Service</label>

                        <div class="col-sm-9">
                            <select class="form form-control" name="service">
                                <option value="Maladies infectieuses">Maladies infectieuses</option>
                                <option value="Pneumologie">Pneumologie</option>
                                <option value="Hématologie">Hématologie</option>
                                <option value="Médecine Interne">Médecine Interne</option>
                                <option value="Bloc 470">Bloc 470</option>
                                <option value="Réanimation Covid">Réanimation Covid</option>
                                <option value="Laboratoire de Pharmacologie">Laboratoire de Pharmacologie</option>
                                <option value="Pharmacie Centrale">Pharmacie Centrale</option>
                                <option value="Laboratoire de Biologie Covid">Laboratoire de Biologie Covid</option>
                                <option value="Laboratoire de Microbiologie">Laboratoire de Microbiologie</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">

                        <label class="col-sm-3 control-label">Médecin traitant :</label>

                        <div class="col-sm-9">
                            <select class="form-control" name="owned_by">

                                @php
                                    $result = DB::table('users')
                                        ->where('service', Auth::user()->service)
                                        ->get();
                                @endphp
                                <option value=""></option>

                                @foreach ($result as $r)
                                    <option value="{{ $r->id }}">{{ $r->name }} {{ $r->prenom }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Date d'entrée</label>

                        <div class="col-sm-9">
                            <input type="date" class="form form-control" name="date_admission"
                                value="<?php echo date('Y-m-d'); ?>" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Motif</label>

                        <div class="col-sm-9">
                            <input type="text" class="form form-control" placeholder="Motif" name="motif" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Numéro billet</label>

                        <div class="col-sm-9">
                            <input type="number" class="form form-control" name="numbiais" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lit" class="col-sm-3 control-label">Chambre</label>

                        <div class="col-sm-9">
                            <input type="number" class="form form-control" name="chambre" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="lit" class="col-sm-3 control-label">Lit</label>

                        <div class="col-sm-9">
                            <input type="number" class="form form-control" name="lit" />
                        </div>
                    </div>


                    <div class="form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Date de sortie</label>

                        <div class="col-sm-9">
                            <input type="date" class="form form-control" name="date_sortie" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Motifs de sortie</label>

                        <div class="col-sm-9">
                            <select class="form form-control" name="motif_sortie" id="motif_sortie">
                                <option value=""></option>
                                <option value="décés">Décés</option>
                                <option value="hopital">Sortie de l'hôpital</option>
                                <option value="autre">Vers un autre service</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" hidden id="service_transfert">
                        <label for="service" class="col-sm-3 control-label">Service transféré</label>

                        <div class="col-sm-9">
                            <select class="form form-control" name="service_transfert">
                                <option value=""></option>
                                <option value="Maladies infectieuses">Maladies infectieuses</option>
                                <option value="Pneumologie">Pneumologie</option>
                                <option value="Hématologie">Hématologie</option>
                                <option value="Médecine Interne">Médecine Interne</option>
                                <option value="Bloc 470">Bloc 470</option>
                                <option value="Réanimation Covid">Réanimation Covid</option>
                                <option value="Laboratoire de Pharmacologie">Laboratoire de Pharmacologie</option>
                                <option value="Pharmacie Centrale">Pharmacie Centrale</option>
                                <option value="Laboratoire de Biologie Covid">Laboratoire de Biologie Covid</option>
                                <option value="Laboratoire de Microbiologie">Laboratoire de Microbiologie</option>
                            </select>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default mb-0" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary mb-0"
                        title="Imprimer et Ajouter une hospitalisation">Imprimer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade in" id="modal_edit_hospitalisation">
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
                        <form action="" class="up_hospitalisation" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                            <table class="table table-bordered table-condensed text-center">
                                <tr>
                                    <td>Service</td>
                                    <td>
                                        <select class="form form-control" name="service">
                                            <option value="Maladies infectieuses">Maladies infectieuses</option>
                                            <option value="Pneumologie">Pneumologie</option>
                                            <option value="Bloc 470">Bloc 470</option>
                                            <option value="Réanimation Covid">Réanimation Covid</option>
                                            <option value="Laboratoire de Pharmacologie">Laboratoire de Pharmacologie
                                            </option>
                                            <option value="Pharmacie Centrale">Pharmacie Centrale</option>
                                            <option value="Laboratoire de Biologie Covid">Laboratoire de Biologie Covid
                                            </option>
                                            <option value="Laboratoire de Microbiologie">Laboratoire de Microbiologie
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Médecin traitant</td>
                                    <td>
                                        <select class="form-control" name="owned_by" id="owned_by">

                                            @php
                                                $result = DB::table('users')
                                                    ->where('service', Auth::user()->service)
                                                    ->get();
                                            @endphp
                                            <option value=""></option>

                                            @foreach ($result as $r)
                                                <option value="{{ $r->id }}">{{ $r->name }}
                                                    {{ $r->prenom }}</option>
                                            @endforeach

                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Num Billet</td>
                                    <td><input type="number" id="numbiais" class="form form-control" name="numbiais"
                                            required /></td>
                                </tr>
                                <tr>
                                    <td>Chambre</td>
                                    <td><input type="number" id="chambre" class="form form-control" name="chambre"
                                            required /></td>
                                </tr>
                                <tr>
                                    <td>Lit</td>
                                    <td><input type="number" id="lit" class="form form-control" name="lit" required />
                                    </td>
                                </tr>
                                <tr>
                                    <td>motif</td>
                                    <td><input type="text" class="form form-control" placeholder="Motif" id="motif"
                                            name="motif" /></td>
                                </tr>
                                <tr>
                                    <td>Date Admission</td>
                                    <td><input type="date" id="date_admission" class="form form-control"
                                            name="date_admission" required /></td>
                                </tr>
                                <tr>
                                    <td>Date Sortie</td>
                                    <td><input type="date" id="date_sortie" class="form form-control"
                                            name="date_sortie" /></td>
                                </tr>
                                <tr>
                                    <td>Motif Sortie</td>
                                    <td>
                                        <select class="form form-control" name="motif_sortie" id="motif_sortie1">
                                            <option value=""></option>
                                            <option value="décés">Décés</option>
                                            <option value="hopital">Sortie de l'hôpital</option>
                                            <option value="autre">Vers un autre service</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr hidden id="service_transfert1">
                                    <td>Service transférer </td>
                                    <td>
                                        <select class="form form-control" name="service_transfert">
                                            <option value="Maladies infectieuses">Maladies infectieuses</option>
                                            <option value="Pneumologie">Pneumologie</option>
                                            <option value="Bloc 470">Bloc 470</option>
                                            <option value="Réanimation Covid">Réanimation Covid</option>
                                            <option value="Laboratoire de Pharmacologie">Laboratoire de Pharmacologie
                                            </option>
                                            <option value="Pharmacie Centrale">Pharmacie Centrale</option>
                                            <option value="Laboratoire de Biologie Covid">Laboratoire de Biologie Covid
                                            </option>
                                            <option value="Laboratoire de Microbiologie">Laboratoire de Microbiologie
                                            </option>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                    </div>

                </div>
                <td>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                <input type="submit" class="btn btn-primary pull-right" value="Modifier">
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade in" id="modal_detail_impression">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <div class="row">
                    <div class="col-md-9">
                        <h4 class="modal-title">Choissiez les parties que vous voulez imprimer</h4>
                    </div>
                </div>
            </div>
            <form action="{{ route('hospitalisation.shows') }}" class="up_impression" method="post"
                enctype="multipart/form-data" target="newStuff">
                @csrf
                <input type="hidden" name="patient_id" value="{{ $patient->id }}">
                <div class="modal-body" style="display: block;">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-bordered table-condensed text-center">
                                <tr>
                                    <td>Antecedants</td>
                                    <td>
                                        <input type="checkbox" name="a" value="a" checked> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Biometrie</td>
                                    <td>
                                        <input type="checkbox" name="b" value="b" checked> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Historique de consultations</td>
                                    <td>
                                        <input type="checkbox" name="c" value="c" checked> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prescription Medicament</td>
                                    <td>
                                        <input type="checkbox" name="p" value="p" checked> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prescription Act</td>
                                    <td>
                                        <input type="checkbox" name="aa" value="aa" checked> <br>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Prescription Examen</td>
                                    <td>
                                        <input type="checkbox" name="e" value="e" id="e" onclick="myFunction()" checked>
                                        <br>
                                    </td>
                                </tr>
                                <tr id="text" style="display:block">
                                    <td>Date Debut</td>
                                    <td>
                                        <input type="date" id="dateD" name="dateD" class="form form-control" />
                                    </td>
                                    <td>Date Fin</td>
                                    <td>
                                        <input type="date" id="dateF" name="dateF" class="form form-control" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>Prescription Chronique</td>
                                    <td>
                                        <input type="checkbox" name="ch" value="ch" checked> <br>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Historique des Hospitalisations</td>
                                    <td>
                                        <input type="checkbox" name="h" value="h" checked> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>phytotherapie</td>
                                    <td>
                                        <input type="checkbox" name="ph" value="ph" checked> <br>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Radiologie</td>
                                    <td>
                                        <input type="checkbox" name="r" value="r" checked> <br>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Fermer</button>
                    <input type="submit" class="btn btn-default pull-right" value="Imprimer Rapport">
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal détails de la hospitalisation -->
<div class="modal fade in" id="modal_detail_hospitalisation">
    <div class="modal-dialog modal-md">

        <div class="modal-content table-responsive">
            <div class="bg-blue modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">Détails de l'hospitalisation</h4>
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
