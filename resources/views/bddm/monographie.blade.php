@extends('bddm.layouts.model')
@section('meta_robot') index,follow @endsection
@section('title') {{ $result['medicament'] }} | HIC MEDIC @endsection
@section('description') {{ $result['medicament'] }} ({{ $result['dci'] }}) : fiche médicament  précisant la composition, la posologie, les indications @endsection
@section('og_title') {{ $result['medicament'] }} | HIC MEDIC @endsection
@section('og_description') {{ $result['medicament'] }} ({{ $result['dci'] }}) : fiche médicament  précisant la composition, la posologie, les indications @endsection
@section('url') {{url()->current()}} @endsection
@section('fb_meta')
      <meta property="fb:app_id" content="100800794638454">
      <meta property="fb:pages" content="100800794638454">  
@endsection

@section('content')
  <div class="row">
      
    <div class="col-sm-12 col-md-12 mt-1">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: white">
          <li class="breadcrumb-item"><a href="{{ route('medicaments.noms-commerciale') }}"><i class="fas fa-capsules"></i> Médicaments</a></li>
          <li class="breadcrumb-item active" aria-current="page">{{ $result['medicament'] }} </li>
        </ol>
      </nav>
        <button   title="Signaler un problème" type="button" class="btn btn-link btn-report" data-toggle="modal" data-target="#bug_report" ><i class="fa fa-bug"></i> Signaler !</button>
        
    </div>

    <div class="col-sm-12 col-md-6">
      <h3>{{ $result['medicament'] }} <span class="badge badge-danger">SP</span></h3>
      {!!  (isset($result['dci']) && !empty($result['dci']) ) ? '<p class="h6">' . $result['dci'] . ' <span class="badge badge-pill badge-success">DCI</span> </p>' : ''; !!}
      {!!  (!empty($result['cph']) ) ? '<p class="h6">' . $result['cph'] . ' <span class="badge badge-pill badge-warning">Classe</span> </p>' : ''; !!}
      {{-- <small>mise à jour : le 01/01/2001</small> --}}
    </div>

    <div class="bhoechie-tab-container col-md-11 col-sm-12 ml-md-3">
      
      <div class="a2a_kit a2a_kit_size_32 a2a_default_style" style="line-height: 32px; position: absolute; right: 0; top: -38px; /* float: right; */ z-index: 9999; padding-top: 2px;">
        <!-- AddToAny BEGIN -->
        <a class="a2a_dd a2a_dd1" href="https://www.addtoany.com/share" style="float: right;"></a>
        <a class="a2a_button_facebook"></a>
        <a class="a2a_button_twitter"></a>
        <a class="a2a_button_google_gmail"></a>
        <a class="a2a_button_whatsapp"></a>
        <a class="a2a_button_print"></a>
        <a class="a2a_button_outlook_com"></a>
        <a class="a2a_button_yahoo_mail"></a>
        <script>
        var a2a_config = a2a_config || {};
        a2a_config.onclick = 1;
        a2a_config.locale = "fr";
        </script>
        <script async src="https://static.addtoany.com/menu/page.js"></script>
        <!-- AddToAny END -->    
      </div> 

      <div class="row d-none d-md-flex justify-content-center">
        <div class="bhoechie-tab-menu col-md-3 col-sm-12">
          <div class="list-group">
            <a href="#" class="list-group-item text-center active" >
              <h4 class="fas fa-arrow-alt-circle-right fa-2x "></h4><br/>Indications
            </a>
            <a href="#" class="list-group-item text-center">
              <h4 class="fas fa-clock fa-2x "></h4><br/>Posologie/Administration
            </a>
            <a href="#" class="list-group-item text-center">
              <h4 class="fas fa-thermometer-three-quarters fa-2x  "></h4><br/>Contre Indication
            </a>
            <a href="#" class="list-group-item text-center">
              <h4 class="fas fa-thermometer-quarter fa-2x  "></h4><br/>Effets indésirables
            </a>
            {{-- <a href="#" class="list-group-item text-center">
              <h4 class="fas fa-thermometer-quarter fa-2x  "></h4><br/>Précaution d'emploi
            </a>  --}}                                               
          </div>
        </div>
        <div class="col-sm-9 bhoechie-tab">
            <!-- flight section -->
            <div class="bhoechie-tab-content active">
                <center>
                  <h1 class=" -plane" style="font-size:14em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Indications</h2>
                  <br>
                </center>
                <h3 style="color:#EC790C"> Types de maladies</h3>
                <table class="table table-sm table-striped">
                  @foreach ($result['indications'] as $indic)
                    <tr>
                      <td> {{$indic->cdf_nom}} </td>
                    </tr>
                  @endforeach
                </table>
            </div>
            <!-- train section -->
            <div class="bhoechie-tab-content">
                <center>
                  <h1 class=" -road" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Posologie(s)</h2>
                  <br>
                  
                </center>
                <table class="table table-borderless table-sm table-striped">
                  @foreach ($result['posologies'] as $key => $poso)
                    <tr>
                        <td><b>Protocole posologique N°{{$key+1}}</b></td>
                        <td></td>
                    </tr>
                    <tr>
                      @if ($poso->terrains)
                        <td>Cas Physiopathologique</td>
                        @php $terrains = explode(',' , $poso->terrains); @endphp
                          <td>
                            @foreach ($terrains as $terrain)
                              {{ $terrain }} <br/>
                            @endforeach
                          </td>
                      @endif
                    </tr>
                      <tr>
                        @if ($poso->indications)
                          <td>Indication</td>
                          @php $indications = explode(',' , $poso->indications); @endphp
                            <td>
                              @foreach ($indications as $indication)
                                {{ $indication }} <br/>
                              @endforeach
                            </td>
                        @endif

                      </tr>

                        @if ($poso->dose)
                      <tr>
                          <td>Dose {{ $poso->type}}</td>
                          <td>{{ $poso->dose}}</td>
                      </tr>
                        @endif

                        @if ($poso->frequence || $poso->cdf_comment_freq)
                      <tr>
                          <td>Fréquence {{ $poso->type}}</td>
                          <td>
                            {{$poso->frequence}}
                            {!! html_entity_decode($poso->cdf_comment_freq) !!}
                          </td>
                      </tr>
                        @endif

                        @if ($poso->duree || $poso->cdf_comment_duree)
                      <tr>
                          <td>Durée du traitement</td>
                          <td>
                            {{$poso->duree}}
                            <br/>
                            {!! html_entity_decode($poso->cdf_comment_duree) !!}
                          </td>
                      </tr>
                        @endif                            
                  @endforeach
                </table>
                <br>
            </div>

            <!-- hotel search -->
            <div class="bhoechie-tab-content">
                <center>
                  <h1 class=" -home" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Contres Indications</h2>
                  <br>
                  
                </center>
                <table class="table table-sm table-striped">
                  @foreach ($result['cis'] as $key => $ci)
                    <tr>
                      <td>@if ($key == '0') <b>Cas Physiopathologique:</b> @endif</td>
                      <td>@if ($key != '0') {{ $ci->terrain }} @endif</td>
                    </tr>
                  @endforeach
                </table>                     
            </div>
            <div class="bhoechie-tab-content">
                <center>
                  <h1 class=" -cutlery" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Effets indésirables</h2>
                  <br>
                  
                </center>

                <table class="table table-sm table-striped">
                  @foreach ($result['effets'] as $effet)
                    <tr>
                      <td> {{$effet->effet}} </td>
                    </tr>
                  @endforeach
                </table>
                     
            </div>
        </div>                
      </div>

    </div>
