@extends('layouts.model-table')

@section('script_css')

@endsection


@section('content')
    <!-- Content Wrapper. Contains page content -->
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
        <!-- Content Header (Page header) -->
        <section class="content-header text-center">
            <h2>Ajouter un Patient </h2>
        </section>

        <section class="content">
            <div class="row">
                <div class="col-md-6 col-md-offset-3 col-xs-12">
                    <div class="box box-info">
                        <div class="box-header with-border  text-center">
                            <h3 class="box-title">
                                Rapports et détails
                            </h3>
                        </div>
                        <form class="form-horizontal" method="POST"
                            action="{{ route('patient.create.step.final.post', ['id' => session('consultation_id')]) }}"
                            id="formReport">
                            <div class="box-body">
                                {{ csrf_field() }}
                                <input type="hidden" name="patient_id" value="{{ session('patient_id') }}">
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Lettre d'Orientation</label>

                                    <div class="col-sm-9">
                                        <textarea name="orientation" cols="32" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Certificat</label>

                                    <div class="col-sm-9">
                                        <textarea name="certificat" cols="32" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Rapport</label>

                                    <div class="col-sm-9">
                                        <textarea name="compte_rendu" cols="32" rows="3"></textarea>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <div class="col-md-3">
                                    <a href="{{ route('patient.create.step.six', ['id' => session('bilan_id')]) }}">
                                        <button type="button" class="btn btn-default pull-left"><i
                                                class="fa fa-arrow-left"></i> Précédent </button>
                                    </a>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn btn-file pull-right mr-1"><i
                                            class="fa fa-print mr-1"></i>Confirmer </button>
                                    <button type="button" class="btn btn-linkedin pull-right mr-1"
                                        onclick="downloadPrescription({{ session('presc_id') }})"><i
                                            class="fa fa-print mr-1"></i>Prescription </button>
                                    <button type="button" class="btn btn-success pull-right mr-1"
                                        onclick="downloadExamen({{ session('bilan_id') }})"><i
                                            class="fa fa-print mr-1"></i>Examen </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <!-- <script src="/plugins/datatables.net/pdfmake-0.1.36/pdfmake.min.js"></script>
        <script src="/plugins/datatables.net/pdfmake-0.1.36/vfs_fonts.js"></script> -->
    <script src="{{ asset('plugins/datatable-1.10.24/datatables.min.js') }}"></script>

    <script src="/js/print.js"></script>
@endsection
