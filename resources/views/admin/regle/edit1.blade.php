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

                        <h3 class="box-title">Modifier la règle</h3>

                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <!--pour choisir entre regle medic ou patient-->

                    <div class="box-body">

                        <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
                            <p> </p><br>
                            ______________________________REGLE PATIENT______________________________
                            <p> </p><br>
                        </div>

                        <div class="element" style="">
                            <form method="POST" action="{{ route('reglee.update', $reglee->id) }}"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}
                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <label for="exampleFormControlSelect2">Choisissez:</label>
                                        <select class="form-control" id="critere" onclick="showAttribut()">
                                            <option></option>
                                            <option>Age(ans)</option>
                                            <option>Taille(cm)</option>
                                            <option>Poids(kg)</option>
                                            <option>Sexe</option>
                                            <option>Mode de vie</option>
                                            <option>Pathologie(s) associée(s)</option>
                                            <option>Allergie(s) associée(s)</option>
                                            <option>Examens</option>
                                            <option>Service</option>
                                            <option>Durée hospitalisation(jours)</option>
                                            <option>état de la patiente</option>
                                            <!--<option>Observance</option>-->
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


                                <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
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

                                <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                    ________________________________FONCTIONS________________________________
                                    <p></p><br>
                                </div>
                                <div class="row">
                                    <div class="form-group col-sm-4" id="operation">
                                        <label for="exampleFormControlSelect1">operation</label>
                                        <select class="form-control" id="operationSelect"
                                            onclick="recupModif1('operationSelect')">
                                            <option></option>
                                            <option>+</option>
                                            <option>-</option>
                                            <option>/</option>
                                            <option>=</option>
                                            <option>!=</option>
                                            <option>></option>
                                            <option>
                                                << /option>
                                            <option>>=
                                            </option>
                                            <option>
                                                <=< /option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="operateur">
                                        <label for="exampleFormControlSelect1">operateur</label>
                                        <select class="form-control" id="operateurSelect"
                                            onclick="recupModif1('operateurSelect')">
                                            <option></option>
                                            <option>ET</option>
                                            <option>OU</option>
                                            <!--<option>NON</option>-->
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="autre">
                                        <label for="exampleFormControlSelect1">autre:</label>
                                        <select class="form-control" id="autreSelect" onclick="recupModif1('autreSelect')">
                                            <option>;</option>
                                            <option>/</option>
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
                                    <!--ancien si -->
                                    <label for="exampleFormControlTextarea_">Ancien Si:</label>

                                    @php
                                    $r = DB::select('select * from reglees where id = ?',[$reglee]);
                                    @endphp

                                    <textarea class="form-control" rows="5" onkeypress="interdireEcriture()"
                                        require>{{ $reglee->si }}</textarea>



                                </div>

                                <div class="form-group" id="textSelection">
                                    <label for="exampleFormControlTextarea1">Taper le nouveau si:</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" name="si" rows="5"
                                        onkeypress="interdireEcriture()" require></textarea>
                                </div>
                                <div class="form-group" id="resultat">
                                    <label for="exampleFormControlSelectAge">nouveau alors:</label>
                                    <select class="form-control" id="resultatSelect" name="alors">
                                        <option>prescription à risque</option>
                                        <option>patient à risque</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">commentaire :</label>
                                    @php
                                    $r = DB::select('select * from reglees where id = ?',[$reglee]);
                                    @endphp
                                    <textarea class="form-control" name="commentaire" id="exampleFormControlTextarea1"
                                        rows="3">{{ $reglee->commentaire }}</textarea>
                                </div>
                                <input type="hidden" name="type" value="patient">
                                <input type="submit" class="btn btn-primary pull-right" value="Confirmer">
                                <p> </p><br><br><br>
                            </form>
                        </div>
                        <!--element-->


                    </div>
                    <!--body-->
                </div>
                <!--boxinfo-->

                <div class="row">
                    <div class="form-group col-sm-4" id="age">
                        <label for="exampleFormControlSelectAge">Nombre:</label>
                        <select class="form-control" id="ageSelect" onclick="recupModif1('ageSelect')">
                            @for ($i = 1; $i < 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <!--div class="form-group col-sm-4" id="uniteAge">
                                                <label for="exampleFormControlSelectAge">Jour/Mois/ans:</label>
                                                <select class="form-control" id="uniteAgeSelect" onclick="recupModif1('uniteAgeSelect')">
                                                    <option>Jours</option>
                                                    <option>Mois</option>
                                                    <option>ans</option>
                                                </select>
                                            </div-->
                    <div class="form-group col-sm-4" id="taille">
                        <label for="exampleFormControlSelect1">Taille:</label>
                        <select class="form-control" id="tailleCmSelect" onclick="recupModif1('tailleCmSelect')">
                            @for ($i = 0; $i < 380; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-sm-4" id="poids">
                        <label class="col-sm-2 control-label">Poids:</label>
                        <select class="form-control" id="poidsCmSelect" onclick="recupModif1('poidsCmSelect')">
                            @for ($i = 0; $i < 300; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="sexe">
                        <label for="exampleFormControlSelect1">Sexe</label>
                        <select class="form-control" id="sexeSelect" onclick="recupModif1('sexeSelect')">
                            <option>Homme</option>
                            <option>Femme</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="modeDeVie">
                        <label for="exampleFormControlSelect1">Mode de vie</label>
                        <select class="form-control" id="modeDeVieSelect" onclick="recupModif1('modeDeVieSelect')">
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
                            onclick="recupModif1('pathologieSelect')">
                            @php
                            $pathologies = DB::select("select * from pathologies");
                            @endphp
                            @foreach ($pathologies as $pathologie)
                                <option value="{{ $pathologie->pathologie }}">{{ $pathologie->pathologie }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="allergie">
                        <label for="exampleFormControlSelect1">Allergie(s) associée(s)</label>
                        <select class="form-control" name="allergies[]" id="allergieSelect"
                            onclick="recupModif1('allergieSelect')">
                            @php
                            $allegries = DB::select("select * from allergies");
                            @endphp
                            @foreach ($allegries as $allegrie)
                                <option value="{{ $allegrie->allergie }}">{{ $allegrie->allergie }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-4" id="service">
                        <label for="exampleFormControlSelect1">Service</label>
                        <select class="form-control" id="serviceSelect" onclick="recupModif1('serviceSelect')">
                            @php
                            $result = DB::table('users')->where('service','<>','')->select('service')->distinct()->get();
                                @endphp

                                @foreach ($result as $r)
                                    <option value="{{ $r->service }}">{{ $r->service }}</option>
                                @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">

                    <div class="form-group col-sm-6" id="examens">
                        <label for="exampleFormControlSelect1">Examens</label>
                        <select class="form-control" id="annalysesSelect" onclick="recupModif1('annalysesSelect')">
                            @php
                            $elements = DB::table('elements')->get();
                            @endphp
                            @foreach ($elements as $element)
                                @if ($element->element == 'Poids' || $element->element == 'poids' || $element->element == 'POIDS')
                                    <option value="Poids(Kg)">{{ $element->element }} ({{ $element->unite }})</option>
                                @else
                                    <option value="{{ $element->element }} ({{ $element->unite }})">{{ $element->element }}
                                        ({{ $element->unite }})</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-sm-6" id="valeur">
                        <label for="exampleFormControlSelect1">Entrez valeur:</label>
                        <br>
                        <input type="number" class="form-control" step="any" id="valeurSelect"
                            onchange="recupModif1('valeurSelect')" />
                    </div>

                </div>
                <!--.................... Dynamique medicament ....................-->
                <div class="row">
                    <div class="form-group col-sm-3" id="mmte_p">
                        <label for="exampleFormControlSelect2">Médicament DCI</label>
                        <input type="text" class="form form-control" placeholder="Médicament DCI ou médicament commerciale"
                            name="medicament_dci" autocomplete="off" id="preinscriptionSelect"
                            onclick="recupModif1('preinscriptionSelect')">
                    </div>

                    <div class="form-group col-sm-3" id="produitalimentaire">
                        <label for="exampleFormControlSelect2">Produits Alimentaires:</label>
                        <select class="form-control" id="phytoSelect" onclick="recupModif1('phytoSelect')">
                            @php
                            $produitalimentaires = DB::select("select produit_naturel_fr from produitalimentaires");
                            @endphp
                            @foreach ($produitalimentaires as $produit_naturel_fr)

                                <option value="{{ $produit_naturel_fr->produit_naturel_fr }}">
                                    {{ $produit_naturel_fr->produit_naturel_fr }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="form-group col-sm-3" id="valDosage">
                        <label for="exampleFormControlSelect2">Fois/Jour:</label>
                        <select class="form-control" id="foisSelect" onclick="recupModif1('foisSelect')">
                            @for ($i = 0; $i < 20; $i++)
                                <option value="[{{ $i }} ParJour]">{{ $i }}</option>
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
                        <select class="form-control" id="etatSelect" onclick="recupModif1('etatSelect')">
                            <option>normale</option>
                            <option>grossesse</option>
                            <option>Allaitement</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-4" id="observance">
                        <label for="exampleFormControlSelect2">Observance</label>
                        <select class="form-control" id="obsSelect" onclick="recupModif1('obsSelect')">
                            <option>non</option>
                            <option>oui</option>
                            <option>moyen</option>
                        </select>
                    </div>

                    <div class="form-group col-sm-4" id="travail">
                        <label for="exampleFormControlSelectAge">Activité professionnel</label>
                        <select class="form-control" id="travailSelect" onclick="recupModif1('travailSelect')">
                            @php
                            $travails = DB::select("select nom from travails");
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
                        <select class="form-control" id="ligneSelect" onclick="recupModif1('ligneSelect')">
                            @for ($i = 1; $i < 30; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>


            </div>
            <!--offset-->
        </div>
        <!--row-->
    </div>
    <!--content-->

@endsection

@section('script')
    <script src="{{ asset('/plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/admin/gestion_regle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/admin/gestion_reglee.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/admin/regle/showDiv1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/js/admin/regle/showDiv2.js') }}"></script>

    <script>
        function Show1(addr) {
            document.getElementById(addr).style.visibility = "visible";
        }

        window.onload = function clearPage() {
            Hide("age");
            Hide("sexe");
            Hide("modeDeVie");
            Hide("pathologie");
            Hide("allergie");
            Hide("taille");
            Hide("poids"); //Hide("uniteAge");
            Hide("service");
            Hide("examens");
            Hide("valeur");
            Hide("mmte_p");
            Hide("valDosage");
            Hide("freq");
            Hide("produitalimentaire");
            Hide("observance");
            Hide("etat");
            Hide("travail");
            Hide("ligne");



        };

    </script>


@endsection
