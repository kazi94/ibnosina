@extends('layouts.model-table')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="clearfix">
                <ol class="breadcrumb">
                    <li><a href="/home"><i class="fa fa-home"></i> Acceuil</a></li>
                    <li><a href="{{ route('pharmacie.index') }}"><i class="fa fa-clinic-medical"></i> Mon Armoire
                            Pharmaceutique</a></li>
                    <li class="active">Mes Educations Thérapeutiques</li>
                </ol>
            </div>
        </section>
        <section class="content">
            @if (count($errors) > 0)
                @foreach ($errors->all() as $error)
                    <p class="alert alert-danger">{{ $error }}</p>
                @endforeach
            @endif

            @if (session()->has('message'))
                <p class="alert alert-success" id="message" style="display: none;">{{ session('message') }}</p>
            @endif

            <div class="row">
                <div class="col-sm-12 ">
                    <div class="box  box-info">
                        <div class="box-header with-border">
                            <h3>Educations Thérapeutiques</h3>
                        </div>

                        <div class="box-body">
                            <div class="row">
                                <div class="">
                                    <div class="col-sm-3 mb-2">
                                        <select id="ip" class="form-control">
                                            <option value="faire">à faire</option>
                                            <option value="historique">historique</option>
                                            <option value="tous">tous</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="faireDiv table-responsive">
                                <table class="table table-condensed table-bordered table-striped text-center" id="tabfaire">
                                    <thead>
                                        <tr class="bg-green text-center">
                                            <th>Num° prescription</th>
                                            <th>Patient</th>
                                            <th>Médecin Prescripteur</th>
                                            <th>Titre</th>
                                            <th>Date et heure</th>
                                            <th>Action</th>
                                            <th>Détails</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patients as $patient)
                                            @foreach ($patient->ReglesEduPatient as $regle_presc_edu)
                                                @if ($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'risqueTherap')
                                                    <tr>
                                                        <td>
                                                            {{ $regle_presc_edu->prescription_id }}
                                                        </td>
                                                        <td>
                                                            @if (Auth::user()->can('patients.module'))
                                                                <a
                                                                    href="{{ route('patient.edit', ['id' => $patient->id]) }}">
                                                                    {{ $patient->nom }}
                                                                    {{ $patient->prenom }}
                                                                </a>
                                                            @else
                                                                {{ $patient->nom }}
                                                                {{ $patient->prenom }}
                                                            @endif
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
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="historiqueDiv table-responsive ">
                                <table class="table table-condensed table-bordered table-stripped text-center"
                                    id="tabhistorique">
                                    <thead>
                                        <tr class="text-center bg-green">
                                            <th>Num° prescription</th>
                                            <th>Patient</th>
                                            <th>Médecin Prescripteur</th>
                                            <th>Titre</th>
                                            <th>Date et heure</th>
                                            <th>Action</th>
                                            <th>Détails</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($patients as $patient)
                                            @foreach ($patient->ReglesEduPatient as $regle_presc_edu)
                                                @if ($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'faite')
                                                    <tr>
                                                        <td>
                                                            {{ $regle_presc_edu->prescription_id }}
                                                        </td>
                                                        <td>
                                                            @if (Auth::user()->can('patients.module'))
                                                                <a
                                                                    href="{{ route('patient.edit', ['id' => $patient->id]) }}">
                                                                    {{ $patient->nom }}
                                                                    {{ $patient->prenom }}
                                                                </a>
                                                            @else
                                                                {{ $patient->nom }}
                                                                {{ $patient->prenom }}
                                                            @endif
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
                                                            <button class="btn btn-primary disabled">Faire</button>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn BTNANALYSE"
                                                                data-id="{{ $patient->id }}"
                                                                data-risque="{{ $regle_presc_edu->prescription_id }}">Details</button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>

                                </table>
                            </div>

                            <div class="tousDiv table-responsive">
                                <table class="table table-condensed  table-bordered table-stripped text-center"
                                    id="tabtous">
                                    <thead>
                                        <tr class="text-center bg-green">
                                            <th>Num° prescription</th>
                                            <th>Patient</th>
                                            <th>Médecin Prescripteur</th>
                                            <th>Titre</th>
                                            <th>Date et heure</th>
                                            <th>Action</th>
                                            <th>Détails</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($patients as $patient)
                                            @foreach ($patient->ReglesEduPatient as $regle_presc_edu)
                                                @if ($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'faite')
                                                    <tr class="bg-green">
                                                        <td>
                                                            {{ $regle_presc_edu->prescription_id }}
                                                        </td>
                                                        <td>
                                                            @if (Auth::user()->can('patients.module'))
                                                                <a
                                                                    href="{{ route('patient.edit', ['id' => $patient->id]) }}">
                                                                    {{ $patient->nom }}
                                                                    {{ $patient->prenom }}
                                                                </a>
                                                            @else
                                                                {{ $patient->nom }}
                                                                {{ $patient->prenom }}
                                                            @endif
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
                                                            <button class="btn btn-primary disabled">Faire</button>
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn BTNANALYSE"
                                                                data-id="{{ $patient->id }}"
                                                                data-risque="{{ $regle_presc_edu->prescription_id }}">Details</button>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach


                                            @foreach ($patient->ReglesEduPatient as $regle_presc_edu)
                                                @if ($regle_presc_edu->PrescEducConcerne->etatAnalyseTherap == 'risqueTherap')
                                                    <tr>
                                                        <td>
                                                            {{ $regle_presc_edu->prescription_id }}
                                                        </td>
                                                        <td>
                                                            @if (Auth::user()->can('patients.module'))
                                                                <a
                                                                    href="{{ route('patient.edit', ['id' => $patient->id]) }}">
                                                                    {{ $patient->nom }}
                                                                    {{ $patient->prenom }}
                                                                </a>
                                                            @else
                                                                {{ $patient->nom }}
                                                                {{ $patient->prenom }}
                                                            @endif
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
    <!-- Modal -->
    <div class="modal fade" id="modal_analyse_therap" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Détails de l'éducation thérapeutique</h4>
                </div>

                <div class="modal-body" id="div_body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" style="background-color:blue; color:#ffffff"
                        data-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/adminlte2/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/datatable-1.10.24/datatables.min.js') }}"></script>
    <script src="{{ asset('js/user/patient/analyse.js') }}"></script>
    <script type="text/javascript">
        $('body').find('span > i').remove('i:last');
        $('#tabfaire').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
        $('#tabhistorique').DataTable({
            "order": [
                [0, "desc"]
            ]
        });
        $('#tabtous').DataTable({
            "order": [
                [0, "desc"]
            ]
        });

        $('.historiqueDiv').toggle(false);
        $('.tousDiv').toggle(false);
        $('#ip').change(function() { //fonction pour alterner entre les deux type de règles
            if ($(this).val() == "faire") {
                $('.faireDiv').toggle(true);
                $('.historiqueDiv').toggle(false);
                $('.tousDiv').toggle(false);
            } else if ($(this).val() == "historique") {
                $('.faireDiv').toggle(false);
                $('.historiqueDiv').toggle(true);
                $('.tousDiv').toggle(false);
            } else {
                $('.faireDiv').toggle(false);
                $('.historiqueDiv').toggle(false);
                $('.tousDiv').toggle(true);
            }
        });

    </script>

@endsection
