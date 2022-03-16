    <div class="col-md-3 d-sm-none" id="aside-profil">
        <!-- Widget: user widget style 1 -->
        <div class="box box-widget widget-user">

            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class=" widget-user-header" style="background: #3c8dbc; padding-left:5px">
                <h3 class="widget-user-username">{{ $patient->nom }} {{ $patient->prenom }}</h3>
                {{-- <h5 class="widget-user-desc">Patient ({{ $patient->sexe }})</h5> --}}
                <button class="switch " id="" style="right: 0%;
                    position: absolute;
                    bottom: 82px;
                    background-color: transparent;
                    border: none;">
                    <span style="font-size:  40px;">-</span>
                </button>
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
                @can('patients.update', Auth::user())
                    {{-- @if (!$patient->readonly) --}}

                    <button class="btn btn-success up_patient" data="{{ $patient->id }}"
                        title="Modifier le profile du patient"
                        style="position: absolute;top: 7px;border: none;font-size: 12.5px;right: 2%;">
                        <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                    </button>
                    <button id="btn_ann_pat" class="btn btn-primary" data-toggle="modal"
                        title="Ajouter une annotation sur le patient" data-target="#modal_annotation" data-type="patient"
                        style="position: absolute;top: 7px;border: none;right: 43px;font-size: 12.5px;">
                        <i class="fa fa-comment-medical" aria-hidden="true"></i>
                    </button>
                    {{-- @endif --}}
                @endcan
                <h3 class="box-title">A propos du Patient
                </h3>
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
                    @if ($patient->communes) {{ $patient->communes->name }} ,
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
                        {!! $patient->paquets ? ' (<span class="text-info">' . $patient->paquets . ' Pa/jours</span>)' : '' !!}
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
                            {{ strtolower($path->pathologie) }} {{ $patient->pathologies != '' ? ',' : ' ' }}
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
        </div>
    </div>
