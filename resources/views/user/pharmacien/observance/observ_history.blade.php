@extends('layouts.model')

@section('content')

<div class="content-wrapper">
	<section class="content">

		<div class="row">

			<div class="col-sm-12 ">
							<div class="box  box-widget">
								<div class="box-header">
									<h2>Historique des Observances</h2>
								</div>

								<div class="box-body">
										<div class="row">
											<div class="col-sm-12">
												<table id="his_obs" class="table table-responsive text-center dataTable" >
													<thead>
														<tr class="bg-teal-active">
															<th>Num</th>
															<th>Patient </th>
															<th>Questionnaire</th>
															<th>Observance </th>
															<th>Date Observance</th>
															{{-- <th>Détails</th> --}}
														</tr>
													</thead>
													
													<tbody>
														@foreach ($questionnaires as $ques)
															<tr>
																<th> {{ $loop->index+1 }}</th>
																<td> {{ $ques->nom  }}  {{ $ques->prenom }} </td>
																<td> {{ $ques->type  }}  </td>
																<th> 
																	@if ($ques->reponse == "1" || $ques->reponse =="2")
																			<p class=" label-warning">Patient modérément observant</p>
																			@elseif ($ques->reponse == "3" || $ques->reponse == "4")
																			<p class=" label-danger">Patient non observant</p>
																			@else
																			<p class=" label-success">Patient très observant</p>
																		@endif
																</th>
																<td> {{ date('d/m/Y',strtotime($ques->date_questionnaire)) }}</td>
{{-- 																<td> 
																	<button type="button" class="btn btn-danger execute" data-id="{{  }}">détails</button>
																</td> --}}
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
								</div>
							</div>
			</div>

		</div>

	</section>
</div>

@endsection

@section('script')
<script type="text/javascript">
	$("#his_obs").DataTable(); //phyto    
</script>
@endsection
