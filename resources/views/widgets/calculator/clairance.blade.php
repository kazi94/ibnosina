@extends('layouts.model-table')
@section('script_css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

@section('title')
    Calculateur de Clairance
@endsection

@endsection
@section('content')

<div class="content-wrapper">
    <section class="content-header text-center">
        <h2>Calculateur de Clairance</h2>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-sm-10 col-sm-offset-1">
                <div class="box">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <form action="" class="form-horizontal">
                                    <div class="form-group">
                                        <label for="" class="col-sm-5 control-label">Age*</label>
                                        <div class="col-sm-7"><input type="number" class="form-control" name="age"
                                                required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Sexe</label>
                                        <div class="col-sm-10"><select name="sexe" id="" class="form-control">
                                                <option value="M">Masculin</option>
                                                <option value="F">Féminin</option>
                                            </select></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-6 control-label">Taille en cm</label>
                                        <div class="col-sm-6"><input type="text" class="form-control" name="taille">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">Créatinime(µmol/L)*</label>
                                        <div class="col-sm-5 no-padding">
                                            <input type="text" class="form-control" name="creat" required>
                                        </div>
                                        <div class="col-sm-2 no-padding">

                                            <select name="unit" id="" class="form-control">
                                                <option value="µmol/L">µmol/L</option>
                                                <option value="mg/dl">mg/dl</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-6 control-label">Poids</label>
                                        <div class="col-sm-6"><input type="text" class="form-control" name="poids">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-2 control-label">Enceinte</label>
                                        <div class="col-sm-10"><select name="enceinte" id="" class="form-control">
                                                <option value="1">Oui</option>
                                                <option value="">Non</option>
                                            </select></div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success">Calculer</button>
                                    </div>
                                </form>
                            </div>
                            <div class="col-sm-6 text-center">
                                <div id="response">
                                    <h3 class="info_clairance">La clairance est indispensable avant toute injection de
                                        produit de contraste au scanner et en IRM. </h3>
                                    <h4 class="info_clairance">Le calcul de la clairance de la créatinine permet
                                        d'éviter une éventuelle insuffisance rénale induite par ces produits de
                                        contraste.</h4>
                                </div>

                                <div class="alert alert-danger" role="alert"><sup>*</sup> Le résultat du calcul de
                                    la clairance est donné à titre indicatif. Les membres de l'équipe
                                    <strong>AnaPharmDz</strong> ne peuvent être tenue pour responsable en
                                    cas de conséquences indésirables.
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>
</section>
</div>

@endsection
@section('script')
<script src="{{ asset('/plugins/jquery/js/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('plugins/adminlte2/js/adminlte.min.js') }}"></script>
<script src="{{ asset('/js/widgets/calculator/clairance.js') }}"></script>
@endsection
