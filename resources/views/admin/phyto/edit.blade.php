@extends('layouts.model1')
@section('content')

<div class="content-wrapper">
	<section class="content">
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

			<div class="col-sm-12">
				<!-- Horizontal Form -->
				<div class="box box-info mt-3">

					<div class="box-header with-border bg-aqua">

						<h3 class="box-title">Ajouter Produit alimentaire</h3>

					</div>
					<!-- /.box-header -->
					<!-- form start -->
					<div class="box-body">

						<form class="form-group" role="form" method="POST" action="{{ route('produit.update',$produit->id) }}">
							{{ csrf_field() }}
							{{ method_field('PATCH') }}
							<div class="row">
								<div class="form-group col-sm-6">

									<label>Produit naturel (FR) </label>

									<input type="text" class="form-control" name="produit_naturel_fr" placeholder="placer votre produit en Français" value="{{ $produit->produit_naturel_fr }}" required>

								</div>

								<div class="form-group col-sm-6">

									<label>Nom scientifique(Latin) </label>

									<input type="text" class="form-control" name="produit_naturel_latin" placeholder="placer votre nom scientifique" value="{{ $produit->produit_naturel_latin }}">

								</div>

								<div class="form-group col-sm-6">

									<label>Partie Active </label>

									<select name="partie_active" class="form-control">
										<option @if ($produit->partie_active == "Racine") selected @endif value="Racine">Racine</option>
										<option @if ($produit->partie_active == "Tige") selected @endif value="Tige">Tige</option>
										<option @if ($produit->partie_active == "Feuille") selected @endif value="Feuille">Feuille</option>
										<option @if ($produit->partie_active == "Fleur") selected @endif value="Fleur">Fleur</option>
										<option @if ($produit->partie_active == "Sommité fleurie") selected @endif value="Sommité fleurie">Sommité fleurie</option>
										<option @if ($produit->partie_active == "Partie aérienne") selected @endif value="Partie aérienne">Partie aérienne</option>
										<option @if ($produit->partie_active == "Graine") selected @endif value="Graine">Graine</option>
										<option @if ($produit->partie_active == "Fruit") selected @endif value="Fruit">Fruit</option>
									</select>

								</div>

								<div class="form-group col-sm-6">

									<label>Mode de Préparation</label>

									<textarea name="mode_preparation" class="form-control" cols="40" rows="3" value="{{ $produit->mode_preparation}}">{{ $produit->mode_preparation}}</textarea>
								</div>

								<div class="form-group col-sm-6">

									<label>Nom en Arabe</label>

									<table class="table">

										<tr>

											<td><input type="text" class="form-control" placeholder="placer votre produit en arabe" name="" id="produit_arabe"></td>

											<td><button type="button" class="btn btn-primary addPlanteArBtn">+</button></td>

										</tr>

									</table>

								</div>

								<div class="form-group col-sm-6">
									<label>Liste des Noms Arabes</label>

									<ul id="arabe_words" class="menu navbar navbar-default">
										@foreach($produits_arabe as $p_arabe)
										<li class="mt-1">
											<input type='hidden' name='produits_arabe[]' value="{{$p_arabe }}">
											{{$p_arabe }}
											<i class='bg-maroon fa fa-1x fa-times-circle ml-2 p-1 deleteArabeWord' style='color:red;cursor : pointer;'> </i>
										</li>
										@endforeach

									</ul>
								</div>
							</div>

							<hr class="mt-0" />


							<div class="row">
								<div class="ml-4">
									<h4> Intéractions Médicamenteuses</h4>
								</div>

								<div>

									<div class="form-group col-sm-6">

										<label>Médicaments (DCI) </label>
										<input type="hidden" class="medicament_dci_id" id="medicament_dci_id">

										<input type="text" class="form-control médicament_dci" placeholder="Médicament DCI" id="medic_input">

									</div>


									<div class="form-group col-sm-6">
										<label>Type d'effet </label>
										<select class="form-control" name="type_effet[]" id="type">
											<option value="Interaction Pharmacocinétique">Interaction Pharmacocinétique</option>
											<option value="Interaction Pharmacodynamique">Interaction Pharmacodynamique</option>
											<option value="Physicochémique">Physicochémique</option>
										</select>
									</div>

									<div class="form-group col-sm-6">

										<label>Effet de l'intéraction</label>

										<textarea type="text" class="form-control" placeholder="Effet de l'intéraction...." rows="2" cols="40" id="effet"></textarea>

									</div>


									<div class="form-group col-sm-6">

										<label>Niveau d'interaction</label>

										<select id="niveau" class="form-control">
											<option value="1">Contre indication</option>
											<option value="2">Association déconseillé</option>
											<option value="3">Précaution d'emploi</option>
										</select>

									</div>
									<div class="form-group col-sm-7">

										<label>Indication traditionelle</label>

										<textarea type="text" class="form-control" placeholder="Indication Traditionnelle..." rows="2" cols="40" id="indic"></textarea>

									</div>
									<div class="form-group col-sm-5">

										<label>Effets Pharmacologiques documenté</label>

										<textarea type="text" class="form-control" placeholder="Effets Pharmacologiques documenté..." rows="2" cols="40" id="ef_pharm"></textarea>

									</div>
									<div class="form-group col-sm-12">

										<label>Recommendations</label>

										<textarea type="text" class="form-control" placeholder="Recommendations..." rows="2" cols="40" id="reco"></textarea>

									</div>

								</div>
								<div class="col-sm-12 text-center mb-3">

									<button type="button" class="btn btn-primary btn-block addMedBtn">Ajouter l'intéraction</button>
								</div>
							</div>

							<div class="table-responsive">
								<table class="table table-bordered table-condensed produit_tab" id="interactions_plantes">
									<thead class="bg-gray">
										<tr>
											<th>Médicament</th>
											<th>Effet de l'interaction</th>
											<th>Type effet</th>
											<th>Indication traditionelle</th>
											<th>Effets Pharmacologiques documenté</th>
											<th>Recommendations</th>
											<th>Niveau</th>
											<th>Supprimer</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($produit->interactions as $p_interac)
										<tr>
											<td>
												<input type="hidden" class="medicament_dci_id" name="id_interactions[]" value="{{ $p_interac->id }}">
												<input type="hidden" class="medicament_dci_id" name="medicament_dci_id[]" value="{{ $p_interac->sac_subactive_id }}">
												@php
												$sac = DB::table('sac_subactive')->select('sac_nom')->where('sac_code_sq_pk' , $p_interac->sac_subactive_id)->get();
												@endphp
												{{ $sac[0]->sac_nom }}
											</td>

											<td>
												<input type="hidden" name="effet_interaction[]" value="{{ $p_interac->effet_interaction }}">

												{{ $p_interac->effet_interaction  }}

											</td>
											<td>
												<input type="hidden" name="type_effet[]" value="{{ $p_interac->type_effet }}">
												{{ $p_interac->type_effet }}
											</td>
											<td>

												<input type="hidden" name="indication[]" value="{{  $p_interac->indication }}">

												{{ $p_interac->indication }}
											</td>
											<td>

												<input type="hidden" name="effet_pharmaco[]" value="{{  $p_interac->effet_pharmaco }}">

												{{ $p_interac->effet_pharmaco }}
											</td>
											<td>

												<input type="hidden" name="recommendation[]" value="{{  $p_interac->recommendation }}">

												{{ $p_interac->recommendation }}
											</td>

											<td>

												<input type="hidden" name="niveau[]" value="{{  $p_interac->niveau }}">

												@if ($p_interac->niveau == "1") Contre Indication @endif
												@if ($p_interac->niveau == "2") Association déconseillé @endif
												@if ($p_interac->niveau == "3") Précaution d'emploi @endif
											</td>
											<td class="text-center">
												<span class='glyphicon glyphicon-trash fa-2x' style="cursor:pointer;"></span>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>

							</div>
							<div class="text-center">

								<button type="submit" class="btn btn-success btn-lg" id="submit">Je valide</button>
							</div>
						</form>

					</div>

					<!-- /.box-body -->
				</div>

			</div>

		</div>

	</section>




</div>



@endsection

@section ('script')
    <!-- <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap.min.js"></script> -->
<script src="{{ asset('plugins/datatable-1.10.24/datatables.min.js') }}"></script>

<script src="{{ asset('plugins/jquery/js/jquery-ui.js')}}"></script>
<script type="text/javascript" src="/js/admin/gestion_produit.js"></script>
@endsection