@extends('layouts.model')
@section('script_css')

    <link rel="stylesheet" href="{{ asset('/plugins/iCheck/all.css')}}">
     <link rel="stylesheet" href="{{ asset('/plugins/toastr/toastr.css')}}">

@endsection

@section('content')
   <style>  
      .isa_info {
    color: #00529B;
    background-color: #BDE5F8;
    padding: 0.9em;
    text-align: center;
}

    .swal2-popup {
  font-size: 1.6rem !important;
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
    


    .headerLine {
      width: 160px;
      height: 2px;
      display: inline-block;
      background: #101F2E;
    }    
    </style>


    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
           <a type="submit"class="btn btn btn-primary" href="{{(route('protocole.index'))}}">Ajouter un protocole</a>
            <a type="button" class="btn  btn-default" href="{{(route('listMaladie.index'))}}">Lister les maladies</a>
            <a type="button" class="btn  btn-default" href="{{route('para')}}">Paramètre général</a>

       
          <!-- jQuery Knob -->
          <div class="row ">
            <div class="col-sm-12">
          <div class="box box-solid">
            <div class="box-header">
                <div class="sectiontitle">
                <h2>List protocole de chimiothérapie</h2>
                <span class="headerLine"></span>
            </div><br>


       
          
                 <div class="row">
                    <div class="col-sm-12 ">
                      @if($protocole->isEmpty())
                      
                        <div class="isa_info" style="width: 80%; text-align: center;position: relative; left: 10%">
                          <h4><i class="fa fa-info-circle"></i> Aucun protocole de chimiothérapie trouvé veuillez <a style="color:red" href="{{(route('protocole.index'))}}">ajouter un</a></h4>
                          
                      </div>
                      <br>
                        @else
                      
                        <div class="box-body table-responsive no-padding">

                            <table id="t_protocole" class="table table-responsive text-center dataTable table table-hover" aria-describedby="t_protocole">
                                <thead>
                                    <tr class="alert alert-info">

                                        <th style="width: 5%" >#</th>
                                        <th style="width: 30%">NOM DU PROTOCOLE</th>
                                        <th style="width: 20%">CREER PAR</th>
                                        <th style="width: 20%">DATE DE CREATION</th> 
                                        <th style="width: 10%">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($protocole as $pro)
                                     <tr>
                                        <td><strong>{{$pro->id}}</strong></td>
                                        <td>{{$pro->nom}}</td>
                                        <td>{{strtoupper(Auth::user()->name)}} {{Auth::user()->prenom}}</td>
                                        <td>{{$pro->created_at}}</td>
                                        <td>
                                            <a href="{{route('detailProtocole',$pro->id) }}"style="color:black;">
                                                <span class="glyphicon glyphicon-eye-open"></span>
                                            </a>                 
                                         <span class="glyphicon glyphicon-edit" style="cursor: pointer" onclick="editData()"></span>
                                      
                                    
                                            <span class="glyphicon glyphicon-trash" style="color: red; cursor: pointer" onclick="deleteLigne({{$pro->id}})"></span>
                                        </td>
                                     </tr>
                                    @endforeach
                                 </tbody>
                            </table>
                        </div>
                        @endif
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
            </section>
        </div>
            <!-- /.box-body -->
      

                
               
@stop
@section('script')
<script src="{{asset('plugins/sweetAlert/sweetalert.js')}}"></script>

<script>
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
  function myFunction() {
    swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this imaginary file!",
  icon: "warning",
  buttons: true,
  dangerMode: true,
})
.then((willDelete) => {
  if (willDelete) {
    swal("Poof! Your imaginary file has been deleted!", {
      icon: "success",
    });
  } else {
    swal("Your imaginary file is safe!");
  }
});
 
      }

</script>

        <script src="{{ asset('plugins/toastr/toastr.js')}}"></script>
                <script>
          $(function () {

              $('#t_protocole').DataTable();
         
// // Define a callback for when the toast is shown/hidden/clicked
// toastr.options.onShown = function() { console.log('hello'); }
// toastr.options.onHidden = function() { console.log('goodbye'); }
// toastr.options.onclick = function() { console.log('clicked'); }
// toastr.options.onCloseClick = function() { console.log('close button clicked'); }
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
        </script>
 
@endsection