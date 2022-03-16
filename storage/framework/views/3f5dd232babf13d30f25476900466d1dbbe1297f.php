<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>	</title>
    <link rel="stylesheet" href="/plugins/bootstrap/dist/css/bootstrap.min.css">

</head>
<body>

	<form action="/testExcel" method="post" enctype="multipart/form-data">
		<?php echo e(csrf_field()); ?>

		<input type="file" name="file" id="">
		<input type="submit">
	</form>
						<table class="table ">
							<thead>
								<tr>
									<th>Questionnaire : 
	
									</th>
									<th>OUI</th>
									<th>NON</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td></td>

									<fieldset>
										<td>
											<input type="hidden" name="oui1" value="0">
											<input type="radio" class="" style=""  onclick="this.previousSibling.value=1-this.previousSibling.value" name="oui1">
										</td>
										<td>
											<input type="hidden" name="oui1"  value="1">
											<input type="radio" class="" style="" onclick="this.previousSibling.value=8-this.previousSibling.value" name="oui1">
										</td>
									</fieldset>
								</tr>
								<tr>
									<td ></td>
									<fieldset>
										<td>
											<input type="hidden" name="oui2" value="0">
											<input type="radio" class="" style=""  onclick="this.previousSibling.value=1-this.previousSibling.value" name="oui2">
										</td>
										<td>
											<input type="hidden" name="oui2"  value="1">
											<input type="radio" class="" style="" onclick="this.previousSibling.value=8-this.previousSibling.value" name="oui2">
										</td>
										
									</fieldset>
								</tr>
								<tr>
									<td></td>
									<fieldset>
										<td>
											<input type="hidden" name="oui3" value="0">
											<input type="radio" class="" style=""  onclick="this.previousSibling.value=1-this.previousSibling.value" name="oui3">
										</td>
										<td>
											<input type="hidden" name="oui3"  value="1">
											<input type="radio" class="" style="" onclick="this.previousSibling.value=8-this.previousSibling.value" name="oui3">
										</td>
										
									</fieldset>
								</tr>
								<tr>
									<td></td>
									<fieldset>
										<td>
											<input type="hidden" name="oui4" value="0">
											<input type="radio" class="" style=""  onclick="this.previousSibling.value=1-this.previousSibling.value" name="oui4">
										</td>
										<td>
											<input type="hidden" name="oui4"  value="1">
											<input type="radio" class="" style="" onclick="this.previousSibling.value=8-this.previousSibling.value" name="oui4">
										</td>
										
									</fieldset>
								</tr>
							</tbody>
						</table>
						<button class="add">add</button>
						<p data-toggle="tooltip" title="sfdsfdsf">fdfdf</p>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
     <div class="modal-body">

		<div class=" text-center ">
			<input type="checkbox" name="" id=""> surdosage
			<input type="checkbox" name="" id=""> sousdosage
			<input type="checkbox" name="" id=""> interaction médicamenteuse
			<input type="checkbox" name="" id=""> redondance
			<input type="checkbox" name="" id=""> contre indication abosulue / précaution d'emploi /utilisation déconseillé
		</div>

		<div class="content">
			<div class="alert alert-warning" role="alert">
				<h2 class="text-center">Surdosage</h2>
				<div class="content">
					<table class="table bg-primary">
						<tr>
							<td rowspan="3">
								<strong>Terrain Physiopathlogique :</strong>
								

							</td>
							<td>
								<select name="profiles[]" id="" class="form-control">
									<option value="">Adulte</option>
									<option value="">Enfant</option>
									<option value="">Nourisson</option>
									<option value="">Nouveau-Née</option>
									<option value="">Insuffisance réanle légère</option>
									<option value="">Insuffisance réanle modéré</option>
									<option value="">Insuffisance réanle sévère</option>
									<option value="">Alcoolique</option>
									<option value="">Enceinte</option>
									<option value="">insuffisance hépatique</option>
								</select>								
							</td>
							<td>
								<button class="btn btn-success">Et</button>
							</td>
						</tr>						
						<tr>
							<td>Poids</td>
							<td>
								<select name="poids[op]" id="" class="form-control">
									<option value="max"><=</option>
									<option value="min">>=</option>
								</select>
							</td>
							<td>
								<input type="text" name="poids[value]" placeholder="valeur" class="form-control">
							</td>
							<td>
								<select name="poids[type]" id="" class="form-control">
									<option value="kg">kg</option>
									<option value="g">g</option>
								</select>
							</td>						
						</tr>
						<tr>
							<td>Age</td>
							<td>
								<select name="age[op]" id="" class="form-control">
									<option value="max"><=</option>
									<option value="min">>=</option>
								</select>
							</td>
							<td>
								<input type="text" name="age[value]" placeholder="valeur" class="form-control">
							</td>	
							<td>
								<select name="age[type]" id="" class="form-control">
									<option value="ans">ans</option>
									<option value="mois">mois</option>
									<option value="semaines">semaines</option>
									<option value="semaines">semaine de grossesse</option>
								</select>								
							</td>						
						</tr>
					</table>
					<p class="bg-success"><strong>Adulte et insuffisance rénale modéré et à partir de 15 ans et inferieur a 55kg....</strong></p>
					<div class="form-group"><label for="">Dose Max</label><input type="text" class="form-control" name="doseMax" id=""></div>
					<div class="form-group"><label for="">Duré max</label><input type="text" class="form-control" name="duréMax" id=""></div>
					<div class="form-group"><label for="">Fréquence max</label><input type="text" class="form-control" name="freqMax" id=""></div>
				</div>
			</div>

			<div class="alert alert-warning" role="alert">
				<h2 class="text-center">précaution d'emploi/contre indication absolue/utilisation déconseillé</h2>
				<div class="content">
					<table class="table ">
						<tr>
							<td rowspan="3">
								<strong>Terrain Physiopathlogique :</strong>
								
							</td>
							<td>
								<select name="" id="" class="form-control">
									<option value="">allergies /pathologies</option>
								</select>								
							</td>
							<td>
								<select name="" id="" class="form-control">
									<option value="">précaution d'emploi</option>
									<option value="">contre indication absolue</option>
									<option value="">Utilisation déconseillé</option>
								</select>								
							</td>							
						</tr>						
					</table>
				</div>
			</div>							
			<div class="alert alert-danger" role="alert">
				<h2 class="text-center">Interaction médicamenteuse</h2>
				<div class="row">
					
					<div class="form-group">
						<div class="col-md-5">
						<label for=""  >Médicament : médicament x interaction avec :</label>
							<select name="" id="" class="form-control">
								<option value="">médicament 1</option>
								<option value="">médicament 2</option>
								<option value="">médicament n</option>
							</select>
						</div>
						<div class="col-md-3">
							<label for="" >niveau interaction</label>
							<select name="" id="" class="form-control">
								<option value="1">Contre indication </option>
								<option value="2">Association déconseillé</option>
								<option value="3">Précaution d'emploi</option>
							</select>	
						</div>
						<div class="col-md-3">
							<label for="" >commentaire</label>
							<textarea></textarea> 
	
						</div>												
						<div class="col-md-1 pagination">
							<button class="btn btn-primary">+</button>			
						</div>
					</div>
				</div>
			</div>	
			<div class="alert alert-success" role="alert">
				<h2 class="text-center">redondance</h2>
				<div class="row">
					
					<div class="form-group">
						<div class="col-md-5">
						<label for=""  >Médicament : médicament x rendondance avec :</label>
							<select name="" id="" class="form-control">
								<option value="">médicament 1</option>
								<option value="">médicament 2</option>
								<option value="">médicament n</option>
							</select>	
						</div>
						<div class="col-md-3">
							<label for="" >commentaire</label>
							<textarea></textarea> 
	
						</div>												
						<div class="col-md-1 pagination">
							<button class="btn btn-primary">+</button>			
						</div>
					</div>
				</div>
			</div>							
		</div>

    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>			
