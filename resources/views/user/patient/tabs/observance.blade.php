<!-- {{-- tab questionnaire --}} -->
<div class="tab-pane {{ session('tab') == 'tab_8' ? 'active in' : '' }}" id="tab_8">
    <div class="clearfix">
        @can('questionaires.create', Auth::user())
            @if (!$patient->readonly)
                <button type="button" class="btn btn-primary float-left" title="Raccourci(o)" data-toggle="modal"
                    data-target="#modal_question">Lancer questionnaire</button>
            @endif
        @endcan
        @can('questionaires.export', Auth::user())
            <a href="/export/ques/{{ $patient->id }}"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        @endcan
    </div>

    <div class="box box-widget">
        <div class="box-body">
            <div class="row">
                <div class="col-sm-12 ">
                    <table id="example21" class="nowrap table table-bordered table-hover text-center">
                        <thead style="background-color: #390d70c2 !important; color:white">
                            <tr>
                                <th>Num°</th>
                                <th>Type questionnaire</th>
                                <th>Date</th>
                                <th>Observations</th>
                                @can('questionaires.delete', Auth::user())
                                    <th>Supprimer</th>
                                @endcan
                                <th>Annotation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->questionnaires as $res)
                                <tr>
                                    <th>{{ $loop->index + 1 }}</th>
                                    <th>{{ $res->type }}</th>
                                    <th>{{ $res->pivot->date_questionnaire }}</th>
                                    <th>
                                        @if ($res->pivot->reponse == '1' || $res->pivot->reponse == '2')
                                            <p class=" label-warning">Patient modérément observant</p>
                                        @elseif ($res->pivot->reponse == "3" || $res->pivot->reponse == "4")
                                            <p class=" label-danger">Patient non observant</p>
                                        @else
                                            <p class=" label-success">Patient très observant</p>
                                        @endif
                                    </th>
                                    @can('questionaires.delete', Auth::user())
                                        <td>
                                            @if (!$patient->readonly)
                                                <a href="" class="deleteRow"
                                                    data-url="/patient/questionnairePatient/destroy/{{ $res->pivot->questionnaire_id }}&{{ $patient->id }}&{{ $res->pivot->user_id }}&{{ $res->pivot->date_questionnaire }}"
                                                    style="color: inherit; cursor: pointer;"><span
                                                        class="glyphicon glyphicon-trash fa-2x"></span></a>
                                            @endif
                                        </td>
                                    @endcan
                                    <td>
                                        @if (!$patient->readonly)
                                            <a href="#" id="btn_ann_obs" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="observance"
                                                data-id="{{ $res->date_questionnaire }}">
                                                <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
