@extends('layouts.model')
@section('script_css')

    <link rel="stylesheet" href="{{ asset('/plugins/iCheck/all.css')}}">
     <link rel="stylesheet" href="{{ asset('/plugins/toastr/toastr.css')}}">
     <meta name="csrf_token" content="{{ csrf_token() }}">

@endsection

@section('content')
   <style>  
 .swal2-popup {
  font-size: 1.6rem !important;
}

    table, th, td {
            border: 0.5px solid black;
        }

        
    .sectiontitle {
      background-position: center;
      margin: 30px 0 0px;
      text-align: center;
      min-height: 20px;
    }

    .sectiontitle h2 {
      font-size: 40px;
      color: #545454;
      margin-bottom: 0px;
      padding-right: 10px;
      padding-left: 10px;
    }
    
  .control__indicator {
        position: absolute;
        top: 2px;
        left: 0;
        height: 20px;
        width: 20px;
        background: #e6e6e6;
}


    .headerLine {
      width: 160px;
      height: 2px;
      display: inline-block;
      background: #101F2E;
    }
      .number {
      background-position: center;
      
      text-align: center;
      font-size: 50px;
    }
     .t {
      background-position: center;
      
      text-align: center;
      font-size: 18px;
    }

    


.projectFactsWrap{
    display: flex;
  margin-top: 30px;
  flex-direction: row;
  flex-wrap: wrap;
    color :  #565656;
}




.projectFactsWrap .item{
  width: 20%;
  height: 100%;
  padding: 20px 0px;
  text-align: center;
    color :  #565656;
}

.projectFactsWrap .item:nth-child(1){
  background: #e1e6ef;
  position: relative;
  top: -40px;
  left: 100px;
}

.projectFactsWrap .item:nth-child(2){
  background: #e1e6ef;
 
  position: relative;
  top: -40px;
  left: 200px;
 

}

.projectFactsWrap .item:nth-child(3){
  background: #e1e6ef;
  position: relative;
  top: -40px;
  left: 300px;

}



.projectFactsWrap .item p.number{
  font-size: 40px;
  padding: 0;
  font-weight: bold;
  color: #000000;
}

.projectFactsWrap .item p{
  color: rgba(255, 255, 255, 0.8);
  font-size: 18px;
  margin: 0;
  padding: 5px;
  font-family: 'Open Sans';
  color :  #565656;
}


.projectFactsWrap .item span{
  width: 40px;
  height: 1px;
  display: block;
  margin: 0 auto;
    background :  #565656;

}


.projectFactsWrap .item i{
  vertical-align: middle;
  font-size: 25px;
  
    color :  #565656;
}


.projectFactsWrap .item:hover i, .projectFactsWrap .item:hover p{
  color :  #565656;
}

.projectFactsWrap .item:hover span{
  color :  #565656;
}


table {
  border: 2px solid #ccc;
  border-collapse: collapse;
  margin: 0;
  padding: 0;
  width: 100%;
  table-layout: fixed;
}



table tr {
  background-color: #f8f8f8;
  border: 1px solid #ddd;
  padding: .35em;
}

table th,
table td {
  padding: .625em;
  text-align: center;
}

table th {
  font-size: .85em;
  letter-spacing: .1em;
  text-transform: uppercase;
}

