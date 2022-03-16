@extends('bddm.layouts.model')

@section('meta_robot') index,follow @endsection
@section('title') classes Pharmaceutiques | HIC MEDIC @endsection
@section('description') la liste des classes pharmaceutiques. @endsection
@section('og_title') classes Pharmaceutiques | HIC MEDIC @endsection
@section('og_description') la liste des classes pharmaceutiques. @endsection
@section('url') {{url()->current()}} @endsection
@section('content')

    <div class="row">

        <div class="bg-white col-sm-7 p-3 mt-3 mb-3 ml-sm-4 rounded shadow">
          <h2 style="">Liste des classes Pharmaceutiques</h2>
          <br>
            <div id="accordion">
              @foreach ($r as $classe)
                  <div class="card">
                    <div class="card-header" style=" padding:0; "id="heading-{{ $classe->CPH_CODE_PK}}">
                      <span class="mb-0">
                        <button class="btn btn-link collapsed" data-id="{{ $classe->CPH_CODE_PK}}" data-toggle="collapse" href="#collapse-{{ $classe->CPH_CODE_PK}}" aria-expanded="false" aria-controls="collapse-{{ $classe->CPH_CODE_PK}}">
                          <i class="fa fa-plus-circle"></i> {{ $classe->CPH_NOM}}
                        </button>
                      </span>
                    </div>
                    
                  </div>
                
              @endforeach
            </div>
        </div>

        <div class="bg-white col-sm-4 mt-3 mb-3 ml-2 p-3 rounded shadow">
            <h5 id="classe"></h5>

            <table  id="medicaments" class="table table-striped">
                <thead>
                  <tr><th>Liste des médicaments</th></tr>
                </thead>
                <tbody>                                                                    
                </tbody>
            </table>                    
        </div>        
    </div>


@endsection
 @section('js_scripts')

  <script>
  jQuery(document).ready(function($) 
  {

    $('.row').on('click', 'button', function () 
    {
      $this = $(this);
      var isExpanded = $this.attr("aria-expanded");
      if (isExpanded == 'false') 
      {
        $this.attr("aria-expanded" , "true");
        $id = $this.data('id');
        $classe = $this.html();
        $nextDiv = $this.closest('div').next().length;
        if ( $nextDiv == 0 ) 
        {
          
          $.ajax({
            url: '/classes-pharmaceutiques/'+$id,
          })
          .done((data) => 
          {
            $result="";
            
            if ( typeof data.medicaments != 'undefined' ) {
              // afficher les médicaments dasn le tableau
                $('#classe').html($classe);
                $('#medicaments > tbody').empty();
              $.each(JSON.parse(data.medicaments), function(index, val) {
                $('#medicaments > tbody').append(`
                    <tr>
                      <td> <a href='/medicaments/${val.sp_code_sq_pk}' > ${val.sp_nom} </a> </td>
                    </tr> 
                  `);
              });
            } else {

              $.each(data, function(index, val) 
              {
               $result+=`
                  <div class="card">
                    <div class="card-header" style=" padding:0; "id="heading-${val.CPH_CODE_PK}">
                      <span class="mb-0">
                        <button class="btn btn-link collapsed" data-id="${val.CPH_CODE_PK}"  data-toggle="collapse" data-target="#collapse-${val.CPH_CODE_PK}" aria-expanded="false" aria-controls="collapseOne">
                          <i class="fa fa-plus-circle"></i>  ${val.CPH_NOM}
                        </button>
                      </span>
                    </div>
                  </div>`;

              });
              
              $card_bd1 =`<div class="card-body">${$result}</div>`;
              $this.closest('div').after(`<div id="collapse-${$id}" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">${$card_bd1}</div>`);

            }
          })
          .fail(function(request, status, error) {
            alert(request.responseJSON.message);
          })
          .always(function() {
            console.log("complete");
          });              
        }
      }
    });                                 
  });
  </script>

 @endsection