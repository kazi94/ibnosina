@extends('layouts.model')

@section('script_css')
	<link rel="stylesheet" href="{{ asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css')}}">
	<link rel="stylesheet" href="{{ asset('plugins/jquery/css/jquery_ui.css')}}">
@endsection

@section('content')


<div class="content-wrapper">

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
    <div class="col-md-8 col-xs-12 col-md-offset-2">
			<!-- Horizontal Form -->
			<div class="box box-info">

				<div class="box-header with-border">

					<h1 class="box-title" aling="center"> Détails de la réponse pharmacovigilance</h1>

				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<div class="box-body">
                     <form method="POST" action="{{ route('pharmaco.update', $pharmaco->id) }}" enctype="multipart/form-data">
                     {{ csrf_field() }}
                     {{ method_field('PATCH') }}
                     <div class="form-group col-sm-12">
                        @php
		                      $r =  DB::select('select * from pharmacos where id = ?',[$pharmaco]);
		                @endphp
                                                       
                     <label for="exampleFormControlSelect">Date de déclaration:</label>
                     <div>{{ $pharmaco->date_declaration_rapporteur }}</div>
                     </div>

                     <div class="form-group col-sm-12">
                      <h3 aling="center" style="color:blue">____________________Informations malade____________________</h3>
                      </div>
                    <div class="row">
                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">Nom: {{ $pharmaco->nom_pharmaco}}</label>
                      </div>
                      
                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">Age: {{ $pharmaco->age_du_malade}}</label>
                      </div>


                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">poids: {{ $pharmaco->poids}}</label>
                      </div>
                    </div>

                    <div class="row">
                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">Taille: {{ $pharmaco->taille}}</label>
                      </div>


                      <div class="form-group col-sm-4">
                      <label for="exampleFormControlSelect">Sexe: {{ $pharmaco->sexe}}</label>
                      
                      </div>

                      </div><!---row-->
                      <div class="form-group col-sm-12">
                      <h3 aling="center" style="color:blue">_____________Description de la réaction indésirable_____________</h3>
                      </div>
                    

                      <div class="form-group">
                        <label for="exampleFormControlTextarea" >Description de la réaction (nature, localisation, gravité, caractéristiques): {{ $pharmaco->description_reaction}}</label>
                      </div>
                
                       
                         <div class="form-group col-sm-6">
                         <label for="exampleFormControlSelect">Date d'apparition: {{ $pharmaco->date_d_apparition}}</label>
                         </div>

                         <div class="form-group col-sm-6">
                         <label for="exampleFormControlSelect">Durée: {{ $pharmaco->duree}}</label>
                         </div>

                         <div role="tabpanel">

                         <ul class="nav nav-tabs"  id="tablist">
                         <li role="presentation" class="active" id ="medic1"><a href="#medicament1" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 1</a></li>
                         <li role="presentation" id="medic2"><a href="#medicament2" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 2</a></li>
                         <li role="presentation" id="medic3"><a href="#medicament3" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 3</a></li>
                         <li role="presentation" id="medic4"><a href="#medicament4" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 4</a></li>
                         <li role="presentation" id="medic5"><a href="#medicament5" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 5</a></li>
                         <li role="presentation" id="medic6"><a href="#medicament6" aria-controls="medicament" role="tab" data-toggle="tab">Médicament 6</a></li>
                         
                         </ul>
                         <div class="tab-content">
                      	    <!--ici c'est le contenu de l'onglet 1-->
                            <div role="tabpanel" class="tab-pane active" id="medicament1">


                            <div class="form-group col-sm-12">
                             <label for="medicament"> <br/>Médicament 1 en DCI: {{ $pharmaco->medicament1}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">N° lot: {{ $pharmaco->n_lot1}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Voie d'administration: {{ $pharmaco->voie_admin1}}</label>
                            </div>


                            <div class="form-group col-sm-12">
                             <label for="medicament">Posologie: {{ $pharmaco->posologie1}}</label>
                            </div>
                          
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'amin début: {{ $pharmaco->date_admin_debu1}}</label>
                            </div>
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'aministration fin: {{ $pharmaco->d_admin_fin1}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Raison d'emploi: {{ $pharmaco->raison_d_emp1}}</label>
                            </div>
                            </div><!--tabpanel medic1-->







                            <div role="tabpanel" class="tab-pane" id="medicament2"><!--onglet 2-->

                            <div class="form-group col-sm-12">
                             <label for="medicament"><br/>Médicament 2 en DCI: {{ $pharmaco->medicament2}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">N° lot: {{ $pharmaco->n_lot2}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Voie d'administration: {{ $pharmaco->voie_admin2}}</label>
                            </div>


                            <div class="form-group col-sm-12">
                             <label for="medicament">Posologie: {{ $pharmaco->posologie2}}</label>
                            </div>
                          
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'amin début: {{ $pharmaco->date_admin_debu2}}</label>
                            </div>
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'aministration fin: {{ $pharmaco->d_admin_fin2}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Raison d'emploi: {{ $pharmaco->raison_d_emp2}}</label>
                            </div>
                                 
                            </div><!--tabpanel medic2-->


                              <div role="tabpanel" class="tab-pane" id="medicament3"><!--onglet 3-->

                            <div class="form-group col-sm-12">
                             <label for="medicament"><br/>Médicament 3 en DCI: {{ $pharmaco->medicament3}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">N° lot: {{ $pharmaco->n_lot3}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Voie d'administration: {{ $pharmaco->voie_admin3}}</label>
                            </div>


                            <div class="form-group col-sm-12">
                             <label for="medicament">Posologie: {{ $pharmaco->posologie3}}</label>
                            </div>
                          
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'amin début: {{ $pharmaco->date_admin_debu3}}</label>
                            </div>
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'aministration fin: {{ $pharmaco->d_admin_fin3}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Raison d'emploi: {{ $pharmaco->raison_d_emp3}} </label>
                            </div>
                                 
                            </div><!--tabpanel medic3-->



                              <div role="tabpanel" class="tab-pane" id="medicament4"><!--onglet 4-->

                            <div class="form-group col-sm-12">
                             <label for="medicament"><br/> Médicament 4 en DCI: {{ $pharmaco->medicament4}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">N° lot: {{ $pharmaco->n_lot4}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Voie d'administration: {{ $pharmaco->voie_admin4}}</label>
                            </div>


                            <div class="form-group col-sm-12">
                             <label for="medicament">Posologie: {{ $pharmaco->posologie4}}</label>
                            </div>
                          
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'amin début: {{ $pharmaco->date_admin_debu4}}</label>
                            </div>
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'aministration fin: {{ $pharmaco->d_admin_fin4}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Raison d'emploi: {{ $pharmaco->raison_d_emp4}}</label>
                            </div>
                                 
                            </div><!--tabpanel medic4-->






                             <div role="tabpanel" class="tab-pane" id="medicament5"><!--onglet 5-->

                            <div class="form-group col-sm-12">
                             <label for="medicament"><br/>Médicament 5 en DCI: {{ $pharmaco->medicament5}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">N° lot:  {{ $pharmaco->n_lot5}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Voie d'administration: {{ $pharmaco->voie_admin5}}</label>
                            </div>


                            <div class="form-group col-sm-12">
                             <label for="medicament">Posologie: {{ $pharmaco->posologie5}}</label>
                            </div>
                          
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'amin début: {{ $pharmaco->date_admin_debu5}}</label>
                            </div>
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'aministration fin: {{ $pharmaco->d_admin_fin5}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Raison d'emploi: {{ $pharmaco->raison_d_emp5}}</label>
                            </div>
                                 
                            </div><!--tabpanel medic5-->





                             <div role="tabpanel" class="tab-pane" id="medicament6"><!--onglet 6-->

                            <div class="form-group col-sm-12">
                             <label for="medicament"><br/>Médicament 6 en DCI: {{ $pharmaco->medicament6}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">N° lot: {{ $pharmaco->n_lot6}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Voie d'administration: {{ $pharmaco->voie_admin6}}</label>
                            </div>


                            <div class="form-group col-sm-12">
                             <label for="medicament">Posologie: {{ $pharmaco->posologie6}}</label>
                            </div>
                          
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'amin début: {{ $pharmaco->date_admin_debu6}}</label>
                            </div>
                        
                            <div class="form-group col-sm-12">
                             <label for="medicament">Date d'aministration fin: {{ $pharmaco->d_admin_fin6}}</label>
                            </div>
                            <div class="form-group col-sm-12">
                             <label for="medicament">Raison d'emploi: {{ $pharmaco->raison_d_emp6}}</label>
                            </div>
                                 
                            </div><!--tabpanel medic6-->
                            
                            </div><!--tab content-->
                        </div><!--role tabpanel-->
                      <div class="form-group col-sm-12">
                      <h3 aling="center" style="color:blue">_____________Traitement de la réaction indésirable____________</h3>
                      </div>

                      <div class="form-group col-sm-12">
                      <label >Nature du traitement : {{ $pharmaco->nature_traitement}} </label>
                    
                      </div>

                      <div class="form-group col-sm-12">
                        <label for="exampleFormControlTextarea" >Descriptif du traitement: {{ $pharmaco->desc_traitement}}</label>
                      </div>
                      
                
                <div class="form-group col-sm-12">
                <label >Evolution: {{ $pharmaco->evolution}}</label>
                 </div>    

                 <div class="form-group col-sm-12">
                      <label for="exampleFormControlSelect">Sequelle: {{ $pharmaco->sequelle}}</label>
                      
                      </div>
                

                <div class="form-group">
                        <label for="exampleFormControlTextarea" >Histoire de la maladie ou commentaires: <p>{{ $pharmaco->histoire_maladie}}</p></label>
                      </div>

                      
                <div class="form-group">
                        <label for="exampleFormControlTextarea" >Les facteurs de risques associés (insuffisance rénale, exposition antérieure au médicament suspecté, allergies antérieures, modalités d'utilisation)
: <p>{{ $pharmaco->facteurs_de_risque}}</p></label>
                      </div>

                     <div class="form-group col-sm-12">
                      <h3 aling="center" style="color:blue">____________________Identité du rapporteur___________________</h3>
                      </div>
                      <div class="form-group col-sm-4">
                             <label for="medicament">Nom: {{ $pharmaco->nom}}</label>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Prenom: {{ $pharmaco->prenom}}</label>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">N° tel/fax: {{ $pharmaco->tel}}</label>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Adresse: {{ $pharmaco->adresse}}</label>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Email: {{ $pharmaco->email}}</label>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Type experience: {{ $pharmaco->type_d_exercice}}</label>

                            </select>
                            </div>
                            <div class="form-group col-sm-4">
                             <label for="medicament">Adresse postal: {{ $pharmaco->adresse_postale}}</label>
                            </div>
                            
                     </form>
                </div><!---body-->
            </div><!--box-info-->
    </div><!--offset-->
    </div><!--row-->

 </div><!--content-->
 @endsection

@section ('script')
	<script src="{{ asset('/plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js')}}"></script>
	<script src="{{ asset('plugins/jquery/js/jquery-ui.js')}}"></script> 
	<script type="text/javascript" src="{{ asset('/js/admin/gestion_regle.js')}}"></script>
    <script>
$('#tablist a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})
</script>
@endsection