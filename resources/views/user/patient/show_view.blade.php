@extends('layouts.model-table')
@section('script_css')
    <style>
        .item-index {
            position: absolute;
            color: #fff;
            text-transform: uppercase;
            padding: 5px 10px;
            background-color: rgba(0, 0, 0, .5);
            border-radius: 3px;
            z-index: 1;
            top: 5px;
            left: 2px;
        }

        .item-desc {
            position: absolute;
            color: #fff;
            text-transform: uppercase;
            padding: 5px 10px;
            background-color: rgba(0, 0, 0, .5);
            border-radius: 3px;
            z-index: 1;
            bottom: 4px;
            left: 5px;
        }

        .img-item {
            width: 150px;
            height: 150px;
            margin-right: 8px;
            margin-bottom: 5px;
        }

    </style>
@endsection
@section('content')

    <div class="content-wrapper">

        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- search form (Optional) -->

            <div class="pull-right box-tools float-right">
                <a href="{{ route('patient.index') }}">
                    <button type="button" class="btn btn-info" data-toggle="tooltip" title="Afficher Liste"><i
                            class="fa fa-list"></i> Vue Tableau
                    </button>
                </a>
            </div>
            <div class="clearfix">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Acceuil</a></li>
                    <li><a href="{{ route('patient.index') }}"><i class="fa fa-users"></i> Mes patients</a></li>

                </ol>
            </div>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="box box-body">
                        <ul class="text-center">
                            <!-- For filtering controls add -->
                            <button class="btn btn-primary" data-filter="all"> Tous </button>
                            <button class="btn btn-primary" data-filter="consultation"> Consultation </button>
                            <button class="btn btn-primary" data-filter="service"> En Service </button>
                            <button class="btn btn-primary" data-filter="décés"> Décédés </button>
                            <button class="btn btn-primary" data-filter="hopital"> Hors CHU </button>
                            <!-- For a shuffle control add -->

                        </ul>
                        <!-- To choose the value by which you want to sort add -->
                        <div class="form-group">
                            <div class="col-sm-3">
                                <select data-sortOrder class="form-control">
                                    <option value="nom"> Nom </option>
                                    {{-- <option value="ville"> Ville </option> --}}
                                    <option value="age"> Age </option>
                                </select>
                            </div>
                            <div class="col-sm-5">
                                <button class="btn btn-secondary" data-sortAsc> Croissant </button>
                                <button class="btn btn-secondary" data-sortDesc> Décroissant </button>

                            </div>
                            <div class="col-sm-4">
                                <input type="text" name="filtr-search" value="" class="form-control"
                                    placeholder="Rechercher ici..." data-search="">
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="box box-widget">
                        <div class="filter-container">
                            @foreach ($patients as $patient)

                                @php
                                    $cat = '';
                                    if ($patient->hospi) {
                                        if ($patient->hospi->motif_sortie == 'hopital' || $patient->hospi->motif_sortie == 'décés') {
                                            $cat = $patient->hospi->motif_sortie;
                                        }
                                        // else if($patient->hospi->service == Auth::user()->service)
                                        elseif ($patient->hospi->service) {
                                            $cat = 'service';
                                        } else {
                                            $cat = 'consultation';
                                        }
                                    }
                                @endphp
                                <div class="filtr-item" data-category="{{ $cat }}"
                                    data-age="{{ intval(date('Y/m/d', strtotime('now'))) - intval(date('Y/m/d', strtotime($patient->date_naissance))) }}"
                                    data-nom="{{ $patient->nom }}" data-ville="{{ $patient->villes->name }}"
                                    data-toggle="tooltip" data-html="true"
                                    title="<b>Ville : </b>{{ $patient->villes->name }}<br/><b>Poids : </b>{{ $patient->poids }}<br/><b>Profession : </b>{{ $patient->travaille }}<br/>">
                                    <span
                                        class="item-index">{{ intval(date('Y/m/d', strtotime('now'))) - intval(date('Y/m/d', strtotime($patient->date_naissance))) }}
                                        ans</span>
                                    <a href="{{ route('patient.edit', $patient->id) }}">
                                        <img src="/images/avatar/{{ $patient->photo }}" alt="sample"
                                            class="img-item img-responsive img-thumbnail" />
                                    </a>
                                    <span class="item-desc">{{ $patient->nom }}</span>

                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            {{-- <div class="row text-center">
                {{ $patients->links() }}
            </div> --}}

        </section>

    </div>

@endsection

@section('script')
    <script src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/adminlte2/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery.fitelizy.min.js') }}"></script>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();

            // Default options
            const options = {
                animationDuration: 0.25, // in seconds
                controlsSelector: '', // Selector for custom controls
                delay: 0, // Transition delay in ms
                delayMode: 'progressive', // 'progressive' or 'alternate'
                easing: 'ease-out',
                filter: 'service', // Initial filter
                filterOutCss: { // Filtering out animation
                    transform: 'scale(0.5)'
                },
                filterInCss: { // Filtering in animation
                    transform: 'scale(1)'
                },
                gridItemsSelector: '.filtr-item',
                gutterPixels: 20, // Items spacing in pixels
                layout: 'sameSize', // See layouts
                multifilterLogicalOperator: 'or',
                searchTerm: '',
                setupControls: true, // Should be false if controlsSelector is set 
                spinner: { // Configuration for built-in spinner
                    enabled: true,
                    fillColor: '#2184D0',
                    styles: {
                        height: '75px',
                        margin: '0 auto',
                        width: '75px',
                        'z-index': 2,
                    },
                },
            }

            // Adjust the CSS selector to match the container where
            // you set up your image gallery
            const filterizr = new Filterizr('.filter-container', options);


        });

    </script>
@endsection
