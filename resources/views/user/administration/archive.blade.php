

@extends('layouts.model')

@section('script_css')

@section('title')
    Historique des Administrations
@endsection

@endsection

@section('content')

<div class="content-wrapper">

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/home"><i class="fa fa-home"></i> Acceuil</a></li>
                <li><a href="{{ route('administrations.index') }}"><i class="fa fa-user-nurse"></i> Mes Administrations</a></li>
                <li class="active">Historique des Administrations</li>
            </ol>
        </div>

    </section>

    <section class="content">
<div class="row">
    <div class="col-sm-12 ">
        <div class="box box-widget">

            <div class="box-body">

                <div class="row">
                    <div class="col-sm-12 table-responsive">
                        <h3>Historique des administrations du service</h3>
                        <!-- La liste des prescriptions qui ont dépassé la date limite d'administrations -->
                        <table id="example1271" class="nowrap table table-bordered table-hover text-center"
                            style="width:100%">
                            <thead>
                                <tr class="bg-blue">
                                    <th></th>
                                    <th>Num°:</th>
                                    <th>Patient</th>
                                    <th>Prescripteur</th>
                                    <th>Date de Prescription</th>
                                    <th>Historique</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $prescription)
                                    <!-- si c'est un patient hospitalisé -->
                                    @isset($prescription->patient->hospi)
                                        @if (date('Y-m-d') > $prescription->lastDate)
                                            <tr>
                                                <td>
                                                    <a data-toggle="collapse" href="#a{{ $loop->index + 1 }}"
                                                        class="text-green"><i class="fa fa-plus fa-2x"></i></a>
                                                </td>
                                                <td> {{ $prescription->id }} </td>
                                                <td> {{ $prescription->patient->nom }}
                                                    {{ $prescription->patient->prenom }}
                                                </td>
                                                <td> Dr.{{ $prescription->prescripteur->name }}
                                                    {{ $prescription->prescripteur->prenom }}
                                                </td>
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
                                                <td style="display: none;"></td>
                                                <td style="display: none;"></td>
                                                <td colspan="6" style="padding: 0 !important;">
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
                                                                    <th>Pendant </th>
                                                                    <th>Stoppée </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <!-- on calcule les jour restants de la prescription -->
                                                                @foreach ($prescription->lignes as $ligne)
                                                                    @php
                                                                    $j_restant = $ligne->nbr_jours -
                                                                    $ligne->jours_restant;
                                                                    @endphp
                                                                    <!-- afficher seulement les médicaments qui ont fini leurs date de prise -->
                                                                    <!-- Si jours restant est égal à 0 ou inf c a d que la date d'utilisation du médicament est fini -->
                                                                    @if ($j_restant < 0)
                                                                        <tr 
                                                                            @if ($ligne->stopped)
                                                                                style='color:
                                                                                gray;
                                                                                pointer-events: none; '
                                                                            @endif
                                                                        >
                                                                            <th> {{ $loop->index + 1 }} </th>
                                                                            <th>
                                                                                @php
                                                                                $resultats = DB::table('cosac_compo_subact')
                                                                                ->join(
                                                                                'sac_subactive as t0','t0.SAC_CODE_SQ_PK',
                                                                                'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                                                ->select('t0.sac_nom','cosac_compo_subact.cosac_dosage','cosac_compo_subact.cosac_unitedosage')
                                                                                ->where('cosac_compo_subact.cosac_sp_code_fk_pk'
                                                                                ,
                                                                                $ligne->med_sp_id)
                                                                                ->get();
                                                                                foreach ($resultats as $key => $resultat) {
                                                                                echo $resultat->sac_nom." ".
                                                                                $resultat->cosac_dosage
                                                                                .$resultat->cosac_unitedosage.( ($key ==
                                                                                (count($resultats)-1)) ? '.' : '/' );
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
                                                                            <td>{{ $ligne->nbr_jours }}j
                                                                            </td>
                                                                            <td>
                                                                                @if ($ligne->stopped)

                                                                                    Arrétée le {!! date('d-m-Y',
                                                                                    strtotime($ligne->stopped_at)) !!}
                                                                                    ({{ $ligne->comment }})
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </td>

                                            </tr>
                                        @endif
                                    @endisset
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Button trigger modal-->



</div>
<!-- Modal Historique des Administration par Prescription -->
<div class="modal fade" id="modal_administrations">
    <div class="modal-dialog  modal-lg ">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Historique des Administrations</h4>
            </div>
            <div class="modal-body">
                <table id="administrations_table" class=" display table table-bordered" style="width:100%">
                    <thead>
                        <tr class="bg-green-active">
                            <th>Médicament</th>
                            <th></th>
                            <th>Prise</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <input type="reset" class="btn btn-default" data-dismiss="modal" value="Fermer">
                <!-- <input type="submit" class="btn btn-primary pull-right" value="Ajouter"> -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('js/user/patient/gestion-administration.js') }}"></script>
<script>
    $("#example1271").DataTable({
        "ordering": false,
    }); //Prescription	
    $('input[type="checkbox"].flat-green').iCheck({
        checkboxClass: 'icheckbox_flat-green'
    });

</script>
@endsection
