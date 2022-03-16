<!--tab Consultation-->
<div class="tab-pane {{ session('tab') == 'tab_10' ? 'active in' : '' }}" id="tab_10">

    <div class="clearfix">
        @can('consultations.create', Auth::user())
            @if (!$patient->readonly)
                <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                    data-target="#modal_consultation" title="Raccourci(c)">Ajouter une Consultation</button>
            @endif
        @endcan
        @can('consultations.export', Auth::user())
            <a href="/export/consultation/{{ $patient->id }}"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> </button></a>
        @endcan
    </div>

    <div class="box box-widget">

        <div class="box-header">
            <h4>Consultations</h4>
        </div>

        <div class="box-body ">
            <div class="">
                <div class="col-sm-12 table-responsive">
                    <table id="table_consultation" class=" table table-bordered table-hover text-center" width="100%"
                        cellspacing="0">
                        <thead style="background-color: #5a3f15 !important; color:white">
                            <tr>
                                <th>Num°</th>
                                <th>Date</th>
                                <th>Détails</th>
                                @can('consultations.update', Auth::user())
                                    @if (!$patient->readonly)
                                        <th>Modifier</th>
                                    @endif
                                @endcan
                                @can('consultations.delete', Auth::user())
                                    @if (!$patient->readonly)
                                        <th>Supprimer</th>
                                    @endif
                                @endcan
                                @if (!$patient->readonly)
                                    <th>Annotation</th>
                                @endif

                                <th>Orientation</th>
                                <th>Certificat</th>

                                <th>Compte rendu</th>

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($patient->consultations as $consultation)
                                <tr>
                                    <td> {{ $loop->index + 1 }} </td>
                                    <td>{{ $consultation->date_consultation }}</td>
                                    <td>
                                        <a href="#detail-consultation" class="detailConsultation"
                                            title="Détails de la consultation" data-toggle="modal"
                                            data-target="#modal_detail_consultation"
                                            data-id="{{ $consultation->id }}">
                                            <i class="fa fa-plus-circle fa-2x"></i>
                                        </a>
                                    </td>
                                    @can('consultations.update', Auth::user())
                                        @if (!$patient->readonly)
                                            <td>
                                                <a href="#modifier-consultation" class="edit_consultation"
                                                    title="Modifier la consultation" data-toggle="modal"
                                                    data-id="{{ $consultation->id }}">
                                                    <i class="fa fa-edit text-green fa-2x"></i>
                                                </a>
                                            </td>

                                        @endif
                                    @endcan

                                    @can('consultations.delete', Auth::user())
                                        @if (!$patient->readonly)
                                            <td>
                                                <form style="display: none;" method="POST"
                                                    action="/patient/consultation/destroy/{{ $consultation->id }}&{{ $patient->id }}"
                                                    id="delete-form-{{ $loop->index + 1 }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>
                                                <a href="" title="Supprimer la consultation"
                                                    onclick="if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                                                    event.preventDefault();
                                                                                                                                    document.getElementById('delete-form-{{ $loop->index + 1 }}').submit();										}
                                                                                                                                    " style="color:inherit;">
                                                    <span class="fa fa-trash text-red fa-2x"></span>
                                                </a>
                                            </td>
                                        @endif
                                    @endcan

                                    @if (!$patient->readonly)
                                        <td>
                                            <a href="#" id="btn_ann_con" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="consultation"
                                                data-id="{{ $consultation->id }}">
                                                <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                            </a>
                                        </td>
                                    @endif
                                    <td>
                                        @if ($consultation->orientation != '')
                                            <a href="#"
                                                onclick="downloadLettre('{{ $consultation->orientation }}' , '{{ $consultation->date_consultation }}')"><i
                                                    class="fa fa-print fa-2x"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($consultation->certificat != '')
                                            <a href="#"
                                                onclick="downloadCertificat('{{ $consultation->certificat }}' , '{{ $consultation->date_consultation }}')"><i
                                                    class="fa fa-print fa-2x"></i>
                                            </a>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($consultation->compte_rendu != '')
                                            <a href="#" onclick="donwloadConsultation({{ $consultation->id }})"><i
                                                    class="fa fa-print fa-2x"></i>
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
<!--fin tab consultation-->
