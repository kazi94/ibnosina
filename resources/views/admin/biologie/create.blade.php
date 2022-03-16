@extends('layouts.model1')
@section('content')
    <div class="content-wrapper">
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                <p class="alert alert-danger">{{ $error }}</p>
            @endforeach
        @endif
        @if (session()->has('message'))
            <p class="alert alert-success">{{ session('message') }}</p>
        @endif
        <div class="row m-0">

            {{-- <div class="col-xs-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ajouter Element</h3>
                    </div>
                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('element.store') }}">
                        <div class="box-body">
                            {{ csrf_field() }}
                            <div class="form-horizontal">

                                <div class="form-group">

                                    <label class="label-control col-sm-3"> Type de Bilan</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="bilan">
                                            <option value="Sanguin FNS">Sanguin FNS</option>
                                            <option value="Frottis de sang">Frottis de sang</option>
                                            <option value="Hémostase Standard">Hémostase Standard</option>
                                            <option value="Hémostase spécialisé">Hémostase spécialisé</option>
                                            <option value="Bilan Lipidique">Bilan Lipidique</option>
                                            <option value="Bilan Rénale">Bilan Rénale</option>
                                            <option value="Bilan hépatique">Bilan hépatique</option>
                                            <option value="Bilan métaboique">Bilan métaboique</option>
                                            <option value="Bilan Thyroidien">Bilan Thyroidien</option>
                                            <option value="Marqueurs Tumoraux">Marqueurs Tumoraux</option>
                                            <option value="Bilans Inflammatoires">Bilans Inflammatoires</option>
                                            <option value="Bilans Hormonaux">Bilans Hormonaux</option>
                                            <option value="Bilans enzymatiques">Bilans enzymatiques</option>
                                            <option value="Gazométrie">Gazométrie</option>
                                            <option value="Bilans immunologiques">Bilans immunologiques</option>
                                            <option value="Bilans Cardiologique">Bilans Cardiologique</option>
                                            <option value="Autres">Autres</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label class="label-control col-sm-3"> Nom de l'élement</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="element"
                                            placeholder="Nom de l'élement..." required>
                                    </div>
                                </div>
                            </div>

                            <div class="m-1">
                                <h3>Variantes</h3>
                                <div class="col-sm-3">

                                    <label class="label-control"> Valeur minimale</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="min" placeholder="">
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                    <label class="label-control"> Valeur maximale</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="max" placeholder="">
                                    </div>
                                </div>
                                <div class="col-sm-3">

                                    <label class="label-control"> Unité de mesure</label>
                                    <div class="">
                                        <select class="form form-control" id="unite">
                                            <option value=""></option>
                                            <option value="g/L">g/L</option>
                                            <option value="g/dL">g/dL</option>
                                            <option value="mcg/L">mcg/L</option>
                                            <option value="pg/L">pg/L</option>
                                            <option value="mg/dL">mg/dL</option>
                                            <option value="mcg/dL">mcg/dL</option>
                                            <option value="ng/dL">ng/dL</option>
                                            <option value="mcg/mL">mcg/mL</option>
                                            <option value="pg/mL">pg/mL</option>
                                            <option value="mmmol/L">mmmol/L</option>
                                            <option value="pmol/L">pmol/L</option>
                                            <option value="nmol/L">nmol/L</option>
                                            <option value="mcmol/L">mcmol/L</option>
                                            <option value="U/g Hb">U/g Hb</option>
                                            <option value="U/L">U/L</option>
                                            <option value="U/mL">U/mL</option>
                                            <option value="kU/L">kU/L</option>
                                            <option value="mUI/mL">mUI/mL</option>
                                            <option value="mEq/L">mEq/L</option>
                                            <option value="mckat/L">mckat/L</option>
                                            <option value="pkat/L">pkat/L</option>
                                            <option value="UI">UI</option>
                                            <option value="Négative">Négative</option>
                                            <option value="mL/kg">mL/kg</option>
                                            <option value="L/kg">L/kg</option>
                                            <option value="mmHg">mmHg</option>
                                            <option value="mU/mol Hb">mU/mol Hb</option>
                                            <option value="%">%</option>
                                            <option value="mcl">mcl</option>
                                            <option value="mm/h">mm/h</option>
                                            <option value="fL">fL</option>
                                            <option value="sec">sec</option>
                                            <option value="unités">unités</option>
                                            <option value="jours">jours</option>
                                            <option value="x 10 p6 cellules/mcL">x 10 p6 cellules/mcL</option>
                                            <option value="x 10 p12 cellules/L">x 10 p12 cellules/L</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">

                                    <label class="label-control">Sexe</label>
                                    <div class="">
                                        <select class="form-control" id="sexe">
                                            <option value=""></option>
                                            <option value="M">M</option>
                                            <option value="F">F</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="button" class="btn btn-info mt-2" onclick="addVariante()">Ajouter la
                                    variante</button>
                            </div>
                            <div class="table-responsive mt-1">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="bg-gray">
                                            <th>Valeur minimale</th>
                                            <th>Valeur maximale</th>
                                            <th>Unité de mesure</th>
                                            <th>Sexe</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right">Je valide</button>
                        </div>
                    </form>
                    <!-- /.box-body -->
                </div>
            </div> --}}
            <div class="col-xs-12 mt-3">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ajouter un Element</h3>
                    </div>

                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('element.store') }}">
                        <div class="box-body">
                            {{ csrf_field() }}
                            <div class="form-horizontal">

                                <div class="form-group">

                                    <label class="label-control col-sm-3"> Type de Bilan</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="bilan">
                                            <option value="Sanguin FNS">Sanguin FNS</option>
                                            <option value="Frottis de sang">Frottis de sang</option>
                                            <option value="Hémostase Standard">Hémostase Standard</option>
                                            <option value="Hémostase spécialisé">Hémostase spécialisé</option>
                                            <option value="Lipidique">Lipidique</option>
                                            <option value="Rénale">Rénale</option>
                                            <option value="Hépatique">Hépatique</option>
                                            <option value="Métaboique">Métaboique</option>
                                            <option value="Thyroidien">Thyroidien</option>
                                            <option value="Marqueurs Tumoraux">Marqueurs Tumoraux</option>
                                            <option value="Inflammatoires">Inflammatoires</option>
                                            <option value="Hormonaux">Hormonaux</option>
                                            <option value="Enzymatiques">Enzymatiques</option>
                                            <option value="Gazométrie">Gazométrie</option>
                                            <option value="Immunologiques">Immunologiques</option>
                                            <option value="Cardiologique"> Cardiologique</option>
                                            <option value="Ionogramme">Ionogramme</option>
                                            <option value="Martial">Martial</option>
                                            <option value="Glucidique">Glucidique</option>
                                            <option value="Gaz de sang">Gaz de sang</option>
                                            <option value="Autres">Autres</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label class="label-control col-sm-3"> Nom de l'élement</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="element"
                                            placeholder="Nom de l'élement..." required>
                                    </div>
                                </div>

                                <div class="col-sm-4">

                                    <label class="label-control"> Valeur minimale</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="min" placeholder="" name="min">
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                    <label class="label-control"> Valeur maximale</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="max" placeholder="" name="max">
                                    </div>
                                </div>
                                <div class="col-sm-2">

                                    <label class="label-control"> Unité de mesure</label>
                                    <div class="">
                                        <select class="form form-control" id="unite" name="unite">
                                            <option value=""></option>
                                            <option value="g/L">g/L</option>
                                            <option value="g/dL">g/dL</option>
                                            <option value="mcg/L">mcg/L</option>
                                            <option value="pg/L">pg/L</option>
                                            <option value="mg/dL">mg/dL</option>
                                            <option value="mcg/dL">mcg/dL</option>
                                            <option value="ng/dL">ng/dL</option>
                                            <option value="mcg/mL">mcg/mL</option>
                                            <option value="pg/mL">pg/mL</option>
                                            <option value="mmmol/L">mmmol/L</option>
                                            <option value="pmol/L">pmol/L</option>
                                            <option value="nmol/L">nmol/L</option>
                                            <option value="mcmol/L">mcmol/L</option>
                                            <option value="U/g Hb">U/g Hb</option>
                                            <option value="U/L">U/L</option>
                                            <option value="U/mL">U/mL</option>
                                            <option value="kU/L">kU/L</option>
                                            <option value="mUI/mL">mUI/mL</option>
                                            <option value="mEq/L">mEq/L</option>
                                            <option value="mckat/L">mckat/L</option>
                                            <option value="pkat/L">pkat/L</option>
                                            <option value="UI">UI</option>
                                            <option value="Négative">Négative</option>
                                            <option value="mL/kg">mL/kg</option>
                                            <option value="L/kg">L/kg</option>
                                            <option value="mmHg">mmHg</option>
                                            <option value="mU/mol Hb">mU/mol Hb</option>
                                            <option value="%">%</option>
                                            <option value="mcl">mcl</option>
                                            <option value="mm/h">mm/h</option>
                                            <option value="fL">fL</option>
                                            <option value="sec">sec</option>
                                            <option value="unités">unités</option>
                                            <option value="jours">jours</option>
                                            <option value="x 10 p6 cellules/mcL">x 10 p6 cellules/mcL</option>
                                            <option value="x 10 p12 cellules/L">x 10 p12 cellules/L</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">

                                    <label class="label-control">Sexe</label>
                                    <div class="">
                                        <select class="form form-control" id="sexe" name="sexe">
                                            <option value=""></option>
                                            <option value="F">F</option>
                                            <option value="M">M</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right">Je valide</button>
                        </div>
                    </form>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

    </div>
@endsection
@section('script')
    <script type="text/javascript" src="/js/admin/gestion_biologie.js"></script>

@endsection
