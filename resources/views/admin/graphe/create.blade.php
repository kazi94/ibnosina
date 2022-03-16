@extends('layouts.model')
@section('script_css')
    <link rel="stylesheet" href="{{ asset('plugins/jquery/css/jquery_ui.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('plugins/jquery.tag-editor.css') }}"> --}}
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
            <div class="col-md-10 col-xs-12 col-md-offset-1">
                <div class="box box-info">
                    @can('dashboard.create', Auth::user())
                        <div class="box-header with-border">
                            <h3 class="box-title">Ajouter un Tableau de bord</h3>
                            <input type="submit" class="btn btn-primary pull-right" data-toggle="modal"
                                data-target="#modal_create" value="Nouveau Tableau de bord" />
                        </div>
                    @endcan
                    <div class="box-body">

                        @php
                        $elements = DB::table('elements')
                        ->select('element')
                        ->where('bilan','<>','Radiographie')
                            ->distinct()
                            ->orderBy('element', 'ASC')
                            ->pluck('element')
                            @endphp

                            <table
                                class="table table-responsive table-bordered table-stripped table-hover text-center dataTable "
                                id="t_biologique">

                                <thead>
                                    <tr class="alert alert-info">
                                        <th>Nom</th>
                                        <th>Description</th>
                                        <th>Inerval par Defaut</th>
                                        <th>Elements</th>
                                        @can('dashboard.delete', Auth::user())
                                            <th>Supprimer</th>
                                        @endcan
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $dashboards = DB::table('dashboards')
                                    ->join('elements','elements.id','dashboards.element_id')
                                    ->groupBy('nom')
                                    ->get();
                                    @endphp

                                    @foreach ($dashboards as $dashboard)
                                        <tr>

                                            <th>{{ $dashboard->nom }}</th>

                                            <th>{{ $dashboard->description }}</th>
                                            <th>{{ $dashboard->duree }}</th>

                                            <th>
                                                @php
                                                $els = DB::table('dashboards')
                                                ->join('elements','elements.id','dashboards.element_id')
                                                ->where('nom','=',$dashboard->nom)
                                                ->get();
                                                @endphp
                                                @foreach ($els as $el)
                                                    {{ $el->element }}<br>
                                                @endforeach

                                            </th>

                                            @can('dashboard.delete')
                                                <td>
                                                    <form style="display: none;" method="POST"
                                                        action="{{ route('dashboard.destroy', $dashboard->nom) }}"
                                                        id="delete-form-{{ $dashboard->nom }}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>

                                                    <a href=""
                                                        onclick="
                                                                                                                                                                                                                          if (confirm('Voulez vous vraiment supprimer cet Dashboard ?')) {
                                                                                                                                                                                                                           event.preventDefault();
                                                                                                                                                                                                                           document.getElementById('delete-form-{{ $dashboard->nom }}').submit();
                                                                                                                                                                                                                          }
                                                                                                                                                                                                                         "><span
                                                            class="glyphicon glyphicon-trash"></span></a>
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

    <div class="modal fade in" id="modal_create" style="display: none;">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="bg-blue modal-header text-center">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Nouveau Tableau de bord</h4>
                </div>
                <form class="form-horizontal" id="form_01" role="form" method="POST"
                    action="{{ route('dashboard.store') }}">
                    <div class="modal-body">
                        <div class="element" style="">

                            {{ csrf_field() }}
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Nom Dashboard</label>
                                <div class="col-sm-9">
                                    <input type="text" id="nom" class="form-control"
                                        placeholder="entrer un nom de dashboard" name="nom" value="{{ old('nom') }}"
                                        required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Interval par Defaut </label>
                                <div class="col-sm-9">
                                    <select name="duree" class="form-control">
                                        <option value="Dernier jour">Dernier jour</option>
                                        <option value="Derniere semaine">Derniere semaine</option>
                                        <option value="Dernier mois">Dernier mois</option>
                                        <option value="Derniere hospitalisation">Derniere hospitalisation</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Description</label>
                                <div class="col-sm-9">
                                    <textarea type="text" id="desc" class="form-control"
                                        placeholder="entrer une description" name="desc"
                                        value="{{ old('desc') }}"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Elements</label>
                                {{-- <input type="text" class="form-control choix"
                                    id="choix_create" value="{{ old('choix') }}" name="elements" required />
                                --}}

                                <div class="col-sm-9">
                                    <select name="elements[]" class="select2" multiple="multiple" style="width:100%"
                                        required>
                                        @php
                                        $elements = DB::table('elements')->distinct()->get();
                                        @endphp

                                        @foreach ($elements as $element)
                                            <option value="{{ $element->id }}">{{ $element->element }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="submit" class="btn btn-primary pull-right" id="" value="Ajouter Dashboard" />
                            <input type="reset" class="btn btn-default pull-left" data-dismiss="modal" value="Fermer">
                        </div>
                </form>
            </div>
        </div>
    </div>

@endsection
{{-- @section('script')
<script src="{{ asset('plugins/jquery.caret.js') }}"></script>
<script src="{{ asset('plugins/jquery.tag-editor.js') }}"></script>



<script>
    var sites = {
        !!json_encode($elements) !!
    };
    $('#choix_create').tagEditor({

        autocomplete: {
            delay: 0,
            position: {
                collision: 'flip'
            },
            source: sites,
        },
        showAutocompleteOnFocus: true,
        placeholder: 'les Elements ...'
    });

</script>
@endsection --}}
