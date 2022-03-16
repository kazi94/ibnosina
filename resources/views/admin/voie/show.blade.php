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
                <div class="box box-info">

                    <div class="box-header with-border">
                        <h3 class="box-title">Renseigner les voies d'administration</h3>
                    </div>

                    <div class="box-body" id="">
                        <table class="table table-bordered text-center" id="unit1">
                            <form action="" method="">

                                <thead class="thead-dark">
                                    <tr>
                                        <th>Num :</th>
                                        <th>Spécialité</th>
                                        <th>Voie(s)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($results as $sp)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>
                                                <input type="hidden" name="sp_id[]"
                                                    value="{{ $sp->sp_code_sq_pk }}">{{ $sp->sp_nom }}
                                            </td>
                                            <td>
                                                <select name="voies_id[{{ $sp->sp_code_sq_pk }}][]"
                                                    class="form-control select2 select2-hidden-accessible" multiple=""
                                                    data-placeholder="Voies..." style="width: 100%;" tabindex="-1"
                                                    aria-hidden="true">
                                                    <option value=""></option>
                                                    @foreach ($voies as $voie)
                                                        <option value="{{ $voie->CDF_CODE_PK }}">{{ $voie->CDF_NOM }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </form>
                        </table>
                        <input type="submit" class="btn btn-primary pull-right" value="enregistrer">
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('plugins/bootstrap/dist/js/bootstrap.min.js') }}"> </script>
    <!-- <script src="{{ asset('/plugins/datatables.net/js/jquery.dataTables.min.js') }}"> </script>
            <script src="{{ asset('/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script> -->
    <script src="{{ asset('plugins/datatable-1.10.24/datatables.min.js') }}"></script>

    <script src="{{ asset('plugins/select2/dist/js/select2.full.min.js') }}"> </script>
    <script type="text/javascript">
        var table = $("#unit1").DataTable({
            drawCallback: function() {
                $('.select2').select2();
            }
        });

        $("input:submit").click(function(e) {
            var form = table.$("input,select"); // get all data
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "/admin/medicaments",
                method: 'post',
                data: form.serialize(), // send data to server
                datatype: 'json',
                success: (data, status) => { //status = 'success'
                    if (status == "success") {
                        alert("Ajout effectué avec succés");

                    }
                },
                error: function(data, result, status) { // status = 'un code d'erreur'
                    alert("Erreur : " + data);
                },
                complete: function(result, status) { //status = 'success'
                    if (window.console && window.console.log) { // check if console is availlable
                        console.log(result + status);
                    }
                }
            });
        });

    </script>
@endsection
