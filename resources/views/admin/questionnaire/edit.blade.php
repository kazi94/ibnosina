@extends('layouts.model1')

@section('content')

<div class="content-wrapper">

	@if (count($errors) > 0)

	  @foreach ($errors->all() as $error)

	    <p class="alert alert-danger">{{ $error }}</p>

	  @endforeach

	@endif

	@if (session()->has('message'))

		<p class="alert alert-success">{{ session('message') }}</p>

	@endif
	<div class="row">
		
		<div class="col-md-8 col-xs-12 col-md-offset-2">
			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h3 class="box-title">Ajouter Questionaire</h3>

				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">

					<form class="form-group" role="form" method="POST" action="{{ route('questionnaires.update' , $questionnaire->id) }}">
						{{  csrf_field() }}
						{{ method_field('PATCH') }}
						<button type="submit" class="btn btn-info pull-right" id="submit">Modifier</button>
						<table class="table  table-responsive">
							<tr>
								<td>
									<div class="form-group col-sm-10">
										<label>Type questionaire</label>
										<input type="text" class="form-control" name="type" placeholder="Renseignez le type de questionaire..." value ="{{ $questionnaire->type }}" required>
									</div>
								</td>
							</tr>

							<tr>
								<td colspan="2" style="">
									<table>
										<tr>
											<td>
												<div class="form-group col-sm-12 col-xs-12">

													<label>Questions </label>
													<input type="text" class="form-control question" placeholder="Ajouter des questions..."  >
												</div>
											</td>
											<td>
												<button type="button" class="btn btn-primary addMedBtn" style="margin-top: 15px;">+</button>
											</td>
										</tr>
									</table>
								</td>
							</tr>

						</table>

						<table class="table table-bordered table-condensed produit_tab">
							<thead class="bg-info"><tr><th>Questions</th><th>Supprimer</th></tr></thead>
							<tbody style="text-align: center;">
								@foreach ($questionnaire->questions as $question)
									<tr>
										<td>
											<input type="hidden"  name="questions[]" value="{{ $question->question }}">

											{{ $question->question  }}											
										</td>
										<td><span class='glyphicon glyphicon-trash'></span><td>
									</tr>
								@endforeach
							</tbody>
						</table>					

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
        $(function()
         {
		$('.addMedBtn').click(function() {//ajouter intercations

			var question    = $('.question').val();
			if (question != "") 
				$('.produit_tab > tbody').append("<tr><td><input type='hidden' name='questions[]' value='"+question+"'>"+question+"</td><td><span class='glyphicon glyphicon-trash'></span><td></tr>"); 
			else 
				$('.alert').html("Veuillez reseigner la question").fadeIn('slow').delay('3000').fadeOut('slow');

			$('.question').val("");	
			});

		$('table').on('click','.glyphicon',function(){//function to remove field with fa close button
			$(this).parent().parent().remove();
			});         	
		});				
	</script>
@endsection