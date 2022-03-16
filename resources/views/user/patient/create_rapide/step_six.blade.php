@extends('layouts.model')

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
                                Prescription d'Examen
                            </h3>
                        </div>

                        <!-- /.box-header -->
                        <form action="{{ route('patient.create.step.six.post') }}" method="POST" class="form-horizontal">
                            <div class="box-body" id="modal_demande_examen">
                                {{ csrf_field() }}
                                <input type="hidden" name="patient_id" value="{{ session('patient_id') }}">
                                <input type="hidden" name="consultation_id" value="{{ session('consultation_id') }}">
                                <input type="hidden" name="date_prescription"
                                    value="<?php echo date('Y-m-d'); ?>">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Type d'examen</label>

                                    <div class="col-sm-9">
                                        <select name="type" id="type_examen" class="form form-control"
                                            onchange="$(this).val() == 'bilan' ? $(' #bilan').show() : $(' #bilan').hide();">
                                            <option value="">Sélectionner le type d'examen</option>
                                            <option value="bilan">Biologique</option>
                                            <option value="radio">Imagerie</option>
                                        </select>
                                    </div>
                                </div>
                                <div id="bilan" style="display: none;">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Prescription type</label>

                                        <div class="col-sm-9">
                                            <select id="examens_type" class="form-control">
                                                <option value="">Sélectionner l'examen type</option>
                                                @foreach (Auth::user()->examensType as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Type de bilan</label>

                                        <div class="col-sm-9">
                                            <select id="type_bilan" class="form form-control">
                                                <option value="">Sélectionner le Bilan</option>
                                                @foreach ($bilans as $bilan)
                                                    <option value="{{ $bilan->bilan }}">{{ $bilan->bilan }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Eléments</label>

                                        <div class="col-sm-9" id="elements">
                                            <table>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Note</label>

                                        <div class="col-sm-9">
                                            <textarea name="note" cols="30" rows="5"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('patient.create.step.five', ['id' => session('trait_ids')]) }}">
                                    <button type="button" class="btn btn-default pull-left"><i class="fa fa-arrow-left"></i>
                                        Précédent </button>
                                </a>
                                <button type="submit" class="btn btn-success pull-right">Suivant <i
                                        class="fa fa-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/user/patient/gestion_bilan.js') }}"></script>
@endsection
