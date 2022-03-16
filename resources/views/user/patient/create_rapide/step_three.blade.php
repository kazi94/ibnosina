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
                    <div class="box box-info" id="modal_hospitalisation">
                        <div class="box-header with-border  text-center">
                            <h3 class="box-title">
                                Hospitalisation
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <form action="{{ route('patient.create.step.three.post') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="hidden" name="patient_id" value="{{ session('patient_id') }}">
                            <div class="box-body">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="service" class="col-sm-3 control-label">Service</label>

                                        <div class="col-sm-9">
                                            <select class="form form-control" name="service">
                                                <option value="Maladies infectieuses"
                                                    {{ Auth::user()->service == 'Maladies infectieuses' ? 'selected' : '' }}>
                                                    Maladies infectieuses</option>
                                                <option value="Pneumologie"
                                                    {{ Auth::user()->service == 'Pneumologie' ? 'selected' : '' }}>
                                                    Pneumologie</option>
                                                <option value="Hématologie"
                                                    {{ Auth::user()->service == 'Hématologie' ? 'selected' : '' }}>
                                                    Hématologie</option>
                                                <option value="Médecine Interne"
                                                    {{ Auth::user()->service == 'Médecine Interne' ? 'selected' : '' }}>
                                                    Médecine Interne</option>
                                                <option value="Bloc 470"
                                                    {{ Auth::user()->service == 'Bloc 470' ? 'selected' : '' }}>Bloc 470
                                                </option>
                                                <option value="Réanimation Covid"
                                                    {{ Auth::user()->service == 'Réanimation Covid' ? 'selected' : '' }}>
                                                    Réanimation Covid</option>
                                                <option value="Laboratoire de Pharmacologie"
                                                    {{ Auth::user()->service == 'Laboratoire de Pharmacologie' ? 'selected' : '' }}>
                                                    Laboratoire de Pharmacologie
                                                </option>
                                                <option value="Pharmacie Centrale"
                                                    {{ Auth::user()->service == 'Pharmacie Centrale' ? 'selected' : '' }}>
                                                    Pharmacie Centrale</option>
                                                <option value="Laboratoire de Biologie Covid"
                                                    {{ Auth::user()->service == 'Laboratoire de Biologie Covid' ? 'selected' : '' }}>
                                                    Laboratoire de Biologie Covid
                                                </option>
                                                <option value="Laboratoire de Microbiologie"
                                                    {{ Auth::user()->service == 'Laboratoire de Microbiologie' ? 'selected' : '' }}>
                                                    Laboratoire de Microbiologie
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">

                                        <label class="col-sm-3 control-label">Médecin traitant :</label>

                                        <div class="col-sm-9">
                                            <select class="form-control" name="owned_by">

                                                @php
                                                $result = DB::table('users')->where('service', Auth::user()->service
                                                )->get();
                                                @endphp
                                                <option value=""></option>

                                                @foreach ($result as $r)
                                                    <option value="{{ $r->id }}">{{ $r->name }} {{ $r->prenom }}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="d_analyse" class="col-sm-3 control-label">Numéro billet</label>

                                        <div class="col-sm-9">
                                            <input type="number" class="form form-control"
                                                value="{{ isset($hosp->num_biais) ? $hosp->num_biais : '' }}"
                                                name="numbiais" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lit" class="col-sm-3 control-label">Chambre</label>

                                        <div class="col-sm-9">
                                            <input type="number" class="form form-control"
                                                value="{{ isset($hosp->chambre) ? $hosp->chambre : '' }}" name="chambre" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="lit" class="col-sm-3 control-label">Lit</label>

                                        <div class="col-sm-9">
                                            <input type="number" class="form form-control"
                                                value="{{ isset($hosp->lit) ? $hosp->lit : '' }}" name="lit" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="d_analyse" class="col-sm-3 control-label">Motif</label>

                                        <div class="col-sm-9">
                                            <input type="text" class="form form-control"
                                                value="{{ isset($hosp->motif) ? $hosp->motif : '' }}"
                                                placeholder="Motif d'entrée" name="motif" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="d_analyse" class="col-sm-3 control-label">Date d'entrée</label>

                                        <div class="col-sm-9">
                                            <input type="date" class="form form-control" name="date_admission"
                                                value="{{ isset($hosp->date_admission) ? $hosp->date_admission : date('Y-m-d') }}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ route('patient.create.step.two', ['id' => session('consultation_id')]) }}">
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
    <script src="{{ asset('/js/print.js') }}"></script>
    <script src="{{ asset('/js/user/patient/gestion_hospitalisation.js') }}"></script>
@endsection
