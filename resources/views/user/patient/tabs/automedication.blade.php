<!--tab Automédication-->
<div class="tab-pane {{ session('tab') == 'tab_5' ? 'active in' : '' }}" id="tab_5">
    <div class="clearfix">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wheelchair"></i> patient</a></li>
            <li><a href="#">médicaments</a></li>
            <li class="active">Automédication</li>
        </ol>
        @can('automedications.create', Auth::user())
            @if (!$patient->readonly)
                <button type="button" class="btn btn-primary float-left"
                    onclick='$("#modalPrescriptionVille form").attr("action", "{{ route('automedication.store') }}");'
                    data-toggle="modal" data-target="#modalPrescriptionVille" title="Raccourci(t)">Ajouter
                    médicament(s)</button>
            @endif
        @endcan
        @can('automedications.export', Auth::user())
            <a href="/export/auto/{{ $patient->id }}"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        @endcan
    </div>
    @can('automedications.view', Auth::user())
        <div class="box box-widget">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-body">
                            <table id="example6" class=" table table-bordered table-hover text-center table-condensed">
                                <thead class="text-nowrap" style="background-color: #00a65a !important; color:white">
                                    <tr>
                                        <th class="text-center">Num°:</th>
                                        <th class="text-center">Médicament</th>
                                        <th class="text-center">Médecin externe</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center">Date de prise</th>
                                        <th class="text-center">Mettre à jour</th>
                                        @can('automedications.update', Auth::user())
                                            @if (!$patient->readonly)
                                                <th class="text-center">Modifier</th>
                                            @endif
                                        @endcan
                                        @can('automedications.delete', Auth::user())
                                            @if (!$patient->readonly)

                                                <th class="text-center">Supprimer</th>
                                            @endif

                                        @endcan
                                        <th>Annotation</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($patient->autos as $ligne)
                                        <tr>
                                            <td> {{ $loop->index + 1 }}</td>
                                            <td style="text-align: left">
                                                @php
                                                    $medicament = '';
                                                    $resultats = DB::table('cosac_compo_subact')
                                                        ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                        ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                        ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $ligne->med_sp_id)
                                                        ->get();
                                                    foreach ($resultats as $key => $resultat) {
                                                        $medicament .= $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                                    }
                                                @endphp

                                                <b> {{ $medicament }} </b> {{ $ligne->voie }}.
                                                {!! $ligne->dose_matin != 0 ? $ligne->dose_matin . ' <b>' .
                                                    strtolower($ligne->unite) . '</b> le <b class="text-info">Matin</b>, ' :
                                                '' !!}
                                                {!! $ligne->dose_midi != 0
                                                ? $ligne->dose_midi .
                                                ' à <b class="text-green">Midi</b>, '
                                                : '' !!}
                                                {!! $ligne->dose_soir != 0
                                                ? $ligne->dose_soir .
                                                ' le <b class="text-yellow">Soir</b>, '
                                                : '' !!}
                                                {!! $ligne->dose_avant_coucher != 0
                                                ? $ligne->dose_avant_coucher .
                                                ' <b class="text-red">Avant-coucher</b>'
                                                : '' !!}.
                                            </td>

                                            <td>{{ $ligne->medecin_externe ? 'Dr.' . $ligne->medecin_externe : '-' }}
                                            </td>
                                            <td>
                                                @if ($ligne->etats == 'En cours' || $ligne->etats == 'Reprise')
                                                    <span class="label label-success text-sm">{{ $ligne->etats }} </span>
                                                @else
                                                    <span class="label label-danger text-sm">{{ $ligne->etats }}</span>
                                                @endif
                                            </td>

                                            <td> {{ $ligne->date_etats }} </td>
                                            {{-- <td>
                                                @if ($ligne->status_hopital == '1') H @else
                                                    V @endif
                                            </td> --}}
                                            @can('traitements_chronique.update', Auth::user())
                                                @if (!$patient->readonly)
                                                    <td>
                                                        <a href="#mise-a-jour" class="updateTraitAuto" data-type="auto"
                                                            data-dci="{{ $ligne->med_sp_id }}"
                                                            data-id="{{ $ligne->id }}"><i
                                                                class="fa fa-sync text-info fa-2x"></i></a>

                                                    </td>
                                                @endif
                                            @endcan

                                            @can('traitements_chronique.update', Auth::user())
                                                @if (!$patient->readonly)
                                                    <td>
                                                        <a href="javascript:void(0)" class="editPrescriptionVille"
                                                            data-type="trait" data-id="{{ $ligne->id }}"><i
                                                                class="fa fa-edit text-green fa-2x"></i></a>

                                                    </td>
                                                @endif
                                            @endcan

                                            @can('traitements_chronique.delete', Auth::user())
                                                @if (!$patient->readonly)
                                                    <td>
                                                        <a href="javascript:void(0)" class="deleteRow"
                                                            data-url="{{ route('automedication.destroy', $ligne->automedication_id) }}"><span
                                                                class="fa fa-trash text-red fa-2x"></span></a>
                                                    </td>
                                                @endif
                                            @endcan
                                            @if (!$patient->readonly)
                                                <td>
                                                    <a href="#" id="btn_ann_chron" data-toggle="modal"
                                                        data-target="#modal_annotation" data-type="auto"
                                                        data-id="{{ $ligne->traitementchronique_id }}">
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
            </div>
        </div>
    @endcan

    @if (count($patient->tmp_autos) > 0)

        <div class="box box-widget">

            <div class="box-header">
                <h3>Récolter par les pharmaciens </h3>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <table id="example7" class=" table table-bordered table-hover text-center table-condensed">
                            <thead style="background-color: #00a65a !important; color:white">
                                <tr>
                                    <th>Médicament (DCI)</th>
                                    <th>Voie</th>
                                    <th>Matin</th>
                                    <th>Midi</th>
                                    <th>Soir</th>
                                    <th>Av-coucher</th>
                                    <th>Unité</th>
                                    <th>Médecin externe</th>
                                    {{-- <th>Pharmacien</th> --}}
                                    <th>Le :</th>
                                    <th>Hopital</th>
                                    @can('patients.valide', $patient)
                                        <th>Valider?</th>
                                        <th>Refuser?</th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->tmp_autos as $tmp_auto_ligne)
                                    <tr>
                                        <th>
                                            @php
                                                $resultats = DB::table('cosac_compo_subact')
                                                    ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                    ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                                    ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $tmp_auto_ligne->med_sp_id)
                                                    ->get();
                                                foreach ($resultats as $key => $resultat) {
                                                    echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                                }
                                            @endphp
                                        </th>
                                        <th> {{ $tmp_auto_ligne->voie }} </th>
                                        <td> {{ $tmp_auto_ligne->dose_mat }}
                                            {{ $tmp_auto_ligne->repas_matin }}
                                        </td>
                                        <td> {{ $tmp_auto_ligne->dose_mi }}
                                            {{ $tmp_auto_ligne->repas_midi }}
                                        </td>
                                        <td> {{ $tmp_auto_ligne->dose_so }}
                                            {{ $tmp_auto_ligne->repas_soir }}
                                        </td>
                                        <td> {{ $tmp_auto_ligne->dose_avant_coucher }} </td>
                                        <td> {{ $tmp_auto_ligne->unite }} </td>
                                        <td>Dr.{{ $tmp_auto_ligne->medecin_externe }} </td>
                                        {{-- <td>Dr. </td> --}}
                                        <td> {{ $tmp_auto_ligne->date_etats }} </td>
                                        <td>
                                            @if ($tmp_auto_ligne->status_hopital == '1') H
                                            @else V @endif
                                        </td>
                                        @can('patients.valide', $patient)
                                            <td>
                                                <a href="" class="deleteRow"
                                                    data-url="{{ route('automedication.confirm', $tmp_auto_ligne->id) }}"
                                                    style="color: inherit; cursor: pointer;"><i class="fa  fa-check-circle "
                                                        style="color: green;font-size: 22px;"></i></a>
                                            </td>
                                            <td>;

                                                <a href="" class="deleteRow"
                                                    data-url="{{ route('automedication.destroy_tmp', $tmp_auto_ligne->id) }}"
                                                    style="color: inherit; cursor: pointer;"><i class="fa  fa-times-circle "
                                                        style="color: red;font-size: 22px;"></i></a>

                                            </td>
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

</div>
