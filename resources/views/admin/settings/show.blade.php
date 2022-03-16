@extends('layouts.model')



@section('content')

    <div class="content-wrapper">
        @if (session()->has('message'))
            <p class="alert alert-success">{{ session('message') }}</p>
        @endif
        <section class="content-header">
            <h3>Table des paramètres</h3>
        </section>

        <section class="content">
            <div class="nav-tabs-custom d-sm-none">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#home">Paramétre Géneral</a></li>
                    <li><a data-toggle="tab" href="#menu1">Act Medicale</a></li>
                    <li><a data-toggle="tab" href="#menu2">Act Chirurgicale</a></li>
                    <li><a data-toggle="tab" href="#menu3">Travail</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="box box-primary">
                                <div class="box-body">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="hopital">Hopital</label>
                                            <input type="text" name="hopital" id="hopital" class="form-control"
                                                placeholder="Hopital....">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="service">Service</label>
                                            <input type="text" name="service" id="service" class="form-control"
                                                placeholder="Service...">
                                        </div>
                                    </div>
                                    <div class="col-md-4 pull-right">
                                        <div class="form-group">
                                            <label class="form-inline">
                                                <h4>Analyse-auto</h4>
                                            </label>
                                            <input type="checkbox" name="analyse_auto" class="form" id="analyse_auto">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class=""><button class="btn btn-info" id="save_01">Sauvegarder</button></div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div id="menu2" class="tab-pane fade">

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
                    @endif
                    <div class="alert alert-danger" style="display: none;"></div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Act Chirurgicale</h3>
                            <input type="submit" class="btn btn-primary pull-right" data-toggle="modal"
                                data-target="#modal_create" value="Nouveau Act Chirurgicale" />
                        </div>
                        <div class="box-body">


                            <table
                                class="table table-responsive table-bordered table-stripped table-hover text-center dataTable "
                                id="t_bio">

                                <thead>
                                    <tr class="alert alert-info">
                                        <th>ID</th>
                                        <th>Nom</th>

                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $act = DB::table('operation_chirugicales')
                                    ->select('operation_chirugicales.*')
                                    ->get()
                                    @endphp

                                    @foreach ($act as $am)
                                        <tr>

                                            <th>{{ $am->id }}</th>
                                            <th>{{ $am->nom }}</th>

                                            <td>
                                                <i class="glyphicon glyphicon-edit edit_operation" title="Modifier"
                                                    style="cursor: pointer" id="{{ $am->id }}"></i>
                                                <form style="display: none;" method="POST"
                                                    action="{{ route('operation.destroy', $am->id) }}"
                                                    id="delete-form-{{ $am->nom }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>

                                                <a href="" onclick="
                                                                            if (confirm('Voulez vous vraiment supprimer cete operation chirugicale?')) {
                                                                                event.preventDefault();
                                                                                document.getElementById('delete-form-{{ $am->nom }}').submit();
                                                                            }
                                                                        "><span
                                                        class="glyphicon glyphicon-trash"></span></a>
                                            </td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade in" id="modal_create" style="display: none;">
                        <div class="modal-dialog modal-lg" style="width: 600px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="box-title">Nouveau Act Chirurgicale
                                        <button type="button" class="close pull-right" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                    </h3>
                                </div>
                                <div class="modal-body">
                                    <div class="element" style="">
                                        <form class="form-group" id="form_01" role="form" method="POST"
                                            action="{{ route('operation.store') }}">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="form-group col-sm-5 col-sm-offset-1">
                                                    <label for="">Nom Act Chirurgicale: </label>
                                                    <input type="text" id="operation" class="form-control"
                                                        placeholder="entrer un nom dact chirurgicale" name="operation"
                                                        value="{{ old('nom') }}" required>
                                                </div>
                                            </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary pull-right" id=""
                                        value="Ajouter Act Chrirurgicale" />
                                    <input type="reset" class="btn btn-default pull-left" data-dismiss="modal"
                                        value="Fermer">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade in" id="modal_operation">
                        <div class="modal-dialog">
                            <div class="modal-content" style="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4 class="modal-title" style="">Modifier</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body" style="display: block;">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <form action="" class="up_operation" method="POST"
                                                enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH') }}
                                                <table class="table table-bordered table-condensed text-center">
                                                    <tr>
                                                        <td></td>
                                                        <td><input type="text" id="operation" class="form form-control"
                                                                name="operation" required /></td>
                                                    </tr>
                                                </table>
                                        </div>

                                    </div>
                                    <td>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left"
                                        data-dismiss="modal">Fermer</button>
                                    <input type="submit" class="btn btn-default pull-right" value="Modifier">
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                </div>

                <div id="menu1" class="tab-pane fade">

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
                    @endif
                    <div class="alert alert-danger" style="display: none;"></div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Act Medicale</h3>
                            <input type="submit" class="btn btn-primary pull-right" data-toggle="modal"
                                data-target="#modal_createe" value="Nouveau Act Medicale" />
                        </div>
                        <div class="box-body">


                            <table
                                class="table table-responsive table-bordered table-stripped table-hover text-center dataTable "
                                id="t_bio">

                                <thead>
                                    <tr class="alert alert-info">
                                        <th>ID</th>
                                        <th>Nom</th>

                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $act = DB::table('act_medicales')
                                    ->select('act_medicales.*')
                                    ->get()
                                    @endphp

                                    @foreach ($act as $am)
                                        <tr>

                                            <th>{{ $am->id }}</th>
                                            <th>{{ $am->nom }}</th>

                                            <td>
                                                <i class="glyphicon glyphicon-edit edit_act" title="Modifier"
                                                    style="cursor: pointer" id="{{ $am->id }}"></i>
                                                <form style="display: none;" method="POST"
                                                    action="{{ route('act.destroy', $am->id) }}"
                                                    id="delete-form-{{ $am->nom }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>

                                                <a href="" onclick="
                                                                        if (confirm('Voulez vous vraiment supprimer cette act chriugiclae?')) {
                                                                            event.preventDefault();
                                                                            document.getElementById('delete-form-{{ $am->nom }}').submit();
                                                                        }
                                                                    "><span class="glyphicon glyphicon-trash"></span></a>
                                            </td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade in" id="modal_createe" style="display: none;">
                        <div class="modal-dialog modal-lg" style="width: 600px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="box-title">Nouveau Act medicale
                                        <button type="button" class="close pull-right" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                    </h3>
                                </div>
                                <div class="modal-body">
                                    <div class="element" style="">
                                        <form class="form-group" id="form_01" role="form" method="POST"
                                            action="{{ route('act.store') }}">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="form-group col-sm-5 col-sm-offset-1">
                                                    <label for="">Nom Act medicale: </label>
                                                    <input type="text" id="act" class="form-control"
                                                        placeholder="entrer un nom dact chirurgicale" name="act"
                                                        value="{{ old('nom') }}" required>
                                                </div>
                                            </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary pull-right" id=""
                                        value="Ajouter Act medicale" />
                                    <input type="reset" class="btn btn-default pull-left" data-dismiss="modal"
                                        value="Fermer">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade in" id="modal_act">
                        <div class="modal-dialog">
                            <div class="modal-content" style="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4 class="modal-title" style="">Modifier</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body" style="display: block;">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <form action="" class="up_act" method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH') }}
                                                <table class="table table-bordered table-condensed text-center">
                                                    <tr>
                                                        <td>Nom Act</td>
                                                        <td><input type="text" id="act" class="form form-control" name="act"
                                                                required /></td>
                                                    </tr>
                                                </table>
                                        </div>

                                    </div>
                                    <td>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left"
                                        data-dismiss="modal">Fermer</button>
                                    <input type="submit" class="btn btn-default pull-right" value="Modifier">
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                </div>

                <div id="menu3" class="tab-pane fade">

                    @if (count($errors) > 0)
                        @foreach ($errors->all() as $error)
                            <p class="alert alert-danger">{{ $error }}</p>
                        @endforeach
                    @endif
                    <div class="alert alert-danger" style="display: none;"></div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Travail</h3>
                            <input type="submit" class="btn btn-primary pull-right" data-toggle="modal"
                                data-target="#modal_createee" value="Nouveau travail" />
                        </div>
                        <div class="box-body">


                            <table
                                class="table table-responsive table-bordered table-stripped table-hover text-center dataTable "
                                id="t_bio">

                                <thead>
                                    <tr class="alert alert-info">
                                        <th>ID</th>
                                        <th>Nom du travail</th>

                                        <th>Supprimer</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $travail = DB::table('travails')
                                    ->select('travails.*')
                                    ->get()
                                    @endphp

                                    @foreach ($travail as $tr)
                                        <tr>

                                            <th>{{ $tr->id }}</th>
                                            <th>{{ $tr->nom }}</th>

                                            <td>
                                                <i class="glyphicon glyphicon-edit edit_travail" title="Modifier"
                                                    style="cursor: pointer" id="{{ $tr->id }}"></i>
                                                <form style="display: none;" method="POST"
                                                    action="{{ route('travail.destroy', $tr->id) }}"
                                                    id="delete-form-{{ $tr->nom }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                </form>

                                                <a href="" onclick="
                                                                            if (confirm('Voulez vous vraiment supprimer ce travail?')) {
                                                                                event.preventDefault();
                                                                                document.getElementById('delete-form-{{ $tr->nom }}').submit();
                                                                            }
                                                                        "><span
                                                        class="glyphicon glyphicon-trash"></span></a>
                                            </td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade in" id="modal_createee" style="display: none;">
                        <div class="modal-dialog modal-lg" style="width: 600px">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="box-title">Nouveau travail
                                        <button type="button" class="close pull-right" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                    </h3>
                                </div>
                                <div class="modal-body">
                                    <div class="element" style="">
                                        <form class="form-group" id="form_01" role="form" method="POST"
                                            action="{{ route('travail.store') }}">
                                            {{ csrf_field() }}
                                            <div class="row">
                                                <div class="form-group col-sm-5 col-sm-offset-1">
                                                    <label for="">Nom travail: </label>
                                                    <input type="text" id="travail" class="form-control"
                                                        placeholder="entrer un nom de travail" name="travail"
                                                        value="{{ old('nom') }}" required>
                                                </div>
                                            </div>


                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <input type="submit" class="btn btn-primary pull-right" id="" value="Ajouter travail" />
                                    <input type="reset" class="btn btn-default pull-left" data-dismiss="modal"
                                        value="Fermer">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade in" id="modal_travail">
                        <div class="modal-dialog">
                            <div class="modal-content" style="">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">×</span></button>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <h4 class="modal-title" style="">Modifier</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body" style="display: block;">
                                    <div class="row">

                                        <div class="col-sm-12">
                                            <form action="" class="up_travail" method="POST" enctype="multipart/form-data">
                                                {{ csrf_field() }}
                                                {{ method_field('PATCH') }}
                                                <table class="table table-bordered table-condensed text-center">
                                                    <tr>
                                                        <td>Nom travail</td>
                                                        <td><input type="text" id="travail" class="form form-control"
                                                                name="travail" required /></td>
                                                    </tr>
                                                </table>
                                        </div>

                                    </div>
                                    <td>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left"
                                        data-dismiss="modal">Fermer</button>
                                    <input type="submit" class="btn btn-default pull-right" value="Modifier">
                                    </form>
                                </div>
                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>

                </div>
            </div>



        </section>
    </div>
