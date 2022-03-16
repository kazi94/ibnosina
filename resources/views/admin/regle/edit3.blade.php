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

                        <div class="element_suivi" style="">
                            <form method="POST" action="{{ route('suivi.update', $suivi->id) }}"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}

                                <div class="row">
                                    <div class="form-group col-sm-4">
                                        <p> </p><br>
                                        @php
                                            $r = DB::select('select * from suivis where id = ?', [$suivi]);
                                        @endphp
                                        <label for="exampleFormControlSelect2_">niveau:</label>
                                        <select class="form-control" id="niveau" name="niveau" value="{{ $suivi->niveau }}">

                                            <option>1</option>
                                            <option>2</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

                                        ______________________________REGLE PATIENT______________________________
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
                                            <option>Durée hospitalisation(jours)</option>

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


                                <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">
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

                                <div style="text-align:center; font-size:1.25em; font-style: italic; color:#2874A6">

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
                                            <option>>=
                                            </option>
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
                                            <!--<option>NON</option>-->
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" id="autre_">
                                        <label for="exampleFormControlSelect1_">autre:</label>
                                        <select class="form-control" id="autreSelect_" onclick="recup('autreSelect_')">
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
                                            <option>à la hausse</option>
                                            <option>à la baisse</option>
                                        </select>
                                    </div>
                                </div>
                                <!--row-->
                                <div class="form-group" id="textSelection">
                                    <!--ancien si -->
                                    <label for="exampleFormControlTextarea_">Ancien Si:</label>

                                    @php
                                        $r = DB::select('select * from suivis where id = ?', [$suivi]);
                                    @endphp

                                    <textarea class="form-control" rows="5" onkeypress="interdireEcriture()"
                                        require>{{ $suivi->si }}</textarea>



                                </div>

                                <div class="form-group" id="textSelection_">
                                    <!--premier si -->
                                    <label for="exampleFormControlTextarea1_">Si:</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1_" name="si" rows="5"
                                        onkeypress="interdireEcriture()" require></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1_">commentaire :</label>
                                    <textarea class="form-control" name="commentaire" id="exampleFormControlTextarea1_"
                                        rows="3">{{ $suivi->commentaire }}</textarea>
                                </div>
                                <input type="submit" class="btn btn-primary pull-right" value="Confirmer">
                                <p> </p><br><br><br>
                            </form>
                        </div>
                        <!--element-->
                    </div>
                    <!--body-->






                </div>
                <!--box info-->

                <div class="row">
                    <div class="form-group col-sm-4" id="age_">
                        <label for="exampleFormControlSelectAge_">Nombre:</label>
                        <select class="form-control" id="ageSelect_" onclick="recup('ageSelect_')">
                            @for ($i = 1; $i < 100; $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <!--div class="form-group col-sm-4" id="uniteAge_">
                                            <label for="exampleFormControlSelectAge_">Jour/Mois/ans:</label>
                                            <select class="form-control" id="uniteAgeSelect_" onclick="recup('uniteAgeSelect_')">
                                                <option>Jours</option>
                                                <option>Mois</option>
                                                <option>ans</option>
                                            </select>
                                        </div-->
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
                                $elements = DB::table('elements')->get();
                            @endphp
                            @foreach ($elements as $element)
                                @if ($element->element == 'Poids' || $element->element == 'poids' || $element->element == 'POIDS')
                                    <option value="Poids(Kg)">{{ $element->element }} ({{ $element->unite }})</option>
                                @else
                                    <option value="{{ $element->element }} ({{ $element->unite }})">
                                        {{ $element->element }} ({{ $element->unite }})</option>
                                @endif
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
                                <option value="[{{ $i }} ParJour]">{{ $i }}</option>
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
                                $produitalimentaires = DB::select('select produit_naturel_fr from produitalimentaires');
                            @endphp
                            @foreach ($produitalimentaires as $produit_naturel_fr)

                                <option value="{{ $produit_naturel_fr->produit_naturel_fr }}">
                                    {{ $produit_naturel_fr->produit_naturel_fr }}</option>
                            @endforeach

                        </select>
                    </div>
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
    <script src="{{ asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js') }}"></script>
    <script src="{{ asset('plugins/jquery/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/gestion_regle.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/gestion_reglee.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/regle/showDiv1.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/admin/regle/showDiv2.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('plugins/jquery/js/jquery-ui.min.js') }}"></script>

    <script>
        function Show1(addr) {
            document.getElementById(addr).style.visibility = "visible";
        }

        window.onload = function clearPage() {
            Hide("age_"); //Hide("uniteAge_");
            Hide("pathologie_");
            Hide("allergie_");
            Hide("poids_");
            Hide("service_");
            Hide("examens_");
            Hide("valeur_");
            Hide("mmte_p_");
            Hide("valDosage_");
            Hide("freq_");
            Hide("produitalimentaire_");





        };

    </script>

@endsection
