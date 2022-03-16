@extends('layouts.model')
@section('script_css')
 <link rel="stylesheet" href="{{ asset('/plugins/bootstrap-tagsinput.css') }}">
  <link rel="stylesheet" href="{{ asset('/plugins/typeaheadjs.css') }}">

<style type="text/css">
  .isa_info {
    color: #00529B;
    background-color: #BDE5F8;
    padding: 0.9em;
    text-align: center;
}
.isa_error {
    color: #D8000C;
    background-color: #FFD2D2;
     padding: 0.9em;
    text-align: center;
}
.swal2-popup {
  font-size: 1.6rem !important;
}
</style>
<meta name="csrf_token" content="{{ csrf_token() }}">

@endsection

@section('content')
   <style>  

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
    
    

    .headerLine {
      width: 160px;
      height: 2px;
      display: inline-block;
      background: #101F2E;
    }
    .lol {
      background: lightblue;
      padding: 0.4em;
    }
    .lol2 {
     background-color: #F2FF81;
     color: black;
      padding: 0.4em;


      }
  
    </style>

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
           <div class="row">
                    <div class="col-sm-12 ">
          @if($protocoles->isNotEmpty())
         <button type="button" class="btn btn btn-primary" data-toggle="modal" data-target="#modal-default">
                Ajouter une maladie
              </button>
              @endif
              <a type="button" class="btn  btn-default" href="{{(route('listProtocole'))}}">Lister les protocoles</a>
              <a type="button" class="btn  btn-default" href="{{route('para')}}">Paramètre général</a>

               

     
          <!-- jQuery Knob -->
          <div class="box box-solid">

        
            <div class="box-header">
             
                <div class="sectiontitle">
                <h2>List maladie de chimiothérapie</h2>
                <span class="headerLine"></span>
            </div><br>
                 <div class="row">
                   <div class="col-sm-12 ">
                    @if($protocoles->isEmpty())
                        <div class="isa_error" style="text-align: center; width: 80%;position: relative; left: 10%">
                         <h4><i class="fa fa-times-circle"></i> Aucun protocole de chimiothérapie trouvé veuillez <a href="{{(route('protocole.index'))}}">ajouter un</a></h4>
                      </div>
                      <br>
                      @elseif($col->isEmpty() && $protocoles->isNotEmpty())
                     
                        <div class="isa_info" style="width: 80%; text-align: center;position: relative; left: 10%">
                          <h4><i class="fa fa-info-circle"></i> Aucune maladie de chimiothérapie trouvé veuillez ajouter une</h4>
                          
                      </div>
                      <br>
                        
                        @else
                    <div class="col-sm-12 ">
                        <div class="box-body table-responsive no-padding">
                            <table id="t_protocole" class="table table-responsive text-center dataTable table table-hover" aria-describedby="t_protocole">
                                <thead>
                                    <tr class="alert alert-info">

                                        <th style="width: 5%">#</th>
                                        <th style="width: 20%">NOM DE LA MALADIE</th>
                                        <th style="width: 40%">PROTOCOLES</th>
                                        <th style="width: 50%">STADE</th>
                                        <th style="width: 5%">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($col as $cle => $valeur)
                                    @php $m = $loop->index; @endphp
                                     <tr>
                                        <th>{{$cle}}</th>
                                        <td id="nom_path">{{DB::table('pathologies')->where('id',$cle)->pluck('pathologie')->first()}}</td>

                                        <td>
                                          @foreach($valeur as $p)
                                          <a class="lol" href="{{route('detailProtocole',$p->protocole_id) }}">
                                            {{DB::table('protocole')->where('id',$p->protocole_id)->pluck('nom')->first()}}
                                          </a>
                                           &nbsp;
                                          @endforeach
                                        </td>
                                        <td>

                                          @foreach($col2 as  $valeur2)
                                           @if($loop->index == $m )
                                            @foreach($valeur2 as $v)
                                              <d class="lol2" style="cursor: pointer;">
                                                {{$v->stade_chimios_id}}
                                              </d>
                                               &nbsp;
                                               @endforeach
                                               @endif
                                          @endforeach
                                        </td>


                                        <td>        
                                            
                                          <span class="glyphicon glyphicon-edit" style="cursor: pointer" onclick="editData(this,'{{$cle}}')"></span>
                                      
                                    
                                            <span class="glyphicon glyphicon-trash" style="color: red; cursor: pointer" onclick="deleteData('{{$cle}}')"></span>
                                                                                
                                        </td>
                                     </tr>
                                     @endforeach
                                
                                    
                                 </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                </div>
              </div>
          

            </section>

        </div>
            <!-- /.box-body -->
          



        <div class="modal fade" id="modal-default">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">AJOUTER UNE MALADIE</h4>
              </div>
              <form action="{{ route('addMaladie') }}" method="post" id="addMaladie">
                            {{ csrf_field() }}
              <div class="modal-body">
                
                <div class="box-body">
                 

                <div class="form-group">
                  <label class="col-sm-2 control-label">Nom </label>
                  <div class="col-sm-10">
                    <input type="text" name="nom" class="form form-control"  placeholder="Nom de la maladie" id="maladie_nom" autocomplete="off" required>
                  </div>
                </div>
                <br><br>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Protocoles</label>
                  <div class="col-sm-10">
                   <select class="form-control select2" id="bla" name ="protocoles[]" multiple="multiple"  placeholder="dsdsd" style="width: 100%;"  required>
                    @foreach($protocoles as $pro)
                        <option value="{{$pro->id}}">{{$pro->nom}}</option>
                    @endforeach
                  </select>
                  </div>
                </div> <br><br>
                <div class="form-group">
                     <label class="col-sm-2 control-label">Stades</label>
                     <div class="col-sm-10">
                 <input type="text"  data-role="tagsinput" name="stade[]" class="form form-control tags"  placeholder="Ajouter Stade pour la maladie"  >
                 <input type="hidden" name="tagss" id="tagss" >
           

               </div>
               </div>
                 
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Annuler</button>

                 <input id="b" type="button" class="btn btn-primary" value="Sauvegarder">
              </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>  


        <div class="modal fade" id="modal-edit">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">MODIFIER</h4>
              </div>
              <form action="{{ route('addMaladie') }}" method="post" id="editMaladie">
                            {{ csrf_field() }}
              <div class="modal-body">   
                <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-2 control-label">Nom</label>
                  <div class="col-sm-10">
                    <input type="text" name="nom" class="form form-control nom"  placeholder="Nom de la maladie" id="maladie_nom" autocomplete="off" required>
                     <input type="hidden" name="nomM" id="nomM" required>
                  </div>
                </div>
                <br><br>
                <div class="form-group">
                  <label class="col-sm-2 control-label">Protocoles</label>
                  <div class="col-sm-10">
                   <select class="form-control select2 select2-hidden-accessible" name ="protocoles[]" multiple="" id="protocole_path" data-placeholder="selectionner les protocoles" style="width: 100%;" tabindex="-1" aria-hidden="true" required>
                    @foreach($protocoles as $pro)
                        <option value="{{$pro->id}}">{{$pro->nom}}</option>
                    @endforeach
                  </select>
                  </div>
                </div><br><br>
                 <div class="form-group">
                     <label class="col-sm-2 control-label">Stades</label>
                     <div class="col-sm-10">
                 <input type="text"    value=""  name="stadee[]"  class="form form-control tagss"  placeholder="Ajouter Stade pour la maladie"  >
                 <input type="hidden" name="tagsss" id="tagsss" >
           

               </div>
               </div>
              </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Annuler</button>
                 <input id="b" type="submit" class="btn btn-primary" value="Sauvegarder">
              </div>
     </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>  

       