@endsection
@section('script')
    {{--call json script to store settings--}}
    <script src="{{ asset('js/admin/settings_json.js') }}"></script>
    <script src="{{ asset('js/user/patient/gestion_hospitalisation.js') }}"></script>
    <script type="text/javascript">
        $('body').find('span > i').remove('i:last');
        $('#t_bio').dataTable();
        $(function() {
            $('.edit_operation').on('click', function() { // traitement pour modifier une operation
                var myModal = $('#modal_operation');
                var operation_id = $(this).attr('id'); // get operaton ID
                // now get the values from the table
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/operation/getOperation/' + operation_id,
                    method: 'POST',
                    datatype: 'json',
                    success: (data) => {

                        // and set them in the modal:
                        $('#operation', myModal).val(data[0].nom);
                        $('.up_operation', myModal).attr('action', '/operation/' +
                            operation_id + '/edit');

                    },
                    error: function(jqXHR, textStatus) {

                        console.log("Request failed: " + textStatus + " " + jqXHR);
                    }
                });


                // and finally show the modal
                myModal.modal({
                    show: true
                });
            });
            $('.edit_act').on('click', function() { // traitement pour modifier un act
                var myModal = $('#modal_act');
                var act_id = $(this).attr('id'); // get act id
                // now get the values from the table
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/act/get/' + act_id,
                    method: 'POST',
                    datatype: 'json',
                    success: (data) => {

                        // and set them in the modal:
                        $('#act', myModal).val(data[0].nom);
                        $('.up_act', myModal).attr('action', '/act/' + act_id + '/edit');

                    },
                    error: function(jqXHR, textStatus) {

                        console.log("Request failed: " + textStatus + " " + jqXHR);
                    }
                });


                // and finally show the modal
                myModal.modal({
                    show: true
                });
            });

            $('.edit_travail').on('click', function() { // traitement pour modifier un travail
                var myModal = $('#modal_travail');
                var travail_id = $(this).attr('id'); // get travail id
                // now get the values from the table
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '/travail/get/' + travail_id,
                    method: 'POST',
                    datatype: 'json',
                    success: (data) => {

                        // and set them in the modal:
                        $('#travail', myModal).val(data[0].nom);
                        $('.up_travail', myModal).attr('action', '/travail/' + travail_id +
                            '/edit');

                    },
                    error: function(jqXHR, textStatus) {

                        console.log("Request failed: " + textStatus + " " + jqXHR);
                    }
                });


                // and finally show the modal
                myModal.modal({
                    show: true
                });
            });

        });

    </script>
@endsection
