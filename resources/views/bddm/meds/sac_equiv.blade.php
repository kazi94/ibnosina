@extends('bddm.layouts.model')
@section('meta_robot') noindex, nofollow @endsection
@section('content')
  <div class="row">
      @if (isset($results['0']->SAC_NOM))
        <h3 class="p-4"><i><u>Substance Active : {{ $results['0']->SAC_NOM }}</u></i></h3>
      @endif
    </div>
          <div class="row d-flex justify-content-center">
            <div class="bg-white col-sm-8 p-3 m-3 rounded shadow table-responsive">
                <table  id="medicaments" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th class="alert alert-success">Liste des médicaments</th>
                        </tr>
                    </thead>            
                    <tbody>
                      @foreach ($results as $sp)
                        <tr>
                          <td> <a href="{{ route('medicaments.monographie' , $sp->SP_CODE_SQ_PK) }}"> {{ $sp->SP_NOM }} </a> </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table> 
               
            </div>
         </div>
@endsection

@section('js_scripts')

  <script>
  $(document).ready(function() {
    $('#medicaments').DataTable({
                "responsive" :true,
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
  });    
  </script>

@endsection

