@extends('layouts.model')

@section('script_css')
    <link rel="stylesheet" href="{{ asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery/css/jquery_ui.css') }}">
@endsection

@section('content')
    <div class="content-wrapper">

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
            <div class="col-md-8 col-xs-12 col-md-offset-2">
                <!-- Horizontal Form -->
                <div class="box box-info">

                    <div class="box-header with-border">

                        <!--<h3 class="box-title">Ajouter une règle</h3>-->

                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <!--pour choisir entre regle medic ou patient-->

                    <div class="box-body">
                        <div role="tabpanel">

                            <ul class="nav nav-tabs" id="tablist">
                                <li role="presentation" class="active" id="the"><a href="#analysepharm"
                                        aria-controls="theriaque" role="tab" data-toggle="tab">Analyse pharmaceutique</a>
                                </li>
                                <li role="presentation" id="educ"><a href="#edu" aria-controls="theriaque" role="tab"
                                        data-toggle="tab">Education thérapeutique</a></li>
                                <li role="presentation" id="sui"><a href="#suivi" aria-controls="theriaque" role="tab"
                                        data-toggle="tab">Pilotage donnée patient</a></li>

                            </ul>

                            <div class="tab-content">
                                <!--ici c'est le contenu de l'onglet 1-->
                                <div role="tabpanel" class="tab-pane active" id="analysepharm">
                                    <!--onglet 1-->

                                    <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                                        <p> </p><br>
                                        ______________________________REGLE PATIENT______________________________
                                        <p> </p><br>
                                    </div>

                                    <div class="element" style="">
                                        <form method="POST" action="{{ route('reglee.store') }}"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="exampleFormControlSelect2">Choisissez:</label>
                                                    <select class="form-control" id="critere" onclick="showAttribut()">
                                                        <option></option>
                                                        <option>Age</option>
                                                        <option>Taille(cm)</option>
                                                        <option>Poids(kg)</option>
                                                        <option>Sexe</option>
                                                        <option>Mode de vie</option>
                                                        <option>Pathologie(s) associée(s)</option>
                                                        <option>Allergie(s) associée(s)</option>
                                                        <option>Examens</option>
                                                        <option>Service</option>
                                                        <option>Durée hospitalisation</option>
                                                        <option>état de la patiente</option>
                                                        <option>Observance</option>
                                                        <option>Activité professionnel</option>
                                                        <option>Nombre de ligne prescription</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="divDynamque1">
                                                </div>
                                                <div class="form-group col-sm-4" id="divDynamque2">
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="row">
                                                <div class="form-group col-sm-6" id="divDynamque11">
                                                </div>
                                                <div class="form-group col-sm-6" id="divDynamque22">
                                                </div>

                                            </div>
                                            <!--row-->


                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                                                ____________________________REGLE MEDICAMENT____________________________
                                                <p> </p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="exampleFormControlSelect2">Choisissez:</label>
                                                    <select class="form-control" id="choice" onclick="showMedicament()">
                                                        <option></option>
                                                        <option>Produits Alimentaires</option>
                                                        <option>Médicament</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-4" id="div1">
                                                </div>
                                                <div class="form-group col-sm-4" id="div2">
                                                </div>
                                            </div>
                                            <!--row-->
                                            <div class="row">
                                                <div class="form-group col-sm-6" id="div11">
                                                </div>
                                                <div class="form-group col-sm-6" id="div22">
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                ________________________________FONCTIONS________________________________
                                                <p></p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4" id="operation">
                                                    <label for="exampleFormControlSelect1">operation</label>
                                                    <select class="form-control" id="operationSelect"
                                                        onclick="recuperer('operationSelect')">
                                                        <option></option>
                                                        <option>+</option>
                                                        <option>-</option>
                                                        <option>/</option>
                                                        <option>=</option>
                                                        <option>!=</option>
                                                        <option>></option>
                                                        <option>
                                                            << /option>
                                                        <option>>=</option>
                                                        <option>
                                                            <=< /option>
                                                    </select>

                                                </div>
                                                <div class="form-group col-sm-4" id="operateur">
                                                    <label for="exampleFormControlSelect1">operateur</label>
                                                    <select class="form-control" id="operateurSelect"
                                                        onclick="recuperer('operateurSelect')">
                                                        <option></option>
                                                        <option>ET</option>
                                                        <option>OU</option>
                                                        <option>NON</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="autre">
                                                    <label for="exampleFormControlSelect1">autre:</label>
                                                    <select class="form-control" id="autreSelect"
                                                        onclick="recuperer('autreSelect')">
                                                        <option>,</option>
                                                        <option>.</option>
                                                        <option>{</option>
                                                        <option>}</option>
                                                        <option value="abs">abs</option>
                                                        <option>(</option>
                                                        <option>)</option>
                                                        <option>[</option>
                                                        <option>]</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="form-group" id="textSelection">
                                                <!--premier si -->
                                                <label for="exampleFormControlTextarea1">Si:</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1" name="si"
                                                    rows="5" onkeypress="interdireEcriture()" require></textarea>
                                            </div>
                                            <div class="form-group" id="resultat">
                                                <label for="exampleFormControlSelectAge">Alors:</label>
                                                <select class="form-control" id="resultatSelect" name="alors">
                                                    <option>prescription à risque</option>
                                                    <option>patient à risque</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1">commentaire :</label>
                                                <textarea class="form-control" name="commentaire"
                                                    id="exampleFormControlTextarea1" rows="3"></textarea>
                                            </div>
                                            <input type="hidden" name="type" value="patient">
                                            <input type="submit" class="btn btn-primary pull-right" value="Confirmer">
                                            <p> </p><br><br><br>
                                        </form>
                                    </div>
                                    <!--element-->

                                    <div class="box-footer ">
                                        @php$reglees = DB::table('reglees')
                                                                                            ->select('reglees.*')
                                                                                    ->get(); @endphp ?>
                                        @if (count($reglees) > 0)
                                            <table class="table table-bordered text-center element " id="id1">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Si</th>
                                                        <th>Alors</th>
                                                        <th>Commentaire</th>

                                                        <th>Modifier</th>
                                                        <th>Supprimer</th>
                                                </thead>
                                                <tbody class="regle_footer">
                                                    @foreach ($reglees as $reglee)
                                                        <tr>

                                                            <td>{{ $reglee->si }}</td>
                                                            <td>{{ $reglee->alors }}</td>
                                                            <td>{{ $reglee->commentaire }}</td>

                                                            <td><a href="{{ route('reglee.edit', $reglee->id) }}"><span
                                                                        class="glyphicon glyphicon-edit"></span></a></td>
                                                            <td>
                                                                <form style='display: none;' method='POST'
                                                                    action="{{ route('reglee.destroy', $reglee->id) }}"
                                                                    id='delete-form-{{ $reglee->id }}'>
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                </form>
                                                                <a href=""
                                                                    onclick="if (confirm('voulez vous supprimer cette ligne ?')) {event.preventDefault(); documalorsent.getElementById('delete-form-{{ $reglee->id }}').submit();} ">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif

                                    </div>
                                    <!--div footer-->

                                </div>
                                <!---onglet 1-->




                                <div role="tabpanel" class="tab-pane" id="edu">
                                    <!--Onglet 2-->
                                    <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                                        <p> </p><br>
                                        ______________________________Education thérapeutique______________________________
                                        <p> </p><br>
                                    </div>
                                    <div class="element_onglet2" style="">
                                        <form method="POST" action="{{ route('education.store') }}"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="form-group col-sm-4" id="choix">
                                                    <label for="exampleFormControlSelect2">Choisissez:</label>
                                                    <select class="form-control" id="choixSelect"
                                                        onclick="recuperer('choixSelect')">
                                                        <option></option>
                                                        <option>pathologie</option>
                                                        <option>observance</option>
                                                        <option>médicament</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4" id="patho">
                                                    <label for="exampleFormControlSelect2">Pathologie(s) associée(s)</label>
                                                    <select class="form-control" id="pathoSelect"
                                                        onclick="recuperer('pathoSelect')">
                                                        @php
                                                            $pathologies = DB::select('select * from pathologies');
                                                        @endphp
                                                        @foreach ($pathologies as $pathologie)
                                                            <option value="{{ $pathologie->pathologie }}">
                                                                {{ $pathologie->pathologie }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="ob">
                                                    <label for="exampleFormControlSelect2">Observance</label>
                                                    <select class="form-control" id="obSelect"
                                                        onclick="recuperer('obSelect')">
                                                        <option>non-observant</option>
                                                        <option>observant</option>
                                                        <option>moyen-observant</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="med">
                                                    <label for="exampleFormControlSelect2">Médicament DCI</label>
                                                    <input type="text" class="form form-control"
                                                        placeholder="Médicament DCI ou médicament commerciale"
                                                        name="medicament_dci" autocomplete="off" id="medSelect"
                                                        onclick="recuperer('medSelect')">
                                                </div>


                                            </div>
                                            <!--row-->



                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                ________________________________FONCTIONS________________________________
                                                <p></p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4" id="op">
                                                    <label for="exampleFormControlSelect1">operation</label>
                                                    <select class="form-control" id="opSelect"
                                                        onclick="recuperer('opSelect')">
                                                        <option></option>
                                                        <option>+</option>
                                                        <option>-</option>
                                                        <option>/</option>
                                                        <option>=</option>
                                                        <option>!=</option>
                                                        <option>></option>
                                                        <option>
                                                            << /option>
                                                        <option>>=</option>
                                                        <option>
                                                            <=< /option>
                                                    </select>

                                                </div>
                                                <div class="form-group col-sm-4" id="operateurr">
                                                    <label for="exampleFormControlSelect1">operateur</label>
                                                    <select class="form-control" id="operateurrSelect"
                                                        onclick="recuperer('operateurrSelect')">
                                                        <option></option>
                                                        <option>ET</option>
                                                        <option>OU</option>
                                                        <option>NON</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="autres">
                                                    <label for="exampleFormControlSelect1">autre:</label>
                                                    <select class="form-control" id="autresSelect"
                                                        onclick="recuperer('autresSelect')">
                                                        <option>,</option>
                                                        <option>.</option>
                                                        <option>{</option>
                                                        <option>}</option>
                                                        <option value="abs">abs</option>
                                                        <option>(</option>
                                                        <option>)</option>
                                                        <option>[</option>
                                                        <option>]</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="form-group" id="titreSelection">
                                                <label>Titre de la règle:</label>
                                                <textarea class="form-control" name="titre"></textarea>
                                            </div>
                                            <div class="form-group" id="texteSelection">
                                                <label for="exampleFormControlTextarea2">Si:</label>
                                                <!--deuxieme si-->
                                                <textarea class="form-control" id="exampleFormControlTextarea2" name="si"
                                                    rows="5" onkeypress="interdireEcriture()" require></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label ">commentaire :</label>
                                                <textarea class=" form-control" name="commentaire" rows="3"></textarea>
                                            </div>
                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                _____________________________A propos de
                                                l'éducation_____________________________
                                                <p></p><br>
                                            </div>
                                            <div class="form-group">
                                                <label>Explication de la maladie :</label>
                                                <textarea class="form-control" name="maladie" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Effets de médicament :</label>
                                                <textarea class="form-control" name="effet" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Conduite à tenir pendant le voyage :</label>
                                                <textarea class="form-control" name="voyage" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Act chirurgical :</label>
                                                <textarea class="form-control" name="act" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Comment utiliser le médicament :</label>
                                                <textarea class="form-control" name="utilisation" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Effets indésirables:</label>
                                                <textarea class="form-control" name="effet_indiserable" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>regles hygiéno-diètétique :</label>
                                                <textarea class="form-control" name="regime" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Ajouter URL :</label>
                                                <textarea class="form-control" name="url" rows="3"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label>Joindre un fichier :</label>
                                                <input type="file" name="pdf">
                                            </div>


                                            <input type="hidden" name="type" value="educRegle">
                                            <input type="submit" class="btn btn-primary pull-right" value="Confirmer">
                                            <p> </p><br><br><br>
                                        </form>
                                    </div>
                                    <!--element-->

                                    <div class="box-footer ">
                                        @php$education = DB::table('education')
                                                                                            ->select('education.*')
                                                                                    ->get(); @endphp ?>
                                        @if (count($education) > 0)
                                            <table class="table table-bordered text-center element " id="id2">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Si</th>
                                                        <th>Commentaire</th>

                                                        <th>Modifier</th>
                                                        <th>Supprimer</th>
                                                </thead>
                                                <tbody class="regle_footer">
                                                    @foreach ($education as $education)
                                                        <tr>

                                                            <td>{{ $education->si }}</td>
                                                            <td>{{ $education->commentaire }}</td>

                                                            <td><a href="{{ route('education.edit', $education->id) }}"><span
                                                                        class="glyphicon glyphicon-edit"></span></a></td>
                                                            <td>
                                                                <form style='display: none;' method='POST'
                                                                    action="{{ route('education.destroy', $education->id) }}"
                                                                    id='delete-form-{{ $education->id }}'>
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                </form>
                                                                <a href=""
                                                                    onclick="if (confirm('voulez vous supprimer cette ligne ?')) {event.preventDefault(); documalorsent.getElementById('delete-form-{{ $education->id }}').submit();} ">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif

                                    </div>
                                    <!--div footer-->

                                </div>
                                <!--onglet 2--->





                                <div role="tabpanel" class="tab-pane" id="suivi">
                                    <!--Onglet 3-->



                                    <div class="element_suivi" style="">
                                        <form method="POST" action="{{ route('suivi.store') }}"
                                            enctype="multipart/form-data">
                                            {{ csrf_field() }}

                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <p> </p><br>
                                                    <label for="exampleFormControlSelect2_">niveau:</label>
                                                    <select class="form-control" id="niveau" name="niveau">
                                                        <option>1</option>
                                                        <option>2</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4"></div>
                                                <div class="form-group col-sm-4">cc
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="">SMS</label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label><input type="checkbox" value="">EMAIL</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                    ______________________________REGLE
                                                    PATIENT______________________________
                                                    <p> </p><br>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="exampleFormControlSelect2_">Choisissez:</label>
                                                    <select class="form-control" id="critere_" onclick="showAttributt()">
                                                        <option></option>
                                                        <option>Poids(kg)</option>
                                                        <option>Pathologie(s) associée(s)</option>
                                                        <option>Allergie(s) associée(s)</option>
                                                        <option>Examens</option>
                                                        <option>Service</option>
                                                        <option>Durée hospitalisation</option>

                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="divDynamque1_">
                                                </div>
                                                <div class="form-group col-sm-4" id="divDynamque2_">
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="row">
                                                <div class="form-group col-sm-6" id="divDynamque11_">
                                                </div>
                                                <div class="form-group col-sm-6" id="divDynamque22_">
                                                </div>

                                            </div>
                                            <!--row-->


                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                                                ____________________________REGLE MEDICAMENT____________________________
                                                <p> </p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4">
                                                    <label for="exampleFormControlSelect2_">Choisissez:</label>
                                                    <select class="form-control" id="choice_" onclick="showMedic()">
                                                        <option></option>
                                                        <option>Produits Alimentaires</option>
                                                        <option>Médicament</option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-sm-4" id="div1_">
                                                </div>
                                                <div class="form-group col-sm-4" id="div2_">
                                                </div>
                                            </div>
                                            <!--row-->
                                            <div class="row">
                                                <div class="form-group col-sm-6" id="div11_">
                                                </div>
                                                <div class="form-group col-sm-6" id="div22_">
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div
                                                style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                                ________________________________FONCTIONS________________________________
                                                <p></p><br>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-sm-4" id="operation_">
                                                    <label for="exampleFormControlSelect1_">operation</label>
                                                    <select class="form-control" id="operationSelect_"
                                                        onclick="recup('operationSelect_')">
                                                        <option></option>
                                                        <option>+</option>
                                                        <option>-</option>
                                                        <option>/</option>
                                                        <option>=</option>
                                                        <option>!=</option>
                                                        <option>></option>
                                                        <option>
                                                            << /option>
                                                        <option>>=</option>
                                                        <option>
                                                            <=< /option>
                                                    </select>

                                                </div>
                                                <div class="form-group col-sm-4" id="operateur_">
                                                    <label for="exampleFormControlSelect1_">operateur</label>
                                                    <select class="form-control" id="operateurSelect_"
                                                        onclick="recup('operateurSelect_')">
                                                        <option></option>
                                                        <option>ET</option>
                                                        <option>OU</option>
                                                        <option>NON</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-sm-4" id="autre_">
                                                    <label for="exampleFormControlSelect1_">autre:</label>
                                                    <select class="form-control" id="autreSelect_"
                                                        onclick="recup('autreSelect_')">
                                                        <option>,</option>
                                                        <option>.</option>
                                                        <option>{</option>
                                                        <option>}</option>
                                                        <option value="abs">abs</option>
                                                        <option>(</option>
                                                        <option>)</option>
                                                        <option>[</option>
                                                        <option>]</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!--row-->

                                            <div class="form-group" id="textSelection_">
                                                <!--premier si -->
                                                <label for="exampleFormControlTextarea1_">Si:</label>
                                                <textarea class="form-control" id="exampleFormControlTextarea1_" name="si"
                                                    rows="5" onkeypress="interdireEcriture()" require></textarea>
                                            </div>

                                            <div class="form-group">
                                                <label for="exampleFormControlTextarea1_">commentaire :</label>
                                                <textarea class="form-control" name="commentaire"
                                                    id="exampleFormControlTextarea1_" rows="3"></textarea>
                                            </div>
                                            <input type="submit" class="btn btn-primary pull-right" value="Confirmer">
                                            <p> </p><br><br><br>
                                        </form>
                                    </div>
                                    <!--element-->

                                    <div class="box-footer ">

                                        @php$suivi = DB::table('suivis')
                                                                                            ->select('suivis.*')
                                                                                    ->get(); @endphp ?>
                                        @if (count($suivi) > 0)
                                            <table class="table table-bordered text-center element " id="id3">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Si</th>
                                                        <th>Commentaire</th>
                                                        <th>Niveau</th>

                                                        <th>Modifier</th>
                                                        <th>Supprimer</th>
                                                </thead>
                                                <tbody class="regle_footer">
                                                    @foreach ($suivi as $suivi)
                                                        <tr>

                                                            <td>{{ $suivi->si }}</td>
                                                            <td>{{ $suivi->commentaire }}</td>
                                                            <td>{{ $suivi->niveau }}</td>
                                                            <td><a href="{{ route('suivi.edit', $suivi->id) }}"><span
                                                                        class="glyphicon glyphicon-edit"></span></a></td>
                                                            <td>
                                                                <form style='display: none;' method='POST'
                                                                    action="{{ route('suivi.destroy', $suivi->id) }}"
                                                                    id='delete-form-{{ $suivi->id }}'>
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                </form>
                                                                <a href=""
                                                                    onclick="if (confirm('voulez vous supprimer cette ligne ?')) {event.preventDefault(); documalorsent.getElementById('delete-form-{{ $suivi->id }}').submit();} ">
                                                                    <span class="glyphicon glyphicon-trash"></span>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @endif


                                    </div>
                                    <!--div footer-->


                                </div>
                                <!--onglet 3-->



                            </div>
                            <!--tab content--->
                        </div>
                        <!--tab panel-->






































                    </div>
                    <!--box body-->
                </div>
                <!--box info-->
                <!-------------------LES DIV DYNAMYQUE DE DE L'ONGLET 1------------------------------->
                <div class="row">
                    <div class="form-group col-sm-4" id="age">
                        <label for="exampleFormControlSelectAge">Nombre:</label>
                        <select class="form-control" id="ageSelect" onclick="recuperer('ageSelect')">
                            @for ($i = 1; $i < 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group col-sm-4" id="uniteAge">
                        <label for="exampleFormControlSelectAge">Jour/Mois/ans:</label>
                        <select class="form-control" id="uniteAgeSelect" onclick="recuperer('uniteAgeSelect')">
                            <option>Jours</option>
                            <option>Mois</option>
                            <option>ans</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="taille">
                        <label for="exampleFormControlSelect1">Taille:</label>
                        <select class="form-control" id="tailleCmSelect" onclick="recuperer('tailleCmSelect')">
                            @for ($i = 0; $i < 380; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-4" id="poids">
                        <label class="col-sm-2 control-label">Poids:</label>
                        <select class="form-control" id="poidsCmSelect" onclick="recuperer('poidsCmSelect')">
                            @for ($i = 0; $i < 300; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="sexe">
                        <label for="exampleFormControlSelect1">Sexe</label>
                        <select class="form-control" id="sexeSelect" onclick="recuperer('sexeSelect')">
                            <option>Homme</option>
                            <option>Femme</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="modeDeVie">
                        <label for="exampleFormControlSelect1">Mode de vie</label>
                        <select class="form-control" id="modeDeVieSelect" onclick="recuperer('modeDeVieSelect')">
                            <option>Tabac</option>
                            <option>Alcool</option>
                            <option>Drogue</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4" id="pathologie">
                        <label for="exampleFormControlSelect1">Pathologie(s) associée(s)</label>
                        <select class="form-control" name="pathologies[]" id="pathologieSelect"
                            onclick="recuperer('pathologieSelect')">
                            @php
                                $pathologies = DB::select('select * from pathologies');
                            @endphp
                            @foreach ($pathologies as $pathologie)
                                <option value="{{ $pathologie->pathologie }}">{{ $pathologie->pathologie }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="allergie">
                        <label for="exampleFormControlSelect1">Allergie(s) associée(s)</label>
                        <select class="form-control" name="allergies[]" id="allergieSelect"
                            onclick="recuperer('allergieSelect')">
                            @php
                                $allegries = DB::select('select * from allergies');
                            @endphp
                            @foreach ($allegries as $allegrie)
                                <option value="{{ $allegrie->allergie }}">{{ $allegrie->allergie }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="service">
                        <label for="exampleFormControlSelect1">Service</label>
                        <select class="form-control" id="serviceSelect" onclick="recuperer('serviceSelect')">
                            @php
                                $result = DB::table('users')
                                    ->where('service', '<>', '')
                                    ->select('service')
                                    ->distinct()
                                    ->get();
                            @endphp

                            @foreach ($result as $r)
                                <option value="{{ $r->service }}">{{ $r->service }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <!--les types d'analyses sanguines -->

                    <div class="form-group col-sm-6" id="examens">
                        <label for="exampleFormControlSelect1">Examens</label>
                        <select class="form-control" id="annalysesSelect" onclick="recuperer('annalysesSelect')">
                            @php
                                $elements = DB::select('select distinct element,unite from  elements');
                            @endphp
                            @foreach ($elements as $element)

                                <option value="{{ $element->element }} ({{ $element->unite }})">
                                    {{ $element->element }} ({{ $element->unite }})</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6" id="valeur">
                        <label for="exampleFormControlSelect1">Entrez valeur:</label>
                        <br>
                        <input type="number" class="form-control" step="any" id="valeurSelect"
                            onchange="recuperer('valeurSelect')" />
                    </div>

                </div>
                <!--.................... Dynamique medicament ....................-->
                <div class="row">
                    <div class="form-group col-sm-3" id="mmte_p">
                        <label for="exampleFormControlSelect2">Médicament DCI</label>
                        <input type="text" class="form form-control" placeholder="Médicament DCI ou médicament commerciale"
                            name="medicament_dci" autocomplete="off" id="preinscriptionSelect"
                            onclick="recuperer('preinscriptionSelect')">
                    </div>

                    <div class="form-group col-sm-3" id="produitalimentaire">
                        <label for="exampleFormControlSelect2">Produits Alimentaires:</label>
                        <select class="form-control" id="phytoSelect" onclick="recuperer('phytoSelect')">
                            @php
                                $produitalimentaires = DB::select('select produit_naturel_fr from  produitalimentaires');
                            @endphp
                            @foreach ($produitalimentaires as $produit_naturel_fr)

                                <option value="{{ $produit_naturel_fr->produit_naturel_fr }}">
                                    {{ $produit_naturel_fr->produit_naturel_fr }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group col-sm-3" id="valDosage">
                        <label for="exampleFormControlSelect2">Fois/Jour:</label>
                        <select class="form-control" id="foisSelect" onclick="recuperer('foisSelect')">
                            @for ($i = 0; $i < 20; $i++)
                                <option value="{{ $i }}/jours">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group col-sm-3" id="freq">
                        <label for="exampleFormControlSelect2">Fréquence</label>
                        <select class="form-control" id="freqSelect" onclick="showFrequence()">
                            <option>Occasionnellement</option>
                            <option>Exceptionnellement</option>
                            <option>Depuis</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-4" id="etat">
                        <label for="exampleFormControlSelect2">état de la patiente</label>
                        <select class="form-control" id="etatSelect" onclick="recuperer('etatSelect')">
                            <option>grossesse</option>
                            <option>Allaitement</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-4" id="observance">
                        <label for="exampleFormControlSelect2">Observance</label>
                        <select class="form-control" id="obsSelect" onclick="recuperer('obsSelect')">
                            <option>non</option>
                            <option>oui</option>
                            <option>moyen</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-4" id="travail">
                        <label for="exampleFormControlSelectAge">Activité professionnel</label>
                        <select class="form-control" id="travailSelect" onclick="recuperer('travailSelect')">
                            @php
                                $travails = DB::select('select nom from  travails');
                            @endphp
                            @foreach ($travails as $travail)
                                <option value="{{ $travail->nom }}">{{ $travail->nom }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-4" id="ligne">
                        <label for="exampleFormControlSelect2">Nombre de ligne</label>
                        <select class="form-control" id="ligneSelect" onclick="recuperer('ligneSelect')">
                            @for ($i = 1; $i < 30; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>








                <!---DIV DYNAMIQUE ONGLET 3--->
                <div class="row">
                    <div class="form-group col-sm-4" id="age_">
                        <label for="exampleFormControlSelectAge_">Nombre:</label>
                        <select class="form-control" id="ageSelect_" onclick="recup('ageSelect_')">
                            @for ($i = 1; $i < 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="uniteAge_">
                        <label for="exampleFormControlSelectAge_">Jour/Mois/ans:</label>
                        <select class="form-control" id="uniteAgeSelect_" onclick="recup('uniteAgeSelect_')">
                            <option>Jours</option>
                            <option>Mois</option>
                            <option>ans</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="poids_">
                        <label class="col-sm-2 control-label">Poids:</label>
                        <select class="form-control" id="poidsCmSelect_" onclick="recup('poidsCmSelect_')">
                            @for ($i = 0; $i < 300; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>


                <div class="row">
                    <div class="form-group col-sm-4" id="pathologie_">
                        <label for="exampleFormControlSelect1_">Pathologie(s) associée(s)</label>
                        <select class="form-control" name="pathologies[]" id="pathologieSelect_"
                            onclick="recup('pathologieSelect_')">
                            @php
                                $pathologies = DB::select('select * from pathologies');
                            @endphp
                            @foreach ($pathologies as $pathologie)
                                <option value="{{ $pathologie->pathologie }}">{{ $pathologie->pathologie }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="allergie_">
                        <label for="exampleFormControlSelect1_">Allergie(s) associée(s)</label>
                        <select class="form-control" name="allergies[]" id="allergieSelect_"
                            onclick="recup('allergieSelect')">
                            @php
                                $allegries = DB::select('select * from allergies');
                            @endphp
                            @foreach ($allegries as $allegrie)
                                <option value="{{ $allegrie->allergie }}">{{ $allegrie->allergie }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="service_">
                        <label for="exampleFormControlSelect1_">Service</label>
                        <select class="form-control" id="serviceSelect_" onclick="recup('serviceSelect_')">
                            @php
                                $result = DB::table('users')
                                    ->where('service', '<>', '')
                                    ->select('service')
                                    ->distinct()
                                    ->get();
                            @endphp

                            @foreach ($result as $r)
                                <option value="{{ $r->service }}">{{ $r->service }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-sm-6" id="examens_">
                        <label for="exampleFormControlSelectntrolSelect1_">Examens</label>
                        <select class="form-control" id="annalysesSelect_" onclick="recup('annalysesSelect_')">
                            @php
                                $elements = DB::select('select distinct element,unite from  elements');
                            @endphp
                            @foreach ($elements as $element)

                                <option value="{{ $element->element }} ({{ $element->unite }})">
                                    {{ $element->element }} ({{ $element->unite }})</option>

                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6" id="valeur_">
                        <label for="exampleFormControlSelect1_">Entrez valeur:</label>
                        <br>
                        <input type="number" class="form-control" step="any" id="valeurSelect_"
                            onchange="recup('valeurSelect_')" />
                    </div>

                </div>
                <!--.................... Dynamique medicament ....................-->
                <div class="row">
                    <div class="form-group col-sm-3" id="mmte_p_">
                        <label for="exampleFormControlSelect2_">Médicament DCI</label>
                        <input type="text" class="form form-control" placeholder="Médicament DCI ou médicament commerciale"
                            name="medicament_dci" autocomplete="off" id="preinscriptionSelect_"
                            onclick="recup('preinscriptionSelect_')">
                    </div>



                    <div class="form-group col-sm-3" id="valDosage_">
                        <label for="exampleFormControlSelect2_">Fois/Jour:</label>
                        <select class="form-control" id="foisSelect_" onclick="recup('foisSelect_')">
                            @for ($i = 0; $i < 20; $i++)
                                <option value="{{ $i }}/jours">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="form-group col-sm-3" id="freq_">
                        <label for="exampleFormControlSelect2_">Fréquence</label>
                        <select class="form-control" id="freqSelect_" onclick="showFreq()">
                            <option>Occasionnellement</option>
                            <option>Exceptionnellement</option>
                            <option>Depuis</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3" id="produitalimentaire_">
                        <label for="exampleFormControlSelect2_">Produits Alimentaires</label>
                        <select class="form-control" id="phytoSelect_" onclick="recup('phytoSelect_')">
                            @php
                                $produitalimentaires = DB::select('select produit_naturel_fr from  produitalimentaires');
                            @endphp
                            @foreach ($produitalimentaires as $produit_naturel_fr)

                                <option value="{{ $produit_naturel_fr->produit_naturel_fr }}">
                                    {{ $produit_naturel_fr->produit_naturel_fr }}</option>
                            @endforeach

                        </select>
                    </div>
                </div>







            </div>
            <!--div offset--->

        </div><!-- div row--->

    </div>
    <!--div wrapper-->
@endsection

@section('script')
    <script src="{{ asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js') }}"></script>
    <script src="{{ asset('plugins/jquery/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/gestion_regle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/gestion_reglee.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/regle/showDiv1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/regle/showDiv2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery/js/jquery-ui.min.js') }}"></script>

    <script>
        $('#tablist a').click(function(e) {
            e.preventDefault()
            $(this).tab('show')
        })

    </script>

    <script type="text/javascript">
        $('body').find('span > i').remove('i:last');
        $('#id1').dataTable();
        $('#id2').dataTable();
        $('#id3').dataTable();

    </script>

@endsection
