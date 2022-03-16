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

                        <h3 class="box-title">Modifier Profile</h3>

                    </div>
                    <!-- /.box-header -->

                    <!-- form start -->
                    <div class="box-body">
                        <form class="form-horizontal" role="form" method="POST"
                            action="{{ route('profile.update', $role->id) }}">

                            {{ csrf_field() }}
                            {{ method_field('PATCH') }}
                            <div class="form-group">
                                <label for="nom_profile" class="control-label col-sm-3"> Nom profile*</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="nom_profile" id="nom_profile"
                                        placeholder="Profile" value="{{ $role->nom_profile }}">
                                </div>
                            </div>



                            <div class="form-group ">

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="analyse_ph" @if ($role->analyse_ph === 'on') checked @endif>
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut faire l'analyse pharmaceutique

                                </label>

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="administrer" @if ($role->administrer === 'on') checked @endif>
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut Administrer le médicament </label>
                            </div>


                            <div class="form-group">

                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="verif_medic" @if ($role->verif_medic === 'on') checked @endif>
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Verifie la disponibilité du médicament</label>
                                <div class="col-sm-1">

                                    <input type="checkbox" class="flat-red" name="afficher_rdv" @if ($role->afficher_rdv === 'on') checked @endif>
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut voir les rendez-vous rédigé par les autres
                                    utilisateurs</label>

                            </div>

                            <div class="form-group">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="executer_demande_examen" @if ($role->executer_demande_examen === 'on') checked </beautify
                                                            end=" @endif">
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut éxecuter les demandes d'examens</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="medecin_presc" @if ($role->medecin_presc === 'on') checked @endif>
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Médecin prescripteur</label>
                            </div>

                            <div class="form-group ">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="analyse_th" @if ($role->analyse_th === 'on') checked @endif>
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut voir le résultat de l'analyse
                                    thérapeutique</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="analyse_sv" @if ($role->analyse_sv === 'on') checked @endif>
                                </div>
                                <label for="nom_profile" class=" col-sm-5"> Peut voir le résultat de l'analyse de
                                    suivie</label>
                            </div>

                            <div class="form-group ">
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="editeur_regle" @if ($role->editeur_regle === 'on') checked @endif>
                                </div>
                                <label for="nom_profile" class="col-sm-5"> Peut accéder l'éditeur de règles</label>
                                <div class="col-sm-1">
                                    <input type="checkbox" class="flat-red" name="ok_chimio" @if ($role->ok_chimio === 'on') checked @endif>

                                </div>
                                <label for="nom_profile" class="col-sm-5"> Chimiothérapie</label>
                            </div>

                            <div class="form-group">

                            </div>


                            <div class="table-responsive">

                                <table class="table table-bordered">
                                    <thead class="bg-gray">
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
                                            
                                            $tableau = ['Patient', 'Prescription', 'Automédication', 'Analyse biologique', 'Traitement chronique', 'Questionnaire', 'Phytothérapie', 'Education thérapeutique', 'Consultation', 'Hospitalisation', 'Acte Médicale', 'Tableau de bord', 'Compte Patient', 'Compte Externe', 'Prescription Chimiothérapeute', 'Protocole Chiomiothérapeute'];
                                            
                                            $tableau1 = ['patient', 'prescription', 'auto', 'analyse_bio', 'traitement', 'question', 'phyto', 'et', 'consultation', 'ho', 'act', 'dashboard', 'cpt_pat', 'cpt_ext', 'Prescription_chimio', 'Protocole_chimio'];
                                            
                                            $k = 0;
                                        @endphp
                                        @for ($i = 0; $i < count($tableau); $i++)
                                            @php
                                                $y = 'ajouter_' . $tableau1[$i];
                                                $z = 'modifier_' . $tableau1[$i];
                                                $w = 'supprimer_' . $tableau1[$i];
                                                $a = 'imprimer_' . $tableau1[$i];
                                                $b = 'lister_details_' . $tableau1[$i];
                                                $f = 'lister_' . $tableau1[$i];
                                                $e = 'exporter_' . $tableau1[$i];
                                            @endphp <tr>
                                                <td>{{ $tableau[$i] }}</td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="lister_{{ $tableau1[$i] }}" @if ($role->$f === 'on') checked @endif></label></td>

                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="détails_{{ $tableau1[$i] }}" @if ($role->$b === 'on') checked @endif></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="ajouter_{{ $tableau1[$i] }}" @if ($role->$y === 'on') checked @endif></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="modifier_{{ $tableau1[$i] }}" @if ($role->$z === 'on') checked @endif></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="supprimer_{{ $tableau1[$i] }}" @if ($role->$w === 'on') checked @endif></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="imprimer_{{ $tableau1[$i] }}" @if ($role->$a === 'on') checked @endif></label></td>
                                                <td><label><input type="checkbox" class="flat-red"
                                                            name="exporter_{{ $tableau1[$i] }}" @if ($role->$e === 'on') checked @endif></label></td>
                                                <!-- <td>
                                                            @if ($tableau[$i] === 'Prescription')
                                                                <label><input type="checkbox" class="flat-red"
                                                                        name="cloner_{{ $tableau1[$i] }}" @if ($role->cloner_prescription === 'on') checked </beautify
                                                                    end=" @endif"> ></label>
                                                            @endif
                                                        </td> -->
                                                <td>
                                                    @if ($tableau[$i] === 'Analyse biologique')
                                                        <label><input type="checkbox" class="flat-red"
                                                                name="dessiner_graphe" @if ($role->dessiner_graphe === 'on') checked @endif></label>
                                                    @endif
                                                </td>

                                            </tr>
                                        @endfor
                                    </tbody>
                                </table>

                            </div>
                            <button type="submit" class="btn btn-warning pull-right">Modifier</button>


                        </form>

                    </div>
                    <!-- /.box-body -->

                </div>

            </div>

        </div>

    </div>


@endsection

@section('script')

    <script src="{{ asset('js/admin/profil/profil.js') }}"></script>

@endsection
