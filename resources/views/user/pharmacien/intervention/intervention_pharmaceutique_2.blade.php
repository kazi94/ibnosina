@extends('layouts.model')

@section('content')

    <div class="content-wrapper">
        <section class="content-header">
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
            @endif

            @if (session()->has('message'))
                <p class="alert alert-success" id="message" style="display: none;">{{ session('message') }}</p>
            @endif
            <div class="">
                <a href="{{ route('intervention.show') }}"><button type="button" class="btn btn-info btn-sm"
                        data-toggle="tooltip" title="Afficher Liste"><i class="fa fa-list"></i></button></a>
                <a href=""><button type="button" class="btn btn-info btn-sm" data-toggle="tooltip"
                        title="Afficher Tableau de bords"><i class=" fa-grip-horizontal"></i></button></a>
            </div>
            <h2 class="box-title">Interventions pharmaceutique</h2>
        </section>

        <section class="content">
            <div class="row">
                <div class="box box-body">
                    @foreach ($patients as $patient)
                        @foreach ($patient->prescriptionsRisque as $pr_risque)
                            <!-- ./col -->
                            <div class="col-xs-3">

                                <div class="small-box" style="hover:text-decoration: none;">

                                    <div class="inner">
                                        <h4>{{ $patient->nom }} {{ $patient->prenom }}</h4>
                                        <i class="fa fa-info bg-blue pull-right"
                                            style="position: relative; bottom: 47px; right:0px;  width: 20px;line-height: 20px;color: #666;background: #d2d6de;border-radius: 50%;text-align: center;"
                                            title="C1 / L3"></i>

                                        <p>Dr.{{ $pr_risque->prescripteur->name }} {{ $pr_risque->prescripteur->prenom }} ,
                                            @if (isset($patient->hospi->service))
                                                {{ $patient->hospi->service }}
                                            @endif
                                            <small></small>
                                        </p>

                                        <small> Le {{ $pr_risque->date_prescription }}</small>
                                        <span class="label label-danger">A analyser !</span><br />

                                    </div>
                                    <div class="icon">
                                        <img class="img-circle" style="width: 60px" src="/images/user.jpg"
                                            alt="User Avatar">
                                    </div>
                                    <div class="pull-le" style="text-align: center"><b>Chambre
                                            {{ $patient->hospi['chambre'] }}
                                            @if (isset($patient->hospi->lit)) /Lit
                                                {{ $patient->hospi->lit }}
                                            @endif
                                        </b></div> <br />
                                    <a href="{{ route('patient.intervenir', [$patient->id, $pr_risque->id]) }}"
                                        class="small-box-footer bg-red">Plus d'infos <i
                                            class="fa fa-arrow-circle-right"></i></a>
                                </div>

                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </section>
    </div>

@endsection
