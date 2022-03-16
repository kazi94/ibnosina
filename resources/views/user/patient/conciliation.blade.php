<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" media="screen"  />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" type="text/css" media="print"  />
        <link rel="stylesheet" href="{{ asset('/lugins/bootstrap/dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css')}}">
        <link rel="stylesheet" href="{{ asset('css/Ionicons/css/ionicons.css')}}">
        <link rel="stylesheet" href="{{ asset('css/AdminLTE.css')}}">
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
            <form class="form-group" role="form" method="POST" action="{{ route('prescription.update',$lignes[0]['patient_id']) }}">
                {{  csrf_field() }}
                {{ method_field('PATCH') }}
                <table class="">
                    @php
                    $ligne_prev = "";
                    for($i=0; $i < count($lignes); $i++) {
                    if($lignes[$i]['CATC_NOMF'] != $ligne_prev) {
                    echo "<tr class='bg-gray'><th colspan='9' class='text-center'>".$lignes[$i]['CATC_NOMF']."</th></tr>";
                    echo "<tr class='alert' style='text-align-last: center;'><th colspan='1'>Medicament</th><th colspan='1'>Voie</th><th colspan='1'>Prise</th><th colspan='1'>Matin</th><th colspan='1'>Midi</th><th colspan='1'>Soir</th><th colspan='1'>av-coucher</th><th colspan='1'>unité</th><th colspan='1'>Durée</th></tr>";
                    }
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
                        "<td><input type='hidden' name='patient_id[]' value='".$lignes[0]['patient_id']."'><input type='hidden' name='lignes_id[]' value='".$lignes[$i]['id']."'>".$dci."</td>".
                        "<td>".$lignes[$i]['voie']."</td>".
                        "<td>".($lignes[$i]['dose'] ?: "/")."</td>".
                        "<td style='text-align: center'>".(($lignes[$i]['dose_matin']  != '0') ? "<select class='form-control' name='repas_matin[]'><option></option><option>Avant</option><option>Aprés</option><option>Pendants</option></select>" : "/" ). "</td>".
                        "<td style='text-align: center'>".(($lignes[$i]['dose_midi']   != '0') ? "<select class='form-control' name='repas_midi[]'><option></option><option>Avant</option><option>Aprés</option><option>Pendants</option></select>"  : "/" ). "</td>".
                        "<td style='text-align: center'>".(($lignes[$i]['dose_soir']   != '0') ? "<select class='form-control' name='repas_soir[]'><option></option><option>Avant</option><option>Aprés</option><option>Pendants</option></select>"  : "/" ). "</td>".
                        "<td style='text-align: center'>".(($lignes[$i]['dose_avant_coucher'] != '0') ? "<i class='fa  fa-check-circle ' style='color: green;font-size: 22px;'>" : "/")."</td>".
                        "<td>".$lignes[$i]['unite']."</td>".
                        "<td>".$lignes[$i]['nbr_jours']."jours</td>".
                    "</tr>";
                    $ligne_prev =  $lignes[$i]['CATC_NOMF'];
                    }
                    @endphp
                </table>
{{--                 <div class="col-sm-4 bg-gray">
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
                </div> --}}
                <input type="submit" value="Modifer" class="btn btn-primary pull-right">
            </form>
                {{-- <a href="{{ route('patient.print_conciliation' , $lignes[0]['patient_id']) }}"> --}}
                    <button data-toggle="modal" data-target="#modal_transfert" class="btn btn-default pull-right" id="exitPatient">Confirmer</button>
        </div>

    <!-- Modal transfert -->    
   <div class="modal fade in" id="modal_transfert">
        <div class="modal-dialog modal-sm modal-dialog-centered" style="">
            <div class="modal-content">
                <div class="modal-body">
                    <form action="{{ route('patient.print_conciliation' , $lignes[0]['patient_id']) }}" method="POST">
                        {{ method_field('PUT') }}
                        {{ csrf_field() }}
                        <textarea class="form-control" rows="3"  placeholder="commentaire pour la fiche de conciliation"></textarea>
                        <div class="">
                            <select class="form-control" onchange="this.value =='Vers le service' ?  $('#service').removeAttr('disabled') : $('#service').attr('disabled' ,'true').val('');" name="exit">
                                <option>Vers la sortie</option>
                                <option value="Vers le service">Vers le service</option>
                                
                            </select>
                            <input type="text" name="service" id="service" placeholder="Service..."  class="form-control" disabled />
                            <input type="date" name="date_sortie" class="form-control"/>
                            <select class="form-control">
                                
                                <option>Mr.médecin 1</option>
                                <option>Mr.médecin 2</option>
                                
                            </select>
                        </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
                            <button type="submit" class="btn btn-primary">Confirmer</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>        
    </body>
    <script src="{{ asset('plugins/jquery/js/jquery.js')}}"></script>
        <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}">             </script>
    
    <script type="text/javascript">
        $(function() {
            // $("#exitPatient").click(function(event) {

            // });
        });
    </script>
</html>