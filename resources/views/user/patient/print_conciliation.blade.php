<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" media="screen"  />
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<link rel="stylesheet" type="text/css" media="print"  />
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Ionicons/css/ionicons.css')}}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css')}}">
    <title>Prescription#{{ $prescription[0]->p_id}}</title>
</head>
<body onload="window.print();">
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <img src="{{ asset('/images/logo_chut.png')}}" style="width: 40px; height: 40px;">
              {{ $prescription[0]->hopital}}, @if (strlen( $prescription[0]->hopital ) > 20) 
                  <br/>
              @endif {{ $prescription[0]->service}}.
              <small class="pull-right">Date: {!! now() !!}</small>
            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-4 invoice-col">
            Patient:
            <address>
              <strong>{{ $prescription[0]->p_nom}}, {{ $prescription[0]->p_prenom}}.</strong><br>
              {{ $prescription[0]->p_dn}} {!! ($prescription[0]->ville) ?? '.' !!} <br>
              {!! (($prescription[0]->p_num1) ? "Phone: (213)".$prescription[0]->p_num1 : '') !!}
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            Médecin Prescripteur:
            <address>
              <strong>{{ $prescription[0]->name}} {{ $prescription[0]->prenom}}.</strong><br>
              {{ $prescription[0]->hopital}}, {{ $prescription[0]->service}}<br>
              {{ $prescription[0]->specialite}}, {{ $prescription[0]->grade}}<br>
              {!! (($prescription[0]->telephone) ? "Phone: (213)".$prescription[0]->telephone : '') !!}<br>
            </address>
          </div>
          <!-- /.col -->
          <div class="col-sm-4 invoice-col">
            <b>prescription #{{ $prescription[0]->p_id}}</b><br>
            <b>Date prescription:</b> {{ $prescription[0]->date_prescription}}<br>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
{{--             <form class="form-group" role="form" method="POST" action="{{ route('prescription.update',$lignes[0]['patient_id']) }}">
                {{  csrf_field() }}
                {{ method_field('PATCH') }}
                <table class="table  table-condensed table-hover">
                    @php
                    $ligne_prev = "";
                    echo "<tr class='alert bg-black' style='text-align: center;'><th colspan='1'>Medicament</th><th colspan='1'>Voie</th><th colspan='1'>Prise</th><th colspan='1'>Matin</th><th colspan='1'>Midi</th><th colspan='1'>Soir</th><th colspan='1'>av-coucher</th><th colspan='1'>unité</th><th colspan='1'>Durée</th></tr>";
                    for($i=0; $i < count($lignes); $i++) {
                    //if($lignes[$i]['CATC_NOMF'] != $ligne_prev) {
                    //echo "<tr class='bg-blue-gradient'><th colspan='9'>".$lignes[$i]['CATC_NOMF']."</th></tr>";
                    //}
                    $resultats = DB::table('cosac_compo_subact')
                                    ->join('sac_subactive as t0','t0.SAC_CODE_SQ_PK' , 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                    ->select('t0.sac_nom','cosac_compo_subact.cosac_dosage','cosac_compo_subact.cosac_unitedosage')
                                    ->where('cosac_compo_subact.cosac_sp_code_fk_pk' , $lignes[$i]['med_sp_id'])
                                    ->get();
                    $dci="";
                    foreach ($resultats as $key => $resultat) {
                    $dci.= $resultat->sac_nom." ". $resultat->cosac_dosage .$resultat->cosac_unitedosage.( ($key == (count($resultats)-1)) ? '.' : '/' );
                    }
                    echo "<tr>".
                        "<td><input type='hidden' name='lignes_id[]' value='".$lignes[$i]['id']."'>".$dci."</td>".
                        "<td>".$lignes[$i]['voie']."</td>".
                        "<td>".$lignes[$i]['dose']."</td>".
                        "<td style='text-align: center'>".(($lignes[$i]['dose_matin'] !='0') ? "<i class='fa  fa-check-circle ' style='color: green;font-size: 22px;'></i>".$lignes[$i]['repas_matin']: '/' )."</td>".
                        "<td style='text-align: center'>".(($lignes[$i]['dose_midi'] !='0') ? "<i class='fa  fa-check-circle ' style='color: green;font-size: 22px;'></i>".$lignes[$i]['repas_midi']: '/' )."</td>".
                        "<td style='text-align: center'>".(($lignes[$i]['dose_soir'] !='0') ? "<i class='fa  fa-check-circle ' style='color: green;font-size: 22px;'></i>".$lignes[$i]['repas_soir']: '/' )."</td>".
                        "<td style='text-align: center'>".(($lignes[$i]['dose_avant_coucher'] != '0') ? "<i class='fa  fa-check-circle ' style='color: green;font-size: 22px;'>" : "/")."</td>".
                        "<td>".$lignes[$i]['unite']."</td>".
                        "<td>".$lignes[$i]['nbr_jours']."jours</td>".
                    "</tr>";
                    $ligne_prev =  $lignes[$i]['CATC_NOMF'];
                    }
                    @endphp
                </table>
                <div class="col-sm-4 bg-gray">
                    <h3>Rapport Pharmacien</h3>
                    @php

                    $re = DB::table('educationtherapeutiques')
                            ->where('patient_id' ,$lignes[0]['patient_id'])
                            ->whereIn('date_et',function($query) {
                                $query->selectRaw('max(date_et)')
                                    ->from('educationtherapeutiques')
                                     ->groupBy('patient_id');
                             })
                            ->get();
                    if (count($re) > 0)
                    echo $re[0]->description;
                    @endphp
                </div>               
                <h3 class="pull-right">............................</h3>
                <h3 class="pull-right">    Signature : </h3>
            </div> --}}
        </body>
        <script src="{{ asset('plugins/jquery/js/jquery.js')}}"></script>
        <script type="text/javascript">
        $(window).on("load",function(){
        window.print();
        });
        </script>
    </html>