@extends('layouts.model-table')

@section('script_css')
@section('title')
    Mes Prescriptions à Analyser
@endsection
@endsection


@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="clearfix">
            <ol class="breadcrumb">
                <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Acceuil</a></li>
                <li><a href="{{ route('pharmacie.index') }}"><i class="fa fa-clinic-medical"></i> Mon Armoire
                        Pharmaceutique</a></li>
                <li class="active">Prescriptions à Analyser</li>
            </ol>
        </div>
        <h2 class="box-title">Prescriptions à Analyser</h2>
    </section>
    <section class="content">
        @if (session()->has('message'))
            <p class="alert alert-success" id="message" style="display: none;">{{ session('message') }}</p>
        @endif
        <div class="row">
            <div class="col-sm-12 ">
                <div class="box box-info">


                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center table-hover" id="tabfaire">

                                <thead>
                                    <tr class="bg-gray">
                                        <th>Num Prescription</th>
                                        <th>Patient</th>
                                        <th>Médecin prescripteur</th>
                                        <th>Service</th>
                                        <th>Chambre</th>
                                        <th>lit</th>
                                        <th>Date Prescription</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($patients as $patient)

                                        @foreach ($patient->prescriptionsRisquePharma as $pr_risque)
                                            <tr>
                                                <td>
                                                    {{ $pr_risque->id }}

                                                </td>
                                                <td>
                                                    {{ $patient->nom }} {{ $patient->prenom }}
                                                </td>
                                                <td>
                                                    {{ $pr_risque->prescripteur->name }}
                                                    {{ $pr_risque->prescripteur->prenom }}
                                                </td>
                                                <td>
                                                    @if (isset($patient->hospi->service))
                                                        {{ $patient->hospi->service }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($patient->hospi->chambre))
                                                        {{ $patient->hospi->chambre }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if (isset($patient->hospi->lit))
                                                        {{ $patient->hospi->lit }}
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $pr_risque->date_prescription }}
                                                </td>
                                                <td>
                                                    <a
                                                        href="{{ route('patient.intervenir', [$patient->id, $pr_risque->id]) }}">
                                                        <button class="btn btn-success">Intervenir <i
                                                                class="fa fa-arrow-right"></i></button>
                                                    </a>
                                                </td>

                                            </tr>
                                        @endforeach

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@endsection

@section('script')
<script src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/adminlte2/js/adminlte.min.js') }}"></script>
<script src="{{ asset('plugins/datatable-1.10.24/datatables.min.js') }}"></script>
<script type="text/javascript">
    $("#tabfaire").DataTable({
        "order": [
            [6, "desc"]
        ]
    });

</script>
@endsection