</body>
        <script src="<?php echo e(asset('/plugins/jquery/js/jquery.min.js')); ?>"></script>
    	<script src="<?php echo e(asset('plugins/bootstrap/dist/js/bootstrap.min.js')); ?>">             </script>

        <script>
						$('[data-toggle="tooltip"]').tooltip()
        	jQuery(document).ready(function($) {
        		$('#myModal').modal('show')
        		//console.log($('html tbody>tr').length);

        		//console.log($('tbody').children('tr').eq(0).prepend("<td>new element</td>").html());
        		$result = $('tbody > tr:eq(0)').children().first().remove();
        		//console.log($result);
        		//console.log($result[0]);
        		//console.log($result.prevObject);
        		// console.log($('tbody > tr:eq(0)').html());

        		$('.add').click(function(event) {
        			var tri = $('tr');
        			var td = $('td');       			
        			$('tbody').append("<tr><fieldset> <td> <input type='hidden' name='oui4' value='0'> <input type='radio' onclick='this.previousSibling.value=1-this.previousSibling.value' name='oui4'> </td> <td> <input type='hidden' name='oui4'  value='1'> <input type='radio' onclick='this.previousSibling.value=8-this.previousSibling.value' name='oui4'> </td></fieldset></tr>");
        		});
    	function getMessage() {
        		$.ajax({
				headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

        			url: 'eventTest',
        			type: 'get',
        		})
        		.done(function(data) {
        			console.log(data);
        		})			
    	}
    	setTimeout(getMessage(), 2000);
var i = 1;                     //  set your counter to 1

function myLoop () {           //  create a loop function
   setTimeout(function () {    //  call a 3s setTimeout when the loop is called
      console.log('hello');          //  your code here
      i++;                     //  increment the counter
      if (i < 10) {            //  if the counter < 10, call the loop function
         myLoop();             //  ..  again which will trigger another 
      }                        //  ..  setTimeout()
   }, 3000)
}

myLoop();                      //  start the loop
      });
        </script>   
</html><?php /**PATH C:\laragon\www\anapharm\resources\views\test.blade.php ENDPATH**/ ?>