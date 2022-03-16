<!--tab Education thérapeutique-->
<div class="tab-pane {{ session('tab') == 'tab_9' ? 'active in' : '' }}" id="tab_9">

    <div class="clearfix">
        @can('educations_therapeutique.create', Auth::user())
            @if (!$patient->readonly)
                <button type="button" class="btn btn-primary float-left" title="Raccourci(e)" data-toggle="modal"
                    data-target="#modal_entretien">Education Thérapeutique</button>
            @endif
        @endcan
        @can('educations_therapeutique.export', Auth::user())
            <a href="/export/et/{{ $patient->id }}"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i></button></a>
        @endcan
    </div>

    <div id="labelforma4" name="labelforma2" style="display: block">

        <div class="box box-widget">
            <div class="box-body">
                <table id="example211" class="table table-bordered table-hover text-center">
                    <thead style="background-color:#39CCCC !important; color:white">
                        <tr>
                            <th>#</th>
                            <th>Type </th>
                            <th>Date </th>
                            <th>Notes </th>
                            <th>Média </th>
                            <th>Imprimer</th>
                            <th>Annotation</th>
                            @can('educations_therapeutique.delete', Auth::user())
                                <th> Supprimer </th>
                            @endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($patient->educations as $education)
                            <tr>
                                <th>{{ $loop->index + 1 }}</th>
                                <td>{{ $education->type }}</td>
                                <td>{{ $education->date_et }}</td>
                                <td style="word-break: break-word">
                                    {{ $education->description }}
                                </td>
                                <td>
                                    <a href="#" class="open_image" data-toggle="modal" data-target="#modal_imgs"
                                        data-url="{{ $education->fichier }}"
                                        data-comment="{{ $education->description }}">
                                        <i class="fa fa-image fa-2x text-green"></i>
                                    </a>
                                </td>
                                <td>
                                    <a href="#" class="download-education" data-date="{{ $education->date_et }}"
                                        data-notes="{{ $education->description }}">
                                        <i class="fa fa-print fa-2x"></i>
                                    </a>
                                </td>
                                <td>
                                    @if (!$patient->readonly)
                                        <a href="#" id="btn_ann_educ" data-toggle="modal"
                                            data-target="#modal_annotation" data-type="edu"
                                            data-id="{{ $education->id }}">
                                            <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                        </a>

                                    @endif
                                </td>
                                @can('educations_therapeutique.delete', Auth::user())
                                    <td>
                                        @if (!$patient->readonly)
                                            <form style="display: none;" method="POST"
                                                action="{{ route('education_therapeutique.destroy', $education->id) }}"
                                                id="delete-form-{{ $education->id }}">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>

                                            <a href=""
                                                onclick="
                                                                                                                                                                         if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                                                                                         event.preventDefault();
                                                                                                                                                                         document.getElementById('delete-form-{{ $education->id }}').submit();										}
                                                                                                                                                                        "
                                                style="color:black"><span class="fa fa-trash text-red fa-2x"></span></a>
                                        @endif
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @can('analyse_therap', Auth::user())
            @if (count($patient->ReglesEduPatient) > 0)
                <div class="box box-widget">
                    <div class="box-header">
                        <h3>Educations Thérapeutiques A Faire</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <table id="example212" class="nowrap table table-bordered table-hover text-center">
                                    <thead style="background-color:#39CCCC !important; color:white">
                                        <tr>
                                            <th>Num° prescription</th>
                                            <th>Fait par le medecin</th>
                                            <th>Titre</th>
                                            <th>Date et heure</th>
                                            <th>Action</th>
                                            <th>Détails</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patient->ReglesEduPatient as $regle_presc_edu)
                                            @if ($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'risqueTherap')
                                                <tr>
                                                    <td>
                                                        {{ $regle_presc_edu->prescription_id }}
                                                    </td>
                                                    <td>
                                                        {{ $regle_presc_edu->PrescEducConcerne->prescripteur->name }}
                                                        {{ $regle_presc_edu->PrescEducConcerne->prescripteur->prenom }}
                                                    </td>
                                                    <td>
                                                        {{ $regle_presc_edu->RegleEducConcerne->titre }}
                                                    </td>
                                                    <td>
                                                        {{ $regle_presc_edu->created_at }}
                                                    </td>
                                                    <td>
                                                        <a
                                                            href="{{ route('patient.FaireEducation', [$regle_presc_edu->prescription_id]) }}">
                                                            <button class="btn btn-primary">Faire</button>
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn BTNANALYSE"
                                                            data-id="{{ $patient->id }}"
                                                            data-risque="{{ $regle_presc_edu->prescription_id }}">Details</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            @endif
        @endcan
    </div>
</div>
