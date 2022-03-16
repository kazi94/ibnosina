<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" media="screen"  />
<link rel="stylesheet" type="text/css" media="print"  />
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap/dist/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css')}}">
    <link rel="stylesheet" href="{{ asset('css/Ionicons/css/ionicons.css')}}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css')}}">
    <title>Prescription</title>
</head>
<body>

<div class="container-fluid">
    
    <table class="table table-condensed">
                <img src="{{ asset('/images/logo_chut.png')}}" alt="Chu Tlemcen"  style="position: absolute; width: 100px; height: 100px;
    top: -10px;
    right: 44px" / >
        <tr><td><u><b>Médecin :</b></u>{{ $prescription[0]->name}} {{$prescription[0]->prenom}} </td>   <td class="float-right"><u><b>Date prescription :</b></u>{{ $prescription[0]->date_prescription}} </td></tr>

        <tr><td><u><b>tel: </b></u>{{$prescription[0]->num1}}</td>   <td class="float-right"><u><b>Hopital :</b></u>{{ $prescription[0]->hopital}}  </td></tr>

        <tr><td><u><b>Adresse :</b></u>{{$prescription[0]->add}}</td>   <td class="float-right"><u><b>Service :</b></u>{{ $prescription[0]->service}} </td></tr>
        
        <tr><td><u><b>Spécialité :</b></u>  {{ $prescription[0]->specialite}}</td>   </tr>
        
        <tr><td><u><b>Patient :</b></u>  {{ $prescription[0]->p_nom}} {{ $prescription[0]->p_prenom}}</td>   </tr>
        <tr><td><u><b>Date de naissance :</b></u>  {{ $prescription[0]->dn}}</td>   </tr>
        <tr><td><u><b>Poids :</b></u>{{$prescription[0]->poids}}  </td>   </tr>


    </table>

    <br/>

    <table class="table table-bordered">
        <thead>
            <tr class="alert alert-info">
                <th>Médicament</th>
                <th>Prise</th>
                <th>Matin</th>
                <th>Midi</th>
                <th>Soir</th>
                <th>Avant coucher</th>
                <th>Pendant:</th>
            </tr>
        </thead>
        @php
            $r = DB::table('ligneprescriptions')
                    ->where('prescription_id',$prescription[0]->p_id)
                    ->select('ligneprescriptions.*')
                    ->get();
        @endphp 
        @foreach ($r  as $val)
            <tr>
                <td>
                    @php
                        $resultats = DB::table('cosac_compo_subact')
                                    ->join('sac_subactive as t0','t0.SAC_CODE_SQ_PK' , 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                    ->select('t0.sac_nom','cosac_compo_subact.cosac_dosage','cosac_compo_subact.cosac_unitedosage')
                                    ->where('cosac_compo_subact.cosac_sp_code_fk_pk' , $val->med_sp_id)
                                    ->get();
                        foreach ($resultats as $key => $resultat) {
                            echo $resultat->sac_nom." ". $resultat->cosac_dosage .$resultat->cosac_unitedosage.( ($key == (count($resultats)-1)) ? '.' : '/' ); 
                        }
                    @endphp
                </td>
                <td>
                    @if ($val->dose_matin)
                        {{ $val->dose_matin }} 
                    @elseif ($val->dose_midi)
                        {{$val->dose_midi}}
                        @elseif ($val->dose_soir)
                        {{$val->dose_soir}}
                        @else 
                        {{$val->dose_avant_coucher}}
                    @endif
                     {{ $val->unite }}</td>
                <td>  @if ($val->dose_matin) <i class="fa  fa-check-circle " style="color: green;font-size: 22px;"></i> {{$val->repas_matin}}  @endif</td>
                <td> @if ($val->dose_midi) <i class="fa  fa-check-circle " style="color: green;font-size: 22px;"></i> {{$val->repas_midi}} @endif </td>
                <td> @if ($val->dose_soir)      <i class="fa  fa-check-circle " style="color: green;font-size: 22px;"></i> {{$val->repas_soir}} @endif </td>
                <td> @if ($val->dose_avant_coucher)<i class="fa  fa-check-circle " style="color: green;font-size: 22px;"></i> @endif </td>
                <td> {{$val->nbr_jours}}j </td>
            </tr>
        @endforeach
    </table>
    <div class="col-sm-4 pull-right"><h3>Signature : ......................</h3></div>
</div>
</body>
<script src="{{ asset('plugins/jquery/js/jquery.js')}}"></script>
<script type="text/javascript">
    $(window).on("load",function(){
        window.print();
    });
</script>
</html>