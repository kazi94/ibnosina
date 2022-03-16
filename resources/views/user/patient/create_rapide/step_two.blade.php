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
            <div class="row text-center">
                <div class="col-sm-8 col-sm-push-2">
                    <div class="box box-info">
                        <div class="box-header with-border text-center">
                            <h2 class="box-title ">
                                <b>Consultation</b>
                            </h2>
                        </div>
                        <!-- /.box-header -->
                        <form action="{{ route('patient.create.step.two.post') }}" method="POST">
                            {{ csrf_field() }}

                            <input type="hidden" name="patient_id" value="{{ session('patient_id') }}">
                            <input type="hidden" name="date_rapport"
                                value="<?php echo date('Y-m-d'); ?>">

                            <div class="box-body">

                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label>Motif de Consultation</label>
                                        <textarea class="form-control" placeholder="Motifs..." name="motif"
                                            required>{{ isset($consultation->motif) ? $consultation->motif : '' }}</textarea>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Signes Fonctionnels</label>
                                        <select class="signes" name="signe[]" multiple="multiple">
                                            @php
                                            $signes = DB::table('signes')->get();
                                            @endphp

                                            @foreach ($signes as $signe)
                                                <option value="{{ $signe->id }}">{{ $signe->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Début des symptômes</label>
                                        <input type="date" class="form-control" name="debut_symptome" id="debut_symptome">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Examens physiques</label>
                                        <textarea class="form-control" placeholder="Examen physiques..." name="examen"
                                            required>{{ isset($consultation->examen) ? $consultation->examen : '' }}</textarea>
                                    </div>

                                </div>
                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <a href="{{ route('patient.create.step.one.get', ['id' => session('patient_id')]) }}">
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
    <script>
        $(function() {
            $(".signes").select2({
                width: '100%'
            })
        });

    </script>
@endsection
