<!--tab Hospitalisation-->
<div class="tab-pane {{ session('tab') == 'tab_11' ? 'active in' : '' }}" id="tab_11">

    <div class="clearfix d-sm-none">
        @can('hospitalisations.create', Auth::user())
            @if (!$patient->readonly)
                <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                    data-target="#modal_hospitalisation" title="Raccourci(h)">Ajouter une Hospitalisation</button>
            @endif
        @endcan
        @can('hospitalisations.print', Auth::user())
            <button class="btn btn-default pull-right edit_impression" id="{{ $patient->id }}" @if (count($patient->hospitalisation) == 0) disabled @endif><i
                    class="fa fa-print"></i> Imprimer Rapport</button>
        @endcan
        @can('hospitalisations.export', Auth::user())
            <a href="/export/ho/{{ $patient->id }}"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        @endcan
    </div>
    <div class="clearfix d-md-none">
        @can('hospitalisations.create', Auth::user())
            @if (!$patient->readonly)
                <button type="button" class="btn btn-primary float-left" data-toggle="modal"
                    data-target="#modal_hospitalisation">Ajouter Hospitalisation</button>
            @endif
        @endcan
        @can('hospitalisations.print', Auth::user())
            <button class="btn btn-default pull-right edit_impression" id="{{ $patient->id }}" @if (count($patient->hospitalisation) == 0) disabled @endif><i
                    class="fa fa-print"></i> </button>
        @endcan
        @can('hospitalisations.export', Auth::user())
            <a href="/export/ho/{{ $patient->id }}"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> </button></a>
        @endcan
    </div>

    <div class="box box-widget">

        {{-- <div class="box-header">
            <h4>Hospitalisations</h4>
        </div> --}}

        <div class="box-body ">
            <div class="row">
                <div class="col-sm-12">
                    <table id="table_hospitalisation" class="table table-bordered nowrap text-center">
                        <thead style="background-color: #3D9970 !important; color:white">
                            <tr>
                                <th>#</th>
                                <th>Service</th>
                                <th>Détails</th>
                                <th>Modifier</th>
                                <th>Supprimer</th>
                                <th>Annotations</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($patient->hospitalisation as $ho)
                                <tr>
                                    <td> {{ $loop->index + 1 }} </td>
                                    <td> {{ $ho->service }}</td>
                                    <td>
                                        <a href="#detail-hospitalisation" class="detailHospitalisation"
                                            title="Détails de l'hospitalisation" data-toggle="modal"
                                            data-target="#modal_detail_hospitalisation" data-id="{{ $ho->id }}">
                                            <i class="fa fa-plus-circle fa-2x"></i>
                                        </a>
                                    </td>
                                    <td>
                                        @can('hospitalisations.update', Auth::user())
                                            @if (!$patient->readonly)
                                                <a href="#modifier-hospitalisation" class="edit_hospitalisation"
                                                    title="Modifier l'hospitalisation" data-toggle="modal"
                                                    data-id="{{ $ho->id }}">
                                                    <i class="fa fa-edit text-green fa-2x"></i>
                                                </a>
                                            @endif
                                        @endcan
                                    </td>
                                    <td>
                                        @can('hospitalisations.delete', Auth::user())
                                            @if (!$patient->readonly)
                                                <form style="display: none;" method="POST"
                                                    action="{{ route('hospitalisation.destroy', $ho->id) }}"
                                                    id="delete-form-{{ $ho->id }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>

                                                <a href="" title="Supprimer Hospitalisation"
                                                    onclick="
                                                                                                                                                                                                                if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                                                                                                                                event.preventDefault();
                                                                                                                                                                                                                document.getElementById('delete-form-{{ $ho->id }}').submit();										}
                                                                                                                                                                                                                "
                                                    style="color:inherit;"><span
                                                        class="fa fa-trash text-red fa-2x"></span></a>
                                            @endif
                                        @endcan
                                    </td>
                                    <td>
                                        @if (!$patient->readonly)
                                            <a href="#" id="btn_ann_hosp" data-toggle="modal"
                                                data-target="#modal_annotation" data-type="hospitalisation"
                                                data-id="{{ $ho->id }}">
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
<!--fin tab hospitalisation-->
