@extends('layouts.model')

@section('content')

<div class="content-wrapper">
	<section class="content">

		<div class="flash-message">
			@foreach (['danger', 'warning', 'success', 'info'] as $msg)
				@if(Session::has('alert-' . $msg))
					<p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }} <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></p>
				@endif
			@endforeach
		</div>

		<div class="row">

			<div class="col-sm-12 ">
				<div class="box box-info">
					

			      		<div class="box-header with-border">

			       			 <h2 class="box-title">Compte Patients</h2>
			       			@can('compte_patient.create',Auth::user())
			        		<a class='col-lg-offset-8 btn btn-success' href="{{ route('compte.create') }}">Ajouter nouveau</a>
			        		@endcan
						</div>

						<div class="box-body">

			
		                    <table class="table table-responsive table-bordered table-stripped text-center dataTable" id="t_user">

		                        <thead>
		                            <tr class="thead-dark">
		                                <th>Num°</th>
		                                <th>Email</th>
		                                <th>Tel</th>
		                                <th>Patient</th>
		                                <th>Code</th>
		                                <th>Informations</th>
		                                @can('compte_update',Auth::user())
		                                <th>Modifier</th>
		                                @endcan
		                                @can('compte_patient.delete',Auth::user())
		                                <th>Supprimer</th>
		                                @endcan
		                            </tr>
		                        </thead>

		                        <tbody>

		                         	@foreach ($comptes as $compte)

		                            <tr>
		                            	<td>{{ $loop->index +1 }}</td>

										<td>{{ $compte->email}}</td>

										<td>{{ $compte->tel }}</td>

										<td>{{ $compte->name}}</td>
										
										<td>{{ $compte->code}}</td>
										
										<td>
											<a href="{{route('send',$compte->patient_id)}}" onclick="return confirm('Voulez vous envoyer les Informations a: {{$compte->name}} ?')">
											<span class="glyphicon glyphicon-envelope" ></span></a>
										</td>
										@can('compte_update',Auth::user())
										<td>
											<a href="#modal_compte" data-toggle="modal" data-email="{{$compte->email}}" data-tel="{{$compte->tel}}" data-id="{{$compte->id}}" data-target="#modal_compte"><span class="glyphicon glyphicon-edit"></span>
											</a>
										</td>
										@endcan
										@can('compte_patient.delete',Auth::user())
										<td>
											<form style="display: none;" method="POST" action="{{ route('compte.destroy',$compte->id) }}" id="delete-form-{{ $compte->id }}">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}
											</form>

											<a href="" onclick="
												if (confirm('voulez vous supprimer cette ligne ?')) {
												event.preventDefault();
												document.getElementById('delete-form-{{ $compte->id }}').submit();										}
											"><span class="glyphicon glyphicon-trash"></span></a>
										</td>
										@endcan

		                            </tr>

		                            @endforeach 

		                        </tbody>
		                    </table>

						</div>

				</div>

			</div>

		</div>

	</section>
</div>

<div class="modal" id="modal_compte" style="display: none;">
	<div class="modal-dialog modal-lg" style="width: 1200px">
		<div class="modal-content">				
			<div class="modal-header">
				<button type="button" class="close left turnOff" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<div class="row">
					<div class="col-md-9">
						<h4 class="modal-title" style="">Modifier compte</h4>
					</div>
				</div>
			</div>
			
			<div class="modal-body">
				<div class="row ">
					<form action="{{route('compte.update','_')}}" method="POST">
						{{ csrf_field()}}
						{{ method_field('PATCH') }}
						<div class="col-sm-4 col-sm-offset-1">
							<label>Email* </label>
							<input type="text" name="email" id="email" class="form form-control" required>
							<input type="hidden" name="id" id="id">
						</div>
						<div class="col-sm-4 col-sm-offset-1">
							<label>Mot de passe* </label>
							<input type="password" name="password" id="password" class="form form-control" required>	
						</div>
						<div class="col-sm-4 col-sm-offset-1">
							<label>Tel* </label>
							<input type="text" name="tel" id="tel" class="form form-control" >	
						</div>			
				</div>
				<div class="modal-footer row">      
					<input type="submit" class="btn btn-primary pull-right" value="Confirmer">          
					<input type="reset" class="btn btn-default pull-left turnOff" data-dismiss="modal" value="Fermer">
				</form>		
						<!-- <input type="submit" class="btn btn-primary pull-right" value="Confirmer" > -->
					<!-- </form> -->
				</div>
			</div>			
		</div>	
	</div>
</div>

@endsection
@section('script')

	<script>
		$(function () {
			$('#t_biologique').DataTable();
		})
	
		$('#modal_compte').on('show.bs.modal', function(event){
			var button = $(event.relatedTarget);
			var mail = button.data('email');
			var id = button.data('id');
			var tel = button.data('tel');
			$(this).find(".modal-body #id").val(id);
	    	$(this).find(".modal-body #tel").val(tel);
	    	$(this).find(".modal-body #email").val(mail);
  		})

  		$('.flash-message').delay(3000).slideUp(200);

	</script>
@endsection