<div class="col-12 d-md-none bg-light">
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="indications-tab" data-toggle="tab" href="#indications" role="tab" aria-controls="indications" aria-selected="true">Indications</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="posologie-tab" data-toggle="tab" href="#posologie" role="tab" aria-controls="posologie" aria-selected="false">Posologie/Administration</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="ci-tab" data-toggle="tab" href="#ci" role="tab" aria-controls="ci" aria-selected="false">Contre indication</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="effets-tab" data-toggle="tab" href="#effets" role="tab" aria-controls="effets" aria-selected="false">Effets indésirables</a>
    </li>  
  </ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="indications" role="tabpanel" aria-labelledby="indications-tab">
                <center>
                  <h1 class=" -plane" style="font-size:14em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Indications</h2>
                  <br>
                </center>
                <h3 style="color:#EC790C"> Types de maladies</h3>
                <table class="table table-sm table-striped">
                  @foreach ($result['indications'] as $indic)
                    <tr>
                      <td> {{$indic->cdf_nom}} </td>
                    </tr>
                  @endforeach
                </table>
  </div>
  <div class="tab-pane fade" id="posologie" role="tabpanel" aria-labelledby="posologie-tab">
    
                    <center>
                  <h1 class=" -road" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Posologie(s)</h2>
                  <br>
                  
                </center>
                <table class="table table-borderless table-sm table-striped">
                  @foreach ($result['posologies'] as $key => $poso)
                    <tr>
                        <td><b>Protocole posologique N°{{$key+1}}</b></td>
                        <td></td>
                    </tr>
                    <tr>
                      @if ($poso->terrains)
                        <td>Cas Physiopathologique</td>
                        @php $terrains = explode(',' , $poso->terrains); @endphp
                          <td>
                            @foreach ($terrains as $terrain)
                              {{ $terrain }} <br/>
                            @endforeach
                          </td>
                      @endif
                    </tr>
                      <tr>
                        @if ($poso->indications)
                          <td>Indication</td>
                          @php $indications = explode(',' , $poso->indications); @endphp
                            <td>
                              @foreach ($indications as $indication)
                                {{ $indication }} <br/>
                              @endforeach
                            </td>
                        @endif

                      </tr>

                        @if ($poso->dose)
                      <tr>
                          <td>Dose {{ $poso->type}}</td>
                          <td>{{ $poso->dose}}</td>
                      </tr>
                        @endif

                        @if ($poso->frequence || $poso->cdf_comment_freq)
                      <tr>
                          <td>Fréquence {{ $poso->type}}</td>
                          <td>
                            {{$poso->frequence}}
                            {!! html_entity_decode($poso->cdf_comment_freq) !!}
                          </td>
                      </tr>
                        @endif

                        @if ($poso->duree || $poso->cdf_comment_duree)
                      <tr>
                          <td>Durée du traitement</td>
                          <td>
                            {{$poso->duree}}
                            <br/>
                            {!! html_entity_decode($poso->cdf_comment_duree) !!}
                          </td>
                      </tr>
                        @endif                            
                  @endforeach
                </table>
                <br>
  </div>
  <div class="tab-pane fade" id="ci" role="tabpanel" aria-labelledby="ci-tab">
                    <center>
                  <h1 class=" -home" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Contres Indications</h2>
                  <br>
                  
                </center>
                <table class="table table-sm table-striped">
                  @foreach ($result['cis'] as $key => $ci)
                    <tr>
                      <td>@if ($key == '0') <b>Cas Physiopathologique:</b> @endif</td>
                      <td>@if ($key != '0') {{ $ci->terrain }} @endif</td>
                    </tr>
                  @endforeach
                </table>   
  </div>
  <div class="tab-pane fade" id="effets" role="tabpanel" aria-labelledby="effets-tab">
    
                        <center>
                  <h1 class=" -road" style="font-size:12em;color:#EC790C"></h1>
                  <h2 style="margin-top: 0;color:#EC790C">Posologie(s)</h2>
                  <br>
                  
                </center>
                <table class="table table-borderless table-sm table-striped">
                  @foreach ($result['posologies'] as $key => $poso)
                    <tr>
                        <td><b>Protocole posologique N°{{$key+1}}</b></td>
                        <td></td>
                    </tr>
                    <tr>
                      @if ($poso->terrains)
                        <td>Cas Physiopathologique</td>
                        @php $terrains = explode(',' , $poso->terrains); @endphp
                          <td>
                            @foreach ($terrains as $terrain)
                              {{ $terrain }} <br/>
                            @endforeach
                          </td>
                      @endif
                    </tr>
                      <tr>
                        @if ($poso->indications)
                          <td>Indication</td>
                          @php $indications = explode(',' , $poso->indications); @endphp
                            <td>
                              @foreach ($indications as $indication)
                                {{ $indication }} <br/>
                              @endforeach
                            </td>
                        @endif

                      </tr>

                        @if ($poso->dose)
                      <tr>
                          <td>Dose {{ $poso->type}}</td>
                          <td>{{ $poso->dose}}</td>
                      </tr>
                        @endif

                        @if ($poso->frequence || $poso->cdf_comment_freq)
                      <tr>
                          <td>Fréquence {{ $poso->type}}</td>
                          <td>
                            {{$poso->frequence}}
                            {!! html_entity_decode($poso->cdf_comment_freq) !!}
                          </td>
                      </tr>
                        @endif

                        @if ($poso->duree || $poso->cdf_comment_duree)
                      <tr>
                          <td>Durée du traitement</td>
                          <td>
                            {{$poso->duree}}
                            <br/>
                            {!! html_entity_decode($poso->cdf_comment_duree) !!}
                          </td>
                      </tr>
                        @endif                            
                  @endforeach
                </table>
  </div>
</div>
</div>

  </div>
@endsection

@section('js_scripts')

<script>
$(document).ready(function() {
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
});    
</script>

@endsection

