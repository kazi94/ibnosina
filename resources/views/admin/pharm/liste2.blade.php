@extends('layouts.model')

@section('script_css')
	<link rel="stylesheet" href="{{ asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css')}}">
	<link rel="stylesheet" href="{{ asset('plugins/jquery/css/jquery_ui.css')}}">
@endsection

@section('content')


<div class="content-wrapper">

	@if (count($errors) > 0)

	@foreach ($errors->all() as $error)

	<p class="alert alert-danger">{{ $error }}</p>

	@endforeach

	@endif

	<div class="alert alert-danger" style="display: none;"></div>

	@if (session()->has('message'))

	<p class="alert alert-success">{{ session('message') }}</p>

	@endif

	<div class="row">
    <div class="col-md-8 col-xs-12 col-md-offset-2">
			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h1 class="box-title" aling="center">Liste des réponses envoyées</h1>

				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
				     @php $pharmacos = DB::table('pharmacos')
                							->select('pharmacos.*')
											->where('envoye' , 'oui')
                							->get(); @endphp
	                            @if (count($pharmacos) > 0)
			                	<table class="table table-bordered text-center element " id="id1">
		                        <thead class="thead-dark">
		                            <tr>
		                                <th>Date de déclaration</th>
		                                <th>Nom de rapporteur</th>
                                        <th>prénom</th>
										<th>N° tel</th>
										<th>Adresse</th>
										<th>email</th>
										<th>détail</th>

		                            
		                        </thead>

								<tbody >
		                        		@foreach ($pharmacos as $pharmaco)
											<tr>
                                            
				                             	<td>{{ $pharmaco->date_declaration_rapporteur }}</td>
				                            	<td>{{ $pharmaco->nom }}</td>
                                                <td>{{ $pharmaco->prenom }}</td>
												<td>{{ $pharmaco->tel }}</td>
												<td>{{ $pharmaco->adresse }}</td>
												<td>{{ $pharmaco->email }}</td>
												<td><a href="{{route('pharmaco.show' ,$pharmaco->id) }}"><span  class="fa fa-plus-circle"></span></a></td>


				                             	 </tr>
		                        		@endforeach
		                        </tbody>
	                    	   </table>
							   @endif
                </div><!---body-->
            </div><!--box-info-->
    </div><!--offset-->
    </div><!--row-->

 </div><!--content-->
 @endsection

@section ('script')
	<script src="{{ asset('/plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js')}}"></script>
	<script src="{{ asset('plugins/jquery/js/jquery-ui.js')}}"></script> 
	<script type="text/javascript" src="{{ asset('/js/admin/gestion_regle.js')}}"></script>
	<script type="text/javascript">
	$('body').find('span > i').remove('i:last');
        $('#id1').dataTable();
       
</script>
@endsection