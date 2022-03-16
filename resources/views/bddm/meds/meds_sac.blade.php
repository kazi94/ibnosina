@extends('bddm.layouts.model')
@section('title') Substances Actives | HIC MEDIC @endsection
@section('meta_robot') index,follow @endsection
@section('description') la liste des substance actives. Vous pouvez chercher les médicaments par le nom de la substance active. @endsection
@section('og_title') Substances Actives | HIC MEDIC @endsection
@section('og_description') la liste des substance actives. Vous pouvez chercher les médicaments par le nom de la substance active. @endsection
@section('url') {{url()->current()}} @endsection
@section('content')

            <div class="row">

		<div class="bg-white col-sm-7 p-3 mt-3 mb-3 ml-4 rounded shadow">
            <h2 style="">Liste des Substances Actives</h2>
            <br>

			<table  id="substances" class="table table-striped table-hover" style="">	
                <thead>
                    <tr>
                        <td style="text-align: center;"><strong>Susbstance Actives</strong></td>
                    </tr>
                </thead>				
				<tbody>
                    @foreach ($substances as $substance)
                        <tr>
                            <td style="text-align: center;cursor: pointer;"> 
                                <input type="hidden"  class='sacID' value="{{ $substance->SAC_CODE_SQ_PK }} ">
                                {{ $substance->SAC_NOM }} 
                            </td>
                        </tr>
                    @endforeach
				</tbody>
			</table>					
		</div>
        <div class="bg-white col-sm-4 mt-3 mb-3 ml-2 p-3 rounded shadow">
            <h3 id="sac_title"></h3>

            <table  id="sac_sp" class="table table-striped">
                <tbody>
                                                                          
                </tbody>
            </table>                    
        </div>        
            </div>


@endsection


 @section('js_scripts')

    <script>
        jQuery(document).ready(function($) {
                    
            var table = $('#substances').DataTable({
                "responsive" :true,
                "language" : {
                    "decimal":        "",
                    "emptyTable":     "Aucune données est disponnible",
                    "info":           "",
                    "infoEmpty":      "de 0 a 0 des 0 lignes",
                    "infoFiltered":   "(filtered from _MAX_ total lignes)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Afficher _MENU_ substances",
                    "loadingRecords": "Chargement...",
                    "processing":     "Processing...",
                    "search":         "Recherchez:",
                    "zeroRecords":    "Aucune substance active trouvée",
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

            $('#substances').on('click', 'tbody tr td', function () {

                var idSAC = $(this ).find(':first-child').val();
                var nomSAC = $(this).html();

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url : '/substances/'+idSAC+'&&null',
                    method :'GET',
                    datatype : 'json',
                    success : (data) => {
                        console.log(data);
                        if (data) {
                            $('#sac_title').html(nomSAC);
                            $("#sac_sp > tbody").empty();
                            $.each(data, function(index, val) {
                                $("#sac_sp > tbody").append(`
                                    <tr>
                                        <td style="text-align: center; cursor : pointer "> <a href='/medicaments/${val.SP_CODE_SQ_PK}' > ${val.SP_NOM} </a></td>
                                    </tr>
                                `);
                            });
                        }
                    },
                    error:function (jqXHR, textStatus) {
        
                        console.log( "Request failed: " + textStatus +" "+jqXHR );
                    }
                });                 
            });                                   
        });
    </script>

 @endsection