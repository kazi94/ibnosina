@extends('layouts.model')

@section('script_css')
@section('script_css')
    <link rel="stylesheet" href="/css/home.css">
@section('title')
    Mon Armoire Pharmaceutique
@endsection
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h2>Mon Armoire Pharmaceutique</h2>
    </section>
    <section class="content">
        <div class="row">
            @can('peut-analyser', Auth::user())
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="{{ route('intervention.show') }}" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            @if ($countAnal)
                                <span class='label label-danger'
                                    style="position: absolute;top: 4px;right: 5px;text-align: center;font-size: 19px;padding: 2px 3px;line-height: .9;">
                                    {{ $countAnal }}
                                </span>
                            @endif
                            <i class="bg-yellow fa fa-5x fa-exclamation-triangle icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">MES PRESCRIPTIONS A ANALYSER
                            </h5>
                            Gérez les prescriptions à risque pour analyse.<br /><br />

                        </div>
                    </a>
                </div>
            @endcan
            @can('peut-analyser', Auth::user())
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="{{ route('intervention.history') }}" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-gray-active fa fa-5x fa-history icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">MES PRESCRIPTIONS ANALYSÉES
                            </h5>
                            Historique des prescriptions analysé par le Pharmacien.

                        </div>
                    </a>
                </div>
            @endcan
            @can('peut-analyser', Auth::user())
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="{{ route('education.todo') }}" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-aqua-active fa fa-5x fa-chalkboard-teacher icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">MES ÉDUCATIONS THÉRAPTEUTIQUE
                            </h5>
                            Gérez les éducations thérapeutique effectuées sur le patient.

                        </div>
                    </a>
                </div>
            @endcan
            @can('peut-analyser', Auth::user())
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="{{ route('questionnaire.show', Auth::user()->id) }}" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-love-kiss fa fa-5x fa-question-circle icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">MES OBSERVANCES
                            </h5>
                            Gérez les observances faite par le Pharmacien.

                        </div>
                    </a>
                </div>
            @endcan
            @can('peut-analyser', Auth::user())
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="{{ route('pharmaco.index') }}" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-asteroid fa fa-5x fa-file-alt icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">PHARMACOVIGILANCE FORMULAIRE
                            </h5>
                            Rédiger un formulaire de pharmacovigilance.

                        </div>
                    </a>
                </div>
            @endcan
            @can('peut-analyser', Auth::user())
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="{{ route('liste1') }}" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-blue-active fa fa-5x fa-sa fa-save icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">PHARMACOVIGILANCES ENREGISTRÉES
                            </h5>
                            Gérer les pharmacovigilances enregistrées.

                        </div>
                    </a>
                </div>
            @endcan
            @can('peut-analyser', Auth::user())
                <div class="col-md-4" style="cursor: pointer;">
                    <a href="{{ route('liste2') }}" class="text-black">
                        <div class="mb-3 text-center card card-body p-3">
                            <i class="bg-grow-early fa fa-5x fa-file-export icon-gradient mb-2">
                            </i>

                            <h5 class="card-title">PHARMACOVIGILANCES ENVOYÉES
                            </h5>
                            Gérer les pharmacovigilances envoyées.

                        </div>
                    </a>
                </div>
            @endcan
        </div>
    </section>
</div>
@endsection
