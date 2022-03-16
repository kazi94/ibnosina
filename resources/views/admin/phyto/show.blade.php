@extends('layouts.model')

@section('content')

<div class="content-wrapper">

	<section class="content">

		@if (session()->has('message'))

		<p class="alert alert-success">{{ session('message') }}</p>

		@endif

		<div class="row">
			<div class="col-sm-12 ">
				<div class="box">
					<div class="box-header with-border">

						<h2 class="box-title">Produits alimentaires/phyltothérapeutes </h2>

						<a class='col-lg-offset-5 btn btn-success' href="{{ route('produit.create') }}">Ajouter nouveau</a>

					</div>

					<div class="box-body table-responsive">

						@if (count($produits) > 0)

						<table class="table table-bordered table-stripped text-center dataTable" id="t_produits">

							<thead>

								<tr class="bg-gray">
									<th>Produit FR</th>
									<th>Produit Latin</th>
									<th>Produits Arabe </th>
									<th>Famille </th>
									<th>Effets médicamenteux</th>
									<th>Modifier</th>
									<th>Supprimer</th>
								</tr>


							</thead>

							<tbody>

								@foreach ($produits as $produit)
								{{-- @foreach ($produit->interactions as $interaction_id) --}}

								<tr>
									<td>{{ $produit->produit_naturel_fr}}</td>

									<td>{{ $produit->produit_naturel_latin}}</td>

									<td>{{ $produit->produits_arabe}}</td>
									<td>{{ $produit->famille}}</td>

									<td>{{-- {{ $interaction_id->type_effet}} --}}<a href="{{  route('produit.edit',$produit->id) }}">Détails</a></td>

									{{-- <td>{{ $interaction_id->effet_interaction}}</td> --}}

									<td>

										<a href="{{  route('produit.edit',$produit->id) }}"><span class="glyphicon glyphicon-edit"></span></a>

									</td>

									<td>

										<form style="display: none;" method="POST" action="{{ route('produit.destroy',$produit->id) }}" id="delete-form-{{ $produit->id }}">
											{{ csrf_field() }}
											{{ method_field('DELETE') }}
										</form>

										<a href="" onclick="
											if (confirm('voulez vous supprimer cette ligne ?')) {
											event.preventDefault();
											document.getElementById('delete-form-{{ $produit->id }}').submit();										}
										"><span class="glyphicon glyphicon-trash"></span></a>
									</td>

								</tr>
								{{-- @endforeach --}}

								@endforeach

							</tbody>

						</table>

						@else
						<div class="container-fluid callout callout-danger">
							<h5 class="">Veuiller Ajouter un nouveau produit alimentaire !!</h5>
						</div>
						@endif
					</div>
				</div>
			</div>
		</div>
	</section>
</div>

@endsection

@section('script')

<script>
	$(function() {

		$('#t_produits').DataTable({
			"order": []
		});
	})
</script>
@endsection