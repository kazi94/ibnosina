@extends('layouts.model-table')

@section('script_css')

@section('title')
    Mes Demandes d'Examens
@endsection

@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="clearfix">
            <ol class="breadcrumb">
                <li><a href="/home"><i class="fa fa-home"></i> Acceuil</a></li>
                <li class="active">Mes Demandes d'examens</li>
            </ol>
        </div>
    </section>

    <section class="content">
        @if (session()->has('message'))
            <p style="display: none;" id="message">{{ session('message') }}</p>
        @endif

        <div class="row">
            <div class="col-sm-12 ">
                <div class="box box-widget">

                    <div class="box-body">

                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <h3>Demandes d'Examens

                                    @if (count($result))
                                        <span class="badge bg-red mb-1">
                                            {{ count($result) }}
                                        </span>

                                    @endif
                                </h3>

                                <table id="demandes_table"
                                    class="nowrap table  table-hover table-bordered table-condensed">
                                    <thead class="bg-gray">
                                        <tr>
                                            <th>#</th>
                                            <th>Patient</th>
                                            <th>Service</th>
                                            <th>Prescripiteur</th>
                                            <th>Date de prescription</th>
                                            <th>Type de demande</th>
                                            <th>Note</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($result as $demande)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $demande->patient->nom }}
                                                    {{ $demande->patient->prenom }}
                                                </td>
                                                <td>{{ $demande->patient->hospi ? $demande->patient->hospi->service : '' }}
                                                </td>
                                                <td>Dr.{{ $demande->prescripteur->name }}
                                                    {{ $demande->prescripteur->prenom }}
                                                </td>
                                                <td>{{ $demande->date_prescription }}</td>
                                                <td>{!! $demande->type == 'radio'
    ? 'Examen Radiologique'
    : 'Examen
                                                    Biologique' !!}</td>
                                                <td>{{ $demande->note }}</td>
                                                <td>
                                                    @can('analyses_biologique.executeRequest', Auth::user())
                                                        <button class="btn btn-primary remplir" data-toggle="modal"
                                                            data-target="#modal_biologique"
                                                            data-id="{{ $demande->id }}">Remplir</button>
                                                    @endcan
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

        <div class="row">
            <div class="col-sm-12 ">
                <div class="box box-widget">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12 table-responsive">
                                <h3>Historique des demandes d'examens faites</h3>
                                <table id="demandes_table_history" class="nowrap table  table-hover table-bordered">
                                    <thead class="bg-gray">
                                        <tr>
                                            <th>#</th>
                                            <th>Patient</th>
                                            <th>Service</th>
                                            <th>Prescripiteur</th>
                                            <th>Date de prescription</th>
                                            <th>Type de demande</th>
                                            <th>Note</th>
                                            <th>Status</th>
                                            {{-- <th></th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($history as $demande)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $demande->patient->nom }}
                                                    {{ $demande->patient->prenom }}
                                                </td>
                                                <td>{{ $demande->patient->hospi ? $demande->patient->hospi->service : '' }}
                                                </td>
                                                <td>Dr.{{ $demande->prescripteur->name }}
                                                    {{ $demande->prescripteur->prenom }}
                                                </td>
                                                <td>{{ $demande->date_prescription }}</td>
                                                <td>{!! $demande->type == 'radio'
    ? 'Examen Radiologique'
    : 'Examen
                                                    Biologique' !!}</td>
                                                <td>{{ $demande->note }}</td>
                                                <td>
                                                    <span class="label label-success"> Faite le
                                                        {{ date('Y-m-d', strtotime($demande->updated_at)) }}
                                                    </span>
                                                </td>
                                                {{-- <td>
                                                    <button class="btn btn-primary" data-toggle="modal"
                                                        data-target="#modal_details" id="details"
                                                        data-id="{{ $demande->id }}">Détails</button>
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
    </section>
</div>



<div class="modal fade" id="modal_biologique" role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="bg-blue modal-header text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Bilans d'examen</h4>
            </div>
            <form method="POST" action="" enctype="multipart/form-data" class="form-horizontal">
                {{ csrf_field() }}
                {{ method_field('PATCH') }}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="d_analyse" class="col-sm-3 control-label">Date d'analyse</label>

                        <div class="col-sm-9">
                            <input type="date" name="date_analyse" class="form-control"
                                value="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="labo" class="col-sm-3 control-label">Laboratoire</label>

                        <div class="col-sm-9">
                            <input type="text" name="laboratoire" class="form-control">
                        </div>
                    </div>
                    <div id="radioDiv" style="display: none;">
                        <div class="form-group">
                            <label for="fichier" class="col-sm-3 control-label">Fichier</label>

                            <div class="col-sm-9">
                                <input type="file" name="fichier" class="form-control" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Imagerie</label>

                            <div class="col-sm-9">
                                <select name="is_imagery" class="form-control">
                                    <option value="0">Absente</option>
                                    <option value="1">Présente</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="" class="col-sm-3 control-label">Taux d'atteinte(%)</label>

                            <div class="col-sm-9">
                                <input type="text" name="attack_rate" class="form-control" value="0">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="commentaire" class="col-sm-3 control-label">Commentaire</label>

                            <div class="col-sm-9">
                                <textarea name="comment" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>

                    <div id="bilanDiv">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="bilansTable">
                                <thead>
                                    <tr class="bg-green ">
                                        <th class="text-center">Element</th>
                                        <th>Valeur</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default mb-0" data-dismiss="modal">Fermer</button>
                    <button type="submit" class="btn btn-primary mb-0">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ asset('plugins/jquery/js/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/adminlte2/js/adminlte.min.js') }}"></script>
<script src="{{ asset('plugins/datatable-1.10.24/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/user/patient/gestion_bilan.js') }}"></script>
<script>
    $("#demandes_table").DataTable();
    $("#demandes_table_history").DataTable();
    $('input[type="checkbox"].flat-green').iCheck({
        checkboxClass: 'icheckbox_flat-green'
    });

</script>
@endsection
