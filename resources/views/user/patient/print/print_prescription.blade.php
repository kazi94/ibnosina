<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" media="screen" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" type="text/css" media="print" />
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Ionicons/css/ionicons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css') }}">
    <title>Prescription#{{ $prescription[0]->p_id }}</title>
</head>

<body onload="window.print();">
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <img src="{{ asset('/images/logo_chut.png') }}" style="width: 40px; height: 40px;">
                        {{ $prescription[0]->hopital }}, @if (strlen($prescription[0]->hopital) > 20)
                            <br />
                        @endif {{ $prescription[0]->service }}.
                        <small class="pull-right">Date: {!! now() !!}</small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
                <div class="col-sm-4 invoice-col">
                    <strong>Patient:</strong>
                    <address>
                        <strong>{{ $prescription[0]->p_nom }}, {{ $prescription[0]->p_prenom }}.</strong><br>
                        {{ $prescription[0]->p_dn }} ,{!! $prescription[0]->ville ?? '.' !!} <br>
                        {!! $prescription[0]->p_num1 ? 'Phone: (213)' . $prescription[0]->p_num1 : '' !!}
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    Médecin Prescripteur:
                    <address>
                        <strong>Dr.{{ $prescription[0]->name }} {{ $prescription[0]->prenom }}.</strong><br>
                        {{ $prescription[0]->hopital }}, {{ $prescription[0]->service }}<br>
                        {{ $prescription[0]->specialite }}, {{ $prescription[0]->grade }}<br>
                        {!! $prescription[0]->telephone ? 'Phone: (213)' . $prescription[0]->telephone : '' !!}<br>
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>prescription #{{ $prescription[0]->p_id }}</b><br>
                    <b>Date prescription:</b> {{ $prescription[0]->date_prescription }}<br>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 ">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Médicament</th>
                                <th>Prise</th>
                                <th>Matin</th>
                                <th>Midi</th>
                                <th>Soir</th>
                                <th>Avant coucher</th>
                                <th>Pendant</th>
                            </tr>
                        </thead>
                        @php
                            $r = DB::table('ligneprescriptions')
                                ->where('prescription_id', $prescription[0]->p_id)
                                ->select('ligneprescriptions.*')
                                ->get();
                        @endphp
                        @foreach ($r as $val)
                            <tr style="text-align: center;">
                                <td>{{ $loop->index + 1 }}</td>
                                <td>
                                    @php
                                        $resultats = DB::table('cosac_compo_subact')
                                            ->join('sac_subactive as t0', 't0.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                            ->select('t0.sac_nom', 'cosac_compo_subact.cosac_dosage', 'cosac_compo_subact.cosac_unitedosage')
                                            ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $val->med_sp_id)
                                            ->get();
                                        foreach ($resultats as $key => $resultat) {
                                            echo $resultat->sac_nom . ' ' . $resultat->cosac_dosage . $resultat->cosac_unitedosage . ($key == count($resultats) - 1 ? '.' : '/');
                                        }
                                    @endphp
                                </td>
                                <td>
                                    @if ($val->dose_matin)
                                        {{ $val->dose_matin }}
                                    @elseif ($val->dose_midi)
                                        {{ $val->dose_midi }}
                                    @elseif ($val->dose_soir)
                                        {{ $val->dose_soir }}
                                    @else
                                        {{ $val->dose_avant_coucher }}
                                    @endif
                                    {{ $val->unite }}
                                </td>
                                <td> {!! $val->dose_matin ? "<i class='fa  fa-check-circle ' style='font-size: 22px;'></i>" . $val->repas_matin : '/' !!} </td>
                                <td> {!! $val->dose_midi ? "<i class='fa  fa-check-circle ' style='font-size: 22px;'></i>" . $val->repas_midi : '/' !!} </td>
                                <td> {!! $val->dose_soir ? "<i class='fa  fa-check-circle ' style='font-size: 22px;'></i>" . $val->repas_soir : '/' !!} </td>
                                <td> {!! $val->dose_avant_coucher ? "<i class='fa  fa-check-circle ' style='font-size: 22px;'><i>" : '/' !!} </td>
                                <td> {!! $val->nbr_jours ? $val->nbr_jours . 'jours' : '/' !!}</td>
                            </tr>
                        @endforeach
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">
                    <p class="lead">Signature:................</p>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
</body>

</html>
