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
		
		<div class="col-md-8 col-sm-offset-2">

			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h3 class="box-title">Ajouter utilisateur</h3>

				</div>
				<!-- /.box-header -->

				<!-- form start -->

					<div class="box-body">
						<form class="form-group" role="form" method="POST" action="{{ route('userEx.store') }}">

							{{  csrf_field() }}
							

							<div class="col-sm-4">
								<div class="form-group">
									
									<label for="nom" class="label-control"> Nom* 

										<input type="text"  class="form-control" name="name" id="nom"  placeholder="nom" required />

									</label>

								</div>					
							</div>

							<div class="col-sm-4">
								<div class="form-group">
								
									<label for="prénom" class="label-control"> Prénom* 

										<input type="text"  class="form-control" name="prenom" id="prénom"  placeholder="prénom" required />

									</label>

								</div>
							</div>

							<div class="col-sm-4">
								<div class="form-group">
								
									<label for="date_naissance" class="label-control"> Date de naissance 

										<input type="date"  class="form-control" name="date_naissance" id="date_naissance"  placeholder="date_naissance" style="width: 214px;">

									</label>

								</div>															
							</div>
							<div class="col-sm-4">
								<div class="form-group">
									
									<label for="email" class="label-control"> Email* 

										<input type="email"  class="form-control" name="email" id="email"  placeholder="Ex : '@'email.com" required />

									</label>

								</div>									
							</div>

							<div class="col-sm-4">
								<div class="form-group">
									
									<label for="password" class="label-control"> Mots de passe* 

										<input type="password"  class="form-control" name="password" id="password"  placeholder="Mots de passe" required />

									</label>

								</div>								
							</div>

							<div class="col-sm-3">
								<div class="form-group">
									<br>
									<button type="submit" class="btn btn-info form-control">Ajouter</button>

								</div>								
							</div>
												


								



							

						</form>

					</div>
					<!-- /.box-body -->

			</div>

		</div>
		
	</div>
	
</div>


@endsection

@section ('script')
	<script>
		
		        $(function() {

		        	 //get json records from general.json and display bilan and unités in there respective select for admin
		        	 $.getJSON("/js/json/general.json",function(obj){

		        			$.each(obj,function(key,value){
	        					// console.log(value.unite.length)
	        					if (value.grade!= "" ) {
					        		$("#grade").append("<option value="+value.grade+">"+value.grade+"</option>");
	        					}
	        					if (value.specialite !="") {
					        		$("#specialite").append("<option value="+value.specialite+">"+value.specialite+"</option>");	        					
	        					}
	        				});
		       		 });

		       		//get json records from general.json and display in there respective div for admin
					$.getJSON("/js/json/general_settings.json",function(obj)
					{					 	
					 	$("#service").val(obj.service);	
					 	$("#hopital").val(obj.hopital);	
					});
				});				
	</script>
@endsection