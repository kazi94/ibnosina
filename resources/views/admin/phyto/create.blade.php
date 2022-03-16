@extends('layouts.model1')

@section('script_css1')
    <style>
        .no-record #default_table {
            display: none;
        }

    </style>
@endsection

@section('content')

    <div class="content-wrapper">
        <section class="content">
            @if (count($errors) > 0)

                @foreach ($errors->all() as $error)

                    <p class="alert alert-danger">{{ $error }}</p>

                @endforeach

            @endif

            <div class="alert alert-danger" style="display: none;"></div>

            @if (session()->has('message'))
                <p class="alert alert-success">{{ session('message') }}</p>
            @endif

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

                            <form class="form-group" role="form" method="POST" action="{{ route('produit.store') }}">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="form-group col-sm-6">

                                        <label>Produit naturel (FR) </label>

                                        <input type="text" class="form-control" name="produit_naturel_fr"
                                            placeholder="placer votre produit en Français" required>

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
                                            <option value="Sommité fleurie">Sommité fleurie</option>
                                            <option value="Partie aérienne">Partie aérienne</option>
                                            <option value="Graine">Graine</option>
                                            <option value="Fruit">Fruit</option>
                                        </select>

                                    </div>

                                    <div class="form-group col-sm-6">

                                        <label>Mode de Préparation</label>

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
                                        <h4> Intéractions Médicamenteuses</h4>
                                    </div>

                                    <div>

                                        <div class="form-group col-sm-6">

                                            <label>Médicaments (DCI) </label>
                                            <input type="hidden" class="medicament_dci_id" id="medicament_dci_id">

                                            <input type="text" class="form-control médicament_dci"
                                                placeholder="Médicament DCI" id="medic_input">

                                        </div>


                                        <div class="form-group col-sm-6">
                                            <label>Type d'effet </label>
                                            <select class="form-control" name="type_effet[]" id="type">
                                                <option value="Interaction Pharmacocinétique">Interaction Pharmacocinétique
                                                </option>
                                                <option value="Interaction Pharmacodynamique">Interaction Pharmacodynamique
                                                </option>
                                                <option value="Physicochémique">Physicochémique</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-sm-6">

                                            <label>Effet de l'intéraction</label>

                                            <textarea type="text" class="form-control"
                                                placeholder="Effet de l'intéraction...." rows="2" cols="40"
                                                id="effet"></textarea>

                                        </div>


                                        <div class="form-group col-sm-6">

                                            <label>Niveau d'interaction</label>

                                            <select id="niveau" class="form-control">
                                                <option value="1">Contre indication</option>
                                                <option value="2">Association déconseillé</option>
                                                <option value="3">Précaution d'emploi</option>
                                            </select>

                                        </div>

                                        <div class="form-group col-sm-7">

                                            <label>Indication traditionelle</label>

                                            <textarea type="text" class="form-control"
                                                placeholder="Indication Traditionnelle..." rows="2" cols="40"
                                                id="indic"></textarea>

                                        </div>

                                        <div class="form-group col-sm-5">

                                            <label>Effets Pharmacologiques documenté</label>

                                            <textarea type="text" class="form-control"
                                                placeholder="Effets Pharmacologiques documenté..." rows="2" cols="40"
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
                                            l'intéraction</button>
                                    </div>
                                </div>


                                <div class="table-responsive">
                                    <table class="table table-bordered table-condensed produit_tab"
                                        id="interactions_plantes">
                                        <thead class="bg-info">
                                            <tr>
                                                <th>Médicament</th>
                                                <th>Effet de l'interaction</th>
                                                <th>Type effet</th>
                                                <th>Indication traditionelle</th>
                                                <th>Effets Pharmacologiques documenté</th>
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



@endsection

@section('script')
    <!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script> -->
    <script src="{{ asset('plugins/datatable-1.10.24/datatables.min.js') }}"></script>

    <script src="{{ asset('plugins/jquery/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="/js/admin/gestion_produit.js"></script>

@endsection
