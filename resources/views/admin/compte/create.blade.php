@extends('layouts.model1')


@section('content')

<div class="content-wrapper">

@if (count($errors) > 0)
  @foreach ($errors->all() as $error)
    <p class="alert alert-danger">{{ $error }}</p>
  @endforeach
@endif

@if (session()->has('message'))
	<p class="alert alert-danger">{{ session('message') }}</p>
@endif
	<div class="row">
		
		<div class="col-md-6 col-sm-offset-2">

			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h3 class="box-title">Ajouter Compte Patient</h3>

				</div>
				<!-- /.box-header -->

				<!-- form start -->

					<div class="box-body">
						<form class="form-group" role="form" method="POST" action="{{ route('compte.store') }}">
							{{  csrf_field() }}
							<div class="col-sm-6">
								<div class="form-group">
									
									<label for="email" class="label-control"> Email* 

										<input type="email"  class="form-control" name="email" id="email"  placeholder="Ex : '@'email.com" required />

									</label>

								</div>									
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									
									<label for="password" class="label-control"> Mots de passe* 

										<input type="password"  class="form-control" name="password" id="password"  placeholder="Mots de passe" required />

									</label>

								</div>								
							</div>

			

								<div class="form-group">
									
									<label for="role" class="label-control"> Patient </label>

										<select name="patient_id" id="patient" class="form-control">
											
											@foreach($users as $patient)
										<option value="{{$patient->id}}">{{$patient->nom}} {{$patient->prenom}}</option>
											@endforeach
										</select>

								</div>


							<button type="submit" class="btn btn-info pull-right">Ajouter</button>

						</form>

					</div>
					<!-- /.box-body -->

			</div>

		</div>
		
	</div>
	
</div>


@endsection
