


<div class="tab-pane" id="tab_123" >
@can('prescriptionChimio.create')
  <a type="button" class="btn btn-primary float-left" href="{{(route('po',$patient))}}">Ajouter un Traitement</a>
@endcan

   @if($traitement->isEmpty())
   <br><br>
                      
                         <div class="isa_info" style="width: 80%; text-align: center;position: relative; left: 10%">
                          <h4><i class="fa fa-info-circle"></i> Aucun Traitement de chimiothérapie trouvé veuillez ajouter un</h4>
                          
                      </div>
                        @else
                       
<!--box tous les prescriptions -->
<div class="box box-widget">	
	<div class="box-body">
		 <div class="box-header">
									<h4>LIST DES TRAITEMENTS</h4>
								</div>

	<table class="fold-table" id="tab_trait">
		<thead>
			<tr>
			<th>Etat</th><th>Protocole</th><th>Date Traitement</th><th>Maladie</th><th>Localisation</th><th>N° Cure prevu</th><th>Date Début Cure</th><th>Médecin</th>
			</tr>
		</thead>
		<tbody>
			@foreach($traitement as $t)

			<tr class="view">
      <td>{{$t->valide}}</td>
			<td>{{DB::table('protocole')->where('id',$t->protocole_id)->pluck('nom')->first()}}</td>
			<td>{{$t->date_debut_traitement}}</td>
			<td>{{DB::table('pathologies')->where('id',$t->pathologies_id)->pluck('pathologie')->first()}}</td>
			<td>{{$t->localisation}}</td>
			<td>{{$t->nombre_cure_prevu}}</td>
			<td>{{DB::table('cure')->where('traitement_id',$t->id)->pluck('date_debut_cure')->first()}}</td>
			<td>{{DB::table('users')->where('id',$t->medecin_id)->pluck('name')->first()}}</td>
			</tr>




			<tr class="fold">
			<td colspan="8">
				<div class="fold-content">
				<div class="col-sm-12" style="text-align:right">
					<a href="{{route('detailProtocole',$t->protocole_id) }}" class="btn btn-default btn-xs">Afficher le protocole</a>&nbsp;
					<button type="button" class="btn btn-default btn-xs" onclick="getRemarque('{{$t->commentaire}}')">Afficher le commentaire</button>&nbsp;
           @if($t->valide != 'Arreter')
           @can('prescriptionChimio.create')
					<button type="button" class="btn btn-default btn-xs" id="addcure" onclick="addCure({{$t->id}},{{$t->nombre_cure_prevu}})">Ajouer une cure</button>&nbsp;
					@endcan
          @can('prescriptionChimio.update', Auth::user())
          <button type="button" id="modifcurenb" class="btn btn-default btn-xs">modifier nombre de cure prevu</button>&nbsp;
					<button type="button" onclick="arreterTraitement({{$t->id}})"  id="arreter" class="btn btn-danger btn-xs">Arrêter le traitement
          </button>
          @endcan
          @else

          <button type="button" class="btn btn-default btn-xs" onclick="afficheCommArreter('{{DB::table('users')->where('id',$t->medecin_id)->pluck('name')->first()}}', '{{$t->comm_arrete}}','{{$t->date_arrete}}')">Raison d'arreter le traitement </button> &nbsp;

          @endif
          @can('prescriptionChimio.delete', Auth::user())
          <button type="button" onclick="deletetraitement({{$t->id}})" class="btn btn-danger btn-xs">Supprimer</button>&nbsp;
          @endcan
        
				</div><br><br>

        
					<h3>List des prescriptions du traitement chimiothérapie suivie: </h3>

				 @php $cures = DB::table('cure')->where('traitement_id',$t->id)->get();@endphp
				@foreach($cures as $key=>$cure)

				<strong>Cure n°{{$cure->numero}} ({{$cure->date_debut_cure}}): {{$cure->commentaire}}</strong>
				<table>
					<thead>
					<tr>
						<th style="width: 10%;text-align:center">Etat</th>
            <th style="width: 40%;text-align:center">Date prescription</th>
            <th style="width: 10%;text-align:center">Jour</th>
            <th style="width: 40%;text-align:center">Action</th>
					</tr>
					</thead>
					<tbody>
						@php $sequences = DB::table('sequences')->where('cure_id',$cure->id)->get();@endphp
						  <input type="hidden" id="taillehhid" value="{{$sequences[0]->taille}}">
						   <input type="hidden" id="poidshidd" value="{{$sequences[0]->poids}}">
						    <input type="hidden" id="massehidd" value="{{$sequences[0]->masse}}">
						@foreach($sequences as $seq)						
					<tr 
          @if($seq->etat == 'prevue' && $seq->date_debut != date('Y-m-d'))
          style="background-color: #DDDDDD;text-align: center"
          @elseif($seq->etat == 'demande')
          style="background-color: #C6E2FF;text-align: center"
          @elseif($seq->etat == 'Arreter')
          style="background-color: #FF7373;text-align: center"

          @else
          style="background-color:  #FFFFFF;text-align: center"

          @endif
          >
						<td>{{$seq->etat}}</td>
						<td>{{$seq->date_debut}}</td>
						<td>{{$seq->jour}}</td>

						<td><a href="{{(route('pres',$seq->id))}}" class="btn btn-default btn-xs">Afficher</a>
            @can('prescriptionChimio.delete', Auth::user())
					
          @if($seq->etat != 'Arreter')
            <button type="button" class="btn btn-danger btn-xs" id="arreter" onclick="arreterSequence({{$seq->id}})">Arreter</button>	
          @else
            <button type="button" class="btn btn-default btn-xs" onclick="afficheCommArreterSeq('{{DB::table('users')->where('id',$seq->id_user_arrete)->pluck('name')->first()}}', '{{$seq->comm_arrete}}','{{$seq->date_arrete}}')">Raison d'arreter la sequence </button> &nbsp;
					@endif
          @if($seq->etat == 'prevue' || $seq->etat == 'prescrite' || $seq->etat == 'demande' || $seq->etat == 'Arreter')
            <button type="button" class="btn btn-danger btn-xs" id="suppp" onclick="deletePrescription({{$seq->id}})">Supprimer</button>
          @endif
            @endcan
						</td>
					</tr>
					
					@endforeach
					</tbody>
				</table>  <br>
        

				@endforeach  
        
				</div>
			</td>
			</tr>

			@endforeach
		
            </tbody>
          </table>
									
	</div>	
