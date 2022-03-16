@extends('layouts.model-table')

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="clearfix">
                <ol class="breadcrumb">
                    <li><a href="{{ route('home') }}"><i class="fa fa-home"></i> Acceuil</a></li>
                    <li><a href="{{ route('pharmacie.index') }}"><i class="fa fa-clinic-medical"></i> Mon Armoire
                            Pharmaceutique</a></li>
                    <li class="active">Mes Prescriptions analysées</li>
                </ol>
            </div>
        </section>
        <section class="content">

            <div class="row">

                <div class="col-sm-12 ">
                    <div class="box  box-widget">
                        <div class="box-header">
                            <h2>Historique des interventions</h2>
                        </div>

                        <div class="box-body">
                            <input type="hidden" name="patient_id" value="1">

                            <div class="row">
                                <div class="col-sm-12 table-responsive">
                                    <table id="his_ip" class="table text-center table-bordered table-condensed table-hover">
                                        <thead>
                                            <tr class="bg-gray">
                                                <th>#</th>
                                                <th>Patient</th>
                                                <th>Date de l'IP</th>
                                                <th>Avis Patient</th>
                                                <th>Avis Pharmacien</th>
                                                <th>Détails</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user->interventionsUser as $intervention)
                                                <tr>
                                                    <td> {{ $loop->index + 1 }}</td>
                                                    <td>
                                                        @if (Auth::user()->can('patients.module'))
                                                            <a
                                                                href="{{ route('patient.edit', ['id' => $intervention->patient->id]) }}">
                                                                {{ $intervention->patient->nom }}
                                                                {{ $intervention->patient->prenom }}
                                                            </a>
                                                        @else
                                                            {{ $intervention->patient->nom }}
                                                            {{ $intervention->patient->prenom }}
                                                        @endif
                                                    </td>
                                                    <td> {{ date('d/m/Y', strtotime($intervention->date_ip)) }}</td>
                                                    <td>
                                                        @if ($intervention->patient_decision == '1')
                                                            <span class="label label-success">Accepter</span>
                                                        @elseif ($intervention->patient_decision == "3")
                                                            <span class="label label-danger">Refuser</span>
                                                        @else <span class="label label-default">Sans Avis</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($intervention->pharmacien_decision == '1')
                                                            <span class="label label-success">Accepter</span>
                                                        @elseif ($intervention->pharmacien_decision == "3")
                                                            <span class="label label-danger">Refuser</span>
                                                        @else <span class="label label-default">Sans Avis</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-info execute"
                                                            data-id="{{ $intervention->id }}"
                                                            data-patient="{{ $intervention->patient->id }}">détails</button>
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

            </div>

        </section>
    </div>
    <div class="modal fade in" id="modal_executer">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-blue">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Rapport de l'intervention pharmaceutique</h4>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="">
                            <div class="col-sm-3 alert alert-danger pt-1 no-border pl-1 pr-0 pri" hidden></div>
                            <div class="col-sm-3 alert alert-warning pt-1 no-border pl-1 pr-0 sec" hidden></div>
                            <div class="col-sm-3 alert alert-success pt-1 no-border pl-1 pr-0 sef" hidden></div>
                            <div class="col-sm-3 alert bg-gray pt-1 no-border pl-1 pr-0 det" hidden></div>
                        </div>
                        <div class="table-responsive">
                            <table class="execute_table table table-bordered table-condensed table-hover">
                                <thead class="text-nowrap bg-gray">
                                    <tr>
                                        <th>Médicament A</th>
                                        <th>Médicament(s) B</th>
                                        <th>Problèmes</th>
                                        <th>Commentaire</th>
                                        <th>Intervention Pharmacien</th>
                                        <th>Commentaire</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <input type="reset" class="btn btn-default" data-dismiss="modal"
                        value="Fermer"> --}}
                    <button type="button" class="btn btn-file" onclick="downloadIntervention()"><i
                            class="fa fa-print mr-1"></i>Imprimer</button>
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
    <script src="{{ asset('js/print.js') }}"></script>
    <script type="text/javascript">
        $("#his_ip").DataTable(); //phyto
        var report = "";
        var tables = [];
        $('.execute').on('click', function() { // Lancement de l'execution de devenir de l'IP
            var myModal = $('#modal_executer');
            $("input[name='patient_id']").val($(this).data('patient'))
            patient = getPatient();
            var intervention_id = $(this).data('id');
            $('.execute_table > tbody').empty();
            $('.pri').empty();
            $('.sec').empty();
            $('.det').empty();
            $('form', myModal).attr('action', '/analyse/' + intervention_id);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/analyse/' + intervention_id + '/edit',
                method: 'get',
                datatype: 'json',
                success: function(data) {
                    report = data['ip'].global_comment;
                    if (data['ip'].first_prob)
                        $('.pri').append(
                            `<h5><i class='fa fa-exclamation-circle'></i> <u>Problème Majeur :</u></h5><h5> ${data['ip'].first_prob}</h5>`
                        ).show();

                    if (data['ip'].second_prob)
                        $('.sec').append(
                            `<h5><i class='fa fa-exclamation-triangle'></i> <u>Problème Modéré :</u></h5><h5> ${data['ip'].second_prob}</h5>`
                        ).show();

                    if (data['ip'].third_prob)
                        $('.sef').append(
                            `<h5><i class='fa fa-exclamation'></i> <u>Problème Mineur :</u></h5><h5> ${data['ip'].third_prob}</h5>`
                        ).show();

                    if (report)
                        $('.det').append(
                            `<h5><i class='fa fa-pencil'></i>  <u>Rapport :</u></h5><h5> ${data['ip'].global_comment}</h5>`
                        ).show();
                    var rows = [];
                    $.each(data['lignes'], function(i, value) {
                        $('.execute_table > tbody').append("<tr>" +
                            "<td>" + value.med_sp + "</td>" +
                            "<td>" + ((value.med_sp_1 != null) ? decodeURI(value.med_sp_1) :
                                "RAS") + "</td>" +
                            "<td>" + value.problemes + "</td>" +
                            "<td>" + ((value.comment_prob != null) ? value.comment_prob :
                                "RAS") + "</td>" +
                            "<td>" + value.ip + "</td>" +
                            "<td>" + ((value.comment_ip != null) ? value.comment_ip :
                                "RAS") + "</td>" +
                            "</tr");
                        // $('input[type="checkbox"].flat-green').iCheck({
                        //     checkboxClass: 'icheckbox_flat-green'
                        // });
                        tables.push(value.med_sp, ((value.med_sp_1 != null) ? decodeURI(value
                                    .med_sp_1) :
                                "RAS"), value.problemes,
                            value.comment_prob, value.ip, value.comment_ip);
                    });

                    //and finally show the modal
                    myModal.modal({
                        show: true
                    });
                },
                error: function(jqXHR, textStatus) {
                    alert("Erreur Serveur: " + textStatus + " " + jqXHR);
                }
            });

        });


        /**
         * Download Intervention du pharmacien
         */
        function downloadIntervention() {
            text = {
                head: [
                    'Date : ' + new Date().toISOString().slice(0, 10) + '\n'
                ],
                core: [{
                        text: 'Rapport Intervention Pharmaceutique',
                        style: 'header',
                        alignment: 'center'
                    },
                    {

                        table: {
                            body: [
                                [{
                                        text: 'Médicament A',
                                        style: 'tableHeader'
                                    },
                                    {
                                        text: 'Médicament(s) B',
                                        style: 'tableHeader'
                                    },
                                    {
                                        text: 'Problème(s)',
                                        style: 'tableHeader'
                                    },
                                    {
                                        text: 'Commentaire',
                                        style: 'tableHeader'
                                    },
                                    {
                                        text: 'Intervention Pharmacien',
                                        style: 'tableHeader'
                                    },
                                    {
                                        text: 'Commentaire',
                                        style: 'tableHeader'
                                    }
                                ],
                                tables
                            ]
                        }
                    },
                    {
                        style: 'header',
                        text: 'Rapport du Pharmacien',
                    },
                    {
                        style: 'core',
                        text: report,
                    },
                ]
            };
            downloadDocument(text, 'Intervention-pharmaceutique-' + new Date().toISOString().slice(0, 10) + ".pdf");
        }

    </script>
@endsection
