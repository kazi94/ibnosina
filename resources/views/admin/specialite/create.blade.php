@extends('layouts.model')
@section('script_css')
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
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ajouter un médicament spécialité</h3>
                    </div>
                    <div class="box-body">
                        <div class="element" style="">
                            <form class="form-group" id="form_01" role="form" method="POST"
                                action="{{ route('specialite.store') }}">
                                {{ csrf_field() }}
                                <div class="form-group col-sm-4">
                                    <label for="">Médicament spécialité</label>
                                    <input type="text" class="form-control" placeholder="taper le médicament spécialité"
                                        name="sp_nom" required>
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
                                            <option value="{{ $voie->CDF_CODE_PK }}">{{ $voie->CDF_NOM }}</option>
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
                                            <option value="{{ $unite->id }}">{{ $unite->unite_nom }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-4 col-sm-offset-0 float-left med_dci">
                                    <label for="Médicament">Médicament(s) DCI lié(s) :</label>
                                    <input type="hidden" name='med_sp_id[]'>
                                    <input type="text" class="form-control" name='medicament_dci' autocomplete="off">
                                </div>
                                <div class="col-sm-1">
                                    <label for=""> </label>
                                    <input type="button" class="btn btn-info" id="addMed" style="margin-top: 25px;"
                                        value="+">
                                </div>
                                <div class="col-sm-12 col-sm-offset-9">
                                    <input type="submit" class="btn btn-primary" id="" value="Ajouter" />
                                </div>
                            </form>
                        </div>
                        <div class="box-footer">
                            @php
                                $sps = DB::table('sp_specialite')
                                    ->where('sp_specialite.SP_ALGERIE', 1)
                                    ->select('sp_specialite.*')
                                    ->limit(2000)
                                    ->get();
                            @endphp
                            @if (count($sps) > 0)
                                <table class="table table-bordered text-center dataTable " id="example6">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>Num :</th>
                                            <th>Spécialité</th>
                                            <th>Médicament(s) (DCI)</th>
                                            <th>Modifier</th>
                                            <th>Supprimer</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($sps as $sp)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $sp->SP_NOM }}</td>
                                                <td>
                                                    @php
                                                        $resultats = DB::table('cosac_compo_subact')
                                                            ->join('sac_subactive', 'sac_subactive.SAC_CODE_SQ_PK', 'cosac_compo_subact.cosac_sac_code_fk_pk')
                                                            ->where('cosac_compo_subact.cosac_sp_code_fk_pk', $sp->SP_CODE_SQ_PK)
                                                            ->select('sac_subactive.SAC_NOM')
                                                            ->get();
                                                        foreach ($resultats as $key => $resultat) {
                                                            echo $resultat->SAC_NOM . ($key == count($resultats) - 1 ? '.' : ' / ');
                                                        }
                                                    @endphp
                                                </td>
                                                <td>
                                                    <a href="{{ route('specialite.edit', $sp->SP_CODE_SQ_PK) }}"><span
                                                            class="glyphicon glyphicon-edit"></span></a>
                                                </td>
                                                <td>
                                                    {{-- <input type="checkbox" class="fdsfsd" name="deletes[]">
											</form> --}}
                                                    <form style='display: none;' method='POST'
                                                        action="{{ route('specialite.destroy', $sp->SP_CODE_SQ_PK) }}"
                                                        id='delete-form-{{ $sp->SP_CODE_SQ_PK }}'>
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                    </form>
                                                    <a href=""
                                                        onclick="if (confirm('ATTENTION SI VOUS SUPPRIMER CE MEDICAMENT LOPERATION VA AUSSI SUPPRIMER LES MEDICAMENTS DES PATIENTS ,voulez vous supprimer cette ligne ?')) {event.preventDefault(); document.getElementById('delete-form-{{ $sp->SP_CODE_SQ_PK }}').submit();} ">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <!-- <script src="{{ asset('js/datatables.net/js/jquery.dataTables.js') }}"></script>
            <script src="{{ asset('js/datatables.net-bs/js/dataTables.bootstrap.js') }}"></script> -->
    <script src="{{ asset('plugins/EasyAutocomplete-1.3.5/jquery.easy-autocomplete.js') }}"></script>
    <script src="{{ asset('plugins/datatable-1.10.24/datatables.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery/js/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="/js/admin/gestion_specialite.js"></script>
    <script>
        $(function() {
            $("#example6").DataTable();
        });

    </script>
@endsection
