<!-- Modal modifier Profile-->
<div class="modal" id="modal_modifier">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h3 class="modal-title"><b>Modifier Profile </b></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-7">
                        <!-- general form elements -->
                        <div class="box box-info" style="background: #5bc9f387;box-shadow: 3px 4px 7px 1px #cecece;">
                            <div class="box-header with-border">
                                <h3 class="box-title">Informations socio /profesionnelles
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <!-- form start -->
                            <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                                action="{{ route('patient.update', $patient->id) }}">
                                {{ csrf_field() }} {{ method_field('PATCH') }}
                                <input type="text" name="created_by" hidden value="{{ Auth::user()->id }}">
                                <div class="box-body" style=" background-color: #e4e4e429">

                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label for="name" class="col-sm-6 control-label">Num Sécurité
                                                    sociale</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="num_securite_sociale"
                                                        placeholder="Num sécurité sociale" name="num_securite_sociale">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-6 control-label">Code nationale</label>
                                                <div class="col-sm-6">
                                                    <input type="text" class="form-control" id="code_nationale"
                                                        placeholder="Code nationale" name="code_national">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="name" class="col-sm-6 control-label">Ajouter Photo De
                                                    Profil</label>
                                                <div class="col-sm-6">
                                                    <!-- <button type="button" id="takePic" class="btn btn-primary " data-toggle="modal" data-target="#modal_webcam"><i class="fa fa-camera"></i></button> -->
                                                    <input type="file" name="photo" id="photo">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- <div class="col-sm-4 widget-user-image">
          <label ><img class="img-circle" id="photo" src="" style="max-height: 150px; max-width: 150px;"></label>
         </div> -->
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Nom*</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="nom" placeholder="Nom"
                                                name="nom" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 control-label">Prénom*</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" id="prenom" placeholder="Prénom"
                                                name="prenom" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="date" class="col-sm-2 control-label float-left contents"
                                            style="text-align: left;">Date de Naissance*</label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control" id="date_naissance1" placeholder=""
                                                name="date_naissance" required>
                                        </div>
                                        <label class="col-sm-1 control-label">Sexe*</label>
                                        <div class="col-sm-2">
                                            <select class="form-control" name="sexe" id="sexe">
                                                <option @if ($patient->sexe == 'M') selected @endif value="M">M</option>
                                                <option @if ($patient->sexe == 'F') selected @endif value="F">F</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div id="etat" @if ($patient->sexe == 'M') style="display:none" @endif>
                                            <label class="col-sm-1 control-label">Etat</label>
                                            <div class="col-sm-3">
                                                <select class="form-control" name="etat">
                                                    <option></option>
                                                    <option @if ($patient->etat == 'alaitement') selected @endif value="alaitement">
                                                        Alaitement</option>
                                                    <option @if ($patient->etat == 'grossesse') selected @endif value="grossesse">
                                                        Grossesse</option>
                                                    <option @if ($patient->etat == 'normal') selected @endif value="normal">Normal
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="grossesse" @if ($patient->sexe == 'M' && $patient->etat != 'grossesse') style="display:none" @endif>
                                            <label for="" class="col-sm-2 control-label">Mois</label>
                                            <div class="col-sm-5">
                                                <select class="form-control" name="grossesse_id">
                                                    @foreach ($grossesses as $grossesse)
                                                        <option value="{{ $grossesse->cdf_code_pk }}"
                                                            {{ $patient->grossesse_id == $grossesse->cdf_code_pk ? 'selected' : '' }}>
                                                            {{ $grossesse->cdf_nom }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <label class="col-sm-3 control-label">Début règles</label>

                                            <div class="col-sm-4">

                                                <input type="date" name="debut_regles" class="form-control"
                                                    value="{{ $patient->debut_regles }}">

                                            </div>
                                            <label class="col-sm-2 control-label">Durée cycle</label>

                                            <div class="col-sm-3">

                                                <input type="number" name="duree_cycle" class="form-control"
                                                    value="{{ $patient->duree_cycle }}">

                                            </div>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Adresse</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="adresse" placeholder="Adresse"
                                                name="adresse">
                                        </div>

                                        <div class="col-sm-3">
                                            <select name="ville" id="villeId" class="form-control">
                                                @foreach ($wilayas as $wilaya)
                                                    <option value="{{ $wilaya->id }}"
                                                        {{ isset($patient->villes) && $wilaya->id == $patient->villes->id ? 'selected' : ($wilaya->id == '13' ? 'selected' : '') }}>
                                                        {{ $wilaya->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-3">
                                            {{-- <input type="text" class="form-control"
                                                id="communeId" placeholder="Commune" name="commune"
                                                value="{{ isset($patient->commune) ? $patient->commune : '' }}"> --}}
                                            <select name="commune" id="communeId" class="form-control">
                                                @foreach ($dairasPatient as $daira)
                                                    <option value="{{ $daira->id }}"
                                                        {{ isset($patient->communes) && $daira->id == $patient->communes->id ? 'selected' : '' }}>
                                                        {{ $daira->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Taille(cm)</label>
                                        <div class="col-sm-3">
                                            <input type="number" class="form-control" id="taille" placeholder="taille"
                                                name="taille">
                                        </div>
                                        <label class="col-sm-2 control-label">Poids (kg)</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="poids" placeholder="poids"
                                                name="poids">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Situation familiale</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="situation_familliale"
                                                id="situation_familliale">

                                                <option value="Marié(e)">Marié(e)</option>
                                                <option value="Célibataire" selected>Célibataire</option>
                                                <option value="Divorcé">Divorcé</option>

                                            </select>
                                        </div>
                                        <div class="col-sm-4" id="nbre_enfants" hidden>
                                            <input type="number" class="form-control" placeholder="nombre d'enfants"
                                                id="nbre" name="nbre_enfants" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Travaile</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="travaille" id="travaille">

                                                <option value="Retraité">Retraité</option>
                                                <option value="Universitaire">Universitaire</option>
                                                <option value="autre">autre :</option>

                                            </select>
                                        </div>
                                        <div class="col-sm-4" id="autre" hidden>
                                            <input type="text" class="form-control" placeholder="travaile"
                                                id="travaille1" name="travaille1"
                                                value="{{ $patient->travaille1 }}" />
                                        </div>
                                    </div>
                                    <label class="control-label">MODE DE VIE :</label>
                                    <div class="form-group">
                                        <div class="row">
                                            <label class="col-sm-3 control-label">Tabac :</label>

                                            <div class="col-sm-1">
                                                <div class="checkbox">
                                                    <label><input type="checkbox" name="tabagiste" id="tabac"
                                                            class="">Oui </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="tabac" style="display:none">

                                                <label class=" col-sm-2 control-label"> Depuis:</label>

                                                <div class="col-sm-2">
                                                    <input type="number" class="form-control" placeholder=""
                                                        name="tabagiste_depuis" value="" id="tabac1">
                                                </div>
                                                <div class="col-sm-1 pt-2">Mois</div>


                                                <label class="col-sm-3 control-label flo"> Cigarettes/j:</label>
                                                <div class=" col-sm-3">
                                                    <input type="number" class="form-control" placeholder=""
                                                        name="cigarettes" id="cigarettes">

                                                </div>
                                                <label class=" col-sm-3 control-label"> Arréter Depuis:</label>
                                                <div class=" col-sm-3">
                                                    <input type="date" class="form-control" placeholder=""
                                                        name="tabagiste_arreter_depuis" id="tabac_stop">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Alcool :</label>
                                        <div class="col-sm-1">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="alcoolique" id="alcool" class="">Oui
                                                </label>
                                            </div>
                                        </div>
                                        <label class="alcool col-sm-2 control-label" hidden> Depuis:</label>
                                        <div class="alcool col-sm-4" hidden>
                                            <input type="date" class="form-control" placeholder="" id="alcool1"
                                                name="alcoolique_depuis" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Drogue :</label>
                                        <div class="col-sm-1">
                                            <div class="checkbox">
                                                <label><input type="checkbox" name="drogue" id="drogue" class="">Oui
                                                </label>
                                            </div>
                                        </div>
                                        <label class="drogue col-sm-2 control-label" hidden> Depuis:</label>
                                        <div class="drogue col-sm-4" hidden>
                                            <input type="date" class="form-control" placeholder="" id="drogue1"
                                                name="drogue_depuis" />
                                        </div>
                                    </div>
                                    <div class="drogue col-sm-12" hidden><input type="text" name="details" id="type_dr"
                                            class="form-control" placeholder="Type de drogues"></div>
                                    <div class="form-group col-sm-7">

                                        <label class="control-label">Cordonnées :</label>
                                        <div class="input-group col-sm-7">
                                            <div class="input-group-addon alert-success">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" class="form-control" name="num_tel_1" required
                                                data-inputmask="" data-mask="" id="num_tel_1">
                                        </div><br />
                                        <div class="input-group col-sm-7">
                                            <div class="input-group-addon alert-success">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="text" class="form-control" name="num_tel_2" data-inputmask=""
                                                data-mask="" id="num_tel_2">
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-5" id="p_tierce_div" hidden>
                                        <label class="control-label">Tierce personne :</label>
                                        <input type="text" class="form-control" id="p_tierce"
                                            placeholder="personne à contacter" name="p_tierce">
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <!-- general form elements -->
                        <div class="box box-info" style="background: #5bc9f387; box-shadow: 3px 4px 7px 1px #cecece;">
                            <!-- /.box-header -->
                            <!-- form start -->
                            <div class="form-horizontal" style="background-color: #e4e4e429">
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="name" class="col-sm-3 control-label">N° Dossier:</label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" id="num_dossier" placeholder=""
                                                name="num_dossier">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label">Pathologie(s) associée(s) :</label>
                                        <div class="col-sm-6">

                                            <select class="form-control pathologies" multiple="multiple"
                                                style="width: 100%;" name="pathologies[]">

                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-5 control-label">Antécedent(s) Familiaux:</label>
                                        <div class="col-sm-6">

                                            <select class="form-control ants_fam" multiple="multiple"
                                                style="width: 100%;" name="famille_antecedants[]">

                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-5 control-label">Antécedant(s) Chirugicaux :</label>
                                        <div class="col-sm-6 col-xs-10">

                                            <select class="form-control select2 select2-hidden-accessible" id="acts"
                                                multiple="" data-placeholder="Antécedant(s) Chirugicaux"
                                                style="width: 100%;" tabindex="-1" aria-hidden="true"
                                                name="operations[]">
                                                @php
                                                    $operations = DB::select('select * from operation_chirugicales');
                                                @endphp
                                                @foreach ($operations as $operation)
                                                    <option value="{{ $operation->id }}" @foreach ($patient->operations as $operationPatient)  @if ($operation->id==$operationPatient->id)
                                                        selected @endif
                                                @endforeach

                                                >{{ $operation->nom }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                        <div class="col-sm-1 no-padding">
                                            <button type="button" class="btn btn-sm btn-primary mt-1"
                                                data-toggle="modal" data-target="#modal-add-act">+</button>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-5 control-label">Allergie(s) associée(s):</label>
                                        <div class="col-sm-6">

                                            <select class="form-control allergies" multiple="multiple"
                                                style="width: 100%;" name="allergies[]">

                                            </select>

                                        </div>
                                    </div>


                                    <div class="form-group">

                                        <label class="col-sm-4 control-label">Co-sanguinité :</label>

                                        <div class="col-sm-8">
                                            <select class="form-control" name="cosanguinite">
                                                <option value="1"
                                                    {{ $patient->cosanguinite == 1 ? 'selected' : '' }}>
                                                    1er dégré</option>
                                                <option value="2"
                                                    {{ $patient->cosanguinite == 2 ? 'selected' : '' }}>
                                                    2ème degré</option>
                                            </select>
                                        </div>

                                    </div>
                                    {{-- <div class="form-group">

                                        <label class="col-sm-5 control-label">Médecin traitant :</label>

                                        <div class="col-sm-4">
                                            <select class="form-control" name="owned_by" id="owned_by">

                                                @php
                                                $result = DB::table('users')->where('service', Auth::user()->service
                                                )->get();
                                                @endphp

                                                @foreach ($result as $s)
                                                    <option value="{{ $s->id }}">{{ $s->name }} {{ $s->prenom }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>

                                    </div> --}}


                                    <div class="form-group">

                                        <label class="col-sm-5 control-label">Group Sanguin :</label>

                                        <div class="col-sm-4">
                                            <select class="form-control" name="groupe_sanguin">
                                                <option value=""></option>
                                                <option value="O RH+" <?php if ($patient->groupe_sanguin
                                                    == 'O RH+') {
                                                    echo 'selected';
                                                    } ?>>O RH+</option>
                                                <option value="O RH-" <?php if ($patient->groupe_sanguin
                                                    == 'O RH-') {
                                                    echo 'selected';
                                                    } ?>>O RH-</option>
                                                <option value="AB RH+" <?php if ($patient->groupe_sanguin
                                                    == 'AB RH+') {
                                                    echo 'selected';
                                                    } ?>>AB RH+</option>
                                                <option value="AB RH-" <?php if ($patient->groupe_sanguin
                                                    == 'AB RH-') {
                                                    echo 'selected';
                                                    } ?>>AB RH-</option>
                                                <option value="A RH+" <?php if ($patient->groupe_sanguin
                                                    == 'A RH+') {
                                                    echo 'selected';
                                                    } ?>>A RH+</option>
                                                <option value="A RH-" <?php if ($patient->groupe_sanguin
                                                    == 'A RH-') {
                                                    echo 'selected';
                                                    } ?>>A RH-</option>
                                                <option value="B RH+" <?php if ($patient->groupe_sanguin
                                                    == 'B RH+') {
                                                    echo 'selected';
                                                    } ?>>B RH+</option>
                                                <option value="B RH+" <?php if ($patient->groupe_sanguin
                                                    == 'B RH-') {
                                                    echo 'selected';
                                                    } ?>>B RH-</option>
                                            </select>
                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="reset" class="btn btn-default btn-lg" data-dismiss="modal" value="fermer">
                    <input type="submit" class="btn btn-primary btn-lg pull-right" value="Modifier">
                    </form>
                </div>
                <!-- /.content -->
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modal-detail-profil">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="bg-blue modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h3 class="modal-title"><b>Profile patient</b></h3>
            </div>
            <div class="modal-body">
                <!-- Widget: user widget style 1 -->
                <div class="box box-widget widget-user">

                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class=" widget-user-header" style="background: #3c8dbc; padding-left:5px">
                        <h3 class="widget-user-username">{{ $patient->nom }} {{ $patient->prenom }}</h3>
                        @if ($patient->hospi)
                            <p class="">
                                <strong>Chambre n°: {{ $patient->hospi->chambre }} Lit n°:
                                    {{ $patient->hospi->lit }}</strong>
                            </p>
                            <h4 class="text-uppercase">
                                <span class="label label-success">{{ $patient->hospi->service }}</span>
                            </h4>
                        @else <span class="label label-danger">Hors CHU</span>
                        @endif
                    </div>
                    <div class="widget-user-image ">
                        <a href="{{ asset('images/avatar/' . $patient->photo . '') }}" target="_blank"
                            style="position: absolute; top: 65px; right: 8px;">
                            <i class="bg-blue-gradient fa fa-arrows-alt img-thumbnail"></i>
                        </a>
                        <img class="img-circle" src="{{ asset('images/avatar/' . $patient->photo . '') }}" alt="User Avatar" />
                    </div>
                </div>
                <!-- /.widget-user -->
                <div class="box box-primary" style="margin-top: -10px;">
                    <div class="box-header with-border">
                        <h3 class="box-title">A propos du Patient</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if ($patient->date_naissance != '')
                            <p><strong>Age : </strong>
                                {{ $patient->age }}
                                ans
                            </p>
                        @endif

                        @if (isset($patient->poids))

                            <p><strong>Poids : </strong>
                                {{ $patient->poids }} kg
                            </p>
                        @endif
                        @if ($patient->taille != '')
                            <p><strong>Taille : </strong> {{ $patient->taille }} cm </p>
                        @endif
                        @if ($patient->travaille != '')
                            <p><strong>Travaille: </strong>
                                {{ $patient->travaille == 'autre' ? $patient->travaille1 : $patient->travaille }}
                            </p>
                        @endif
                        @if (isset($patient->situation_familliale))
                            <p>
                                <strong>Situation familliale: </strong>
                                {{ $patient->situation_familliale }}
                                {{ isset($patient->nbre_enfants) ? '(' . $patient->nbre_enfants . ' enfants)' : '' }}
                            </p>
                        @endif
                        <strong>Adresse : </strong>
                        <p>
                            @if ($patient->villes) {{ $patient->villes->name }} ,
                            @endif
                            @if ($patient->communes) {{ $patient->communes->name }}
                                ,
                            @endif
                            @if ($patient->adresse) {{ $patient->adresse }} .
                            @endif
                        </p>
                        <strong>Cordonnées</strong>
                        @if ($patient->num_tel_1)
                            <p>{{ $patient->num_tel_1 }}</p>
                        @endif
                        @if ($patient->num_tel_2)
                            <p>{{ $patient->num_tel_2 }}</p>
                        @endif
                        <p>
                            <strong>
                                {{ $patient->tabagiste ? 'Tabagiste' : '' }}
                                {!! $patient->paquets
                                ? ' (<span class="text-info">' .
                                    $patient->paquets .
                                    '
                                    Pa/jours</span>)'
                                : '' !!}
                                {{ $patient->tabagiste_arreter_depuis ? ' Arréter le : ' . $patient->tabagiste_arreter_depuis . '.' : '' }}

                                @if ($patient->alcoolique) alcoolique
                                    ({{ $patient->alcoolique_depuis }}).@endif
                                @if ($patient->drogue) drogué
                                    ({{ $patient->details }})({{ $patient->drogue_depuis }})@endif
                            </strong>
                        </p>
                        @if (!is_null($patient->pathologies))
                            <strong>Pathologie(s) associée(s) :</strong>
                            <p>
                                @foreach ($patient->pathologies as $path)
                                    {{ strtolower($path->pathologie) }}
                                    {{ $patient->pathologies != '' ? ',' : ' ' }}
                                @endforeach
                            </p>
                        @endif
                        @if (!empty($patient->allergies))

                            <p>
                                <strong>Allergie(s) associée(s) :</strong>
                                @foreach ($patient->allergies as $all)
                                    {{ strtolower($all->allergie) }} {{ $patient->allergies != '' ? ',' : '' }}
                                @endforeach
                            </p>
                        @endif
                        @if (isset($patient->operations))
                            <p>
                                <strong>Antécedants Chirugicaux: </strong>
                                @foreach ($patient->operations as $all)
                                    {{ $all->nom }} {{ $patient->operations != '' ? ',' : '' }}
                                @endforeach
                            </p>
                        @endif
                        @if (isset($patient->antecedentsFamilliaux))
                            <p>
                                <strong>Antécédents Familiaux :</strong>
                                @foreach ($patient->antecedentsFamilliaux as $ant)
                                    {{ strtolower($ant->pathologie) }}
                                    {{ $patient->antecedentsFamilliaux != '' ? ',' : '' }}
                                @endforeach
                            </p>
                        @endif
                        @if ($patient->groupe_sanguin)
                            <p>
                                <strong>Groupe Sanguin: </strong>
                                {{ $patient->groupe_sanguin }}
                            </p>
                        @endif
                        @if (!empty($patient->grossesse_id))
                            <p>
                                <strong>Mois de grossesse: </strong>
                                {{ $patient->pregnant->cdf_nom }}
                            </p>
                        @endif
                        @if ($patient->debut_regles)
                            <p>
                                <strong>Règles début : </strong>
                                {{ $patient->debut_regles }}
                                @if ($patient->duree_cycle)
                                    <strong>Durée du cycle : </strong>
                                    {{ $patient->duree_cycle }}
                                @endif
                            </p>
                        @endif
                        @if ($patient->cosanguinite)
                            <p>
                                <strong>Co-sanguinite: </strong>
                                {{ $patient->cosanguinite }} er degré
                            </p>
                        @endif
                    </div>
                    <!-- /.box-body -->
                    <div class="modal-footer">
                        <input type="reset" class="btn btn-default" data-dismiss="modal" value="fermer">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.modals.add-act')