@media screen and (max-width: 600px) {
  table {
    border: 0;
  }

  table caption {
    font-size: 1.3em;
  }
  
  table thead {
    border: none;
    clip: rect(0 0 0 0);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
  }
  
  table tr {
    border-bottom: 3px solid #ddd;
    display: block;
    margin-bottom: .625em;
  }
  
  table td {
    border-bottom: 1px solid #ddd;
    display: block;
    font-size: .8em;
    text-align: right;
  }

  
  
  table td::before {
    /*
    * aria-label has no advantage, it won't be read inside a table
    content: attr(aria-label);
    */
    content: attr(data-label);
    float: left;
    font-weight: bold;
    text-transform: uppercase;
  }
  
  table td:last-child {
    border-bottom: 0;
  }


    </style>


    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
          <div class="row">
                    <div class="col-sm-12 ">

          <!-- jQuery Knob -->
          <button type="button" class="btn  btn-primary">Modifier</button>
          <button type="button" class="btn btn-default" onclick="deleteLigne({{$protocole->id}})">Supprimer</button>
          <button type="button" onclick="javascript:history.back();" class="btn  btn-secondary">Retour</button>
          <div class="clearfix" style="float: right; width: 35%">
                <div class="breadcrumb" >
                     <b><img src="{{asset('/images/741.png')}}" style="width: 3%"> Protocole créer par {{DB::table('users')->where('id',$protocole->user_id)->pluck('name')->first()}} le {{ $protocole->created_at}}</b>                   
                 </div>           
              </div>
              
          <div class="box box-solid">
            <div class="box-header">
                <div class="sectiontitle">
                <h2>{{$protocole->nom}}</h2>
                <span class="headerLine"></span>
            </div> <br>
            
                 
  <div class="col-sm-1"> </div>
<div class="col-sm-11">
    <div class="fullWidth eight columns">
        <div class="projectFactsWrap ">
            <div class="item wow fadeInUpBig animated animated" data-number="12" style="visibility: visible;">
               
                <p id="number1" class="number">{{$protocole->nbr_sequence }}</p>
                <span></span>
                <p>Séquences</p>
            </div>
            
            <div class="item wow fadeInUpBig animated "style="visibility: visible;">

                <p id="number3" class="number">{{$protocole->nbrcure_min}}-{{$protocole->nbrcure_max}}</p>
                <span></span> 
                <p>Cures</p>
            </div>
            <div class="item wow fadeInUpBig animated animated" data-number="246" style="visibility: visible;">
               
                <p id="number4" class="number">{{$protocole->intervalle_cure}} j</p>
                <span></span>
                <p>Repos</p>
            </div>
        </div>
    </div>
</div>

<div class="panel-body">
                  @if($protocole->remarque != null)
                    <p class="text-muted" style="font-weight : bolder; color: green;">{{$protocole->remarque}}</p>
                  @endif
                    
                      <table>
                      <thead>
                        <tr>
                        <th style="width: 10%">Etape</th>
                        <th style="width: 30%">Médicaments</th>
                        <th style="width: 20%">Voies</th>
                        <th style="width: 10%">Posologie</th>
                         @foreach ($sequence as $s)
                           <th>j {{$s->jour}}</th>
                          @endforeach

                        </tr>
                      </thead>
                      <tbody>
                       @if ($premedicament->isNotEmpty())
                     
                        @foreach ($premedicament as $key=>$p)
                        
                         <tr id="prem{{$key}}" onmouseover="colorr({{$key}})" onmouseout="noncolorr({{$key}})" onclick="affiche('{{$p->solvant}}','{{$p->commentaire}}')" style="cursor: pointer;">
                          @if ($loop->first)
                            <td id="none" rowspan="{{$premedicament->count()}}">Prémidication</td>
                          @endif
                            <td>{{DB::table('sp_specialite')->where('SP_CODE_SQ_PK',$p->sp_id)->pluck('SP_NOM')->first()}}</td>
                            <td>{{$p->voie}}</td>
                            <td><b>{{$p->posologie}} </b>{{$p->u1}} / {{$p->u2}}</td>
                            <?php $tmp = collect(); ?>
                            @foreach ($collection as $cc)
                              @if($p->sp_id == $cc->sp_id)   
                                @foreach ($sequence as $s)
                                  @if($cc->sequencetype_id == $s->id)
                                    <?php
                                     //sauvgarder jour sequence
                                     //break;               
                                      $tmp->put($s->id,$s->jour);
                                      break;
                                    ?>                     
                                  @endif 
                                 @endforeach
                              @endif 
                            @endforeach
                            @foreach ($sequence as $s)
                              <?php 
                              //if s->jour == [] cheker 
                              //else non
                                if ($tmp->contains($s->jour)) { ?>
                                  <td>
                                   <img src="{{asset('/images/741.png')}}" style="width: 10%">                               
                                  </td>
                                <?php } 
                                else{ ?>
                                 <td>
                                  <img src="{{asset('/images/85.png')}}" style="width: 10%">
                                  </td>
                               <?php } ?>
                            @endforeach                     
                           </tr>
                        @endforeach
                     
                        @endif 
                        
                          @if ($traitement->isNotEmpty())
                        @foreach ($traitement as $key=>$t)
                         <tr id="prem{{$key}}" onmouseover="colortrait({{$key}})" onmouseout="noncolortrait({{$key}})" style="cursor: pointer;" style="cursor: pointer;" onclick="affiche('{{$t->solvant}}','{{$t->commentaire}}')">
                          @if ($loop->first)
                            <td id="nonetrait" rowspan="{{$traitement->count()}}">Traitement</td>
                          @endif
                            <td>{{DB::table('sp_specialite')->where('SP_CODE_SQ_PK',$t->sp_id)->pluck('SP_NOM')->first()}}</td>
                            <td>{{$t->voie}}</td>
                            <td><b>{{$t->posologie}} </b>{{$t->u1}} / {{$t->u2}} / {{$t->u3}}</td>
                            <?php $tmp = collect(); ?>
                            @foreach ($collection as $cc)
                              @if($t->sp_id == $cc->sp_id)   
                                @foreach ($sequence as $s)
                                  @if($cc->sequencetype_id == $s->id)
                                    <?php
                                     //sauvgarder jour sequence
                                     //break;               
                                      $tmp->put($s->id,$s->jour);
                                      break;
                                    ?>                     
                                  @endif 
                                 @endforeach
                              @endif 
                            @endforeach
                            @foreach ($sequence as $s)
                              <?php 
                              //if s->jour == [] cheker 
                              //else non
                                if ($tmp->contains($s->jour)) { ?>
                                  <td>
                                    <img src="{{asset('/images/741.png')}}" style="width: 10%">                           
                                  </td>
                                <?php } 
                                else{ ?>
                                 <td>
                                  <img src="{{asset('/images/85.png')}}" style="width: 10%">
                                  </td>
                               <?php } ?>
                            @endforeach                     
                           </tr>
                        @endforeach
                        @endif 
                      </tbody>
                      </table>
                </div>
              </div></div></div></div>
            </section>
        </div>
            <!-- /.box-body -->
            <!-- modal info-->
<div class="modal fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">DÉTAIL</h4>
              </div>           
              <div class="modal-body">
                <div class="box-body">
                  <div class="col-sm-12">
                          <label class=" control-label" >Solvant</label>
                               <textarea name="" id="solvant" class="col-xs-12 col-md-12" disabled></textarea> <br><br>
                               <br><br><label class=" control-label" >Commentaire</label>
                               <textarea name="" id="commentaire" class="col-xs-12 col-md-12" disabled></textarea>
                          </div>
                  </div>
              </div>
              
              <div class="modal-footer">
                 <input id="b" type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">
              </div>      
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>  
           
@stop
@section('script')

<script src="{{asset('plugins/sweetAlert/sweetalert.js')}}"></script>

<script type="text/javascript">
  function colorr(id){

    document.getElementById("prem"+id).style.backgroundColor = "lightblue";
    document.getElementById("none").style.backgroundColor = "lightblue";
  }
  function noncolorr(id){
    document.getElementById("prem"+id).style.backgroundColor = "";
    document.getElementById("none").style.backgroundColor = "";
  }
  function colortrait(id){
     document.getElementById("prem"+id).style.backgroundColor = "lightblue";
    document.getElementById("nonetrait").style.backgroundColor = "lightblue";
  }
  function noncolortrait(id){
    document.getElementById("prem"+id).style.backgroundColor = "";
    document.getElementById("nonetrait").style.backgroundColor = "";
  }
  function affiche(solvant,commentaire){
    //alert(commentaire);
    var myModal = $('#modal-info');
    document.getElementById('solvant').value = solvant; 
    document.getElementById('commentaire').value=commentaire; 
    myModal.modal({ show: true });

  }
  //delete protocole
  function deleteLigne(id){
Swal.fire({
    backdrop: `
    rgba(255,0,0,0.4)
  `,
  title: 'Êtes-vous sûr?',
  text: "Vous ne pourrez pas revenir en arrière!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, supprimez-le!',
  cancelButtonText:'Annuler'

}).then((result) => {
  if (result.value) {
        $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/chimio/protocole/"+id,
                method : "POST",              
                success: function(data){                  
                  Swal.fire({
                    title:'Supprimé!',
                    text:'Le protocole a été supprimé..',
                    type:'success',
                     onClose :function () {
                         location.href = '{{(route('listProtocole'))}}';
                      }
                  }                   
                  )           
                },
                error: function(data){
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Quelque chose a mal tourné!'
                    })
                  }
              }); 
  }
})
  }
  
</script>


@stop