@stop
@section('script')

<script src="{{asset('plugins/bootstrap-tagsinput.js')}}"></script>

<script src="{{asset('plugins/typeahead.bundle.js')}}"></script>
<script src="{{asset('plugins/sweetAlert/sweetalert.js')}}"></script>
<script src="{{ asset('plugins/toastr/toastr.js')}}"></script>

<script type="text/javascript">
  //tags
var tags = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  // url points to a json file that contains an array of country names, see
  // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
  prefetch: {
    url :"/tags",
    cache:false
  }
});
tags.initialize();

$('.tags').tagsinput({
  typeaheadjs: {
    name: 'stade_chimios_id',
    source: tags.ttAdapter()
  }
});
//edit 
var emm = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  // url points to a json file that contains an array of country names, see
  // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
  prefetch: {
    url :"/tags",
    cache:false
  }
});
emm.initialize();

$('.tagss').tagsinput({
  typeaheadjs: {
    name: 'stade_chimios_id',
    source: emm.ttAdapter()
  }
});
  $("#bla").select2({
    placeholder: "Select a state",
    allowClear: true
});

  //edit data
  function editData(btn,id){
    //console.log(btn.closest('tr').children());
    var trr = btn.closest('tr');
    //console.log(trr.children[1].innerText);
    var nom_path_tr = trr.children[1].innerText;
  
    var select_opt = $('#protocole_path');

        var myModal = $('#modal-edit');
            $.ajax({          
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url : "/chimio/listMaladie/info/"+id,
                method :'post',
                datatype : 'json',
                success : (data) => {
                  var opts = new Array();
                  data.forEach(function(d) {
                    opts.push(d.id);
                  });
                  //console.log(opts);
                  select_opt.val(opts).trigger('change'); 
                   $.ajax({          
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url : "/chimio/listMaladie/info/tag/"+id,
                    method :'post',
                    datatype : 'json',
                    success : (data) => {
                      console.log(data);
                     // document.getElementById("po").value = "FR";
                     $('.tagss').val("o").trigger('change');
                      
                      //alert(Object.values(Object.values(data)[0])[0]);
                      //myModal.find('input[id="po"]').attr('value',"hah");
                      
                    },
                    error:function (jqXHR, textStatus) {
                        //console.log( "Request failed: " + textStatus +" "+jqXHR );
                        Swal.fire({
                                  type: 'error',
                                  title: 'Oops...',
                                  text: 'erreur 500 stades '
                                })
                    }
                }); 
                },
                error:function (jqXHR, textStatus) {
                    //console.log( "Request failed: " + textStatus +" "+jqXHR );
                    Swal.fire({
                              type: 'error',
                              title: 'Oops...',
                              text: 'Quelque chose a mal tourné!'
                            })
                }
            }); 
            myModal.find('input[id="maladie_nom"]').attr('value',nom_path_tr);
            myModal.find('input[id="nomM"]').attr('value',nom_path_tr);
        myModal.modal({ show: true }); 
    
  }
 //delete data
    function deleteData(id){ 
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
                      url: "/chimio/listMaladie/"+id,
                      method : "POST",              
                      success: function(data){                  
                        Swal.fire({
                          title:'Supprimé!',
                          text:'La Maladie a été supprimé..',
                          type:'success',
                          onClose :function (){
                                  location.reload();     
                            }
                        }                   
                        )           
                      },
                      error: function(data){
                          Swal.fire({
                            type: 'error',
                            title: 'Oops...',
                            text: 'Quelque chose a mal tourné!',
                          })
                        }
                    }); 
        }
      })
  }
  
