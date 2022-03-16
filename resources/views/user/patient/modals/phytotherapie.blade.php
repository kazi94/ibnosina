<!-- Modal Phylthothérapie -->
<div class="modal fade in" id="modal_phyto">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="bg-blue modal-header text-center">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Ajouter Un Produit Phytothérapeute</h4>
			</div>
			<form method="POST" action="{{ route('phytotherapie.store') }}" enctype="multipart/form-data" class="form-horizontal">
				{{ csrf_field() }}
				<input type="hidden" name="patient_id" value="{{$patient->id}}">
				<div class="modal-body">
					<div class="form-group">
						<label for="d_analyse" class="col-sm-3 control-label">Plante (FR)</label>

						<div class="col-sm-9">
							<input type="hidden" name="produitalimentaire_id" class="pr_hidden">
							<input type="text" class="form-control pr_input">
						</div>
					</div>
					<div class="form-group">
						<label for="labo" class="col-sm-3 control-label">العشبة</label>

						<div class="col-sm-9">
							<input type="text" class="form-control ar_input">
						</div>
					</div>
					 <div class="form-group">
						<label for="labo" class="col-sm-3 control-label">Utilisation</label>

						<div class="col-sm-9">

							<select name="used_on" class="form-control select2">
								<option value=""></option>
								@foreach ($pathologies as $pathologie)
								<option value="{{ $pathologie->id }}">{{ $pathologie->pathologie }}</option>
								@endforeach
							</select>
						</div>
					</div> 
					<div class="form-group">
						<label for="labo" class="col-sm-3 control-label">Fréquence</label>

						<div class="col-sm-9">
							<select class="form form-control frequence" name="frequence">
								<option>Occasionnellement</option>
								<option>Exceptionnellement</option>
								<option>Depuis :</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="labo" class="col-sm-3 control-label"></label>

						<div class="col-sm-9">
							<input type="date" class="form-control frequence_date" name="frequence_date" style="display: none;" />
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default mb-0" data-dismiss="modal">Fermer</button>
					<button type="submit" class="btn btn-primary mb-0">Ajouter</button>
				</div>
			</form>
		</div>
	</div>
</div>