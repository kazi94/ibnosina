<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" media="screen"  />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" type="text/css" media="print"  />
        <link rel="stylesheet" href="{{ asset('/plugins/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('/css/font-awesome/css/font-awesome.css')}}">
        <link rel="stylesheet" href="{{ asset('/css/Ionicons/css/ionicons.css')}}">
        <link rel="stylesheet" href="{{ asset('/css/AdminLTE.css')}}">
        <title>Fiche de Conciliation </title>
    </head>
<body>
    <div class="wrapper">
      <!-- Main content -->
      <section class="invoice">
        <!-- title row -->
        <div class="row">
          <div class="col-xs-12">
            <h2 class="page-header">
              <img src="{{ asset('/images/logo_chut.png')}}" style="width: 40px; height: 40px;">
              {{ $lignes[0]['hopital'] }}, @if (strlen( $lignes[0]['hopital']) > 20) 
                  <br/>
              @endif {{ $lignes[0]['service']}}.
              <small class="pull-right">Date: {!! now() !!}</small>
            </h2>
          </div>
          <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
          <div class="col-sm-6 invoice-col">
            Patient:
            <address>
              <strong>{{ $lignes['0']['nom']}} {{ $lignes['0']['prenom']}}.</strong><br>
              {{ $lignes[0]['date_naissance']}} {!! ( $lignes[0]['ville'] ) ?? '.' !!} <br>
          </div>
          <!-- /.col -->
          <div class="col-sm-6 invoice-col">
            Médecin Traitant:
            <address>
              <strong>Dr.{{ $lignes[0]['user_name'] }} {{ $lignes[0]['user_prenom'] }}.</strong><br>
              {{-- {{ $lignes[0]['specialite']}}, {{ $lignes[0]['grade']}}<br> --}}
              {{-- {!! (($lignes[0]['telephone']) ? "Phone: (213)".$lignes[0]['telephone'] : '') !!}<br> --}}
            </address>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <h2 class="page-header"></h2>
        
        <table class="table  table-condensed table-hover">
            @php
                $ligne_prev = "";
                echo "<tr class='alert bg-black text-center'><th>Medicament</th><th>Voie</th><th>Prise</th><th>Matin</th><th>Midi</th><th>Soir</th><th>av-coucher</th><th>unité</th><th>Durée</th></tr>";
                for($i=0; $i < count($lignes); $i++) {
                $resultats = DB::table('cosac_compo_subact')
                                ->join('sac_subactive as t0','t0.SAC_CODE_SQ_PK' , 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                ->select('t0.sac_nom','cosac_compo_subact.cosac_dosage','cosac_compo_subact.cosac_unitedosage')
                                ->where('cosac_compo_subact.cosac_sp_code_fk_pk' , $lignes[$i]['med_sp_id'])
                                ->get();
                $dci="";
                foreach ($resultats as $key => $resultat) {
                $dci.= $resultat->sac_nom." ". $resultat->cosac_dosage .$resultat->cosac_unitedosage.( ($key == (count($resultats)-1)) ? '.' : '/' );
                }
            @endphp
             <tr>
                <td><input type='hidden' name='lignes_id[]' value={{ $lignes[$i]['id'] }}>{{ $dci }}</td>
                <td> {{ $lignes[$i]['voie'] }}                                                                                                                                                    </td>
                <td> {!! (isset($lignes[$i]['dose']              )) ? $lignes[$i]['dose'] : "0"                                                                                                !!}</td>
                <td> {!! (isset($lignes[$i]['dose_matin']        )) ? "<i class='fa  fa-check-circle ' style='color: green;font-size: 22px;'></i><b>".$lignes[$i]['repas_matin']."</b>" : "/"  !!}</td>
                <td> {!! (isset($lignes[$i]['dose_midi']         )) ? "<i class='fa  fa-check-circle ' style='color: green;font-size: 22px;'></i><b>".$lignes[$i]['repas_midi']."</b>": "/"    !!}</td>
                <td> {!! (isset($lignes[$i]['dose_soir']         )) ? "<i class='fa  fa-check-circle ' style='color: green;font-size: 22px;'></i><b>".$lignes[$i]['repas_soir']."</b>": "/"    !!}</td>
                <td> {!! (isset($lignes[$i]['dose_avant_coucher'])) ? "<i class='fa  fa-check-circle ' style='color: green;font-size: 22px;'></i>" : "/"                                       !!}</td>
                <td> {{ $lignes[$i]['unite'] }}                                                                                                                                                   </td>
                <td> {!! (isset($lignes[$i]['nbr_jours']         )) ? $lignes[$i]['nbr_jours']." jours" : "/"                                                                                  !!}</td>
            </tr>
            @php
            $ligne_prev =  $lignes[$i]['CATC_NOMF'];
            }
            @endphp
        </table>

        {{-- <div class="col-sm-4 bg-gray">
            <h3>Rapport Pharmacien</h3>
            @php
                $re = DB::table('educationtherapeutiques')
                    ->where('patient_id' ,$lignes[0]['patient_id'])
                    ->whereIn('date_et',function($query) {
                        $query->selectRaw('max(date_et)')
                            ->from('educationtherapeutiques')
                             ->groupBy('patient_id');
                     })->get();
                echo count($re) > 0 ? $re[0]->description : '';
            @endphp
        </div> --}} 

        <h3 class="pull-right">............................</h3>
        <h3 class="pull-right">    Signature : </h3>

            </div>
        </body>
        <script>
            window.print();
        </script>
    </html>