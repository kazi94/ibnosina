<!--tab phyltothérapie-->
<div class="tab-pane {{ session('tab') == 'tab_6' ? 'active in' : '' }}" id="tab_6">

    <div class="clearfix">
        @can('phytotherapies.create', Auth::user())
            @if (!$patient->readonly)
                <button type="button" class="btn btn-primary float-left" title="Raccourci(p)" data-toggle="modal"
                    data-target="#modal_phyto">Saisir
                    plante(s)</button>
            @endif
        @endcan
        @can('phytotherapies.export', Auth::user())
            <a href="/export/phyto/{{ $patient->id }}"><button type="button" class="btn btn-success pull-right"><i
                        class="fa fa-download"></i> Exporter</button></a>
        @endcan
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="box box-widget">
                <div class="box-body table-responsive">
                    <table id="example8" class="table text-center table-bordered nowrap">
                        <thead style="background-color: #68a942 !important; color:white">
                            <tr>
                                <th> Num°: </th>
                                <th>Plante (FR) </th>
                                <th>Plante (AR) </th>
                                <th>Utilisation </th>
                                <th>Fréquence </th>
                                @can('phytotherapies.delete', Auth::user())
                                    <th>Supprimer</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($patient->phytos as $phyto)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $phyto->produit['produit_naturel_fr'] }}</td>
                                    <td>{{ $phyto->produit['produits_arabe'] }}</td>
                                    <td>{{ $phyto->utilisation ? $phyto->utilisation->pathologie : '' }}
                                    </td>
                                    <td>{{ $phyto->frequence }} {{ $phyto->frequence_date }}</td>
                                    @can('phytotherapies.delete', Auth::user())
                                        <td>
                                            @if (!$patient->readonly)
                                                <a href="" class="deleteRow"
                                                    data-url="{{ route('phytotherapie.destroy', $phyto->id) }}"
                                                    style="color: inherit; cursor: pointer;"><span
                                                        class="glyphicon glyphicon-trash "></span></a>
                                            @endif
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
