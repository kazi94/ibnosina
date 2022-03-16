@extends('layouts.model')

@section('script_css')
<link rel="stylesheet" href="{{ asset('plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/jquery/css/jquery_ui.css') }}">
@endsection

@section('content')


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

        <div class="row">

            <div class="col-md-8 col-xs-12 col-md-offset-2">
                <!-- Horizontal Form -->
                <div class="box box-info">

                    <div class="box-header with-border">

                        <h3 class="box-title">Modifier la règle , type : Patient</h3>

                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <div class="element" style="">
                            <form class="form-group" role="form" method="POST"
                                action="{{ route('regle.update', $regle->id) }}">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}

                                <div class="form-group col-sm-4">
                                    <label for="">Nom de la règle</label>
                                    <input type="hidden" name="type_regle" value="patient">
                                    <input type="text" class="form-control" placeholder="Nom règle" name="regle"
                                        value="{{ $regle->regle }}">
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Type d'élément</label>
                                    <input type="text" class="form-control" placeholder="taper l'élement d'examen"
                                        name="element" value="{{ $regle->element }}">
                                </div>

                                <div class="col-sm-8 col-sm-offset-1">
                                    <table class="table text-center">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="color: red;">Valeurs normale</th>

                                            </tr>
                                        </thead>
                                        <tbody
                                            style="/* background-color: #ff00002b; */ box-shadow: 0px 3px 9px 0px #000000a6;">
                                            <tr>
                                                <th>Inférieur ou égale à : </th>
                                                <td><input type="text" class="form-control" name="inf"
                                                        value="{{ $regle->inf }}"></td>
                                                <th class="unite">Unité</th>

                                            </tr>
                                            <tr>
                                                <th>Supèrieur ou égale à : </th>
                                                <td><input type="text" class="form-control" name="sup"
                                                        value="{{ $regle->sup }}"></td>
                                                <th class="unite">Unité</th>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>


                                @foreach ($regle->medicament as $medicament)


                                    <div class="col-sm-4 col-sm-offset-0 float-left med_dci">
                                        <label for="Médicament">Médicament (DCI) liée :</label>
                                        <input type="hidden" name='medicament_dci_id[]'
                                            value="{{ $medicament->SAC_CODE_SQ_PK }}">
                                        <input type="text" class="form-control" name='medicament_dci'
                                            value="{{ $medicament->SAC_NOM }}" autocomplete="off">
                                    </div>

                                    <div class="col-sm-1">
                                        <label for=""> </label>
                                        <i class="fa fa-times-circle"
                                            style="color:red;cursor : pointer; margin-top:30px;"></i>

                                    </div>

                                @endforeach

                                <div class="col-sm-4 col-sm-offset-0 float-left med_dci">
                                    <label for="Médicament">Médicament (DCI) liée :</label>
                                    <input type="hidden" name='medicament_dci_id[]'>
                                    <input type="text" class="form-control" name='medicament_dci'>
                                </div>
                                <div class="col-sm-1">
                                    <label for=""> </label>
                                    <input type="button" class="btn btn-info" id="addMed" style="margin-top: 25px;"
                                        value="+">
                                </div>

                                <div class="col-sm-4 col-sm-offset-0">
                                    <label for="Classe">Classe Pharmacothérapeutique</label>
                                    <input type="hidden" name="classe_id" value="{{ $regle->classe }}">
                                    @php
                                        $classe = DB::select(
                                            'select cph_nom from cph_classepharmther where cph_code_pk = ?
                                                                            limit 1',
                                            [$regle->classe],
                                        );
                                        if (count($classe) > 0) {
                                            echo "<input type='text' class='form-control' name='classe'
                                                                                value='" .
                                                $classe[0]->cph_nom .
                                                "'>";
                                        }
                                    @endphp
                                    <input type="text" class="form-control" name="classe">
                                </div>
                        </div>
                        <div class="col-sm-12 col-sm-offset-9">
                            <input type="submit" value="Modifier" class="btn btn-primary" />
                        </div>
                        </form>
                    </div>

                </div><!-- /.box-body -->

            </div>

        </div>

    </div>


    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js') }}"></script>
    <script src="{{ asset('plugins/jquery/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="/js/admin/gestion_regle.js"></script>
@endsection