//data table
      $(function () {
            $('#t_protocole').DataTable();
            if ($("#message").text()) {
                    toastr.options = {
                      "closeButton": false,
                      "debug": false,
                      "newestOnTop": false,
                      "progressBar": false,
                      "positionClass": "toast-bottom-center",
                      "preventDuplicates": false,
                      "onclick": null,
                      "showDuration": "300",
                      "hideDuration": "1000",
                      "timeOut": "3000",
                      "extendedTimeOut": "1000",
                      "showEasing": "swing",
                      "hideEasing": "linear",
                      "showMethod": "fadeIn",
                      "hideMethod": "fadeOut"
                    }
                    toastr.success($("#message").text())    
            }

          })
      
//getMaladie name

        $('input[id="maladie_nom"]').keydown(function() { 
        $(this).autocomplete({
          appendTo: $(this).parent(), // selectionner l'element pour ajouter la liste des suggestion
          source: function( request, response ) {
              $.ajax( {
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},  
                url: "/maladie",
                method : "POST",
                data: {
                  phrase: request.term // value on field input
                },
                success: function( data , status , code ) {
                    response($.map(data.slice(0, 20), function (item) { // slice cut number of element to show
                      return {
                          label : item.pathologie, // pour afficher dans la liste des suggestions
                          value:  item.pathologie // value c la valeur à mettre dans l'input this
                      };
                  }));
                }
              });
            },// END SOURCE

          }).data("ui-autocomplete")._renderItem = function (ul, item) {//cette method permet de gérer l'affichage de la liste des suggestions
               

                 return $("<li></li>")
                     .data("item.autocomplete", item)//récupérer les donnée de l'autocomplete
                     //.attr( "data-value", item.id )
                     .append( item.label)//ajouter à la liste de suggestions
                     .appendTo(ul); 
                 };
      });




$("#b").click(function () {
          event.preventDefault();
          $this = $("#addMaladie");

            document.getElementById('tagss').value = $(".tags").tagsinput('items');
              //alert($(".tags").tagsinput('items'));

               $.ajax({
                  url: $this.attr('action'),
                  method: $this.attr('method'),
                  data: $this.serialize(),
                  
                  datatype :'json' ,
                  success : function (data) {
                   if (data =='ok') {
                  const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                  });

                  Toast.fire({
                    type: 'success',
                    title: 'Maladie ajouter'
                  })
                    window.setTimeout(function(){location.reload(true)},3000);
                   }
                  
                 },
                  error : function (error) {
                          Swal.fire({
                          type: 'error',
                          title: 'Oops...',
                          text: 'Something went wrong!'
                        })
                    }
            });
              });


 
   




        </script>

 
@endsection