</div>
<!--box prescription-->
 @endif
  
</div>
<!-- modal commentaire-->
<div class="modal fade" id="modal-commentaire">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">COMMENTAIRE</h4>
              </div>           
              <div class="modal-body">
                <div class="box-body">
                	<div class="col-sm-12" style="text-align: center"><b id="commt" ></b></div>
              </div>
              </div>
              <div class="modal-footer">
                 <input id="b" type="submit" class="btn btn-primary" data-dismiss="modal" value="Quiter">
              </div>      
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>  

        <!-- modal add cure-->
<div class="modal fade" id="modal-cure">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">AJOUTER UNE CURE</h4>
              </div>           
                	<form action="{{ route('addCure') }}" method="post">
                            {{ csrf_field() }}
              <div class="modal-body">
                <div class="box-body">
                	<div class="col-sm-12">
                		<div class="col-sm-6">
                			<div class="form-group" style="text-align: center">
						       <label class="control-label">Numero de cure</label>
						           <input type="number" name="numeroCure" id="numeroCure" class="form form-control" style="text-align: center" value="" required disabled>
						           <input type="hidden" name="numeroCuree" id="numeroCuree">
				     		</div>
                		</div>
                		<div class="col-sm-6">
                			<div class="form-group" style="text-align: center">
						       <label class="control-label">Début de la cure</label>
						           <input type="date" name="datecure" id="datecure" class="form form-control"  placeholder="" style="text-align: center" value="" required onchange="commRequired()">
				     		</div>
                		</div>
                		<div class="col-sm-4">	
                			<label class="control-label">Taille(cm)</label>
             				<input type="number" id="taillecure" name="taillecure" class="form-control"  style="text-align: center" value="" onchange="calculeSC()" required>
                		</div>
                		<div class="col-sm-4">
                			<label class="control-label">Poids(kg)</label>
             				<input type="number" id="poidscure" name="poidscure" step="0.01" class="form-control"  style="text-align: center" value="" onchange="calculeSC()" required>
                		</div>
                		<div class="col-sm-4">
                			<label class="control-label">Surf. corporelle(m²)</label>
             				<input type="number" id="massecure" name="massecure" class="form-control" step="0.01" style="text-align: center" value="" disabled required placeholder="Surff (m²)"><br>
             				<input type="hidden" name="massecuree" id="massecuree" value="">
                		</div>
                		<div class="form-group" style="text-align: center">  
                     		 <label class="control-label" hidden id="commR"><p style="color: red; font-size: 18px">Date début = date fin cure précédente + intervalle entre cure</p>Date début de la cure est calculé automatiquement <br>Changé la date vous oblige a écrire un commentaire</label>
                                <textarea id="commmm" name="commmm" class="col-xs-12 col-md-12" placeholder="Ecrivez quelque chose a propos de la cure ajouté" name="commmm" ></textarea>
                   </div>  
                	</div>
              
				    
                	
              </div>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Annuler</button>
                 <input id="bx" type="submit" class="btn btn-primary" value="Ajouter">
              </div>  
              <input type="hidden" name="idTraitement" id="idTraitement">
                </form>    
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
               <!-- modal add arrete-->
