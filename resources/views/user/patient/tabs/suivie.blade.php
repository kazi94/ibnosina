                            
                        
	<div class="tab-pane" id="tab_suivie">  
		<div class="box box-widget">
			<div class="box-header">
			   <h3>Pilotage données patient:</h3>
			</div>
			<div class="box-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="box-body table-responsive no-padding">  
							<table class="table table-responsive text-center dataTable" id="tabtous">
								<thead>
									<tr class="alert alert-info">
										
										<th>Regle de suivie</th>
										<th>commentaire</th>
										<th>valeur(s) déclenchante(s)</th>
										<th>Date et heure:</th>
										<th>niveau</th>
										<th>etat</th>
										
									</tr>
								</thead>
									
									<tbody>
										@foreach ($patient->ReglesSuiviPatient as $regle_suivie)
											@if ($regle_suivie->RegleSuiviConcerne->niveau ==1)
												<tr>
											
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->si }}
													</td>
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->commentaire }}
													</td>
													<td>
														{{ $regle_suivie->valeursDeclenchantes }}
													</td>
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->created_at }}
													</td>
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->niveau }}
													</td>
													<td>
														<i class="glyphicon glyphicon-alert" style="font-size:30px;color: red;"></i>
													</td>
												</tr>
											@endif
										@endforeach
										@foreach ($patient->ReglesSuiviPatient as $regle_suivie)
											@if ($regle_suivie->RegleSuiviConcerne->niveau ==2)
														
											<tr>			
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->si }}
													</td>
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->commentaire }}
													</td>
													<td>
														{{ $regle_suivie->valeursDeclenchantes }}
													</td>
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->created_at }}
													</td>
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->niveau }}
													</td>
													<td>
														@if($regle_suivie->etat=="nonVu")
														<a href="{{route('regleSuivPatient.vu', [ $patient->id ,$regle_suivie->RegleSuiviConcerne->id ] )}}">
															<img src="{{ asset('/images/nonVu.png') }}" alt=""></a>
														@endif
														@if($regle_suivie->etat=="Vu")
															<img src="{{ asset('/images/Vu.png') }}" alt="">
														@endif
													</td>
												</tr>
											@endif
										@endforeach
										<!--@foreach ($patient->ReglesSuiviPatient as $regle_suivie)
											@if ($regle_suivie->RegleSuiviConcerne->niveau ==1 && $regle_suivie->RegleSuiviConcerne->etat == "rique")
							    				
												<tr bgcolor=''>
													
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->si }}
													</td>
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->commentaire }}
													</td>
													<td>
														{{ $regle_suivie->valeursDeclenchantes }}
													</td>
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->created_at }}
													</td>
													<td>
														{{ $regle_suivie->RegleSuiviConcerne->niveau }}
													</td>
													<td>
														{{ $regle_suivie->etat }}
													</td>
												</tr>
											@endif
										@endforeach-->
								</tbody>

							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


