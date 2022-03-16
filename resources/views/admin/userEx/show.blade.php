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

			       			 <h2 class="box-title">Utilisateurs Externes</h2>
			       			@can('compte_externe.create',Auth::user())
			        		<a class='col-lg-offset-8 btn btn-success' href="{{ route('userEx.create') }}">Ajouter nouveau</a>
			        		@endcan
						</div>

						<div class="box-body">

			
		                    <table class="table table-responsive table-bordered table-stripped text-center dataTable" id="t_user">

		                        <thead>
		                            <tr class="thead-dark">
		                                <th>Num°</th>
		                                <th>Utilisateur</th>
		                                <th>Email</th>
		                                @can('compte_externe.update',Auth::user())
		                                <th>Modifier</th>
		                                @endcan
		                                @can('compte_externe.delete',Auth::user())
		                                <th>Supprimer</th>
		                                @endcan
		                            </tr>
		                        </thead>

		                        <tbody>

		                         	@foreach ($users as $user)

		                            <tr>
		                            	<td>{{ $loop->index +1 }}</td>

		                                <td>{{ $user->nom}} {{$user->prenom}}</td>

		                                <td>{{ $user->email}}</td>
		                                @can('compte_externe.update',Auth::user())
										<td>
											<a href="#modal_userEx" data-toggle="modal" data-email="{{$user->email}}" data-id="{{$user->id}}" data-target="#modal_userEx"><span class="glyphicon glyphicon-edit">
											</a>
										</td>
										@endcan
										@can('compte_externe.delete',Auth::user())
										<td>
											<form style="display: none;" method="POST" action="{{ route('userEx.destroy',$user->id) }}" id="delete-form-{{ $user->id }}">
												{{ csrf_field() }}
												{{ method_field('DELETE') }}
											</form>

											<a href="" onclick="
												if (confirm('voulez vous supprimer cette ligne ?')) {
												event.preventDefault();
												document.getElementById('delete-form-{{ $user->id }}').submit();										}
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

<div class="modal" id="modal_userEx" style="display: none;">
	<div class="modal-dialog modal-lg" style="width: 1200px">
		<div class="modal-content">				
			<div class="modal-header">
				<button type="button" class="close left turnOff" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span></button>
				<div class="row">
					<div class="col-md-9">
						<h4 class="modal-title" style="">Modifier utilisateur</h4>
					</div>
				</div>
			</div>
			
			<div class="modal-body">
				<div class="row ">
					<form action="{{route('userEx.update','_')}}" method="POST">
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

        $('#modal_userEx').on('show.bs.modal', function(event){
			var button = $(event.relatedTarget);
			var mail = button.data('email');
			var id = button.data('id');
			$(this).find(".modal-body #id").val(id);
	    	$(this).find(".modal-body #email").val(mail);
  		})
    		$('.flash-message').delay(2000).slideUp(200);

        </script>
@endsection
