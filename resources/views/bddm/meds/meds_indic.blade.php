@extends('bddm.layouts.model')
@section('meta_robot') index,follow @endsection
@section('title') Indications | HIC MEDIC @endsection
@section('description') la liste des indications. Vous pourrez chercher le médicament par le type d'indication. @endsection
@section('og_title') Indications | HIC MEDIC @endsection
@section('og_description') la liste des indications. Vous pourrez chercher le médicament par le type d'indication. @endsection
@section('url') {{url()->current()}} @endsection
@section('content')

            <div class="row">

		<div class="bg-white col-sm-7 p-3 mt-3 mb-3 ml-sm-4 rounded shadow">
            <h2 style="">Liste des Indications</h2>
            <br>

			<table  id="indications" class="table table-striped table-hover" style="width: auto;">	
                <thead>
                    <tr>
                        <td style="text-align: center;"><strong>Indications</strong></td>
                    </tr>
                </thead>				
				<tbody>
                    @foreach ($indications as $indication)
                        <tr>
                            <td style="text-align: center;cursor: pointer;"> 
                                <input type="hidden"  class='sacID' value="{{ $indication->FIN_CDF_NAIN_CODE_FK_PK }} ">
                                {{ $indication->cdf_nom }} 
                            </td>
                        </tr>
                    @endforeach
				</tbody>
			</table>					
		</div>
        <div class="bg-white col-sm-4 mt-3 mb-3 ml-2 p-3 rounded shadow">
            <h3 id="indic_title"></h3>

            <table  id="indic_sp" class="table table-striped">
                <tbody>
                                                                          
                </tbody>
            </table>                    
        </div>        
            </div>


@endsection


 @section('js_scripts')

    <script>
        jQuery(document).ready(function($) {
                    
            var table = $('#indications').DataTable({
                
                "language" : {
                    "decimal":        "",
                    "emptyTable":     "Aucune données est disponnible",
                    "info":           "",
                    "infoEmpty":      "de 0 a 0 des 0 lignes",
                    "infoFiltered":   "(filtered from _MAX_ total lignes)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Afficher _MENU_ lignes",
                    "loadingRecords": "Chargement...",
                    "processing":     "Processing...",
                    "search":         "Recherchez:",
                    "zeroRecords":    "Aucun Médicament trouvé dans votre recherche",
                    "paginate": {
                        "first":      "Début",
                        "last":       "Dernier",
                        "next":       "Suivant",
                        "previous":   "Précédent"
                    },
                    "aria": {
                        "sortAscending":  ": activate to sort column ascending",
                        "sortDescending": ": activate to sort column descending"
                    }
                }
            }); 

            $('#indications').on('click', ' tbody tr td', function () {
                console.log('msg')
                var idSAC = $(this ).find(':first-child').val();
                var nomSAC = $(this).html();

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url : '/indications/'+idSAC,
                    method :'GET',
                    datatype : 'json',
                    success : (data) => {
                        if (data) {
                            $('#indic_title').html(nomSAC);
                            $("#indic_sp > tbody").empty();
                            $.each(JSON.parse(data), function(index, val) {
                                $("#indic_sp > tbody").append(`
                                    <tr>
                                        <td style="text-align: center; cursor : pointer "> <a href='/medicaments/${val.SP_CODE_SQ_PK}'> ${val.SP_NOM} </a></td>
                                    </tr>
                                `);
                            });
                        }
                    },
                    error:function (request, status, error) {
                        alert(request.responseJSON.message);
                    }
                });                 
            });                                   
        });
    </script>

 @endsection