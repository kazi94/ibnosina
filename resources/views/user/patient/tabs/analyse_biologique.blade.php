<!--tab analyse biologique-->
<div class="tab-pane {{ session('tab') == 'tab_3' ? 'active in' : '' }}" id="tab_3">
    <!--analyse biologique tab -->
    <div class="clearfix">
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-wheelchair"></i> patient</a></li>
            <li class="active">Prescription Examen</li>
        </ol>

        <div class="row">
            <div class="col-sm-9 col-xs-5">
                @can('analyses_biologique.create', Auth::user())
                    @if (!$patient->readonly)
                        <button type="button" class="btn btn-primary " data-toggle="modal"
                            data-target="#modal_demande_examen" title="Raccourci(e)">Prescrire un Examen</button>
                    @endif
                @endcan
            </div>
            <div class="col-sm-3 col-xs-7 col-xs-push-1 col-sm-push-0">

                @can('analyses_biologique.export', Auth::user())
                    <a href="/export/gen_ab/{{ $patient->id }}" class="pull-right"><button type="button"
                            class="btn btn-success "><i class="fa fa-download"></i></button></a>
                @endcan
            </div>
        </div>
    </div>

    <div class="box box-widget">
        <div class="box-body">
            <div class="">
                <div class="col-sm-12">
                    @if (count($patient->requestExams) != 0)
                        <!-- <div class="alert alert-success alert-dismissible fade in">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            Une demande d'examen est en cours
                        </div> -->

                        <!-- {{-- Affichge seulement pour agent de labo --}} -->
                        <!-- {{-- Droite : peut remplir les examens --}} -->

                        <h3>Prescriptions d'examens en cours</h3>
                        <table id="demandes_table" class="table table-bordered table-hover table-striped">
                            <thead style="background-color: #0097f0 !important; color:white">
                                <tr>
                                    <th>Médecin prescripiteur</th>
                                    <th>Date de prescription</th>
                                    <th>Type de demande</th>
                                    <th>Note</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($patient->requestExams as $demande)
                                    <tr>
                                        <td>Dr.{{ $demande->prescripteur->name }}
                                            {{ $demande->prescripteur->prenom }}
                                        </td>
                                        <td>{{ $demande->date_prescription }}</td>
                                        <td>{!! $demande->type == 'radio' ? 'Examen Radiologique' : 'Examen Biologique' !!}</td>
                                        <td>{{ $demande->note }}</td>
                                        <td>
                                            @can('analyses_biologique.executeRequest', Auth::user())
                                                <button class="btn btn-primary remplir" data-toggle="modal"
                                                    data-target="#modal_biologique" data-id="{{ $demande->id }}">
                                                    <i class="fa fa-vial mr-1"></i>Remplir</button>
                                            @endcan
                                            {{-- @cannot('analyses_biologique.executeRequest', Auth::user()) --}}
                                            <button class="btn btn-light" onclick="
                                                if (confirm('voulez vous annuler la demande d\'examen ?')) {
                                                event.preventDefault();
                                                document.getElementById('delete-form-{{ $demande->id }}').submit();										}
                                                ">
                                                <i class="fa fa-redo mr-1"></i>
                                                <form style="display: none;" method="POST"
                                                    action="{{ route('prescription.examen.destroy', $demande->id) }}"
                                                    id="delete-form-{{ $demande->id }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>
                                                Annuler
                                            </button>

                                            <button class="btn btn-danger"
                                                onclick="downloadExamen({{ $demande->id }})"><i
                                                    class="fa fa-print mr-1"></i> Imprimer</button>
                                            {{-- @endcannot --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    @endif
                    @if (count($patient->bilans) > 0)
                        <h3>Liste des bilans d'examens biologique</h3>

                        <div id="labelforma" name="labelforma" value="labelforma" style="display: block">
                            <table id="example3"
                                class="nowrap table table-bordered table-hover table-striped text-center">
                                <thead style="background-color: #0097f0 !important; color:white">
                                    <tr>
                                        <th># </th>
                                        <th>Type Bilan </th>
                                        <th>Type élement </th>
                                        <th>Valeur </th>
                                        <th>Min </th>
                                        <th>Max </th>
                                        <th>Date d'analyse </th>
                                        <th>Laboratoire </th>
                                        <th>Commentaire </th>
                                        <th>Graphe </th>
                                        @can('analyses_biologique.update', Auth::user())
                                            <th>Modifier</th>
                                        @endcan
                                        @can('analyses_biologique.delete', Auth::user())
                                            <th>Supprimer </th>
                                        @endcan
                                        <th>Annotation</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient->bilans as $bilan)
                                        @if ($bilan->element)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td> {{ $bilan->element->bilan }} </td>
                                                <td> {{ $bilan->element->element }} </td>
                                                <td>

                                                    @if ($bilan->valeur && ($bilan->valeur > $bilan->element->maximum || $bilan->valeur < $bilan->element->minimum))
                                                        <span class="label label-danger text-sm">{{ $bilan->valeur }}
                                                            {{ $bilan->element->unite }}</span>
                                                    @elseif ($bilan->valeur )
                                                        <span
                                                            class="label label-success text-sm">{{ $bilan->valeur }}
                                                            {{ $bilan->element->unite }}</span>
                                                    @endif

                                                </td>
                                                <td> <b>{{ $bilan->element->minimum }} </b> </td>
                                                <td> <b>{{ $bilan->element->maximum }}</b> </td>
                                                <td> {{ $bilan->date_analyse }} </td>

                                                <td>{{ $bilan->laboratoire }}</td>
                                                <td>{{ $bilan->commentaire }}</td>
                                                <td>
                                                    @can('analyses_biologique.dessin', Auth::user())
                                                        @php
                                                            $el = DB::table('elements')
                                                                ->where('id', $bilan->element_id)
                                                                ->get();
                                                        @endphp
                                                        @if ($el->first()->bilan != 'Radiographie')
                                                            <button type="button"
                                                                class="btn btn-primary float-left show_chart"
                                                                data-toggle="modal" id="{{ $bilan->id }}"
                                                                data-target="#modal_graphe">Graphe</button>
                                                        @endif
                                                    @endcan
                                                </td>
                                                @can('analyses_biologique.update', Auth::user())
                                                    <td>
                                                        @if (!$patient->readonly)
                                                            <a href="#modifier-element" class="edit_bilan"
                                                                title="Modifier la consultation" data-toggle="modal"
                                                                data-target="#modal_update_biologique"
                                                                data-el="{{ $bilan->element->element }}"
                                                                data-id="{{ $bilan->id }}">
                                                                <i class="fa fa-edit text-green fa-2x"></i>
                                                            </a>
                                                        @endif
                                                    </td>
                                                @endcan
                                                @can('analyses_biologique.delete', Auth::user())
                                                    <td>
                                                        @if (!$patient->readonly)
                                                            <form style="display: none;" method="POST"
                                                                action="{{ route('bilan.destroy', $bilan->id) }}"
                                                                id="delete-form-{{ $bilan->id }}">
                                                                {{ csrf_field() }}
                                                                {{ method_field('DELETE') }}
                                                            </form>

                                                            <a href=""
                                                                onclick="if (confirm('voulez vous supprimer cette ligne ?')) {event.preventDefault(); document.getElementById('delete-form-{{ $bilan->id }}').submit(); }"
                                                                style="color: inherit; ">
                                                                <span class="fa fa-trash text-red fa-2x"></span>
                                                            </a>
                                                        @endif
                                                    </td>
                                                @endcan
                                                <td>
                                                    @if (!$patient->readonly)
                                                        <a href="#" id="btn_ann_examen" data-toggle="modal"
                                                            data-target="#modal_annotation" data-type="bilan"
                                                            data-id="{{ $bilan->id }}">
                                                            <i class="fa fa-2x fa-comment-dots text-yellow"></i>
                                                        </a>

                                                    @endif
                                                </td>

                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    @if (count($patient->bilansRadiologique) > 0)
                        <h3>Liste des bilans d'examens radiologique</h3>

                        <div id="labelforma" name="labelforma" value="labelforma" style="display: block">
                            <table id="radio_table"
                                class="nowrap table table-bordered table-hover table-striped text-center">
                                <thead style="background-color: #0097f0 !important; color:white">
                                    <tr>
                                        <th>#</th>
                                        <th>Type Bilan </th>
                                        <th>Date d'analyse </th>
                                        <th>Laboratoire </th>
                                        <th>Imagerie </th>
                                        <th>Taux d'atteinte </th>
                                        <th>Commentaire </th>
                                        <th>Image</th>
                                        <th>Annotation</th>
                                        @can('analyses_biologique.delete', Auth::user())
                                            <th>Supprimer </th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($patient->bilansRadiologique as $bilan)

                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>Radiologique</td>
                                            <td> {{ $bilan->date_analyse }} </td>
                                            <td>{{ $bilan->laboratoire }}</td>
                                            <td>{{ $bilan->is_imagery ? 'Présente' : 'Absente' }}</td>
                                            <td>{{ $bilan->is_imagery ? $bilan->attack_rate . '%' : '/' }}</td>
                                            <td>{{ $bilan->commentaire }}</td>
                                            <td>
                                                <a href="#" class="open_image" data-toggle="modal"
                                                    data-target="#modal_imgs" data-url="{{ $bilan->fichier }}"
                                                    data-comment="{{ $bilan->commentaire }}">
                                                    <i class="fa fa-2x fa-image text-green"></i>
                                                </a>
                                            </td>
                                            <td>
                                                @if (!$patient->readonly)
                                                    <a href="#" id="btn_ann_examen" data-toggle="modal"
                                                        data-target="#modal_annotation" data-type="bilan"
                                                        data-id="{{ $bilan->id }}">
                                                        <i class="fa fa-2x fa-comment-dots text-yellow"></i></a>
                                                @endif
                                            </td>
                                            @can('analyses_biologique.delete', Auth::user())
                                                <td>
                                                    @if (!$patient->readonly)
                                                        <form style="display: none;" method="POST"
                                                            action="{{ route('bilan.destroy', $bilan->id) }}"
                                                            id="delete-form-{{ $bilan->id }}">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                        </form>

                                                        <a href=""
                                                            onclick="
                                                                                                                                                                                                                                                                                                                                                                                                                                      if (confirm('voulez vous supprimer cette ligne ?')) {
                                                                                                                                                                                                                                                                                                                                                                                                                                      event.preventDefault();
                                                                                                                                                                                                                                                                                                                                                                                                                                      document.getElementById('delete-form-{{ $bilan->id }}').submit();										}
                                                                                                                                                                                                                                                                                                                                                                                                                                     "
                                                            style="color: inherit; "><span
                                                                class="fa fa-2x fa-trash text-red"></span></a>
                                                    @endif
                                                </td>
                                            @endcan
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
