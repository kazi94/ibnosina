@extends('layouts.model1')



@section('content')

    <div class="content-wrapper">

        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
        @endif

        @if (session()->has('message'))
            <p class="alert alert-success">{{ session('message') }}</p>
        @endif
        <div class="row">

            <div class="col-sm-12 mt-2 p-4">

                <!-- Horizontal Form -->
                <div class="box box-info">

                    <div class="box-header with-border">

                        <h3 class="box-title">Ajouter Profile</h3>

                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->

                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('profile.store') }}">

                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="nom_profile" class="control-label col-sm-3"> Nom profile*</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nom_profile" id="nom_profile"
                                        placeholder="Profile">
                                </div>
                            </div>



                            <div class="form-group ">

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="analyse_ph">
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut faire l'analyse pharmaceutique

                                </label>

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="administrer">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut Administrer le médicament </label>
                            </div>


                            <div class="form-group">

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="verif_medic">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Verifie la disponibilité du médicament</label>
                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="afficher_rdv">
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut voir les rendez-vous rédigé par les autres
                                    utilisateurs</label>

                            </div>

                            <div class="form-group">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="executer_demande_examen">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut éxecuter les demandes d'examens</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="medecin_presc">
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Médecin prescripteur</label>
                            </div>

                            <div class="form-group ">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="analyse_th">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut voir le résultat de l'analyse
                                    thérapeutique</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="analyse_sv">
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut voir le résultat de l'analyse de
                                    suivie</label>
                            </div>

                            <div class="form-group ">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="editeur_regle">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut accéder l'éditeur de règles</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="ok_chimio">

                                </div>
                                <label for="nom_profile" class="col-sm-5"> Chimiothérapie</label>
                            </div>

                            <div class="form-group">

                            </div>


                            <div class="table-responsive">

                                <small>Cliquer sur le titre de la colonne pour cocher toute la colonne*</small>

                                <table class="table table-bordered table-responsive">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th></th>
                                            <th>Lister</th>
                                            <th>Module</th>
                                            <th>Ajouter</th>
                                            <th>Modifier</th>
                                            <th>Supprimer</th>
                                            <th>Imprimer</th>
                                            <th>Exporter</th>
                                            <th>Graphe</th>
                                        </tr>
                                    </thead>
                                    <tbody style="text-align: center;">

                                        @php
                                            $tableau = [
                                                'Patient',
                                                'Prescription',
                                                'Automédication',
                                                'Analyse
                                                                                                                                biologique',
                                                'Traitement chronique',
                                                'Phytothérapie',
                                                'Questionnaire',
                                                'Education
                                                                                                                                thérapeutique',
                                                'Consultation',
                                                'Hospitalisation',
                                                'act_medicale',
                                                'dashboard',
                                                'compte patient',
                                                'compte
                                                                                                                                externe',
                                                'Prescription_chimio',
                                                'Protocole_chimio',
                                            ];
                                            $k = 0;
                                        @endphp
                                        @for ($i = 0; $i < count($tableau); $i++)
                                            <tr>
                                                <td>{{ $tableau[$i] }}</td>

                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="lister_{{ $tableau[$i] }}">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="détails_{{ $tableau[$i] }}">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="ajouter_{{ $tableau[$i] }}">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="modifier_{{ $tableau[$i] }}">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="supprimer_{{ $tableau[$i] }}">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="imprimer_{{ $tableau[$i] }}">
                                                    </label>
                                                </td>
                                                <td>
                                                    <label>
                                                        <input type="checkbox" class="flat-red"
                                                            name="exporter_{{ $tableau[$i] }}">
                                                    </label>
                                                </td>
                                                <!-- <td>
                                                        @if ($tableau[$i] === 'Prescription')
                                                            <label>
                                                                <input type="checkbox" class="flat-red"
                                                                    name="cloner_{{ $tableau[$i] }}">
                                                            </label>
                                                        @endif
                                                    </td> -->
                                                <td>
                                                    @if ($tableau[$i] === 'Analyse biologique')
                                                        <label>
                                                            <input type="checkbox" class="flat-red" name="dessiner_graphe">
                                                        </label>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>

                            </div>

                            <button type="submit" class="btn btn-info pull-right">Ajouter</button>

                        </form>

                    </div>
                    <!-- /.box-body -->

                </div>

            </div>

        </div>

    </div>


@endsection
@section('script')

    <script src="{{ asset('js/admin/profil/profil.js') }}"> </script>

@endsection
