@extends('layouts.model')
@section('script_css')
    <link rel="stylesheet" href="{{ asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jquery/css/jquery_ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome/css/font-awesome.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/adminlte2/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/skin-blue.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/dist/css/select2.min.css') }}">
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
                        <h3 class="box-title">Renseigner les Unités</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <div class="box-body">
                        {{-- <form class="form-group" id="form_02" role="form" method="POST" action="">
						{{  csrf_field() }}
					<div class="form-group col-sm-4">
						<label for="">Forme pharmaceutique</label>
						<select id="forme" class="form-control" name="forme">
							@php
							$formes = DB::table('formes')->get();
							@endphp
							@foreach ($formes as $forme)
							<option value="{{$forme->CDF_CODE_PK}}">{{ $forme->forme_nom }}</option>
							@endforeach
						</select>
					</div>
					<div class="form-group col-sm-4">
						<label for="">Unité de prise</label>
						<input type="text" class="form-control" placeholder="Nom règle" name="unite_nom">
					</div>
					<div class="col-sm-12 col-sm-offset-9">
						<button class="btn btn-primary" id="bout_02">Ajouter</button>
					</div>
					</form>
				</div> --}}


                        <div class="box-footer">

                            <form>
                                @php
                                    $sacs = DB::table('sac_subactive')
                                        ->distinct()
                                        ->orderBy('sac_nom', 'asc')
                                        ->get();
                                @endphp
                                <table class="table table-bordered text-center" id="unit1">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Num :</th>
                                            <th>medic algerien</th>
                                            <th>dci algerien</th>
                                            <th>dci theriaque equiv</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($r as $sp)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>
                                                    <input type="hidden" value="{{ $sp['id'] }} " name="sp[]">
                                                    {{ $sp['medicament'] }}
                                                </td>
                                                <td>{{ $sp['dci'] }}</td>
                                                <td>
                                                    {{-- <select class="form-control select2 select2-hidden-accessible" multiple="" data-placeholder="diabètes" style="width: 100%;" tabindex="-1" aria-hidden="true" name="dcis[]" >
																								
												@foreach ($sacs as $sac)
												<option value="{{$sac->SAC_CODE_SQ_PK}}">{{$sac->SAC_NOM}}</option>
										@endforeach
										</select> --}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <input type="submit" value="enregistrer" class="btn btn-primary">
                            </form>

                            <table class="table table-bordered text-center mmte">
                                <thead>
                                    <tr>
                                        <th>dci</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sacs = DB::table('sac_subactive')
                                            ->distinct()
                                            ->orderBy('sac_nom', 'asc')
                                            ->get();
                                    @endphp


                                    @foreach ($sacs as $sac)
                                        <tr>
                                            <td>{{ $sac->SAC_NOM }}</td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>
                            {{-- <table class="table table-bordered text-center mmte" >
							<thead class="thead-dark">
								<tr>
									<th>Num :</th>
									<th>Forme pharmaceutique</th>
									<th>Unité de prise</th>
									<th>Supprimer</th>
								</thead>
								<tbody>
															@php
						$regles = DB::table('formes')
						->join('forme_unite', 'formes.CDF_CODE_PK', '=', 'forme_unite.forme_id')
						->join('unites', 'unites.id', '=', 'forme_unite.unite_id')
						->select('formes.*' ,'unites.*')
						->get();
						@endphp
									
									@foreach ($regles as $regle)
									<tr>
										<td>{{ $loop->index + 1 }}</td>
					<td>{{ $regle->forme_nom }}</td>
					<td>{{ $regle->unite_nom }}</td>
					<td>
						<form style='display: none;' method='POST' action="{{ route('unite.destroy',$regle->id) }}" id='delete-form-{{$regle->id}}'>
							{{ csrf_field() }}
							{{ method_field('DELETE') }}
						</form>
						<a href="" onclick="if (confirm('voulez vous supprimer cette ligne ?')) {event.preventDefault(); document.getElementById('delete-form-{{ $regle->id }}').submit();} ">
							<span class="glyphicon glyphicon-trash"></span>
						</a>
					</td>
					</tr>
					@endforeach
					</tbody>
					</table> --}}
                        </div>

                    </div>
                    <!-- /.box-body -->
                </div>
            </div>

        </div>

    </div>
@endsection
@section('script')
    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"> </script>
    <script src="{{ asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js') }}"> </script>
    <script type="text/javascript">
        var table = $("#unit1").DataTable();
        var table1 = $(".mmte").DataTable();
        $('.select2').select2();
        $("form").on('submit', function(e) {
            e.preventDefault();

            var form = table.$('input, select');



            sendForm(form, "/admin/specialite1");

        });

        // Send Form Data via Ajax Method
        function sendForm(form, url) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                method: 'POST',
                data: form.serialize(), // send data form to server
                datatype: 'json',
                success: (data, status) => { //status = 'success'
                    // $.each(form, function(index, val) {
                    // 	if (val.type == 'select-one' && val.value) //TypeOf Select and option isSelected
                    // 		$(this).closest('tr').fadeOut('slow' , function(){
                    // 			$(this).remove();
                    // 		});
                    // });

                    // alert('Ajout Effectué avec succés');
                    console.log(data);

                },

                error: function(data, result, status) { // status = code d'erreur
                    alert(data.responseText);
                    // var errors = $.parseJSON(data.responseText);// because the reponse is a 'String' format , //responseText is when erros has been set
                    // $.each(errors.errors , function(key , value){
                    // 	for (i=0 ; i< value.length ; i++) //because each attribut has more than one error message
                    // 		alert(value[i]);
                    // });

                },
                complete: function(result, status) { //status = 'success'
                    if (window.console && window.console.log) { // check if console is availlable
                        console.log(result + status);
                    }
                }
            });
        }

    </script>
@endsection
