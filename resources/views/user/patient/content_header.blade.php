<!-- Content Header (Page header) -->
@if (isset($pr_risque))
    <div class="row p-1">
        <div class="col-xs-12">
            <div class="btn-group float-right">
                <button type="button" class="btn  btn-danger float-right" id="analyseBtn" data-id="{{ $patient->id }}"
                    data-risque="{{ $pr_risque }}">Lancer l'analyse</button>
                <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">

                    <li><a href="#" data-target="#prescription_details" data-toggle="modal">Détails prescription</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endif
<section class="content-header d-md-none" id="horizontal-profil">
    <div class="row">
        <div class="col-sm-12">
            <!-- <?php $color_h = '#1c80b9'; ?>
            @foreach ($patient->ReglesSuiviPatient as $regle_suivie) @if ($regle_suivie->RegleSuiviConcerne->niveau == 1)
            <?php $color_h = '#fd1c1c'; ?> @endif
            @endforeach -->
            <div class="bg-blue-gradient box no-margin" id="divUrgence">
                <div class="box-body table-responsive">
                    <table class="no-border table table-condensed text text-center text-nowrap">
                        <tr>
                            <td><b>Patient:</b> {{ $patient->nom }} {{ $patient->prenom }}</td>
                            <td><b>Sexe:</b> {{ $patient->sexe }}</td>
                            <td>
                                <b>Taille:</b>
                                @if ($patient->taille != '')
                                    {{ $patient->taille }} cm
                                @endif
                            </td>
                            <td>
                                <b>Poids:</b> {{ $patient->poids ? $patient->poids . ' Kg' : '' }}
                            </td>
                            <td><b>Ville:</b>
                                @if ($patient->villes)
                                    {{ $patient->villes->name }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><b>Age :</b>
                                @if ($patient->date_naissance != '')
                                    {{ intval(date('Y/m/d', strtotime('now'))) - intval(date('Y/m/d', strtotime($patient->date_naissance))) }}
                                    ans
                                @endif
                            </td>
                            <td><b>Situation familliale:</b> {{ $patient->situation_familliale }}</td>
                            <td><b>Travaille:</b> {{ $patient->travaille }}</td>
                            <td><b>Cordonnées:</b> {{ $patient->num_tel_1 }}</td>
                            <td><b>Group Sangauin:</b> {{ $patient->groupe_sanguin }}</td>
                        </tr>
                    </table>

                    <?php $var = false; ?>
                    <i></i>
                    @can('patients.update', Auth::user())
                        @foreach ($patient->ReglesSuiviPatient as $regle_suivie)
                            @if ($regle_suivie->RegleSuiviConcerne->niveau == 1)
                                <?php $var = true; ?>
                                @if (!$patient->readonly)
                                    <button class="btn btn-primary up_patient" data-toggle="modal"
                                        data-target="#modal_modifier" data="{{ $patient->id }}"
                                        style=" position: absolute; right: 30px; top: 15px; border: none; font-size: 12.5px;background-color: DarkRed ;">
                                        <i class="fa fa-pencil-alt" aria-hidden="true"></i></button>
                                @endif
                                @break
                            @endif
                        @endforeach
                        @if ($var == false)
                            @if (!$patient->readonly)
                                <button class="btn btn-success up_patient" data="{{ $patient->id }}"
                                    style=" position: absolute; left: 0px; top: 0px; border: none;"> <i
                                        class="fa fa-pencil-alt" aria-hidden="true"></i></button>
                            @endif
                        @endif
                        @if (!$patient->readonly)
                            <button id="btn_ann_pat" class="btn btn-info" data-toggle="modal"
                                data-target="#modal_annotation" data-type="patient"
                                style=" position: absolute; left: 0px; top: 37px; border: none;"> <i
                                    class="fa fa-comment-medical" aria-hidden="true"></i></button>
                        @endif
                    @endcan
                    <button class="switch " class="d-sm-none"
                        style="position: absolute; right: 5px; top: -1px; border: none; font-size: 30px; background-color: transparent;">-</button>
                    <button data-toggle="modal" data-target="#modal-detail-profil" class="d-md-none"
                        style="position: absolute; right: 5px; top: -1px; border: none; font-size: 30px; background-color: transparent;"><i
                            class="fa fa-plus-circle"></i></button>
                </div>

            </div>

        </div>
    </div>
</section>
