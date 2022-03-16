@extends('layouts.model')

@section('script_css')
    <link rel="stylesheet" href="plugins/EasyAutocomplete-1.3.5/easy-autocomplete.min.css">
    <link rel="stylesheet" href="plugins/jquery/css/jquery_ui.css">
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

                        <h3 class="box-title">Modifier Médicament spécialité</h3>

                    </div><!-- /.box-header -->

                    <div class="box-body">

                        <div class="element" style="">
                            <form class="form-group" role="form" method="POST"
                                action="{{ route('specialite.update', $sp[0]->SP_CODE_SQ_PK) }}">
                                {{ csrf_field() }}
                                {{ method_field('PATCH') }}

                                <div class="form-group col-sm-4">
                                    <label for="">Médicament spécialité*</label>
                                    <input type="hidden" class="form-control" placeholder="taper le médicament spécialité"
                                        name="sp_id" value="{{ $sp[0]->SP_CODE_SQ_PK }}" required>
                                    <input type="text" class="form-control" placeholder="taper le médicament spécialité"
                                        name="sp_nom" value="{{ $sp[0]->SP_NOM }}" required>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Voie</label>
                                    <select name="voie" class="form-control">
                                        @php
                                            $voies = DB::table('voies')
                                                ->select('voies.*')
                                                ->distinct()
                                                ->orderBy('cdf_nom', 'ASC')
                                                ->get();
                                            
                                        @endphp
                                        @foreach ($voies as $voie)
                                            <option value="{{ $voie->CDF_CODE_PK }}" @if ($voie->CDF_CODE_PK == $sp[0]->SPVO_CDF_VO_CODE_FK_PK) selected
                                                    {{-- expr --}} @endif>{{ $voie->CDF_NOM }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-4">
                                    <label for="">Unité</label>
                                    <select name="unite" class="form-control">
                                        @php
                                            $unites = DB::table('unites')
                                                ->select('unites.*')
                                                ->distinct()
                                                ->orderBy('unite_nom', 'asc')
                                                ->get();
                                        @endphp
                                        @foreach ($unites as $unite)
                                            <option value="{{ $unite->id }}" @if ($unite->id == $sp[0]->PRE_CDF_UP_CODE_FK) selected @endif>{{ $unite->unite_nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @php
                                    $resultats = DB::table('cosac_compo_subact')
                                        ->join('sac_subactive', 'sac_subactive.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                        ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $sp[0]->SP_CODE_SQ_PK)
                                        ->get();
                                @endphp
                                @foreach ($resultats as $val)


                                    <div class="col-sm-4 col-sm-offset-0 float-left med_dci">
                                        <label for="Médicament">Médicament (DCI) liée :</label>
                                        <input type="hidden" name='medicament_dci_id[]'
                                            value="{{ $val->SAC_CODE_SQ_PK }}">
                                        <input type="text" class="form-control" name='medicament_dci'
                                            value="{{ $val->SAC_NOM }}" autocomplete="off">
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
                                    <input type="text" class="form-control" name='medicament_dci' autocomplete="off">
                                </div>
                                <div class="col-sm-1">
                                    <label for=""> </label>
                                    <input type="button" class="btn btn-info" id="addMed" style="margin-top: 25px;"
                                        value="+">
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
    <script src="{{ asset('js/admin/gestion_regle.js') }}"></script>
@endsection
