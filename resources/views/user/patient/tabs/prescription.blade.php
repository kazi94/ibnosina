<!--tab prescription -->
<div class="tab-pane {{ session('tab') == 'tab_2' ? 'active in' : '' }}" id="tab_2">


    <div class="clearfix">

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wheelchair"></i> patient</a></li>
            <li class="active">Prescription Service</li>
        </ol>

        <a href="#modal">
            @if (!$patient->readonly)
                <button type="button" id="prescrBtn" class="btn btn-primary float-left" title="Raccourci(m)"
                    data-toggle="modal" data-target="#modal_prescription">Ajouter une prescription</button>

            @endif
        </a>

    </div>

    <!--box Prescriptions en attente d'envoie-->
    @if (count($patient->prescriptions))

        <div class="box box-widget">

            <div class="box-body">

                <div class="">
                    <div class="col-sm-12 table-responsive">
                        <h3>Prescriptions en attente d'envoie</h3>

                        <table id="example127" class="table table-bordered table-hover nowrap">
                            <thead>
                                <tr class="bg-blue">
                                    <th class="text-center">Num°:</th>
                                    <th class="text-center">Date Prescription</th>
                                    <th class="text-center">Prescripteur</th>
                                    <th class="text-center">Détails</th>
                                    @can('prescriptions.print', Auth::user())
                                        <th class="text-center">Imprimer</th>
                                    @endcan
                                    @can('prescriptions.update', Auth::user())
                                        @if (!$patient->readonly)
                                            <th class="text-center">Modifier</th>
                                        @endif
                                    @endcan
                                    <th class="text-center">Envoyer</th>
                                    @can('prescriptions.delete', Auth::user())
                                        @if (!$patient->readonly)

                                            <th class="text-center">Supprimer</th>
                                        @endif

                                    @endcan

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->prescriptions as $prescription)

                                    <tr class="text-center">
                                        <td> {{ $prescription->id }} </td>
                                        <td> {{ $prescription->date_prescription }} </td>
                                        <td> Dr.{{ $prescription->prescripteur->name }}
                                            {{ $prescription->prescripteur->prenom }}
                                        </td>
                                        <td>
                                            <a href="#detail-prescription" class="detailPrescription"
                                                title="Détails de la prescription" data-toggle="modal"
                                                data-target="#modal_detail_prescription"
                                                data-id="{{ $prescription->id }}">
                                                <i class="fa fa-plus-circle fa-2x"></i>
                                            </a>
                                        </td>
                                        @can('prescriptions.print', Auth::user())
                                            <td>
                                                <a href="#" onclick="downloadPrescription({{ $prescription->id }})">
                                                    <i style="cursor: pointer;" class="fa fa-print fa-2x"></i>
                                                </a>
                                            </td>
                                        @endcan
                                        @can('prescriptions.update', Auth::user())
                                            @if (!$patient->readonly)
                                                <td>
                                                    <a href="#modifierPrescription" class="editPrescription"
                                                        title="Modifier la Prescription" data-toggle="modal"
                                                        data-target="#modal_prescription"
                                                        data-id="{{ $prescription->id }}">
                                                        <i class="fa fa-edit text-green fa-2x"></i>
                                                    </a>
                                                </td>
                                            @endif
                                        @endcan
                                        <td>
                                            <a href="/patient/{{ $patient->id }}/pre_analyser/{{ $prescription->id }}"
                                                title="Envoyé au Pharmacien pour analyse">
                                                <i class="fa fa-envelope-open fa-2x text-warning"></i>
                                            </a>
                                        </td>
                                        <!-- <button id="btn_ann_pres" class="btn btn-default" data-toggle="modal" data-target="#modal_annotation" data-type="prescription" data-id="{{ $prescription->id }}" style="border-radius: 50%;background: #34c5d6;">
                                            <i class="fa fa-comment-medical fa-2x"></i>
                                        </button> -->
                                        @can('prescriptions.delete', Auth::user())
                                            @if (!$patient->readonly)
                                                <td>
                                                    <a href="" class="deleteRow"
                                                        data-url="{{ route('prescription.destroy', $prescription->id) }}"
                                                        style="color: inherit; cursor: pointer;"><span
                                                            class="fa fa-trash text-red fa-2x"></span>
                                                    </a>
                                                </td>
                                            @endif
                                        @endcan
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    @endif
    <!--End box Prescriptions en attente d'evoie-->

    @can('prescriptions.inject', Auth::user())
        <!--Prescription en attente d'administration-->
        @if (count($patient->prescriptionsDesc))
            <div class="box box-widget">

                <div class="box-body">

                    <div class="">
                        <div class="col-sm-12 table-responsive">
                            <h3>Prescriptions En cours d'administration</h3>
                            <table id="table_injections" class="nowrap table table-bordered table-hover text-center"
                                style="width:100%">
                                <thead>
                                    <tr class="bg-blue ">
                                        <th></th>
                                        <th class="text-center">Num°:</th>
                                        <th class="text-center">Date de Prescription</th>
                                        <th class="text-center">Historique</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient->prescriptionsDesc as $prescription)
                                        @if (date('Y-m-d') <= $prescription->lastDate)
                                            <tr>
                                                <td>
                                                    <a data-toggle="collapse" href="#a{{ $loop->index + 1 }}"
                                                        class="text-green"><i class="fa fa-plus fa-2x"></i></a>
                                                </td>
                                                <td> {{ $prescription->id }} </td>
                                                <td> {{ $prescription->date_prescription }} </td>
                                                <td>
                                                    <button class="btn btn-info" data-toggle="modal"
                                                        data-target="#modal_administrations"
                                                        data-id="{{ $prescription->id }}"><i
                                                            class="fa fa-calendar mr-1"></i>
                                                        Administrations</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td colspan="4" style="padding: 0 !important;">
                                                    <div id="a{{ $loop->index + 1 }}" class="accordian-body collapse">
                                                        <table class="table table-bordered table-condensed">
                                                            <thead>
                                                                <tr class="bg-gray">
                                                                    <th>Num</th>
                                                                    <th>Médicament (DCI)</th>
                                                                    <th>Voie</th>
                                                                    <th>Matin</th>
                                                                    <th>Midi</th>
                                                                    <th>Soir</th>
                                                                    <th>Avant coucher</th>
                                                                    <th>Unité</th>
                                                                    <th>J Restants </th>
                                                                    <th>Administrer </th>
                                                                    <th>Stoppée </th>

                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($prescription->lignes as $ligne)
                                                                    <tr @if ($ligne->stopped) style='color: gray; pointer-events: none; ' @endif>
                                                                        <th> {{ $loop->index + 1 }} </th>

                                                                        <th style="text-align: left">
                                                                            @php
                                                                                $resultats = DB::table('cosac_compo_subact')
                                                                                    ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                                                    ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                                                    ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $ligne->med_sp_id)
                                                                                    ->get();
                                                                                foreach ($resultats as $key => $resultat) {
                                                                                    echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                                                                }
                                                                            @endphp
                                                                        </th>
                                                                        <td> {{ $ligne->voie }} </td>
                                                                        <td> {{ $ligne->dose_matin ? $ligne->dose_mat . $ligne->repas_matin : '' }}
                                                                        </td>
                                                                        <td> {{ $ligne->dose_midi ? $ligne->dose_mid . $ligne->repas_midi : '' }}
                                                                        </td>
                                                                        <td> {{ $ligne->dose_soir ? $ligne->dose_soi . $ligne->repas_soir : '' }}
                                                                        </td>
                                                                        <td> {{ $ligne->dose_avant_coucher ? $ligne->dose_ac : '' }}
                                                                        </td>
                                                                        <td> {{ $ligne->unite }} </td>
                                                                        <td> -{{ $ligne->nbr_jours - $ligne->jours_restant }}j
                                                                        </td>
                                                                        <td class="text-nowrap">
                                                                            @if (!$ligne->stopped)
                                                                                @php
                                                                                    $injections = $ligne->load([
                                                                                        'todayInjections' => function ($query) use ($ligne) {
                                                                                            $query->orWhere('day_j', $ligne->nbr_jours)->get();
                                                                                        },
                                                                                    ]);
                                                                                    $injections = $injections->todayInjections;
                                                                                @endphp
                                                                                @if ($ligne->dose_matin)

                                                                                    <input type="hidden" name="injected"
                                                                                        data-id="{{ $ligne->id }}"
                                                                                        data-prise="matin" value="0">
                                                                                    @php
                                                                                        $state = '';
                                                                                        foreach ($injections as $injectedLine) {
                                                                                            if ($injectedLine->prise == 'matin') {
                                                                                                $state = 'checked disabled';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                    <input type='checkbox' name="injected"
                                                                                        class='form-control flat-green'
                                                                                        {{ $state }}
                                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />

                                                                                @endif
                                                                                @if ($ligne->dose_midi)
                                                                                    <input type="hidden" name="injected"
                                                                                        data-id="{{ $ligne->id }}"
                                                                                        data-prise="midi" value="0">
                                                                                    @php
                                                                                        $state = '';
                                                                                        foreach ($injections as $injectedLine) {
                                                                                            if ($injectedLine->prise == 'midi') {
                                                                                                $state = 'checked disabled';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                    <input type='checkbox' name="injected"
                                                                                        class='form-control flat-green'
                                                                                        {{ $state }}
                                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />

                                                                                @endif

                                                                                @if ($ligne->dose_soir)
                                                                                    <input type="hidden" name="injected"
                                                                                        data-id="{{ $ligne->id }}"
                                                                                        data-prise="soir" value="0">
                                                                                    @php
                                                                                        $state = '';
                                                                                        foreach ($injections as $injectedLine) {
                                                                                            if ($injectedLine->prise == 'soir') {
                                                                                                $state = 'checked disabled';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                    <input type='checkbox' name="injected"
                                                                                        {{ $state }}
                                                                                        class='form-control flat-green'
                                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />
                                                                                @endif

                                                                                @if ($ligne->dose_avant_coucher)

                                                                                    <input type="hidden" name="injected"
                                                                                        data-id="{{ $ligne->id }}"
                                                                                        data-prise="coucher" value="0">
                                                                                    @php
                                                                                        $state = '';
                                                                                        foreach ($injections as $injectedLine) {
                                                                                            if ($injectedLine->prise == 'coucher') {
                                                                                                $state = 'checked disabled';
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                    @endphp
                                                                                    <input type='checkbox' name="injected"
                                                                                        class='form-control flat-green'
                                                                                        {{ $state }}
                                                                                        onclick="this.previousSibling.value=1-this.previousSibling.value" />

                                                                                @endif

                                                                            @endif

                                                                        </td>
                                                                        <td>
                                                                            @if (!$ligne->stopped)
                                                                                <button class="btn btn-danger stopInjection"
                                                                                    data-id="{{ $ligne->id }}"><i
                                                                                        class="fa fa-hand-o"></i>Stop</button>
                                                                            @else
                                                                                Arrétée le {!! date('d-m-Y', strtotime($ligne->stopped_at)) !!}
                                                                                ({{ $ligne->comment }})
                                                                            @endif
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endcan
    <!--box Prescription à Administrer-->
    @if (count($patient->prescriptionsRetroInvalide))
        <div class="box box-widget">

            <div class="box-header">
                <h3>Liste des Prescriptions</h3>
            </div>

            <div class="box-body">
                <div class="col-sm-12 table-responsive">
                    <table id="hist_presc" class="table table-bordered table-hover nowrap">
                        <thead>
                            <tr class="bg-blue">
                                <th class="text-center">Num°:</th>
                                <th class="text-center">Date Prescription</th>
                                <th class="text-center">Etats</th>
                                <th class="text-center">Prescripteur</th>
                                <th class="text-center">Détails</th>
                                @can('prescriptions.print', Auth::user())
                                    <th class="text-center">Imprimer</th>
                                @endcan
                                <th class="text-center">Modifier</th>
                                <th class="text-center">Supprimer</th>
                                @if (!$patient->readonly)
                                    <th>Annotation</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($patient->prescriptionsRetroInvalide as $prescription)

                                <tr class="text-center">
                                    <td> {{ $prescription->id }} </td>
                                    <td> {{ $prescription->date_prescription }} </td>
                                    <td>
                                        @if ($prescription->etats == 'risque') <span
                                                class="badge bg-red">Prescription à analyser par le Pharmacien</span>
                                        @endif
                                        <!-- @if ($prescription->etats == 'done') <span class="badge bg-blue">Validée </span> @endif -->
                                        @if ($prescription->etats == 'in progress')
                                            <span class="badge bg-orange">En cours de validation par le Médecin</span>
                                        @endif
                                        @if ($prescription->etats == 'prescription')
                                            <span class="badge bg-green">Prescription dispensée du service</span>
                                        @endif
                                        @if ($prescription->etats == 'invalide') <span
                                                class="badge bg-aqua">Validée</span>@endif
                                    </td>
                                    <td>
                                        {{ $prescription->prescripteur->name }}
                                        {{ $prescription->prescripteur->prenom }}
                                    </td>
                                    <td>
                                        <a href="#detail-prescription" class="detailPrescription"
                                            title="Détails de la prescription" data-toggle="modal"
                                            data-target="#modal_detail_prescription"
                                            data-id="{{ $prescription->id }}">
                                            <i class="fa fa-plus-circle fa-2x"></i>
                                        </a>
                                    </td>
                                    @can('prescriptions.print', Auth::user())
                                        <td>
                                            <a href="#" onclick="downloadPrescription({{ $prescription->id }})"><i
                                                    style="cursor: pointer;" class="fa fa-print fa-2x"
                                                    title="Imprimer"></i></a>
                                        </td>
                                    @endcan
                                    <td>
                                        @can('prescriptions.update', Auth::user())
                                            @if (!$patient->readonly)
                                                <a href="" class="editPrescription" title="Modifier la Prescription"
                                                    data-toggle="modal" data-target="#modal_prescription"
                                                    style="color: inherit; cursor: pointer;"
                                                    data-id="{{ $prescription->id }}"><span
                                                        class="fa fa-edit fa-2x text-green"></span></a>
                                            @endif
                                        @endcan
                                    </td>
                                    <td>
                                        @can('prescriptions.delete', Auth::user())
                                            @if (!$patient->readonly)
                                                <a href="" class="deleteRow"
                                                    data-url="{{ route('prescription.destroy', $prescription->id) }}"
                                                    style="color: inherit; cursor: pointer;"><span
                                                        class="fa fa-trash fa-2x text-red"></span>
                                                </a>
                                            @endif
                                        @endcan
                                    </td>
                                    @if (!$patient->readonly)
                                        <td>

                                            <a href="#" id="btn_ann_con" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="prescription"
                                                data-id="{{ $prescription->id }}">
                                                <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    @endif

</div>