<div class="modal fade" id="modal-arreter">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rasion d'arreter le traitement</h4>
              </div>           .
              <div class="modal-body">
                <div class="box-body">               
              <div class="col-sm-12" style="text-align: center"><b id="arreterr" ></b></div>  
              </div>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-primary" data-dismiss="modal">Quiter</button>
              </div> 
               
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
                      <!-- modal add arrete sequence-->
<div class="modal fade" id="modal-arreterSeq">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Rasion d'arreter la prescription</h4>
              </div>
              <div class="modal-body">
                <div class="box-body">               
              <div class="col-sm-12" style="text-align: center"><b id="arreterrseq" ></b></div>  
              </div>
              </div>
              <div class="modal-footer">
                 <button type="button" class="btn btn-primary" data-dismiss="modal">Quiter</button>
              </div> 
               
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div> 
         
{{-- <script src="{{asset('plugins/sweetAlert/sweetalert.js')}}"></script>
<script src="{{asset('plugins/math.js')}}"></script>
@if(session('notif'))
      <script type="text/javascript">
               
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      });

      Toast.fire({
        type: 'success',
        title: '{{session('notif')}}'
      })
      </script>
    @endif
<script type="text/javascript">
	 //delete prescription
  function deletePrescription(id){
   Swal.fire({
    backdrop: `
    rgba(255,0,0,0.4)
  `,
  title: 'Êtes-vous sûr?',
  text: "Vous ne pourrez pas revenir en arrière!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, supprimez-le!',
  cancelButtonText:'Annuler'

}).then((result) => {
  if (result.value) {
        $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/prescriptionDelete/"+id,
                method : "GET",              
                success: function(data){                  
                  Swal.fire({
                    title:'Supprimé!',
                    text:'La Prescription a été supprimé..',
                    type:'success',
                     onClose :function () {
                         window.location.reload();
                      }
                  }                   
                  )           
                },
                error: function(data){
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Quelque chose a mal tourné!'
                    })
                  }
              }); 
  }
})
  }
	 //calcule SC
    function calculeSC(){
      //récupérer formule
      var formule = '{{$formule}}';

      var taille = document.getElementById("taillecure").value;
      var poids = document.getElementById("poidscure").value;
      //replacer poids et taille dans la formule
      formule = formule.replace("POIDS", poids);
      formule = formule.replace("TAILLE", taille);

      if (taille!=0 && poids !=0) {
        var SC = math.eval(formule);
        document.getElementById("massecure").value = SC.toFixed(2);
        document.getElementById("massecuree").value = SC.toFixed(2);
      }
      else
        document.getElementById("massecure").value='';
    }
	//commRequired
	function commRequired(){
		 document.getElementById("commR").hidden = false;
		 document.getElementById("commmm").required = true;

	}
  //afficher comm arreter traitement
  function afficheCommArreter(nom , comm, date){
    var myModal = $('#modal-arreter');
    document.getElementById("arreterr").innerHTML = 'Traitement arreter par: '+nom+' le: '+date+'<br>'+comm;
    myModal.modal({ show: true });
  }
   //afficher comm arreter sequence
  function afficheCommArreterSeq(nom , comm, date){
    var myModal = $('#modal-arreterSeq');
    document.getElementById("arreterrseq").innerHTML = 'Prescription arreter par: '+nom+' le: '+date+'<br>'+comm;
    myModal.modal({ show: true });


  }
	//ajouter une cure
	function addCure(id, cure_pevu){
		 $.ajax({
                //headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/countCure/"+id,
                dataType: "json",
                method : "GET",              
                success: function(resultat){              
                    if (parseInt(resultat) == cure_pevu) {	 
						Swal.fire({
						  type: 'error',
						  title: 'Oops...',
						  text: 'Vous avez atteint le nombre maximum de cure prevu pour ce traitement!'
						})
                    }
                    else{
                    	 $.ajax({
		                		//headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
				                url: "/getDateCure/"+id,
				                dataType: "json",
				                method : "GET",              
				                success: function(data){
				                	var myModal = $('#modal-cure');
				                	myModal.find('input[id="numeroCure"]').attr('value',parseInt(resultat)+1);
				                	myModal.find('input[id="numeroCuree"]').attr('value',parseInt(resultat)+1);
				                	myModal.find('input[id="datecure"]').attr('value',data);
				                	myModal.find('input[id="idTraitement"]').attr('value',id);
				                	myModal.find('input[id="taillecure"]').attr('value',document.getElementById("taillehhid").value);
				                	myModal.find('input[id="poidscure"]').attr('value',document.getElementById("poidshidd").value);
				                	myModal.find('input[id="massecuree"]').attr('value',document.getElementById("massehidd").value);
				                	myModal.find('input[id="massecure"]').attr('value',document.getElementById("massehidd").value);
				                	myModal.modal({ show: true });
				                },
				                error: function(data){
				                    Swal.fire({
				                      type: 'error',
				                      title: 'Oops...',
				                      text: 'Quelque chose a mal tourné!'
				                    })
				                  }
				              }); 
                    }
                },
                error: function(resultat){
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Quelque chose a mal tourné!'
                    })
                  }
              }); 

	}

	//supp traitement
  function deletetraitement(id){
Swal.fire({
    backdrop: `
    rgba(255,0,0,0.4)
  `,
  title: 'Êtes-vous sûr?',
  text: "Vous ne pourrez pas revenir en arrière!",
  type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#d33',
  cancelButtonColor: '#3085d6',
  confirmButtonText: 'Oui, supprimez-le!',
  cancelButtonText:'Annuler'

}).then((result) => {
  if (result.value) {
        $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/chimio/traitement/delete/"+id,
                method : "GET",              
                success: function(data){                  
                  Swal.fire({
                    title:'Supprimé!',
                    text:'Le Traitement a été supprimé..',
                    type:'success',
                     onClose :function () {
                        window.location.reload();
                      }
                  }                   
                  )           
                },
                error: function(data){
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Quelque chose a mal tourné!'
                    })
                  }
              }); 
  }
})
  }
  //get remarque
  function getRemarque(remarque){
  	//alert(remarque);
  	var myModal = $('#modal-commentaire');
  	//id="commt"
  	if (remarque != '') {
  		document.getElementById("commt").innerHTML = remarque;
  	}else{
  		document.getElementById("commt").innerHTML = 'Pas de commentaire a affiché';
  	}
  	

  	myModal.modal({ show: true }); 

  }

  //arreter traitement
  function arreterTraitement(id){

  Swal.fire({
  title: 'Pourquoi voulez vous arrêter le traitement ?',
  input: 'textarea',
  inputPlaceholder: 'Tapez votre commentaire ici...',
  cancelButtonText:'Annuler',
  confirmButtonText: 'Arrêter',
  showCancelButton: true
}).then((result) => {
  if (result.value) {
      $.ajax({
               // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: "/chimio/traitement/arrete/"+id,
                method : "GET", 
                data : {
                  id: id,
                  text :result.value
                },            
                success: function(){                  
                  Swal.fire({
                    title:'Arrêter!',
                    text:'Le Traitement a été Arrêter...',
                    type:'success',
                    onClose :function () {
                        window.location.reload();
                      }
                  }                   
                  )           
                },
                error: function(data){
                    Swal.fire({
                      type: 'error',
                      title: 'Oops...',
                      text: 'Quelque chose a mal tourné!'
                    })
                  }
              });   
  }

})


}

  //arreter sequence
  function arreterSequence(id){

Swal.fire({
title: 'Pourquoi voulez vous arrêter la prescription ?',
input: 'textarea',
inputPlaceholder: 'Tapez votre commentaire ici...',
cancelButtonText:'Annuler',
confirmButtonText: 'Arrêter',
showCancelButton: true
}).then((result) => {
if (result.value) {
    $.ajax({
             // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              url: "/chimio/sequence/arrete/"+id,
              method : "GET", 
              data : {
                id: id,
                text :result.value
              },            
              success: function(){                  
                Swal.fire({
                  title:'Arrêter!',
                  text:'La Prescription a été Arrêter...',
                  type:'success',
                  onClose :function () {
                      window.location.reload();
                    }
                }                   
                )           
              },
              error: function(data){
                  Swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'Quelque chose a mal tourné!'
                  })
                }
            });   
}

})

}

  
  
</script> --}}

