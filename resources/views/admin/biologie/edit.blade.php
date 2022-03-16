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

            <div class="col-xs-12 mt-3">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Modifier un Element</h3>
                    </div>

                    <!-- /.box-header -->
                    <!-- form start -->
                    <form role="form" method="POST" action="{{ route('element.update', ['id' => $element->id]) }}">
                        <div class="box-body">
                            @csrf
                            @method('PATCH')
                            <div class="form-horizontal">

                                <div class="form-group">

                                    <label class="label-control col-sm-3"> Type de Bilan</label>
                                    <div class="col-sm-9">
                                        <select class="form form-control" name="bilan">
                                            <option {{ $element->bilan == 'Sanguin FNS' ? 'selected' : '' }}
                                                value="Sanguin FNS">Sanguin FNS</option>
                                            <option {{ $element->bilan == 'Frottis de sang' ? 'selected' : '' }}
                                                value="Frottis de sang">Frottis de sang</option>
                                            <option {{ $element->bilan == 'Hémostase Standard' ? 'selected' : '' }}
                                                value="Hémostase Standard">Hémostase Standard</option>
                                            <option {{ $element->bilan == 'Hémostase spécialisé' ? 'selected' : '' }}
                                                value="Hémostase spécialisé">Hémostase spécialisé</option>
                                            <option {{ $element->bilan == 'Lipidique' ? 'selected' : '' }}
                                                value="Lipidique">
                                                Lipidique</option>
                                            <option {{ $element->bilan == 'Rénale' ? 'selected' : '' }} value="Rénale">
                                                Rénale
                                            </option>
                                            <option {{ $element->bilan == 'Hépatique' ? 'selected' : '' }}
                                                value="Hépatique">
                                                Hépatique</option>
                                            <option {{ $element->bilan == 'Métaboique' ? 'selected' : '' }}
                                                value="Métaboique">Métaboique</option>
                                            <option {{ $element->bilan == 'Thyroidien' ? 'selected' : '' }}
                                                value="Thyroidien">Thyroidien</option>
                                            <option {{ $element->bilan == 'Marqueurs Tumoraux' ? 'selected' : '' }}
                                                value="Marqueurs Tumoraux">Marqueurs Tumoraux</option>
                                            <option {{ $element->bilan == 'Inflammatoires' ? 'selected' : '' }}
                                                value="Inflammatoires">Inflammatoires</option>
                                            <option {{ $element->bilan == 'Hormonaux' ? 'selected' : '' }}
                                                value="Hormonaux">
                                                Hormonaux</option>
                                            <option {{ $element->bilan == 'Enzymatiques' ? 'selected' : '' }}
                                                value="Enzymatiques">Enzymatiques</option>
                                            <option {{ $element->bilan == 'Gazométrie' ? 'selected' : '' }}
                                                value="Gazométrie">Gazométrie</option>
                                            <option {{ $element->bilan == 'Immunologiques' ? 'selected' : '' }}
                                                value="Immunologiques">Immunologiques</option>
                                            <option {{ $element->bilan == 'Cardiologique' ? 'selected' : '' }}
                                                value="Cardiologique">Cardiologique</option>
                                            <option {{ $element->bilan == 'Ionogramme' ? 'selected' : '' }}
                                                value="Ionogramme">Ionogramme</option>
                                            <option {{ $element->bilan == 'Martial' ? 'selected' : '' }} value="Martial">
                                                Martial</option>
                                            <option {{ $element->bilan == 'Glucidique' ? 'selected' : '' }}
                                                value="Glucidique">Glucidique</option>
                                            <option {{ $element->bilan == 'Gaz de sang' ? 'selected' : '' }}
                                                value="Gaz de sang">Gaz de sang</option>
                                            <option {{ $element->bilan == 'Autres' ? 'selected' : '' }} value="Autres">
                                                Autres
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <label class="label-control col-sm-3"> Nom de l'élement</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control" name="element"
                                            value="{{ $element->element }}" disabled placeholder="Nom de l'élement..."
                                            required>
                                    </div>
                                </div>

                                <div class="col-sm-4">

                                    <label class="label-control"> Valeur minimale</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="min" placeholder="" name="min"
                                            value="{{ $element->minimum }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                    <label class="label-control"> Valeur maximale</label>
                                    <div class="">
                                        <input type="text" class="form-control" id="max" placeholder="" name="max"
                                            value="{{ $element->maximum }}">
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                    <label class="label-control"> Unité de mesure</label>
                                    <div class="">
                                        <select class="form form-control" id="unite" name="unite">
                                            <option value=""></option>
                                            <option {{ $element->unite == 'g/L' ? 'selected' : '' }} value="g/L">g/L
                                            </option>
                                            <option {{ $element->unite == 'g/dL' ? 'selected' : '' }} value="g/dL">g/dL
                                            </option>
                                            <option {{ $element->unite == 'mcg/L' ? 'selected' : '' }} value="mcg/L">mcg/L
                                            </option>
                                            <option {{ $element->unite == 'pg/L' ? 'selected' : '' }} value="pg/L">pg/L
                                            </option>
                                            <option {{ $element->unite == 'mg/dL' ? 'selected' : '' }} value="mg/dL">mg/dL
                                            </option>
                                            <option {{ $element->unite == 'mcg/dL' ? 'selected' : '' }} value="mcg/dL">
                                                mcg/dL</option>
                                            <option {{ $element->unite == 'ng/dL' ? 'selected' : '' }} value="ng/dL">ng/dL
                                            </option>
                                            <option {{ $element->unite == 'mcg/mL' ? 'selected' : '' }} value="mcg/mL">
                                                mcg/mL</option>
                                            <option {{ $element->unite == 'pg/mL' ? 'selected' : '' }} value="pg/mL">pg/mL
                                            </option>
                                            <option {{ $element->unite == 'mmmol/L' ? 'selected' : '' }} value="mmmol/L">
                                                mmmol/L</option>
                                            <option {{ $element->unite == 'pmol/L' ? 'selected' : '' }} value="pmol/L">
                                                pmol/L</option>
                                            <option {{ $element->unite == 'nmol/L' ? 'selected' : '' }} value="nmol/L">
                                                nmol/L</option>
                                            <option {{ $element->unite == 'mcmol/L' ? 'selected' : '' }} value="mcmol/L">
                                                mcmol/L</option>
                                            <option {{ $element->unite == 'U/g Hb' ? 'selected' : '' }} value="U/g Hb">U/g
                                                Hb</option>
                                            <option {{ $element->unite == 'U/L' ? 'selected' : '' }} value="U/L">U/L
                                            </option>
                                            <option {{ $element->unite == 'U/mL' ? 'selected' : '' }} value="U/mL">U/mL
                                            </option>
                                            <option {{ $element->unite == 'kU/L' ? 'selected' : '' }} value="kU/L">kU/L
                                            </option>
                                            <option {{ $element->unite == 'mUI/mL' ? 'selected' : '' }} value="mUI/mL">
                                                mUI/mL</option>
                                            <option {{ $element->unite == 'mEq/L' ? 'selected' : '' }} value="mEq/L">mEq/L
                                            </option>
                                            <option {{ $element->unite == 'mckat/L' ? 'selected' : '' }} value="mckat/L">
                                                mckat/L</option>
                                            <option {{ $element->unite == 'pkat/L' ? 'selected' : '' }} value="pkat/L">
                                                pkat/L</option>
                                            <option {{ $element->unite == 'UI' ? 'selected' : '' }} value="UI">UI</option>
                                            <option {{ $element->unite == 'Négative' ? 'selected' : '' }} value="Négative">
                                                Négative</option>
                                            <option {{ $element->unite == 'mL/kg' ? 'selected' : '' }} value="mL/kg">mL/kg
                                            </option>
                                            <option {{ $element->unite == 'L/kg' ? 'selected' : '' }} value="L/kg">L/kg
                                            </option>
                                            <option {{ $element->unite == 'mmHg' ? 'selected' : '' }} value="mmHg">mmHg
                                            </option>
                                            <option {{ $element->unite == 'mU/mol Hb' ? 'selected' : '' }}
                                                value="mU/mol Hb">mU/mol Hb</option>
                                            <option {{ $element->unite == '%' ? 'selected' : '' }} value="%">%</option>
                                            <option {{ $element->unite == 'mcl' ? 'selected' : '' }} value="mcl">mcl
                                            </option>
                                            <option {{ $element->unite == 'mm/h' ? 'selected' : '' }} value="mm/h">mm/h
                                            </option>
                                            <option {{ $element->unite == 'fL' ? 'selected' : '' }} value="fL">fL</option>
                                            <option {{ $element->unite == 'sec' ? 'selected' : '' }} value="sec">sec
                                            </option>
                                            <option {{ $element->unite == 'unités' ? 'selected' : '' }} value="unités">
                                                unités</option>
                                            <option {{ $element->unite == 'jours' ? 'selected' : '' }} value="jours">jours
                                            </option>
                                            <option {{ $element->unite == 'x 10 p6 cellules/mcL' ? 'selected' : '' }}
                                                value="x 10 p6 cellules/mcL">x 10 p6 cellules/mcL</option>
                                            <option {{ $element->unite == 'x 10 p12 cellules/L' ? 'selected' : '' }}
                                                value="x 10 p12 cellules/L">x 10 p12 cellules/L</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success pull-right">Je Modifie</button>
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
